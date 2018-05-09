<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 4/27/2018
 * Time: 6:16 PM
 */
include("User.php");
session_start();
?>
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
    <li><a class='active' href='../php/homepage.php' name='homepageurl'>Homepage</a></li>
    <li><a class = 'active' href='../php/menu.php'>Menu</a></li>
    <li><a class='active' href='../php/search.php'>Search</a></li>
    <li><a class='active' href='../php/landing.php'>Sign Out</a></li>
    <li><a class='active' href='../php/userpage.php'>User Page</a></li>
    <?php checkAdmin(); ?>
</ul>



<h1>Welcome <?php getUserName(); ?></h1>
<h3> This Week's Popular Foods </h3>
<p>Top 3 foods of the week</p>
<?php TopThreeFoods(); ?>
</body>
</html>
<?php

function TopThreeFoods()
{
    include("FoodDao.php");
    include("RatingDao.php");
    #$user=$_SESSION['user'];
    $foodDao = new FoodDao();
    $ratingDao = new RatingDao();
    $ratings= $ratingDao->orderByValue();
    $ratings=array_reverse($ratings);
    //print_r($foods);
    $topThree = array_slice($ratings, 0, 3);
    $count = 1;
    for ($i = 0; $i < 3; $i++) {
        $food=$foodDao->selectByFoodname($topThree[$i]->foodname);
        $htmlStatement = '<p>' . $count . '. ' . $food->name . ' with a rating of ' . ($topThree[$i]->value ). '</p>';
        echo $htmlStatement;
        $count++;
    }
    echo '<table><tr>';
    for ($i = 0; $i < 3; $i++) {
        $food=$foodDao->selectByFoodname($topThree[$i]->foodname);
        $htmlStatement = '<td> <img src= "../static/images/' . $food->image . '"/> </td>';
        echo $htmlStatement;
    }
    echo '</tr><tr>';
    for ($i = 0; $i < 3; $i++) {
        $food=$foodDao->selectByFoodname($topThree[$i]->foodname);
        $htmlStatement = '<td><p>' . $food->name . '</p></td>';
        echo $htmlStatement;
    }
    echo '</tr></table>';
}
function checkAdmin()
{
    $user=$_SESSION['user'];
    if($user->admin==1)
    {
        echo '<li class=\'nav\'><a class=\'active\' href=\'admin.php\'>Admin Page</a></li>';
    }
    else{
        return;
    }
}

function getUserName(){
    echo $_SESSION['user']->username;
}
?>


