<?php

namespace common\components;


use common\models\Coupon;
use common\models\Order;
use hscstudio\cart\Cart;
use hscstudio\cart\CostCalculationEvent;
use hscstudio\cart\Storage;
use Yii;
use yii\di\Instance;

class MyCart extends Cart
{
    /*
     * Discount for all cart
     * @var integer
     */
    public $discount;


    public function init()
    {
        $this->storage = Instance::ensure($this->storage, Storage::className());
        $this->load();
        if (!$this->getIsEmpty()) {
            Yii::$app->view->params['order'] = new Order(Yii::$app->session['discount']);
        }
    }

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
            $this->discount = $coupon_id ? Coupon::findOne($coupon_id)->campaign->discount : 0;
            $cost = max(0, $cost - $this->discount);
        }
        return $cost;
    }
}