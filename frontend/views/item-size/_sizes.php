<?php

/** @var array $sizes common\models\Size */
/** @var array $item_sizes common\models\ItemSize */
$template = null;
for ($i = 0; $i < count($sizes); $i++) {
    $size_box = "<label class='modal-radio'>{$sizes[$i]['value']}<input type='radio' name='Item[sizes]' value='' disabled></label>";
    for ($j = 0; $j < count($item_sizes); $j++) {
        if ($sizes[$i]['id'] == $item_sizes[$j]['size_id']){
            if ($item_sizes[$j]['amount'] > 0) {
                $size_box = "<label class='modal-radio'>{$sizes[$i]['value']}<input type='radio' name='Item[sizes]' value='{$sizes[$i]['id']}'></label>";
            }
        }
    }
    $template .= $size_box;
}
echo $template;