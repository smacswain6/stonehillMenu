<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" >
    <title>Homepage</title>
    <link rel = 'stylesheet'  href = "../static/login.css" />
    <link rel = 'stylesheet'  href = "../static/nav.css" />
</head>
<body>

<!--NAV BAR-->
<ul>
    <li><a class='active' href='../templates/homepage.html' name='homepageurl'>Homepage</a></li>
    <li><a class = 'active' href='../templates/menu.html'>Menu</a></li>
    <li><a class='active' href='../templates/search.html'>Search</a></li>
    <li><a class='active' href='../templates/landing.html'>Sign Out</a></li>
    <li><a class='active' href='../templates/userpage.html'>User Page</a></li>
</ul>



<h1>Homepage</h1>
<h3> This Week's Popular Foods </h3>
<p>Top 3 foods of the week</p>
<?php TopThreeFoods(); ?>
</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 4/27/2018
 * Time: 6:16 PM
 */

function TopThreeFoods()
{
    include("FoodDao.php");
    #$user=$_SESSION['user'];
    $dao = new FoodDao();
    $foods = $dao->orderByRating();
    $topThree = array_slice($foods, 0, 3);
    $count = 1;
    for ($i = 0; $i < 3; $i++) {
        $htmlStatement = '<p>' . $count . '. ' . $topThree[$i]->name . ' with a rating of ' . ($topThree[$i]->rating / $topThree[$i]->votes) . '</p>';
        echo $htmlStatement;
        $count++;
    }
    echo '<table><tr>';
    for ($i = 0; $i < 3; $i++) {
        $htmlStatement = '<td> <img src= "../static/images/' . $topThree[$i]->image . '"/> </td>';
        echo $htmlStatement;
    }
    echo '</tr><tr>';
    for ($i = 0; $i < 3; $i++) {
        $htmlStatement = '<td><p>' . $topThree[$i]->name . '</p></td>';
    }
    echo '</tr></table>';
}
?>


