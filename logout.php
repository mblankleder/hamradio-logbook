<?php

//start the session
session_start();

//check to make sure the session variable is registered
//if(session_is_registered('username')) {
if (isset($_SESSION['username'])) {
    //session variable is registered, the user is ready to logout
    unset($_SESSION['username']);
    //session_unset();
    //session_destroy();
    header("Location: index.php");
} else {
    //the session variable isn't registered, the user shouldn't even be on this page
    header("Location: index.php");
}
?> 
