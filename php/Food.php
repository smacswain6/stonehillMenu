<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 4/16/18
 * Time: 11:19 PM
 */

class Food
{
    var $name;
    var $rating;
    var $image;
    public function _construct($n,$r,$i)
    {
        $this->name = $n;
        $this->rating = $r;
        $this->image = $i;
    }

    function toString()
    {
        return $this->name." ".$this->rating." ".$this->image;
    }
}