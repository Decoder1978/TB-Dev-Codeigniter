<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    function list_all_countries() {
        return $this->db->get('countries')->result();
    }
	
	function get_username($id)
	{
	$res = $this->db->query("SELECT username FROM users WHERE id = $id")->row_array();
	if ($res)
		return $res['username'];
	}


    function get_user_country($uid) {

        return $this->db->select('c.name, c.flagpic')
                        ->from('countries c')
                        ->join('users u', 'u.country = c.id')
                        ->where('u.id', $uid)
                        ->get()->row();
    }

    function count_user_torrents($uid) {
        $this->db->where('owner', $uid);
        $this->db->where('modded', 'yes');
        $this->db->from('torrents');
        return $this->db->count_all_results();
    }

    function count_user_comments($uid) {
        $this->db->where('user', $uid);
        $this->db->from('comments');
        return $this->db->count_all_results();
    }

    function torrents($limit, $offset, $uid) {

        // results query
        $q = $this->db->select($this->config->item('db_select_str'))
                ->from('torrents')
                ->where(array('owner' => $uid))
                ->limit($limit, $offset)
                ->order_by('id', 'desc');

        $ret['rows'] = $q->get()->result();

        // count query
        $this->db->where(array('owner' => $uid));
        $this->db->from('torrents');

        $ret['num_rows'] = $this->db->count_all_results();

        return $ret;
    }

    function comments($id, $limit, $offset) {
        // results query
        $q = $this->db->select('c.fid, c.id, c.text, c.added, t.url, t.name AS torrentname')
                ->from('comments c')
                ->join('torrents t', 'c.fid = t.id', 'left')
                ->where('c.user', $id)
                ->limit($limit, $offset)
                ->order_by('c.id', 'desc');


        $ret['rows'] = $q->get()->result();

        // count query
        $q = $this->db->select('COUNT(*) as count', FALSE)
                ->from('comments')
                ->where('user', $id)
                ->get()
                ->result();

        $ret['num_rows'] = $q[0]->count;

        return $ret;
    }

}