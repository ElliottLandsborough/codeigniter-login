<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userlib {

	// return 32 randomish characters
    public function genrandomstring()
	{
		// stick with md5 because of speed
		return md5(uniqid(rand(), true));
		//return hash_hmac('sha512', uniqid(rand(), true), $site_key);
	}

	/*
	Password encryption function using two separately located salts:
	 - the codeigniter encryption key salt
	 - a salt stored in the db
	 - trixy coding so it looks like it's an md5 hash
	 - sha512
	 - probably slower than other stuff but secure as fuck
	
	To create the hash/salt:
	$newhash = _passcrypt('password');
	$salt = substr($string, 0, 16);
	$hash = substr($string, -16);

	To check 'password':
	$dbhash = mysql -> get hash from table where userid == x;
	$salt = substr($dbhash, 0, 16);
	$check = _passcrypt('password',$salt);
	$checkhash = substr($check, -16);
	*/
	public function passcrypt($password,$salt=null)
	{
		$CI =& get_instance();
		$site_key = $CI->config->item('encryption_key'); // get the codeigniter encryption key
	    if ($salt === null) // if the salt hasn's been set
	    { // get the first 16 chars of md5(randomshit) to use as salt for this user
			$salt = substr($this->genrandomstring(), 0, 16); 
	    }
	    // make a codeigniter-key-salted-sha512 hash of $password.$salt
		$securehash = hash_hmac('sha512', $password . $salt, $site_key);
		// return 16-char-salt.16-char-hash to store in db
		// so it just looks like a standard md5 hash
		return $salt . substr(md5(sha1($securehash)), 0, 16);
	}

	// check login details
	public function checklogin($form)
	{

		$hashresult = $this->gethash($form['login']);
		$hash = $hashresult['hash'];
		$user_name = $hashresult['user_name'];
		$user_email = $hashresult['user_email'];
		if (!$hash)
		{
			$this->logout();
			return false;
		}
		else
		{
			$csalt = substr($hash, 0, 16);
			$check = $this->passcrypt($form['pass'],$csalt);
			if ($hash == $check && $form['login'] != '')
			{
				$CI =& get_instance();
				$CI->session->set_userdata('user_name', $user_name);
				$CI->session->set_userdata('user_email', $user_email);
				$CI->session->set_userdata('logged_in', TRUE);
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	// log user out
	public function logout()
	{
		$CI =& get_instance();
		$CI->session->set_userdata('logged_in', FALSE);
		$CI->session->sess_destroy();
		return true;
	}

	// get hash from db if user exists
	private function gethash($login)
    {
    	$CI =& get_instance();
        $query = $CI->db->get_where('users', array('user_name' => $login));
        // make it allow email OR username
        $equery = $CI->db->get_where('users', array('user_email' => $login));
        if ($query->num_rows() == 1 || $equery->num_rows() == 1)
        {
        	if ($query->num_rows() == 1)
        	{
        		$row = $query->row(0);
        	}
            else
        	{
        		$row = $equery->row(0);
        	}
            $result['hash'] = $row->user_password;
            $result['user_name'] = $row->user_name;
            $result['user_email'] = $row->user_email;
            return $result;
        }
        else 
        {
            return false;
        }
    }

    // add user to db
    public function adduser($form)
    {
    	$CI =& get_instance();
        $this->user_name = $form['login'];
        $this->user_email = $form['email'];
        $this->user_password = $form['hash'];
        $this->user_status = 'u';
        $this->user_lastlogin = $form['datetime'];
        $this->user_joindate = $form['datetime'];
        $this->user_key = $form['key'];
        return ($CI->db->insert('users', $this));
    }

    // email activation
    public function activateuser($key)
    {
    	$CI =& get_instance();
        $query = $CI->db->get_where('users', array('user_key' => $key));
        $row = $query->row(0);
        $this->user_key = 0;
        $this->user_lastlogin = date("Y-m-d H:i:s");
        $this->user_status = 'v';
        return $CI->db->update('users', $this, array('user_key' => $row->user_key));
    }

}

?>