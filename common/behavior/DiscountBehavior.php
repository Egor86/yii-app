<?php
/**
 * Created by PhpStorm.
 * User: egor
 * Date: 17.10.16
 * Time: 14:38
 */

namespace common\behavior;


class DiscountBehavior extends \hscstudio\cart\DiscountBehavior
{
    public function onCostCalculation($event)
    {
        // Some discount logic, for example
        $event->discountValue = 100;
    }
}