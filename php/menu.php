<?php session_start(); ?>
<?php
include ("FoodDao.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" >
    <title>Menu</title>
    <link rel = 'stylesheet'  href = "../static/login.css" />
    <link rel = 'stylesheet'  href = "../static/nav.css" />
    <link rel = 'stylesheet'  href = "../static/menu.css" />
</head>
<body>
<script src="tableSort.js"></script>


<!--NAV BAR-->
<ul>
    <li><a class='active' href='homepage.php' name='homepageurl'>Homepage</a></li>
    <li><a class = 'active' href='menu.php'>Menu</a></li>
    <li><a class='active' href='search.php'>Search</a></li>
    <li><a class='active' href='landing.php'>Sign Out</a></li>
    <li><a class='active' href='userpage.php'>User Page</a></li>
</ul>

<!--Menu-->
<h1>This Week's Menu</h1>
<form id='form' method='post' action=''>
    <?php checkForm(); ?>
        <?php populateMenu(); ?>
</form>
</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 4/29/2018
 * Time: 6:31 PM
 */

function populateMenu()
{
    $dao = new FoodDao();
    $menuItems = $dao->selectAll();
    $dao=Null;
    echo '<table id="menutable">
        <tr>
            <th>Day</th>
            <th>Meal</th>
            <th>Station</th>
            <th> Button</th>
        </tr>
        <tr>';
    for ($i = 0; $i <count($menuItems); $i++) {
        $htmlStatment = ' <tr> <td>' . $menuItems[$i]->day . '</td><td>' . $menuItems[$i]->name . '</td><td>' . $menuItems[$i]->station
            . '</td><td><input type="submit" name="' . $menuItems[$i]->name . '" value="View Food"></td></tr>';
        echo $htmlStatment;
    }
    echo '</table>';
}
function checkForm()
{
    $dao = new FoodDao();
    $menuItems = $dao->selectAll();
    for ($i = 0; $i <count($menuItems); $i++) {
        $name=$menuItems[$i]->name;
        $name=str_replace(' ','_',$name);
        if(isset($_POST[$name])){
            $name=str_replace('_',' ',$name);
            $fooditem = $dao->selectByFoodname($name);
            $_SESSION['fooditem']=$fooditem;
            header("Location: ../php/fooditem.php"); /* Redirect browser */
        }
    }
}



?>