<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

	if(!function_exists('add_js')){
	 function add_js($file = array())
		{
			$str = '';
			$ci = &get_instance();
			$header_js  = $ci->config->item('header_js');
	 
			if(empty($file)){
				return;
			}
	 
			if(is_array($file)){
				if(!is_array($file) && count($file) <= 0){
					return;
				}
				foreach($file AS $item){
					$header_js[] = $item;
				}
				$ci->config->set_item('header_js',$header_js);
			}else{
				$str = $file;
				$header_js[] = $str;
				$ci->config->set_item('header_js',$header_js);
			}
		}
	}
	 
	//Dynamically add CSS files to header page
	if(!function_exists('add_css')){
		 function add_css($file='')
		{
			$str = '';
			$ci = &get_instance();
			$header_css = $ci->config->item('header_css');
	 
			if(empty($file)){
				return;
			}
	 
			if(is_array($file)){
				if(!is_array($file) && count($file) <= 0){
					return;
				}
				foreach($file AS $item){   
					$header_css[] = $item;
				}
				$ci->config->set_item('header_css',$header_css);
			}else{
				$str = $file;
				$header_css[] = $str;
				$ci->config->set_item('header_css',$header_css);
			}
		}
	}
	 
	if(!function_exists('put_headers')){
		 function put_headers()
		{
			$str = '';
			$ci = &get_instance();
			$header_css = $ci->config->item('header_css');
			$header_js  = $ci->config->item('header_js');
	 
			foreach($header_css AS $item){
				$str .= '<link rel="stylesheet" href="'.base_url().'assets/css/'.$item.'" type="text/css" />'."\n";
			}
	 
			foreach($header_js AS $item){
				$str .= '<script type="text/javascript" src="'.base_url().'assets/js/'.$item.'"></script>'."\n";
			}
	 
			return $str;
		}
	}


function get_date_time($timestamp = 0) {
    if ($timestamp)
        return date("Y-m-d H:i:s", $timestamp);
    else
        return date("Y-m-d H:i:s");
}

function title_url($str, $separator = '-', $lowercase = FALSE) {
    if ($separator == 'dash') {
        $separator = '-';
    } else if ($separator == 'underscore') {
        $separator = '_';
    }

    $q_separator = preg_quote($separator);

    $trans = array(
        '&.+?;' => '',
        '(*UTF8)[^a-zа-я0-9 _-]' => '',
        '\s+' => $separator,
        '(' . $q_separator . ')+' => $separator
    );

    $str = strip_tags($str);

    foreach ($trans as $key => $val) {
        $str = preg_replace("#" . $key . "#i", $val, $str);
    }

    if ($lowercase === TRUE) {
        $str = strtolower($str);
    }

    return trim($str, $separator);
}

function text_add(&$item, $key) {
    $item = '+' . $item;
}

function avatar($user, $size = 100) {

    $avatarpath = 'public/upload/avatars/' . $user;

    $image_properties = array(
        'src' => ($user != '' ? $avatarpath : 'public/assets/pic/default_avatar.jpg'),
        'class' => 'img-rounded img-responsive avatar',
        'width' => $size,
        'height' => $size
    );

    return img($image_properties);
}

function link_user($userid, $username) {

    if ($username)
        return '<span class="clickable" onclick="userinfo(' . $userid . ')">' . $username . '</span>';
    else
        return '<i>удалён</i>';
}

function mysql_human($timestamp = "", $format = "d/m/Y H:i:s") {
    if (empty($timestamp) || !is_numeric($timestamp))
        $timestamp = time();
    return date($format, $timestamp);
}

function _bbcode($str) {

    $str = trim(nl2br($str)); //new line break

    $str = parse_smileys($str, site_url('public/assets/pic/smilies/')); //add smileys support

    $parser = new JBBCode\Parser();

    $parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());

    $parser->parse($str);

    return $parser->getAsHtml();
}

function view_helper($view, $vars = array(), $output = false) {
    $CI = &get_instance();
    return $CI->load->view('templates/' . $CI->config->item('default_theme') . '/helpers/' . $view, $vars, $output);
}