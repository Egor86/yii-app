<?php
/**
 * Created by PhpStorm.
 * User: egor
 * Date: 28.10.16
 * Time: 12:58
 */

namespace common\components;


use common\models\Coupon;
use hscstudio\cart\Cart;
use hscstudio\cart\CostCalculationEvent;
use Yii;

class MyCart extends Cart
{
    /*
     * Discount for all cart
     * @var integer
     */
    public $discount;


    /**
     * overwritten from parent getCost
     * @param bool $withDiscount
     * @return int|mixed
     */
    public function getCost($withDiscount = false)
    {
        $cost = 0;
        foreach ($this->items as $item) {
            $cost += $item->getCost();
        }
//        $costEvent = new CostCalculationEvent([
//            'baseCost' => $cost,
//        ]);
//        $this->trigger(self::EVENT_COST_CALCULATION, $costEvent);
        if ($withDiscount) {
            $coupon_id = Yii::$app->session['discount'];
            $this->discount = $coupon_id ? Coupon::findOne($coupon_id)->discount : 0;
            $cost = max(0, $cost - $this->discount);
        }
        return $cost;
    }
}