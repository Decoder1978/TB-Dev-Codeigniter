<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Global_model extends MX_Model {

    function categories() {
        return $this->db->select('*')
                        ->from('categories')
                        ->order_by('sort', 'asc')
                        ->get()
                        ->result();
    }

    function un_modded() {
        $this->db->where('modded', 'no');
        $this->db->from('torrents');
        return $this->db->count_all_results();
    }

}