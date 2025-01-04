<?php
session_start();
 
if(isset($_REQUEST['signup']))
{
    //$_SESSION['status1']=true;
    header('location:signup.php');
}
elseif(isset($_REQUEST['registration']))
{
    header('location:registration.php');
}




?>