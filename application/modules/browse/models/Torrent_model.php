<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Torrent_model extends CI_Model {


	public function is_valid_id($id)
	{
	  return is_numeric($id) && ($id > 0) && (floor($id) == $id);
	}

	public function check(){
		
		foreach(explode(":","descr:type:name") as $v) {
			if (!isset($_POST[$v]))
				bark("missing form data");
		}

		if (!isset($_FILES["userfile"]))
			bark("missing form data");


		if (empty($this->input->post('name')))
			{
			$this->session->set_flashdata('danger', 'Bestands naam is leeg......vul een naam in');
			redirect('torrents/upload', 'refresh');
			}

		/*if (empty($this->input->post('nfo')))
			{
			$this->session->set_flashdata('danger', 'Geen NFO ontvangen....voeg een NFO toe !');
			redirect('torrents/upload', 'refresh');
			}*/

		if (empty($this->input->post('descr')))
			{
			$this->session->set_flashdata('danger', 'Geen omschrijfing ontvangen.......');
			redirect('torrents/upload', 'refresh');
			}
			
		$catid = (0 + $this->input->post('type'));
		
		if (! $this->is_valid_id($catid))
		{
			$this->session->set_flashdata('danger', 'Geen categorie ontvangen.......voer een categorie toe');
			redirect('torrents/upload', 'refresh');
		}

			
		//if (!validfilename($fname))
		//	bark("Invalid filename!");
	
		if (!preg_match('/^(.+)\.torrent$/si', $_FILES["userfile"]['name'], $matches))
		{
			//die('niet geldig');
			$this->session->set_flashdata('danger', 'Ongeldige extentie.......Dit is geen .torrent bestand');
			redirect('torrents/upload', 'refresh');			
		}
		
		//$shortfname = $torrent = $matches[1];
		//if (!empty($_POST["name"]))
		//	$torrent = unesc($_POST["name"]);

		$tmpname = $_FILES['userfile']['tmp_name'];
		if (!is_uploaded_file($tmpname))
			bark("eek");
		if (!filesize($tmpname))
			bark("Empty file!");

		$dict = bdec_file($tmpname, 1024*1024*4);
		if (!isset($dict))
			bark("What the hell did you upload? This is not a bencoded file!");

		function dict_check($d, $s) {
			if ($d["type"] != "dictionary")
				bark("not a dictionary");
			$a = explode(":", $s);
			$dd = $d["value"];
			$ret = array();
			foreach ($a as $k) {
				unset($t);
				if (preg_match('/^(.*)\((.*)\)$/', $k, $m)) {
					$k = $m[1];
					$t = $m[2];
				}
				if (!isset($dd[$k]))
					bark("dictionary is missing key(s)");
				if (isset($t)) {
					if ($dd[$k]["type"] != $t)
						bark("invalid entry in dictionary");
					$ret[] = $dd[$k]["value"];
				}
				else
					$ret[] = $dd[$k];
			}
			return $ret;
		}

		function dict_get($d, $k, $t) {
			if ($d["type"] != "dictionary")
				bark("not a dictionary");
			$dd = $d["value"];
			if (!isset($dd[$k]))
				return;
			$v = $dd[$k];
			if ($v["type"] != $t)
				bark("invalid dictionary entry type");
			return $v["value"];
		}

		list($ann, $info) = dict_check($dict, "announce(string):info");
		list($dname, $plen, $pieces) = dict_check($info, "name(string):piece length(integer):pieces(string)");

		# the first one will be displayed on the pages
		$announce_urls = array();
		$announce_urls[] = 'http://torrent-empire.org/announce';
		
		
		if (!in_array($ann, $announce_urls, 1))
			echo("invalid announce url! must be <b>" . $announce_urls[0] . "</b>");

		if (strlen($pieces) % 20 != 0)
			bark("invalid pieces");

		$filelist = array();
		$totallen = dict_get($info, "length", "integer");
		if (isset($totallen)) {
			$filelist[] = array($dname, $totallen);
			$type = "single";
		}
		else {
			$flist = dict_get($info, "files", "list");
			if (!isset($flist))
				bark("missing both length and files");
			if (!count($flist))
				bark("no files");
			$totallen = 0;
			foreach ($flist as $fn) {
				list($ll, $ff) = dict_check($fn, "length(integer):path(list)");
				$totallen += $ll;
				$ffa = array();
				foreach ($ff as $ffe) {
					if ($ffe["type"] != "string")
						bark("filename error");
					$ffa[] = $ffe["value"];
				}
				if (!count($ffa))
					bark("filename error");
				$ffe = implode("/", $ffa);
				$filelist[] = array($ffe, $ll);
			}
			$type = "multi";
		}

		$infohash = pack("H*", sha1($info["string"]));


		// Replace punctuation characters with spaces
		$tor = $this->input->post('name');
		$torrent = str_replace("_", " ", $tor);
	
	}
}

