<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comments_model extends CI_Model {

    function add($data, $tid) {
        $this->db->insert('comments', $data);

        $this->db->where('id', $tid);
        $this->db->set('comments', '`comments`+1', FALSE);
        $this->db->update('torrents');
    }

    function get_last($cid) {
        return $this->db->select('c.id, c.text, c.user, c.added, c.editedby, u.username, u.userfile, e.username AS editedbyname')
                        ->from('comments c')
                        ->join('users u', 'c.user = u.id', 'left')
                        ->join('users e', 'c.editedby = e.id', 'left')
                        ->where('c.id = ' . $cid)
                        ->limit(1)
                        ->order_by('c.id', 'desc')
                        ->get()
                        ->result();
    }

    function new_comment_id() {
        $q = $this->db->query("SHOW TABLE STATUS LIKE 'comments'");
        $new_id = $q->row_array();
        return $new_id['Auto_increment'];
    }

    function delete($commentid, $fid) {

        $this->db->delete('comments', array('id' => $commentid));

        if ($fid && $this->db->affected_rows() > 0) {
            $this->db->where('id', $fid);
            $this->db->set('comments', '`comments`-1', FALSE);
            $this->db->update('torrents');
        }
    }

    function edit($data, $id) {

        $this->db->update('comments', $data, 'id = ' . $id);
    }

    function get_by_id($cid) {

        return $this->db->get_where('comments', array('id' => $cid), 1)
                        ->row();
    }

}