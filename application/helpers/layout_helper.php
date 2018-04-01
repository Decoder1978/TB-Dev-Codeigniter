<?php


	function begin_frame($title = NULL, $type = 'default')
		{
	    $x  = '<div class="panel panel-'. $type .'">';
        $x .= '<div class="panel-heading">';
        $x .= '<h3 class="panel-title">'.  $title .'</h3>';
		$x .= '</div>';
        $x .= '<div class="panel-body">';	
		
		return $x;
		}
	
	
	function end_frame()
	{
	$x  = '</div>';
    $x .= '</div>';
	return $x; 
	}
	
	


	

