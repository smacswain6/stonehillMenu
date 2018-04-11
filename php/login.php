<html>
<body>

<?php

    /* right now hardocded for one user, in future will incorporate sql database to check
    username password combo */
    if($_POST["username"]=="smacswain")
    {
        if($_POST["password"]=="password") {
            include("../templates/homepage.html");
        }
    }
    else
    {
        include("../templates/login.html");
    }
    ?>
</body>
</html>