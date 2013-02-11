<?PHP

include "config.php";
//check that the user is calling the page from the login form and not accessing it directly
//and redirect back to the login form if necessary
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header("Location: ../index.php");
}
//check that the form fields are not empty, and redirect back to the login page if they are
elseif (empty($_POST['username']) || empty($_POST['password'])) {
    header("Location: ../index.php");
} else {
//convert the field values to simple variables
//add slashes to the username and md5() the password
    $user = addslashes($_POST['username']);
    $pass = md5($_POST['password']);

    $result = mysql_query("select * from users where username='$user' AND password='$pass'", $dbh);

//check that at least one row was returned

    $rowCheck = mysql_num_rows($result);
    if ($rowCheck > 0) {
        while ($row = mysql_fetch_array($result)) {

            //start the session and register a variable

            session_start();
            //session_register('username');
            $_SESSION['username'] = $user;

            //successful login code will go here...
            //echo 'Success!';
            //we will redirect the user to another page where we will make sure they're logged in
            header("Location: main.php");
        }
    } else {
        //if nothing is returned by the query, unsuccessful login code goes here...
        header("Location: index.php");
        //echo 'Incorrect login name or password. Please try again.';
    }
}
?> 
