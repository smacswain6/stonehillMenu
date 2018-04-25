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
    var $description;
    var $station;
    var $day;
    var $votes;
    var $current;

    public function __construct($n,$r,$i,$d,$s,$da,$v,$c)
    {
        $this->name = $n;
        $this->rating = $r;
        $this->image = $i;
        $this->description=$d;
        $this->station=$s;
        $this->day=$da;
        $this->votes=$v;
        $this->current=$c;
    }

    function toString()
    {
        return $this->name." ".$this->rating." ".$this->image." ".$this->description." ".$this->station." ".$this->day." ".$this->votes." ".$this->current;
    }
}