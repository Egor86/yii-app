<?php

/** @var array $sizes common\models\Size */
use common\models\ItemSize;

/** @var array $item_sizes common\models\ItemSize */


$sizes = $item->getSizeTable();

$item_sizes = ItemSize::find()
    ->select(['size_id', 'amount'])
    ->where(['item_id' => $item->id])
    ->asArray()
    ->all();

$template = null;
for ($i = 0; $i < count($sizes); $i++) {
    $size_box = "<div class='custom-radio not-available'><input type='radio' name='Item[sizes]' class='size-select' id='radio{$i}' value='' disabled><label for='radio{$i}'> {$sizes[$i]['value']}</label></div>";
    for ($j = 0; $j < count($item_sizes); $j++) {
        if ($sizes[$i]['id'] == $item_sizes[$j]['size_id']){
            if ($item_sizes[$j]['amount'] > 0) {
                $size_box = "<div class='custom-radio'><input type='radio' name='Item[sizes]' class='size-select' id='radio{$i}' value='{$sizes[$i]['id']}'><label for='radio{$i}'> {$sizes[$i]['value']}</label></div>";
            }
        }
    }
    $template .= $size_box;
}
echo $template;
