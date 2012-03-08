<?php
echo 'Welcome, ';
if ($this->session->userdata('logged_in') == TRUE)
{
    echo $this->session->userdata('user_name').'. <a href="/user/logout">Logout</a>';
}
else
{
    echo '<a href="/user/login">login</a> or <a href="/user/register">register</a>';
}
?>