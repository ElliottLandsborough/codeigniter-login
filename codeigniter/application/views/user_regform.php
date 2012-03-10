<?php
echo validation_errors();
$this->load->helper('form');
$attributes = array('class' => 'register');
echo form_open('/user/register', $attributes);
$username = array(
              'name'        => 'username',
              'class'          => 'username',
              'value'       => 'username',
              'maxlength'   => '26',
              'size'        => '16',
            );
$email = array(
              'name'        => 'email',
              'class'          => 'email',
              'value'       => 'email',
              'maxlength'   => '40',
              'size'        => '16',
            );
$emailconf = array(
              'name'        => 'emailconf',
              'class'          => 'emailconf',
              'value'       => 'email',
              'maxlength'   => '40',
              'size'        => '16',
            );
$password = array(
              'name'        => 'password',
              'class'          => 'password',
              'value'       => 'password',
              'maxlength'   => '32',
              'size'        => '16',
              'type'		=> 'password',
            );
$passconf = array(
              'name'        => 'passconf',
              'class'          => 'passconf',
              'value'       => 'password',
              'maxlength'   => '32',
              'size'        => '16',
              'type'        => 'password',
            );
echo form_input($username).'<br />';
echo form_input($email).'<br />';
echo form_input($emailconf).'<br />';
echo form_input($password).'<br />';
echo form_input($passconf).'<br />';
echo form_submit('doregister', 'register');
form_close()
?>