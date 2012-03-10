<?php
$this->load->helper('form');
echo validation_errors();
$attributes = array('class' => 'login');
echo form_open('user/login', $attributes);
$username = array(
              'name'        => 'username',
              'class'          => 'username',
              'value'       => '',
              'maxlength'   => '26',
              'size'        => '26',
            );
echo form_input($username);
$password = array(
              'name'        => 'password',
              'class'          => 'password',
              'value'       => '',
              'maxlength'   => '32',
              'size'        => '26',
              'type'        => 'password',
            );
echo form_input($password);
echo $html_captcha;
echo form_submit('dologon', 'login');
form_close()
?>