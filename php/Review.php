<?php
/**
 * Created by PhpStorm.
 * User: Stephen
 * Date: 4/16/2018
 * Time: 9:16 PM
 */

class Review
{
    var $username;
    var $review;
    var $foodname;

    public function __construct($username,$review,$foodname)
    {
        $this->username=$username;
        $this->review=$review;
        $this->foodname=$foodname;
    }
    public function __toString()
    {
        return $this->username." ".$this->review." ".$this->foodname;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getReview()
    {
        return $this->review;
    }

    public function getFoodname()
    {
        return $this->foodname;
    }

}

#$review = new Review('Matt','okay','Tacos');
#print $review->getUsername();
#print $review->getReview();
#print $review->getFoodname();