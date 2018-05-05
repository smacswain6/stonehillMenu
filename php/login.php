<!DOCTYPE html>
<html>
<head>
    <link rel = 'stylesheet'  href = "../static/login.css" />
    <meta charset="UTF-8" >
    <title>Login</title>
</head>
<body>
<h1> Stonehill Caf Menu App</h1>

<!--LOGIN-->
<table class='inline'><tr><td>
            <h2>Login</h2>
            <form id='form' method='post' action=''/>
            <?php login(); ?>
            <p>Username: <input type='text' placeholder="Enter Username" name='username'/></p>
            <p>Password: <input type='password' placeholder="Enter Password" name='password'/></p>
            <input type='submit' value='Submit'/>
            </form>
        </td></tr></table>
<img src='../static/images/Roche1.jpg' alt='Roche1' class='left' class='inline'/>
<img src='../static/images/Roche2.jpg' alt='Roche2' class='right' class='inline'/>

<img src='../static/images/foodbanner.jpg' alt='foodbanner' class='banner'/>

</body>
</html>
<?php
function login()
{
    include("UserDao.php");
    /* right now hardcoded for one user, in future will incorporate sql database to check
    username password combo */
    if(isset($_POST['username'])) {
        $dao = new UserDao();
        $user = $dao->selectByUserID($_POST["username"]);
        if ($user == NULL) {
            return;
        } else if ($_POST["username"] == $user->username && $_POST["password"] == $user->password) {
            session_start();
            $_SESSION['user'] = $user->username;
            header('Location:../php/homepage.php');
        } else {
            header("'Location:../php/login.php");
        }
    }
}
?>