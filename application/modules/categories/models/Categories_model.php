<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories_model extends CI_Model {

    function get_list() {
        return $this->db->select('*')
                        ->from('categories')
                        ->order_by('sort', 'asc')
                        ->get()
                        ->result();
    }
    
    function get_cat($id) {
        return $this->db->get_where('categories', array('id' => $id))->row();
        
    }

    function delete($id) {
        $this->db->delete('categories', array('id' => $id));
    }

    function add($data) {
        $this->db->insert('categories', $data);
    }
    
    function get_cat_details($id) {
        return $this->db->get_where('categories', array('id' => $id), 1)->row();
    }
    
    function edit($id, $data) {
        $this->db->update('categories', $data, 'id = ' . $id);
    }
}