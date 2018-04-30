<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 4/29/18
 * Time: 6:04 PM
 */

class Rating
{

    var $foodname;
    var $value;
    var $username;
    var $id;

    public function __construct($foodname,$value,$username)
    {
        $this->foodname=$foodname;
        $this->value=$value;
        $this->username=$username;
        $this->id=$username.$foodname;
    }

    public function toString()
    {
        return $this->id;
    }


}

#$rating = new Rating('salad', 5, 'matt');
#print $rating->toString();