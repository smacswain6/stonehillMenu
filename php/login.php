<html>
<body>

<?php
include ("UserDao.php");
    /* right now hardcoded for one user, in future will incorporate sql database to check
    username password combo */
    $dao=new UserDao();
    $dao->connect();
    $user=$dao->selectByUserID($_POST["username"]);
    if($_POST["username"]==$user['username'] && $_POST["password"]==$user["password"])
    {
        include("../templates/homepage.html");
    }
    else
    {
        include("../templates/login.html");
    }
    ?>
</body>
</html>