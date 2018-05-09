
<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 4/27/18
 * Time: 5:46 PM
 */
include("UserDao.php");

echo '<table class=\"one\" height=\"200px\" width=\"400px\">
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
</table>'
?>
