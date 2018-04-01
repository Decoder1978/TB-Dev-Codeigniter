<?php
error_reporting(E_ALL);
////////////////// GLOBAL VARIABLES ////////////////////////////	
$TBDEV['baseurl'] = 'http://torrent-empire.org';
$TBDEV['announce_interval'] = 60 * 30;
$TBDEV['user_ratios'] = 0;
$TBDEV['connectable_check'] = 0;
define ('UC_VIP', 2);
// DB setup
$TBDEV['mysql_host'] = "localhost";
$TBDEV['mysql_user'] = "root";
$TBDEV['mysql_pass'] = "*igpeLaF";
$TBDEV['mysql_db']   = "torrentempire";
////////////////// GLOBAL VARIABLES ////////////////////////////

// DO NOT EDIT BELOW UNLESS YOU KNOW WHAT YOU'RE DOING!!

define( 'TIME_NOW', time() );

$agent = $_SERVER["HTTP_USER_AGENT"];

// Deny access made with a browser...
if (
    preg_match('%^Mozilla/|^Opera/|^Links |^Lynx/%i', $agent) || 
    isset($_SERVER['HTTP_COOKIE']) || 
    isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) || 
    isset($_SERVER['HTTP_ACCEPT_CHARSET'])
    )
   // tracker_error("torrent not registered with this tracker CODE 1");

if( !$_GET['compact'] )
  {
    tracker_error('Sorry, this tracker no longer supports non-compact clients!');
  }
/////////////////////// FUNCTION DEFS ///////////////////////////////////

function get_date_time($timestamp = 0)
{
  if ($timestamp)
    return date("Y-m-d H:i:s", $timestamp);
  else
//    return gmdate("Y-m-d H:i:s");
    return date("Y-m-d H:i:s");
}


function dbconn()
{
    global $TBDEV;

    if (!@mysql_connect($TBDEV['mysql_host'], $TBDEV['mysql_user'], $TBDEV['mysql_pass']))
    {
	  tracker_error('Please call back later');
    }
    mysql_select_db($TBDEV['mysql_db']) or tracker_error('Please call back later');
}
require_once("benc_old.php");


// tracker state
$_SERVER['tracker'] = array(
	// general tracker options
	/* 'open_tracker'      => $conf['open_tracker'],           
	'announce_interval' => $conf['announce_interval'],     
	'min_interval'      => $conf['min_interval'],           
	'default_peers'     => $conf['default_peers'],            
	'max_peers'         => $conf['max_peers'],            */

	// general tracker options
	'open_tracker'      => FALSE,          /* track anything announced to it */
	'announce_interval' => 1800,          /* how often client will send requests */
	'min_interval'      => 900,           /* how often client can force requests */
	'default_peers'     => 50,            /* default # of peers to announce */
	'max_peers'         => 100,           /* max # of peers to announce */

	// advanced tracker options
	'external_ip'       => TRUE,          /* allow client to specify ip address */
	'force_compact'     => FALSE,         /* force compact announces only */
	'full_scrape'       => FALSE,         /* allow scrapes without info_hash */
	'random_limit'      => 500,           /* if peers > #, use alternate SQL RAND() */
	'clean_idle_peers'  => 1,            /* tweaks % of time tracker attempts idle peer removal */
	                                      /* if you have a busy tracker, you may adjust this */
	                                      /* example: 10 = 10%, 20 = 5%, 50 = 2%, 100 = 1% */
	                                      
	// database options
	'db_host'           => 'localhost',   /* ip or hostname to mysql server */
	'db_user'           => 'root',        /* username used to connect to mysql */
	'db_pass'           => '*igpeLaF',            /* password used to connect to mysql */
	'db_name'           => 'torrentempire', /* name of the PeerTracker database */

	// advanced database options
	'db_prefix'         => '',         /* name prefixes for the PeerTracker tables */
	'db_persist'        => false,         /* use persistent connections if available. */
);

function tracker_error($error) 
{
	exit('d14:failure reason' . strlen($error) . ":{$error}e");
}

function sqlesc($x) {
    return "'".mysql_real_escape_string($x)."'";
}

function hash_where($name, $hash) {
    $shhash = preg_replace('/ *$/s', "", $hash);
    return "($name = " . sqlesc($hash) . " OR $name = " . sqlesc($shhash) . ")";
}
function benc_resp_raw($x)
	{
	header("Content-Type: text/plain");
	header("Pragma: no-cache");
	print($x);
	}

// strip auto-escaped data
if (get_magic_quotes_gpc())
{
	$_GET['info_hash'] = stripslashes($_GET['info_hash']);
	$_GET['peer_id'] = stripslashes($_GET['peer_id']);
}

// 20-bytes - info_hash
// sha-1 hash of torrent metainfo
if (!isset($_GET['info_hash']) || strlen($_GET['info_hash']) != 20);


// 20-bytes - peer_id
// client generated unique peer identifier
if (!isset($_GET['peer_id']) || strlen($_GET['peer_id']) != 20) exit;

// integer - port
// port the client is accepting connections from
if (!(isset($_GET['port']) && is_numeric($_GET['port']))) tracker_error('client listening port is invalid');

// integer - left
// number of bytes left for the peer to download
if (isset($_GET['left']) && is_numeric($_GET['left'])) $_SERVER['tracker']['seeding'] = ($_GET['left'] > 0 ? 0 : 1); else tracker_error('client data left field is invalid');

// integer boolean - compact - optional
// send a compact peer response
// http://bittorrent.org/beps/bep_0023.html
if (!isset($_GET['compact']) || $_SERVER['tracker']['force_compact'] === 'true') $_GET['compact'] = 1; else $_GET['compact'] += 0;
 
// integer boolean - no_peer_id - optional
// omit peer_id in dictionary announce response
if (!isset($_GET['no_peer_id'])) $_GET['no_peer_id'] = 0; else $_GET['no_peer_id'] += 0;


if (!isset($_GET['event'])) $_GET['event'] = ''; else $_GET['event'] = $_GET['event'];


// string - ip - optional
// ip address the peer requested to use
if (isset($_GET['ip']) && $_SERVER['tracker']['external_ip'] === 'true')
{
	// dotted decimal only
	$_GET['ip'] = trim($_GET['ip'],'::ffff:');
	if (!ip2long($_GET['ip'])) tracker_error('invalid ip, dotted decimal only');
}
// set ip to connected client
elseif (isset($_SERVER['REMOTE_ADDR'])) $_GET['ip'] = trim($_SERVER['REMOTE_ADDR'],'::ffff:');
// cannot locate suitable ip, must abort
else tracker_error('could not locate clients ip');

// integer - numwant - optional
// number of peers that the client has requested
if (!isset($_GET['numwant'])) $_GET['numwant'] = $_SERVER['tracker']['default_peers'];
elseif (($_GET['numwant']+0) > $_SERVER['tracker']['max_peers']) $_GET['numwant'] = $_SERVER['tracker']['max_peers'];
else $_GET['numwant'] += 0;


if (!isset($_GET['passkey']) || strlen($_GET['passkey']) != 32)
	{
	tracker_error("Verkeerde passkey. Download de torrent opnieuw aub.");
	}



if (!isset($_GET['event']))
	$event = "";
	$left = $_GET['left'];

$seeder = ($left == 0) ? "yes" : "no";

dbconn();

$valid = @mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM users WHERE passkey='{$_GET['passkey']}'"));
	if ($valid[0] != 1) err("Foute passkey! Download de .torrent opnieuw van de site");

$def = mysql_query("SELECT id FROM users WHERE passkey='{$_GET['passkey']}'");
$defs = mysql_fetch_assoc($def);
if ($defs)
	{
	$userid=$defs['id'];
	}

	if (isset($_GET['info_hash']))
	{
	$info_hash = strtolower(urlencode(bin2hex($_GET['info_hash']))) ;
	}

	if (isset($_GET['peer_id']))
	{
	$peer_id = strtolower(urlencode(bin2hex($_GET['peer_id']))) ;
	}
	
$res = mysql_query("SELECT id, banned, UNIX_TIMESTAMP(added) AS ts FROM torrents WHERE info_hash='{$info_hash}'");
$torrent = mysql_fetch_assoc($res);
if (!$torrent)
	tracker_error("Deze torrent bestaat niet op deze tracker. ");
$torrentid = $torrent["id"];

//die($torrentid);

$fields = "seeder, peer_id, ip, port, uploaded, downloaded, userid";

//$numpeers = $torrent["numpeers"];
//$limit = "";
//if ($numpeers > $rsize)
	$limit = "ORDER BY RAND() LIMIT 50";

//die($peer_id);
$res = mysql_query("SELECT $fields FROM peers WHERE torrent = '$torrentid' AND connectable = 'yes' $limit")or die(mysql_error());
$resp = "d" . benc_str("interval") . "i" . $_SERVER['tracker']['announce_interval'] . "e" . benc_str("peers") . "l";
unset($self);
while ($row = mysql_fetch_assoc($res))
	{
	//$row["peer_id"] = hash_pad($row["peer_id"]);
	if ($row["peer_id"] === $peer_id)
		{
		$userid = $row["userid"];
		$self = $row;
		continue;
		}

	$resp .= "d" .
		benc_str("ip") . benc_str($row["ip"]) .
		benc_str("peer id") . benc_str($row["peer_id"]) .
		benc_str("port") . "i" . $row["port"] . "e" .
		"e";
	}

$resp .= "ee";
$selfwhere = "torrent = $torrentid AND " . hash_where("peer_id", $peer_id);

if (!isset($self))
	{
	$res = mysql_query("SELECT $fields FROM peers WHERE $selfwhere");
	$row = mysql_fetch_assoc($res);
	if ($row)
		{
		$userid = $row["userid"];
		$self = $row;
		}
	}

//// Up/down stats ////////////////////////////////////////////////////////////
function verbindbaar()
	{
	$sockres = @fsockopen($ip, $port, $errno, $errstr, 5);
	if (!$sockres)
		{
		@fclose($sockres);
		return "Nee";
		}
	else
		{
		@fclose($sockres);
		return "";
		}
	}

if (!isset($self))
	{
		if (!verbindbaar())
		{
		$connectable = "no";
		err("U bent niet verbindbaar..1..");
		}

		$valid = @mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM peers WHERE torrent=$torrentid AND passkey='{$_GET['passkey']}'"));

		$rz = mysql_query("SELECT maxtorrents, id, uploaded, downloaded, class, username FROM users WHERE passkey='". $_GET['passkey'] ."'") or tracker_error("Tracker error 2");
		
		if (mysql_num_rows($rz) == 0)
		{
		tracker_error("Onbekende passkey. Download de torrent opnieuw aub.");
		}

		$az = mysql_fetch_assoc($rz);
		$userid = $az["id"];
		$username = $rz['username'];

		if (!verbindbaar())
			{
			$connectable = "no";
			tracker_error("U bent niet verbindbaar..2..");
			}
		
		$allowedtorrents = $az["maxtorrents"];
		$res = mysql_query("SELECT COUNT(*) FROM peers WHERE userid=$userid") or err("Maximale torrents bereikt.");
		$row = mysql_fetch_row($res);
		$activetorrents = $row[0];
	
	
		if ($activetorrents >= $allowedtorrents)
		{
		tracker_error("Sorry, $allowedtorrents is maximaal voor u.");	
		}
	
	}
else
	{
		$uploaded = $_GET['uploaded'];
		$downloaded = $_GET['downloaded'];
		
		$upthis = max(0, $uploaded - $self["uploaded"]);
		$downthis = max(0, $downloaded - $self["downloaded"]);

		if ($upthis > 0 || $downthis > 0)
		{
		$ressite =  mysql_query("SELECT * FROM downup WHERE user=$userid AND torrent=$torrentid") or tracker_error("DownUpStats Error");
		$rowsite = mysql_fetch_array($ressite);
		if (!$rowsite)
			mysql_query("INSERT INTO downup (torrent, user, added, uploaded, downloaded) VALUES ($torrentid, $userid, NOW(), $upthis, $downthis)");
		else
			mysql_query("UPDATE downup SET uploaded = uploaded + $upthis, downloaded = downloaded + $downthis, lastseen=NOW() WHERE user=$userid AND torrent=$torrentid") or tracker_error("Tracker foutmelding 4");
			
		mysql_query("UPDATE users SET uploaded = uploaded + $upthis, downloaded = downloaded + $downthis WHERE id=$userid") or tracker_error("Tracker foutmelding 3");
		}
	}

function portblacklisted($port)
	{
	if ($port >= 411 && $port <= 413) return true; // direct connect
	if ($port >= 6881 && $port <= 6889) return true; // bittorrent
	if ($port == 1214) return true; // kazaa
	if ($port >= 6346 && $port <= 6347) return true; // gnutella
	if ($port == 4662) return true; // emule
	if ($port == 6699) return true; // winmx
	return false;
	}

$updateset = array();

if ($_GET['event'] == "stopped")
	{
		if (isset($self))
		{
			mysql_query("DELETE FROM peers WHERE $selfwhere");
			if (mysql_affected_rows())
			{
			if ($self["seeder"] == "yes")
				$updateset[] = "seeders = seeders - 1";
			else
				$updateset[] = "leechers = leechers - 1";
			}
		}
	}
else
	{
		if ($_GET['event'] == "completed")
		{
		//$ratiocompleted = floor($uploaded / $downloaded * 1000) / 1000; // this does not get used anywhere here so don't need it 
		$updateset[] = "times_completed = times_completed + 1";
		//===================== check if torrent has been completed alredy if zo ignore this ======= Decoder ==========
		$torrent_chack =  mysql_query("SELECT * FROM downloaded WHERE user=$userid AND torrent=$torrentid") or tracker_error("Error Event completed client");
		$torrent_check = mysql_fetch_array($torrent_chack);
		
			if (!$torrent_check)//================== end of check==== sql below is default dont touch it or you screw up announce.php lol ==========
			{
			mysql_query("INSERT INTO downloaded (torrent, user, added, username, uploaded, downloaded) VALUES ('$torrentid', '$userid', '". get_date_time() ."', 'leeg', '$uploaded', '$downloaded')") or tracker_error("FOUT2");
			}
		}
	if (isset($self))
		{
		if (!verbindbaar())
			{
			$connectable = "no";
			tracker_error("U bent niet verbindbaar..3..");
			}

		mysql_query("UPDATE peers SET uploaded='$uploaded', downloaded='$downloaded', to_go='$left', last_action = '". get_date_time() ."', seeder='$seeder'"
			. ($seeder == "yes" && $self["seeder"] != $seeder ? ", finishedat = " . time() : "") . " WHERE $selfwhere")or die(mysql_error());
		if (mysql_affected_rows() && $self["seeder"] != $seeder)
			{
			if ($seeder == "yes")
				{
				$updateset[] = "seeders = seeders + 1";
				$updateset[] = "leechers = leechers - 1";
				}
			else
				{
				$updateset[] = "seeders = seeders - 1";
				$updateset[] = "leechers = leechers + 1";
				}
			}
		}
		else
		{
		if (portblacklisted($_GET['port']))
			tracker_error("Poort $port is geblokkeerd op torrent-empire.org.");
		else
			{
			if (!verbindbaar())
				{
				$connectable = "no";
				}
			else
				{
				$connectable = "yes";
				}
			}
		//die(date("Y-m-d H:i:s"));
		$ret = mysql_query("INSERT INTO peers (connectable, torrent, peer_id, ip, port, uploaded, downloaded, to_go, started, last_action, seeder, userid, agent, uploadoffset, downloadoffset, passkey) VALUES ('$connectable', '$torrentid', '$peer_id', '".$_GET['ip'] ."', '". $_GET['port']."' , ".$_GET['uploaded'].", ".$_GET['downloaded'].", ".$_GET['left'].", NOW(), NOW(), '$seeder', '$userid', '".$_GET['agent']."', '".$_GET['uploaded']."', '".$_GET['downloaded']."', '".$_GET['passkey']."')") or die(mysql_error());
		
		if(!$ret)
		{
			tracker_error('oeps....kon niks toevoegen in de database...sorry');
		}
		
		if ($ret)
			{
			if ($seeder == "yes")
				$updateset[] = "seeders = seeders + 1";
			else
				$updateset[] = "leechers = leechers + 1";
			}
		}
	}

if ($seeder == "yes")
	{
	if ($torrent["banned"] != "yes")
		$updateset[] = "visible = 'yes'";
	$updateset[] = "last_action = NOW()";
	}

if (count($updateset))
	//die( $torrentid);
	mysql_query("UPDATE torrents SET " . join(",", $updateset) . " WHERE id = $torrentid");

if (!verbindbaar())
	{
	tracker_error("U bent niet verbindbaar..3..");
	}
else
	benc_resp_raw($resp);

?>