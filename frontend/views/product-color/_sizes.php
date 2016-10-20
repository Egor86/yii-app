<?php

/** @var array $sizes common\models\Size */
/** @var array $color_sizes common\models\ProductColor */
$template = null;
for ($i = 0; $i < count($sizes); $i++) {
    $size_box = "<label class='modal-radio'>{$sizes[$i]['value']}<input type='radio' name='Product[sizes]' value='' disabled></label>";
    for ($j = 0; $j < count($color_sizes); $j++) {
        if ($sizes[$i]['id'] == $color_sizes[$j]['size_id']){
            if ($color_sizes[$j]['amount'] > 0) {
                $size_box = "<label class='modal-radio'>{$sizes[$i]['value']}<input type='radio' name='Product[sizes]' value='{$sizes[$i]['id']}'></label>";
            }
        }
    }
    $template .= $size_box;
}
echo $template;