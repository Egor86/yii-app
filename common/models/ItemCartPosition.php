<?php

namespace common\models;


use hscstudio\cart\CartPositionInterface;
use hscstudio\cart\CostCalculationEvent;
use yii\base\Component;
use yii\base\Object;

class ItemCartPosition extends Object implements CartPositionInterface
{
    public $id;
    public $size;
    protected $_item;

    /**
     * @return integer
     */
    public function getPrice()
    {
        if ($this->getItem()->discount_price > 0) {
            return $this->getItem()->discount_price;
        }
        return $this->getItem()->price;
    }

    /**
     * @param bool $withDiscount
     * @return integer
     */
    public function getCost($withDiscount = true)
    {
        /** @var Component|CartPositionInterface|self $this */
        $cost = $this->getQuantity() * $this->price;
        $costEvent = new CostCalculationEvent([
            'baseCost' => $cost,
        ]);
        if ($this instanceof Component)
            $this->trigger(CartPositionInterface::EVENT_COST_CALCULATION, $costEvent);
        if ($withDiscount)
            $cost = max(0, $cost - $costEvent->discountValue);
        return $cost;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return md5(serialize([$this->id, $this->size]));
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getItem()
    {
        if ($this->_item === null) {
            $this->_item = Item::findOne($this->id);
        }
        return $this->_item;
    }
}