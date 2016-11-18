<?php

/** @var $this \yii\web\View*/
/** @var $sort \yii\data\Sort*/

echo $sort->link('created_at') . ' | ' . $sort->link('price'). ' | ' . $sort->link('price_low'). ' | ' . $sort->link('discount_price');

echo $this->render('//site/item',['item' => $item]);