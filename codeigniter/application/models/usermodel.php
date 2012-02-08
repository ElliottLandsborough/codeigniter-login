<?php
class Usermodel extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    function gethash($login)
    {
        $query = $this->db->get_where('users', array('user_name' => $login));
        $equery = $this->db->get_where('users', array('user_name' => $login));
        if ($query->num_rows() == 1 || ($equery->num_rows() == 1))
        {
            $row = $query->row(0);
            return $row->user_password;
        }
        else 
        {
            return false;
        }
    }

    function adduser($form)
    {
         $this->user_name = $form['login'];
         $this->user_email = $form['email'];
         $this->user_password = $form['hash'];
         $this->user_status = 'u';
         $this->user_lastlogin = $form['datetime'];
         $this->user_joindate = $form['datetime'];
         $this->user_key = $form['key'];
         return ($this->db->insert('users', $this));
    }

    function activateuser($key)
    {
        $query = $this->db->get_where('users', array('user_key' => $key));
        $row = $query->row(0);
        $this->user_key = 0;
        $this->user_lastlogin = date("Y-m-d H:i:s");
        $this->user_status = 'v';
        return $this->db->update('users', $this, array('user_key' => $row->user_key));
    }
}

?>