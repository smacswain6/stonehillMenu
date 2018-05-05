<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" >
    <title>Landing Page</title>
    <link rel = 'stylesheet'  href = "../static/login.css" />
</head>
<body>
<h1> Stonehill Caf Menu App</h1>
<table class='inline'>
    <tr>
        <td>
            <form id='form' method='post' action=''/>
            <input type='submit' name='existinguser' value='Existing User'/>
            <input type='submit' name='newuser' value='New User'/>
            </form>
            <?php checkForm(); ?>
        </td>
    </tr>
</table>
<img src='../static/images/Roche1.jpg' alt='Roche1' class='left' class='inline'/>
<img src='../static/images/Roche2.jpg' alt='Roche2' class='right' class='inline'/>
<img src='../static/images/foodbanner.jpg' alt='foodbanner' class='banner'/>
</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 5/5/2018
 * Time: 3:59 PM
 */

function checkForm()
{
    if(isset($_POST['existinguser']))
    {
        header("Location: ../php/login.php");
    }
    else if(isset($_POST['newuser']))
    {
        header("Location: ../php/createAccount.php");
    }
    else
    {
        return;
    }
}