<?php
class Usermodel extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    function gethash($login)
    {
        if ($login == 'test')
        {
            return 'd0a7da30c5bc3e8de3a1d0287ae5698b';
        }
        else
        {
            return false;
        }
    }
}
/*
    function get_last_ten_entries()
    {
        $query = $this->db->get('entries', 10);
        return $query->result();
    }

    function insert_entry()
    {
        $this->title   = $_POST['title']; // please read the below note
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->insert('entries', $this);
    }

    function update_entry()
    {
        $this->title   = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }
*/
?>