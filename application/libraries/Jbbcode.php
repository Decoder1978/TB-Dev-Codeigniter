<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Jbbcode
{
    public function __construct()
    {
        require_once APPPATH.'third_party/JBBCode/Parser.php';
    }
}