<?php

 
if (!defined("IN_TORRENT")) die("Access denied!");
 
if (isset($_GET['info_hash'])) {

	$torrent = $db->get_row("SELECT id, announce, info_hash FROM torrents WHERE info_hash = '".$_GET['info_hash']."'");

	if($torrent){		
		$returnError = "";
		$smarty->assign('notFound',false);
 		$annouce = unserialize($torrent->announce);  
		// First, we clear torrent stats 
		$startUp->clearScrape($torrent->info_hash);
		// Set errorScrape to false
 		$smarty->assign('returnScrape',false);
 
		if (is_array($annouce)) {
			foreach ($annouce as $key => $value) {
				$returnError .= $startUp->torrentScrape($value[0],$torrent->info_hash);		
			}	
			$smarty->assign('returnScrape',$returnError);		
		} else {
	 
				$smarty->assign('soloScrape',$startUp->torrentScrape($annouce,$torrent->info_hash));	
		}
		
 


		// Traitements
		$NewTorrentvalue = $db->get_row("SELECT id, seeds, leechers, finished, last_scrape FROM torrents WHERE info_hash = '".$torrent->info_hash."'");
		$retour = array(
			'chaine'    => $NewTorrentvalue,
			'lastScrape'      => date('j F Y H:i:s', $NewTorrentvalue->last_scrape),
			'errorScrape'      => $returnError
		);
 
		 
		// Envoi du retour (on renvoi le tableau $retour encodé en JSON)
		header('Content-type: application/json');
		echo json_encode($retour);
		exit;
		// var_dump($torrent);
 		// $startUp->redirect($conf['baseurl'].'/'.$startUp->makeUrl(array('page'=>'torrent-detail','id'=>$torrent->id)));
	} else {
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); // Set 404, no reference to anything on the search engines!
		$smarty->assign('notFound',true);
	}
}


 

