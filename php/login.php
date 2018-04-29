<html>
<body>

<?php
include ("UserDao.php");
    /* right now hardcoded for one user, in future will incorporate sql database to check
    username password combo */
    $dao=new UserDao();
    $user=$dao->selectByUserID($_POST["username"]);
    if($user==NULL)
    {
        header('Location:../templates/login.html');
    }
    else if($_POST["username"]==$user->username && $_POST["password"]==$user->password)
    {
        session_start();
        $_SESSION['user']=$user->username;
        header('Location:../templates/homepage.html');
    }
    else
    {
        header("'Location:../templates/login.html");
    }
    ?>
</body>
</html>