<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 5/6/2018
 * Time: 10:31 PM
 */
session_start();
include("FoodDao.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" >
    <title>Search</title>
    <link rel = 'stylesheet'  href = "../static/specialnav.css" />
    <link rel = 'stylesheet'  href = "../static/login.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
        $(function() {
            var availableTags =<?php echo json_encode(getTags());?>;
            $( "#tags" ).autocomplete({
                source: availableTags
            });
        });
    </script>
</head>
<body>

<!--NAV BAR-->
<ul class='nav'>
    <li class='nav'><a class='active' href='homepage.php'>Homepage</a></li>
    <li class='nav'><a class = 'active' href='menu.php'>Menu</a></li>
    <li class='nav'><a href='search.php'>Search</a></li>
    <li class='nav'><a class='active' href='landing.php'>Sign Out</a></li>
    <li class='nav'><a class='active' href='userpage.php'>User Page</a></li>
</ul>

<!--SEARCH-->
<h1>Search Meal</h1>
<form id="form" method="post">
    <div class='ui-widget'>
        <label for='tags'> Tags </label>
        <input type='text' id='tags' name='search'/>
        <?php checkForm(); ?>
    </div>
    <input type='submit' name='submit' value='submit'/>
</form>
</body>
</html>

<?php

function getTags()
{
    $dao = new FoodDao();
    $foods =$dao->selectAll();
    $foodsNames=[];
    for($i=0;$i<count($foods);$i++)
    {
        array_push($foodsNames,$foods[$i]->name);
    }
    return $foodsNames;
}
function checkForm()
{
if(isset($_POST['search'])) {
    $foodname=$_POST['search'];
    $dao=new FoodDao();
    $food=$dao->selectByFoodname($foodname);
    if($food != Null) {
        $_SESSION['$fooditem'] = $food;
        header("Location: ../php/fooditem.php");
    }
    else
    {
        return;
    }
}
else
    return;
}
?>
