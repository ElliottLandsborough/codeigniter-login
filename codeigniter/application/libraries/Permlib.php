<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permlib {

	/**
	permissions - must increase in squares to work
	AFTER DEPLOYMENT THESE CANNOT BE CHANGED EVER WITHOUT SERIOUS RISK OF CLUSTERFUCK.
	ONLY ADD NEW ONES - DO NOT MODIFY OLD ONES.
	*/
	// maybe don't have these in consts and have them in an array instead??
	const ACCESS = 1; // equivalent of being unbanned
    const EDIT_SELF = 2; // in case we want to disable edits for specific users
    const DISABLE_SELF = 4; // user can disable OWN profile only
    const VIEW_VOUCHERS = 8;
    const OWN_VOUCHERS = 16; // can own/edit vouchers
    const GLOBAL_VOUCHERS = 32; // can edit/disable ALL vouchers
    const GLOBAL_VIEW = 64; // can view anything
    const GLOBAL_EDIT = 128; // can edit anything
    const GLOBAL_DISABLE = 256; // can disable anything
    const SUPERADMIN = 512; // can add/remove global operators
    
    public function __construct()
    {
    	$Mask = 0;
        $this->Mask = $Mask;
        $CI =& get_instance();
        $dbperms = $this->getperms($CI->session->userdata('user_id'));
        if ($dbperms != $CI->session->userdata('user_perms'));
        {
        	$CI->session->set_userdata('user_perms', $dbperms);
        }
    }

    // return the users permissions
    public function getperms($user_id=null)
	{
		$CI =& get_instance();	
		if ($user_id==null)
		{
			$input['user_id'] = $CI->session->userdata('user_id');
		}
		else
		{
			$input['user_id'] = $user_id;
		}
		$pquery = $CI->db->get_where('user_perms', array('user_id' => $input['user_id']));
		if ($pquery->num_rows() == 0)
		{
			if ($this->DefaultPerms($input))
        	{
        		$pquery = $CI->db->get_where('user_perms', array('user_id' => $input['user_id']));
        	}
		}
		if ($pquery->num_rows() != 0)
		{
			$prow = $pquery->row(0);
   			$perms = $prow->user_perms;
       		return $perms;
       	}
	}

	// setup default permission set
	public function DefaultPerms($input)
	{
		$CI =& get_instance();
		$perms->user_id = $input['user_id'];
		// default permissions for standard users
		$permsarray = array( 
			permlib::EDIT_SELF,
			permlib::DISABLE_SELF,
			permlib::VIEW_VOUCHERS
			);
		foreach ($permsarray as $perm)
		{
			$this->AddPermission($perm);
		}
		$perms->user_perms = $this->GetMask();
		if ($perms->user_id != null)
		{
			return ($CI->db->insert('user_perms', $perms));
		}
	}

	public function SetPermissions($input)
	{
		$CI =& get_instance();
		$user_id = $input['user_id'];
		$perms->user_perms = $input['user_perms'];
		$CI->db->where('user_id', $user_id);
		return $CI->db->update('user_perms', $perms);
	}

	public function SetMask($input)
	{
		if ($input['newmask']==null)
		{
			$this->Mask = $this->getperms($input['user_id']);
		}
		else
		{
			$this->Mask = $input['newmask'];
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

}

?>