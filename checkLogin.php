<?php

//start the session
session_start();

//check to make sure the session variable is registered
//if(session_is_registered('username')) {
if(isset($_SESSION['username'])){

//the session variable is registered, the user is allowed to see anything that follows
    echo 'Welcome, you are still logged in.';
}else {

//the session variable isn't registered, send them back to the login page
    header( "Location: logbook/index.php" );
}

?> 
