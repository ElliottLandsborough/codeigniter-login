<?php
//echo '<pre>'.print_r($theusers->result()).'</pre>';
echo '<table>';
echo '<th>username</th>';
echo '<th>email</th>';
//echo '<th>password hash</th>';
echo '<th>last login</th>';
echo '<th>registered from</th>';
echo '<th>permissions</th>';
foreach ($theusers->result_array() as $row)
{
	echo '<tr>';
   echo '<td>';
   echo '<a href="/profile/'.$row['user_id'].'">'.$row['user_name'].'</a>';
   echo '</td>';
   echo '<td>';
   $this->load->helper('url');
   echo safe_mailto($row['user_email']);
   echo '</td>';
   //echo '<td>';
   //echo $row['user_password'];
   //echo '</td>';
   echo '<td>';
   echo $row['user_lastlogin'];
   echo '</td>';
   echo '<td>';
   echo $row['user_joindate'];
   echo '</td>';
   echo '<td>';
   echo $row['user_perms'];
   echo '</td>';
   echo '</tr>';
}
echo '</table>';
?>