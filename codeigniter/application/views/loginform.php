<?php
$this->load->helper('form');
$attributes = array('class' => 'login', 'id' => 'login');
echo form_open('user/login', $attributes);
$data = array(
              'name'        => 'username',
              'id'          => 'username',
              'value'       => 'username',
              'maxlength'   => '30',
              'size'        => '30',
            );
echo form_input($data);
$data = array(
              'name'        => 'password',
              'id'          => 'password',
              'value'       => '',
              'maxlength'   => '30',
              'size'        => '30',
              'type'		=> 'password',
            );
echo form_input($data);
echo form_submit('dologon', 'login');
form_close()
?>