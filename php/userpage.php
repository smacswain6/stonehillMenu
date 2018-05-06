<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 5/6/2018
 * Time: 4:19 PM
 */
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" >
    <title>User Page</title>
    <link rel = 'stylesheet'  href = "../static/nav.css" />
    <link rel = 'stylesheet'  href = "../static/userpageCSS.css" />
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

<div class="reviews">
    <?php getReviews(); ?>
</div>

<div class="rates">
   <?php getRatings(); ?>
</div>
<div class="stats">

    <table class=\"one\" height=\"200px\" width=\"400px\">
        <th>User stats</th>
        <tr>
            <td>Total ratings: </td>
            <td>{{ratingCount}}</td>
        </tr>
        <tr>
            <td>Average rating: </td>
            <td>{{avgRating}}</td>
        </tr>
        <tr>
            <td>Total Reviews:</td>
            <td>{{reviewCount}}</td>
        </tr>
    </table>

</div>
</body>
</html>

<?php

function getReviews()
{
    include("ReviewDao.php");
    $dao=new ReviewDao();
    $reviews=$dao->selectByUsername($_SESSION['user']);
    print_r($reviews);
    array_reverse($reviews);
    $topThree = array_slice($reviews, 0, 3);
   echo ' <table> <th> Your three most recent reviews: </th> ';
   for($i=0;$i<count($topThree);$i++) {
       echo '<tr><td>' . ($i + 1) . '.' . $topThree[$i]->foodname . '<br>' . $topThree[$i]->review . '</td></tr>';
   }
    echo '</table>';
}
function getRatings()
{
    echo '<table><th>Your three favorite meals: </th>';
    $dao=new ReviewDao();
    $reviews=$dao->selectByUsername($_SESSION['user']);
    $topThree = array_slice($reviews, 0, 3);
    for($i=0;$i<count($topThree);$i++) {
        echo '<tr><td>' . ($i + 1) . '.' . $topThree[$i]->foodname.'with a rating of'. $topThree[$i]->value.'</td></tr>';
        $string='<tr><td><img src= "..static/images/'.$topThree[$i]->image.'" height="150" width="300" /></td></tr>';
        echo $string;
    }
    echo '</table>';
}