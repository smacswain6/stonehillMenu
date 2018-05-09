<?php
include("FoodDao.php");
session_start();
?>
<html>
<head>
    <title>Admin Page</title>
    <meta charset="UTF-8" >
    <title>Homepage</title>
    <link rel = 'stylesheet'  href = '../static/login.css ' />
    <link rel = 'stylesheet'  href = "../static/nav.css " />
</head>
<body>

<!--NAV BAR-->
<ul>
    <li><a class='active' href='homepage.php' >Homepage</a></li>
    <li><a class = 'active' href='menu.php'>Menu</a></li>
    <li><a class='active' href='search.php'>Search</a></li>
    <li><a class='active' href='landing.php'>Sign Out</a></li>
    <li><a class='active' href='userpage.php'>User Page</a></li>
    <li><a class='active' href='admin.php'>Admin</a></li>
</ul>

<h1> Admin </h1>
<h2>Create/Update Food Items</h2>
<p>Please Complete all Fields.</p>
<form id='admin' method='post' action='../php/admin.php' enctype='multipart/form-data'/>
<?php handleForm() ?>
<table>
    <tr><td>Name:<input type='text' name='foodname'/></td></tr>
    <tr><td>Description:<input type='text' name='description'/></td></tr>
    <tr><td>Image:<input type='file' name='file'/></td></tr>
    <tr><td>Station:
            <select name='station'>
                <option value='Entree'>Entree</option>
                <option value='Vegetarian'>Vegetarian</option>
                <option value='International'>International</option>
                <option value='Spitfire'>Spitfire</option>
                <option value='Grill'>Grill</option>
                <option value='Soup'>Soup</option>
                <option value='Bakery'>Bakery</option>
            </select>
        </td></tr>
    <tr><td>Day Served:
            <select name='day'>
                <option value='Monday'>Monday</option>
                <option value='Tuesday'>Tuesday</option>
                <option value='Wednesday'>Wednesday</option>
                <option value='Thursday'>Thursday</option>
                <option value='Friday'>Friday</option>
            </select>
        </td></tr>
    <tr><td><input type='submit' name='update' value='update'/>
            <input type='submit' name='insert' value='insert'/>
</table>
</form>
</body>
</html>

<?php

function handleForm(){
    $dao = new FoodDao();
    if(isset($_POST['foodname'])){
        $foodname = $_POST['foodname'];
        $description = $_POST['description'];
        $image = $_POST['file'];
        $station = $_POST['day'];
        $day = $_POST['day'];
        $foodItem = new Food($foodname,1,$image,$description,$station,$day,1,true);

        if(isset($_POST['update'])){
            $dao->update($foodItem);
        }
        else if(isset($_POST['insert'])){
            $dao->insert($foodItem);
        }
    }
}









?>

