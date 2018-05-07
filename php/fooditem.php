<?php
include("Food.php");
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" >
    <title>Food Item</title>
    <link rel = 'stylesheet'  href = "../static/login.css" />
    <link rel = 'stylesheet'  href = "../static/nav.css" />
    <link rel = 'stylesheet'  href = "../static/fooditem.css" />
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

<h1> <?php getFoodName(); ?> </h1>

<!--Food Table-->

<img src = <?php getFoodImage() ?> />
<table>
    <tr>
        <td>
            <p> Description: <?php getDescription() ?> </p>
        </td>
        <td>
            <p> Rating: <?php getRating() ?> </p>
        </td>
    </tr>
    <tr>
        <td>
            <p> Station: <?php getStation() ?> </p>
        </td>
        <td>
            <p> Day Served: <?php getDay() ?> </p>
        </td>
    </tr>
</table>

<!--Add Comment or Rating-->
<h2> Add your rating </h2>
<form id='form' method='post' action='../php/fooditem.php'>
    <?php handleForm() ?>
    <p> Rate <input type='number' name='rate' min='0' max='10'/><p>
    <p> Review <input type='textfield' name='review'/>
        <input type='submit' value='Submit' name='submit'/>
</form>

<!--Comments Table-->
<h2> Reviews </h2>
<table>
<?php getReviews(); ?>
</table>

</body>
</html>


<?php
function getReviews()
{
    include_once("ReviewDao.php");
    $dao = new ReviewDao();
    if (isset($_SESSION['fooditem'])) {
        $reviews = $dao->selectByFoodname($_SESSION['fooditem']->name);
        foreach ($reviews as $review) {
            $string = $review->review;
            $username = $review->username;
            echo "<tr><td>$string</td><td>$username</td></tr>";
        }
    }
}


function getFoodName()
{
    if( isset($_SESSION['fooditem'])) {
        echo $_SESSION['fooditem']->name;
    }
    else{
        echo "No fooditem found";
    }
}

function getFoodImage()
{
    if(isset($_SESSION['fooditem'])) {
        echo "../static/images/".$_SESSION['fooditem']->image;
    }
    else{
        echo "No image available";
    }

}

function getDescription()
{
    if(isset($_SESSION['fooditem'])){
        echo $_SESSION['fooditem']->description;
    }
    else{
        echo "No descripiton found";
    }
}

function getRating(){
    if(isset($_SESSION['fooditem'])){
        echo $_SESSION['fooditem']->rating;
    }
    else{
        echo "No rating found";
    }
}

function getStation(){
    if(isset($_SESSION['fooditem'])){
        echo $_SESSION['fooditem']->station;
    }
    else{
        echo "No station found";
    }
}

function getDay(){
    if(isset($_SESSION['fooditem'])){
        echo $_SESSION['fooditem']->day;
    }
    else{
        echo "No day found";
    }
}

function handleForm()
{
    include("ReviewDao.php");
    $dao = new ReviewDao();
    if (isset($_POST['review'])) {
        $review = new Review($_SESSION['user']->name, $_POST['review'], $_SESSION['fooditem']->name);
        $dao->insert($review);
        header("'Location:../php/fooditem.php");
    }

    include("RatingDao.php");
    $dao = new RatingDao();
    if (isset($_POST['rate'])){
        $rating = new Rating($_SESSION['fooditem']->name,$_POST['rate'],$_SESSION['user']->name);
        $dao->insert($rating);
    }
}
?>