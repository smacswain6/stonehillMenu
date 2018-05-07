<?php
include("FoodDao.php");
include("RatingDao.php");
include("ReviewDao.php");
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
    <li><a class='active' href='homepage.php' name='homepageurl'>Homepage</a></li>
    <li><a class = 'active' href='menu.php'>Menu</a></li>
    <li><a class='active' href='search.php'>Search</a></li>
    <li><a class='active' href='landing.php'>Sign Out</a></li>
    <li><a class='active' href='userpage.php'>User Page</a></li>
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
    $dao = new ReviewDao();
    if (isset($_POST['review'])) {
        $review = new Review($_SESSION['user']->username, $_POST['review'], $_SESSION['fooditem']->name);
        if($_POST['review'] == ''){}
        else {
            $dao->insert($review);
            $dao->update($review);
        }
        header("'Location:../php/fooditem.php");
    }

    $dao = new RatingDao();
    if (isset($_POST['rate'])) {
        $rating = new Rating($_SESSION['fooditem']->name,$_POST['rate'],$_SESSION['user']->username);
        $dao->insert($rating);
        $dao->update($rating);
    }
        header("'Location:../php/fooditem.php");

}

function getRating(){
    $dao = new RatingDao();
    $ratings = $dao->selectByFoodname($_SESSION['fooditem']->name);
    $sum = 0;
    $count = 0;
    foreach ($ratings as $rating){
        $sum = $sum + $rating->value;
        $count = $count + 1;
    }
    if($count == 0){
        echo 'no rating yet';
    }
    else {
        $sum = $sum/$count;
        echo $sum;
    }
}
?>