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

<!--NAV BAR-->
<ul>
    <li><a class='active' href='homepage.html' name='homepageurl'>Homepage</a></li>
    <li><a class = 'active' href='menu.html'>Menu</a></li>
    <li><a class='active' href='search.html'>Search</a></li>
    <li><a class='active' href='landing.html'>Sign Out</a></li>
    <li><a class='active' href='userpage.html'>User Page</a></li>
</ul>

<!--Menu-->
<h1>This Week's Menu</h1>
<form id='form' method='post' action='menu'>
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
    include("FoodDao.php");
    #$user = $_SESSION['user'];
    $dao = new FoodDao();
    $menuItems = $dao->selectAll();
    echo '<table>
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

?>