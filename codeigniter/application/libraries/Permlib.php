<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permlib {

	/**
	permissions - must increase in squares to work
	AFTER DEPLOYMENT THESE CANNOT BE CHANGED EVER WITHOUT SERIOUS RISK OF CLUSTERFUCK.
	ONLY ADD NEW ONES - DO NOT MODIFY OLD ONES.
	*/
	// maybe don't have these in consts and have them in an array instead??
	const VIEW_PROFILE = 1; // equivalent of being banned
    const EDIT_PROFILE = 2; // in case we want to disable edits for specific users
    const DISABLE_PROFILE = 4; // user can disable OWN profile only
    const VIEW_VOUCHER = 8;
    const EDIT_VOUCHER = 16; // can edit vouchers
    const DISABLE_VOUCHER = 32; // disable OWN vouchers only
    const GLOBAL_EDIT = 64; // can edit all
    const GLOBAL_DISABLE = 128; // can disable all
    const SUPERADMIN = 256; // everything including view ALL disabled profiles and vouchers
    
    public function __construct()
    {
    	$Mask = 0;
        $this->Mask = $Mask;
    }

	// return the users permissions
	public function getperms($user_id=null)
	{
		$CI =& get_instance();
		if ($user_id==null)
		{
			$login = $CI->session->userdata('user_login');
			$email = $CI->session->userdata('user_email');
        	$query = $CI->db->get_where('users', array('user_name' => $login,'user_email' => $email));
        	$row = $query->row(0);
        	$input['user_id'] = $row->user_id;
        }
        else
        {
        	$input['user_id'] = $user_id;
        }
        $pquery = $CI->db->get_where('user_perms', array('user_id' => $input['user_id']));
        if ($pquery->num_rows() == 0)
        {
        	if ($this->setperms($input))
        	{
        		$perms = $this->getperms($input['user_id']);
        	}
        }
        else
        {
        	$prow = $pquery->row(0);
        	$perms = $prow->user_perms;
        }
        return $perms;
	}

	// change a users permissions
	/* usage:
	$newperms = array( 
		permlib::VIEW_PROFILE,
		permlib::EDIT_PROFILE,
		permlib::DISABLE_PROFILE,
		permlib::VIEW_VOUCHER
		);

	$array = array(
		'user_id' => $user_id,
		'newperms'=> $newperms
		);
	setperms($array);
	*/
	public function setperms($input=null)
	{
		$CI =& get_instance();
		$perms->user_id = $input['user_id'];
		if (!isset($input['newperms']))
		{
			// default permissions for standard users
			$permsarray = array( 
				permlib::VIEW_PROFILE,
				permlib::EDIT_PROFILE,
				permlib::DISABLE_PROFILE,
				permlib::VIEW_VOUCHER
				);
		}
		else
		{
			//$this->Mask = $this->getperms($input['user_id']);
			$this->Mask = 0;
			$permsarray = $input['newperms'];
		}
		foreach ($permsarray as $perm)
		{
			$this->AddPermission($perm);
		}
		// in here goes the rest of function - basically need to work out whether to add or remove permissions instead of always adding them.
		$perms->user_perms = $this->GetMask();
		if (!isset($input['newperms']))
		{
			return ($CI->db->insert('user_perms', $perms));
		}
		else
		{
			return ($CI->db->update('user_perms', $perms));
		}
	}

	public function InvokePermission($Bit)
    {
        return ($this->Mask & $Bit); //True / False
    }

    public function AddPermission($Bit)
    {
        $this->Mask |= $Bit; //Add the bit to the mask
    }

    public function RevokePermission($Bit)
    {
        $this->Mask &= ~ $Bit;
    }

    public function GetMask()
    {
         return $this->Mask;
    }

    /*
	if($this->permlib->InvokePermission(permlib::VIEW_PROFILE))
	{
	    //User can vew profiles
	}
    */
}

?>