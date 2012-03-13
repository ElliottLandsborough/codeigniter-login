<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Listusers extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_users()
    {
        //$query = $this->db->get('users');
        //return $query->result();
        $this->db->select(' users.user_id,
                            users.user_name,
                            users.user_email,
                            users.user_password,
                            users.user_lastlogin,
                            users.user_joindate,
                            user_perms.user_perms,
                            user_communication.communication_perms,
                            user_visibility.visibility_perms
                        ');
        $this->db->from('users');
        $this->db->join('user_perms', 'users.user_id = user_perms.user_id');
        $this->db->join('user_communication', 'users.user_id = user_communication.user_id');
        $this->db->join('user_visibility', 'users.user_id = user_visibility.user_id');
        //$this->db->where('user_perms.user_perms <=', $perms);
        $q = $this->db->get();
        return $q;
    }

}
?>