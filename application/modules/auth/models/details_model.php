<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Details_model extends CI_Model {

    function get_details($id) {
        $q = $this->db->select('t.*, c.name AS catname, c.url AS caturl, u.username')
                ->from('torrents t')
                ->join('categories c', 'c.id = t.category_id', 'left')
                ->join('users u', 'u.id = t.user_id', 'left')
                ->where('t.id', $id)
                ->limit(1);

        return $q->get()->row();
    }

    function get_trackers($id) {
        $query = $this->db->get_where('torrents_scrape', array('tid' => $id));
        return $query->result();
    }

    function get_files($id) {
        $query = $this->db->get_where('files', array('torrent' => $id));
        return $query->result();
    }

    function get_comments($id, $limit, $offset) {
        // results query
        $q = $this->db->select('c.id, c.text, c.user, c.added, c.editedby, u.username, u.userfile, e.username AS editedbyname')
                ->from('comments c')
                ->join('users u', 'c.user = u.id', 'left')
                ->join('users e', 'c.editedby = e.id', 'left')
                ->where('c.fid = ' . $id . ' AND c.location = "torrents"')
                ->limit($limit, $offset)
                ->order_by('c.id', 'desc');


        $ret['rows'] = $q->get()->result();

        // count query
        $this->db->where(array('fid' => $id, 'location' => 'torrents'));
        $this->db->from('comments');

        $ret['num_rows'] = $this->db->count_all_results();

        return $ret;
    }

    function update_info($id, $data) {
        $this->db->update('torrents', $data, 'id = ' . $id);
    }

    function update_torrents_scraper($id, $url, $data) {
        $this->db->where(array('tid' => $id, 'url' => $url));
        $this->db->update('torrents_scrape', $data);
    }

    function add_info($data) {
        $this->db->insert('torrents', $data);

        return $this->db->insert_id();
    }

    function add_trackers($data) {
        $this->db->insert('torrents_scrape', $data);
    }

    function add_files($data) {
        $this->db->insert('files', $data);
    }

    function delete_torrent($id) {
        $this->db->delete('torrents', array('id' => $id));
        $this->db->delete('torrents_scrape', array('tid' => $id));
        $this->db->delete('files', array('torrent' => $id));
        $this->db->delete('comments', array('fid' => $id, 'location' => 'torrents'));
    }

    function get_related($title, $tid, $cid) {
        $q = $this->db->select($this->config->item('db_select_str'))
                ->from('torrents')
                ->where('MATCH (name) AGAINST ("' . $title . '" IN BOOLEAN MODE) AND id != ' . $tid . ' AND category_id = ' . $cid, NULL, FALSE)
                ->limit($this->config->item('related_nr'));

        return $q->get()->result();
    }

    function new_torrent_id() {
        $q = $this->db->query("SHOW TABLE STATUS LIKE 'torrents'");
        $new_id = $q->row_array();
        return $new_id['Auto_increment'];
    }

}