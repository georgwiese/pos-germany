<tr>
    <td class='main'><?php
        echo $data[0];
        if (isset($data[5])){
            echo '<br><span style="font-weight:normal">' . $data[5] . '</span>';
        }
    ?></td>
    <!--
    <td><?php echo round($data[1])?></td>
    <td><?php echo $data[2]?></td>
    <td><?php echo $data[3]?></td>-->
    <td>
        <?php $prefix = $tableIndex . "_" . $rowIndex . "_" ?>
        <form><div id="<?php echo $prefix?>radio" class="radio">
            <input type="radio" id="<?php echo $prefix?>radio1" name="radio" checked="checked" />
                <label for="<?php echo $prefix?>radio1"><div>Nicht</div><div>kaufen</div></label>
            <input type="radio" id="<?php echo $prefix?>radio2" name="radio" />
                <label for="<?php echo $prefix?>radio2"><div>S</div><div><?php echo sprintf("%01.2f €", $data[2] / 12 / 2)?></div></label>
            <input type="radio" id="<?php echo $prefix?>radio3" name="radio" />
                <label for="<?php echo $prefix?>radio3"><div>M</div><div><?php echo sprintf("%01.2f €", $data[2] / 12)?></div></label>
            <input type="radio" id="<?php echo $prefix?>radio4" name="radio" />
                <label for="<?php echo $prefix?>radio4"><div>L</div><div><?php echo sprintf("%01.2f €", $data[2] / 12 * 2)?></div></label>
        </div></form>

        <!--
        <div class="yui-skin-sam">
            <div id="slider-bg<?php echo $tableIndex . "_" . $rowIndex?>" class="yui-h-slider" tabindex="-1" title="Slider">
				<div id="slider-thumb<?php echo $tableIndex . "_" . $rowIndex?>" class="yui-slider-thumb"><img src="<?php echo JURI::root(true) . "/media/com_posshop/images/thumb-s.gif";?>"></div>
            </div>
        </div>

        <span style="display:none;" id="sv<?php echo $tableIndex . "_" . $rowIndex?>">0</span>
        <span id="scv<?php echo $tableIndex . "_" . $rowIndex?>">0</span>
        <input type=hidden name="srv<?php echo $tableIndex . "_" . $rowIndex?>" id="srv<?php echo $tableIndex . "_" . $rowIndex?>" value="0"/>
		<?php array_push($sliders, array($tableIndex . "_" . $rowIndex, $data[1], $data[4]));?>
        -->
        <?php array_push($buttonsets, $prefix . 'radio');?>
    </td>
</tr>
