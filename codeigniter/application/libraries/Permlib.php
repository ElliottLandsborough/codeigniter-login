<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permlib {

	/**
	permissions - must increase in doubles to work
	AFTER DEPLOYMENT THESE CANNOT BE CHANGED EVER WITHOUT SERIOUS RISK OF CLUSTERFUCK.
	ONLY ADD NEW ONES - DO NOT MODIFY OLD ONES.
	see comments at bottom for numbers
	remember 32/64bit compatibility issues - ideally have no more than 31 different perm types else shit will hit fans
	*/
	// maybe don't have these in consts and have them in an array instead??
	const ACCESS = 1; // email validation complete - use this to ban people
	const COMMUNICATE = 2; // communication
    const EDIT = 4; // profile edit
    const VOUCHERS = 8; // vouchers
    const BRAND = 16; // brand profile
    const MODERATOR = 32; // mod profile
    const ADMINISTRATOR = 64; // admin profile
    // insert categorized perms here - up to 32 per cat
    
    // communication permissions
    const WALL = 1; // post on walls
    const STATUS = 2; // update status
    const FRIENDS = 4; // can have friends
    const PHOTO = 8; // can photo
    const CHAT = 16; // can chat
    const PRIVATE_MESSAGE = 32; // can private message
    
    /* TODO
	vouchers:
		own (yes/no)
		trade (yes/no)
		bid?? (yes/no)

	brand:
		leave this for now,
		combination of own/edit
		vouchers and also
		profile with wall etc

	pretty much any content at all:
		public
		friends only
		private
		public minus friends?
		password protected?
    */

    public function __construct()
    {
    	$Mask = 0;
        $this->Mask = $Mask;
        $CI =& get_instance();
        $dbperms = $this->getperms($CI->session->userdata('user_id'));
        $theperms = $dbperms['user_perms'];
        if ($theperms != $CI->session->userdata('user_perms'));
        {
        	$CI->session->set_userdata('user_perms', $theperms);
        }
    }

    // default permission sets and tables/fields
    public function defaultperms($input)
    {
    	if ($input['permsarray'] == permlib::ACCESS)
		{
			$input['table'] = 'user_perms';
			$input['field'] = 'user_perms';
			// default permissions for standard users
			$permsarray = array( 
				permlib::COMMUNICATE,
				permlib::EDIT,
				permlib::VOUCHERS
			);
		}
		else if ($input['permsarray'] == permlib::COMMUNICATE)
		{
			$input['table'] = 'user_communication';
			$input['field'] = 'communication_perms';
			// default communication perms
    		$permsarray = array( 
    			permlib::WALL,
				permlib::STATUS,
				permlib::FRIENDS,
				permlib::PHOTO,
				permlib::CHAT,
				permlib::PRIVATE_MESSAGE
			);
		}
		return $input;
    }

    public function getmyperms()
    {
    	$CI =& get_instance();
    	$input['user_id'] = $CI->session->userdata('user_id');
    	return  $this->getperms($input);
    }

    public function getperms($input)
    {
    	$user_id = $input['user_id'];
    	$user_id = $input['user_id'];
    }
    /*
	
    */
    /*
	// return the users permissions
    public function getperms($input)
	{
		$CI =& get_instance();
		$user_id = $input['user_id'];
		$output['user_id'] = $user_id;
		$pquery = $CI->db->get_where('user_perms', array('user_id' => $output['user_id']));
		if ($pquery->num_rows() == 0)
		{
			$output['permsarray'] = permlib::ACCESS;
			if ($this->DefaultPerms($output))
        	{
        		$pquery = $CI->db->get_where('user_perms', array('user_id' => $output['user_id']));
        	}
		}
		if ($pquery->num_rows() != 0)
		{
			$prow = $pquery->row(0);
   			$perms['user_perms'] = $prow->user_perms;
       		return $perms;
       	}
	}


    public function secperms($input)
    {
    	$CI =& get_instance();
    	$perms = $this->getperms($input);
    	$perms['newmask'] = $perms['user_perms'];
	   	$this->SetMask($perms);
    	if($this->InvokePermission(permlib::ADMINISTRATOR))
    	{
    		
    	}
    	else if ($this->InvokePermission(permlib::MODERATOR))
    	{

    	}
    	else if ($this->InvokePermission(permlib::BRAND))
    	{

    	}
    	else if ($this->InvokePermission(permlib::ACCESS))
    	{
    		
    		$pquery = $CI->db->get_where('user_communication', array('user_id' => $input['user_id']));
    		$prow = $pquery->row(0);
    		$perms['communication_perms'] = $prow->communication_perms;
    	}
    	unset($perms['newmask']);
    	return $perms;
    }

    // setup default permission set
	public function DefaultPerms($input)
	{
		$CI =& get_instance();
		$perms->user_id = $input['user_id'];
		if ($input['permsarray'] == permlib::ACCESS)
		{
			$input['table'] = 'user_perms';
			$input['field'] = 'user_perms';
			// default permissions for standard users
			$permsarray = array( 
				permlib::COMMUNICATE,
				permlib::EDIT,
				permlib::VOUCHERS
			);
		}
		else if ($input['permsarray'] == permlib::COMMUNICATE)
		{
			$input['table'] = 'user_communication';
			$input['field'] = 'communication_perms';
			// default communication perms
    		$permsarray = array( 
    			permlib::WALL,
				permlib::STATUS,
				permlib::FRIENDS,
				permlib::PHOTO,
				permlib::CHAT,
				permlib::PRIVATE_MESSAGE
			);
		}
		foreach ($permsarray as $perm)
		{
			$this->AddPermission($perm);
		}
		$tablename = $input['field'];
		$perms->$tablename = $this->GetMask();
		if ($perms->user_id != null)
		{
			return ($CI->db->insert($input['table'], $perms));
		}
	}

	public function SetPermissions($input)
	{
		$CI =& get_instance();
		$user_id = $input['user_id'];
		$perms->user_perms = $input['user_perms'];
		$CI->db->where('user_id', $user_id);
		return $CI->db->update('user_perms', $perms);
	}*/

	public function SetMask($input)
	{
		if ($input['newmask']==null)
		{
			$theperms = $this->getperms($input['user_id']);
			$this->Mask = $theperms['user_perms'];
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

	/* permissions numbers:
	1. 1
	2. 2
	3. 4
	4. 8
	5. 16
	6. 32
	7. 64
	8. 128
	9. 256
	10. 512
	11. 1024
	12. 2048
	13. 4096
	14. 8192
	15. 16384
	16. 32768
	17. 65536
	18. 131072
	19. 262144
	20. 524288
	21. 1048576
	22. 2097152
	23. 4194304
	24. 8388608
	25. 16777216
	26. 33554432
	27. 67108864
	28. 134217728
	29. 268435456
	30. 536870912
	31. 1073741824
	32. 2147483648
	// stop here if 32bit os
	33. 4294967296
	34. 8589934592
	35. 17179869184
	36. 34359738368
	37. 68719476736
	38. 137438953472
	39. 274877906944
	40. 549755813888
	41. 1099511627776
	42. 2199023255552
	43. 4398046511104
	44. 8796093022208
	45. 17592186044416
	46. 35184372088832
	47. 70368744177664
	48. 140737488355328
	49. 281474976710656
	50. 562949953421312
	51. 1125899906842624
	52. 2251799813685248
	53. 4503599627370496
	54. 9007199254740992
	55. 18014398509481984
	56. 36028797018963968
	57. 72057594037927936
	58. 144115188075855872
	59. 288230376151711744
	60. 576460752303423488
	61. 1152921504606846976
	62. 2305843009213693952
	63. 4611686018427387904
	*/
	/*
	public function profileview($query)
	{
		$row = $query->row(0);
		echo $row->user_name;
		$j=0;
		for ($i=1; $j<63;)
 		{
 			$j++;
  			echo $j.". ".$i."<br />";
  			$i = $i*2;
  		}
	}
	*/
?>