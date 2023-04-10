<?php

function promotionPercentage($cost, $value)
{
    $promotional_price=$cost*$value/100;
    return $promotional_price;
}

