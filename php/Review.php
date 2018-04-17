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
    var $name;
    var $review;

    public function __construct($user,$name,$review)
    {
        $this->username=$user;
        $this->name=$name;
        $this->review=$review;
    }
    public function __toString()
    {
        return $this->name." ".$this->username." ".$this->review;
    }

}