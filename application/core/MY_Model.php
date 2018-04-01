<?php defined('BASEPATH') OR exit('No direct script access allowed');


class MY_Model extends CI_Model
{



	function gmtime()
	{
		return strtotime(get_date_time());
	}
		
	function get_elapsed_time($ts)
		{
		  $mins = floor(($this->gmtime() - $ts) / 60);
		  $hours = floor($mins / 60);
		  $mins -= $hours * 60;
		  $days = floor($hours / 24);
		  $hours -= $days * 24;
		  $weeks = floor($days / 7);
		  $days -= $weeks * 7;
		  $t = "";
		  if ($weeks > 0)
			if ($weeks > 1) return "$weeks weken"; 
			else return "$weeks week";
		  if ($days > 0)
			if ($days > 1) return "$days dagen geleden"; 
			else return "$days dag";
		  if ($hours > 0)
			if ($hours > 1) return "$hours uur geleden"; 
			else return "$hours uur geleden";
		  if ($mins > 0)
			if ($mins > 1) return "$mins minuten geleden"; 
			else return "$mins minuut geleden";
		  return "minder dan 1 minuut";
		}

}