<!doctype html>
<head>
    <link rel = 'stylesheet'  href = "../static/login.css" />
    <title>CreateAccount</title>
</head>
<body>
<table class='inline'>
    <tr>
        <td>
            <h1>Create Account</h1>
            <form id='form' method='post' action = ''>
                <p>Userid: <input type='text' name='username'/></p>
                <p>Password: <input type='password' name='password'/></p>
                <input type='submit' name='submit' value='Create Account'/>
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
 * User: Matt
 * Date: 4/11/18
 * Time: 9:24 PM
 */

/** This class will handle create new accounts for users*/
function checkForm()
{
    if(isset($_POST['username']) and isset($_POST['password']))
    {
        createAccount();
    }
    else
    {
        return;
    }

}
function createAccount()
{
    include("UserDao.php");
    $dao = new UserDao();
    #check if username exists
    $userValue=$dao->selectByUserID($_POST['username']);
    if($userValue==NULL)
    {
        $dao->insert(new User($_POST['username'],$_POST['password'],0));
        header("Location: ../php/login.php");
    }
    else
    {
        echo 'User name already exists';
        header("Location: ../php/createAccount.php");
    }
}


?>