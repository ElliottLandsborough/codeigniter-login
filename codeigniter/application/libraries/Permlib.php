<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permlib {
	/**
	permissions - must increase in doubles to work
	AFTER DEPLOYMENT THESE CANNOT BE CHANGED EVER WITHOUT SERIOUS RISK OF CLUSTERFUCK.
	ONLY ADD NEW ONES - DO NOT MODIFY OLD ONES.
	see comments at bottom for numbers
	remember 32/64bit compatibility issues - ideally have no more than 31 different perm types else shit will hit fans
	*/

	private $Mask = 0;

	// parent perms
	const ACCESS = 1; // email validation complete - use this to ban people
	const VISIBILITY = 2;
	const COMMUNICATE = 4; // communication
    const EDIT = 8; // profile edit
    const VOUCHERS = 16; // vouchers
    const BRAND = 32; // brand profile
    const MODERATOR = 64; // mod profile
    const ADMINISTRATOR = 128; // admin profile
    // insert categorized perms here - up to 32 per cat
    
    // visibility perms
    const SEARCHABLE = 1;
    const PUBLIC_PROFILE = 2;

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
    	$this->RefreshMyPerms();
    }

    public function RefreshMyPerms()
    {
    	$CI =& get_instance();
        $dbpermsarray = $this->getmyperms();
        if ($dbpermsarray)
        {
		    $dbperms = $dbpermsarray;
			while($element = current($dbperms))
			{
				$key = key($dbperms);
				$CI->session->set_userdata($key, $dbperms[$key]);
			   	next($dbperms);
			}
		}
    }

    // specify default permission sets and tables/fields
    public function DefaultPerms($input)
    {
    	if ($input == 'parents')
    	{
    		$input = array( 
	    		permlib::ACCESS,
				permlib::COMMUNICATE,
				permlib::VISIBILITY,
				permlib::EDIT,
				permlib::VOUCHERS,
				permlib::BRAND,
				permlib::MODERATOR,
				permlib::ADMINISTRATOR
			);
    	}
    	else if (isset($input['parent']))
    	{
    		if ($input['parent'] == permlib::ACCESS)
			{
				$input['table'] = 'user_perms';
				$input['field'] = 'user_perms';
				// default permissions for standard users
				$input['permsarray'] = array( 
					permlib::COMMUNICATE,
					permlib::VISIBILITY,
					permlib::EDIT,
					permlib::VOUCHERS
				);
			}
			else if ($input['parent'] == permlib::VISIBILITY)
			{
				$input['table'] = 'user_visibility';
				$input['field'] = 'visibility_perms';
				// default permissions for standard users
				$input['permsarray'] = array( 
					permlib::SEARCHABLE,
					permlib::PUBLIC_PROFILE
				);
			}
			else if ($input['parent'] == permlib::COMMUNICATE)
			{
				$input['table'] = 'user_communication';
				$input['field'] = 'communication_perms';
				// default communication perms
	    		$input['permsarray'] = array( 
	    			permlib::WALL,
					permlib::STATUS,
					permlib::FRIENDS,
					permlib::PHOTO,
					permlib::CHAT,
					permlib::PRIVATE_MESSAGE
				);
			}
			else
			{
				$input = false;
			}
		}
		else
		{
			$input = false;
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
    	$CI =& get_instance();
    	if ( isset($input['user_id']) && $input['user_id'] != null)
    	{
    		$newinput['user_id'] = $input['user_id'];
	    	$parents = $this->DefaultPerms('parents');
	    	foreach ($parents as $parent)
			{
				$newinput['parent'] = $parent;
				$defaultperms = $this->DefaultPerms($newinput);
				if ($defaultperms != false)
				{
					$table = $defaultperms['table'];
					$field = $defaultperms['field'];
					$pquery = $CI->db->get_where($table, array('user_id' => $newinput['user_id']));
					if ($pquery->num_rows() == 0)
		        	{
		        		$this->InitializeDefaultPerms($newinput);
		        		$pquery = $CI->db->get_where($table, array('user_id' => $newinput['user_id']));
					}
					if ($pquery->num_rows() != 0)
		        	{
						$prow = $pquery->row(0);
						$perms[$field] = $prow->$field;
					}
				}
			}
			if (isset($perms))
			{
				return $perms;
			}
			else
			{
				return false;
			}
    	}
    	else
    	{
    		return false;
    	}
    	
    }

    // initialize default permissions
    public function InitializeDefaultPerms($input)
    {
    	$CI =& get_instance();
    	$perms->user_id = $input['user_id'];
    	$defaultperms = $this->DefaultPerms($input);
	    if ($defaultperms == true)
		{
			foreach ($defaultperms['permsarray'] as $perm)
			{
				$this->AddPermission($perm);
			}
			$table = $defaultperms['table'];
			$field = $defaultperms['field'];
			$perms->$field = $this->GetMask();
			if ($perms->user_id != null)
			{
				$save['user_id'] = $input['user_id'];
				$save['table'] = $table;
				$save['fields'] = $perms;
				return $this->save($save);
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}

    }

    public function GetDefaultPerms($input)
    {
    	$defaultperms = $this->DefaultPerms($input);
    	foreach ($defaultperms['permsarray'] as $perm)
		{
			$this->AddPermission($perm);
		}
		return $this->Mask;
    }

    public function SetPermissions($input)
	{
		$CI =& get_instance();
		$user_id = $input['user_id'];
		$perms->user_perms = $input['user_perms'];
		$CI->db->where('user_id', $user_id);
		return $CI->db->update('user_perms', $perms);
	}

	/*
	$save['table'];
	$save['user_id'];
	$save['fields'];
	*/
	public function save($input)
	{
		$CI =& get_instance();
		//$CI->db->start_cache();
		$table = $input['table'];
		$CI->db->from($table);
		//$CI->db->stop_cache();
		if ($input['user_id'] !== NULL)
		{
			$record = $input['fields'];
			$user_id = $input['user_id'];
			$CI->db->where('user_id',$user_id);
			if ($CI->db->count_all_results() == 0)
			{
				$query = $CI->db->insert($table, $record);
			}
			else
			{
				$query = $CI->db->update($table, $record, array('user_id'=>$user_id));
			}
			//$CI->db->flush_cache();
			if ($CI->db->affected_rows() > 0)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}

	public function ZeroMask()
	{
		$input['newmask'] = 0;
    	$this->SetMask($input);
	}

	public function SetMask($input=null)
	{
		if ($input['newmask']==null)
		{
			$theperms = $this->getperms($input);
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