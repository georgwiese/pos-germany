<tr>
    <td class='main'><?php echo $data[0]?></td>
    <td><?php echo round($data[1])?></td>
    <td><?php echo $data[2]?></td>
    <td><?php echo $data[3]?></td>
    <td>
        <div class="yui-skin-sam">
            <div id="slider-bg<?php echo $tableIndex . "_" . $rowIndex?>" class="yui-h-slider" tabindex="-1" title="Slider">
				<div id="slider-thumb<?php echo $tableIndex . "_" . $rowIndex?>" class="yui-slider-thumb"><img src="<?php echo JURI::root(true) . "/media/com_posshop/images/thumb-s.gif";?>"></div>
            </div>
        </div>

        <span style="display:none;" id="sv<?php echo $tableIndex . "_" . $rowIndex?>">0</span>
        <span id="scv<?php echo $tableIndex . "_" . $rowIndex?>">0</span>
        <input type=hidden name="srv<?php echo $tableIndex . "_" . $rowIndex?>" id="srv<?php echo $tableIndex . "_" . $rowIndex?>" value="0"/>
		<?php array_push($sliders, array($tableIndex . "_" . $rowIndex, $data[2], $data[4]));?>
    </td>
</tr>
