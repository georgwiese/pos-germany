<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	require("calculator_ge.php");
?>
<ul id="main-tables-years">
    <li style="width: 200px">
        <a href="<?php echo JURI::root(true)?>"><?php echo JText::_("COM_POSWHATDOYOUPAY_BACK_TO_THE_MAIN")?></a></li>
</ul>
<div id="main-tables">
<div class="textual">
<div class="padding-10">
<h1><?php echo JText::_("COM_POSWHATDOYOUPAY_TITLE")?></h1>

<div class="main-table-wrapper">
<div class="tm">
<div class="ml">
<div class="mr">
<div class="bm">
<div class="tl">
<div class="tr">
<div class="bl">
<div class="br">
<div class="content-wrapper">
<div class="content">
<div class="padding-20">
    <table>
        <tr>
            <td>
                <table cellpadding="4" cellspacing="0" border="0"
                       class="calc-table">
                    <col width="40"/>
                    <col width="225"/>
                    <col width="150"/>
                    <col/>
                    <tr>
                        <td width="40"><img
                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/result-graph.png"
                                border="0" alt="graph"></td>
                        <td class="m" width="400">
                            <div><?php echo JText::sprintf('COM_POSWHATDOYOUPAY_RESULT_TEXT1', $gross_salary, $net_salary,$monthly_expenses, $gross_salary); ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <div class="level1" style="display:inline"><h3>
                                <?php echo JText::sprintf('COM_POSWHATDOYOUPAY_RESULT_TEXT2', $total_taxes); ?>
                                <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                     border="0"
                                     alt="bulb"
                                     title="<?php echo JText::_('COM_POSWHATDOYOUPAY_RESULT_TEXT2_TOOLTIP'); ?>"/>
                            </h3>
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <td width="40"><img
                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/result-clock.png"
                                border="0" alt="clock"/></td>
                        <td class="m">
							<?php
							if ($tax_wage <= 1) {
								?>
                                <div style="display:inline"><?php echo JText::sprintf('COM_POSWHATDOYOUPAY_RESULT_TEXT3', formatTime(8 - round($tax_wage * 8, 2)), formatTime(round($tax_wage * 8, 2))); ?>
                                    <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                         border="0" alt="bulb"
                                         title="<?php echo JText::_('COM_POSWHATDOYOUPAY_RESULT_TEXT3_TOOLTIP');?>"/>
                                </div>
								<?php
							} else {
								?>
                                <div><strong><?php echo JText::_('COM_POSWHATDOYOUPAY_RESULT_TEXT4'); ?></strong></div>
                                <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                     border="0" alt="bulb"
                                     title="<?php echo JText::_('COM_POSWHATDOYOUPAY_RESULT_TEXT4_TOOLTIP'); ?>"/>
								<?php
							}
							?>
                        </td>
                    </tr>
                    <tr>
                        <td width="40"><img
                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/result-hand.png"
                                border="0" alt="hand"></td>
                        <td class="m">
                            <div><strong><?php echo JText::sprintf('COM_POSWHATDOYOUPAY_RESULT_TEXT5', $total_taxes); ?></strong></div>
                        </td>
                    </tr>
                    <tr>
                        <td width="40">&nbsp;</td>
                        <td>
                            <table>
                                <tr>
                                    <td width="40"><img
                                            src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/gruzia-fdsbgvd.jpg"
                                            border="0" alt="tax"></td>
                                    <td class="m">
                                        <div><strong><?php echo JText::sprintf('COM_POSWHATDOYOUPAY_RESULT_TEXT6', $total_taxes); ?></strong>
                                        </div>
                                        <div><?php echo JText::_('COM_POSWHATDOYOUPAY_RESULT_TEXT7'); ?></div>
                                        <div style="display:inline"><?php echo JText::sprintf('COM_POSWHATDOYOUPAY_RESULT_TEXT8', $income_tax); ?>
                                            <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                 border="0" alt="bulb"
                                                 title=""/>
                                        </div>
                                        <br>

                                        <div style="display:inline"><?php echo JText::sprintf('COM_POSWHATDOYOUPAY_RESULT_TEXT9', $excise_tax); ?>
                                            <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                 border="0" alt="bulb"
                                                 title=""/>
                                        </div>
                                        <br>

                                        <div style="display:inline"><?php echo JText::sprintf('COM_POSWHATDOYOUPAY_RESULT_TEXT10', $VAT); ?>
                                            <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                 border="0" alt="bulb"
                                                 title=""/>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <div style="display:inline">
                    <h2><?php echo JText::_('COM_POSWHATDOYOUPAY_MONTHLY_BALANCE'); ?><img
                            src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                            border="0"
                            title="<?php echo JText::_('COM_POSWHATDOYOUPAY_MONTHLY_BALANCE_TOOLTIP'); ?>">

                        <h2>
                </div>
                <iframe frameborder=0 scrolling=no marginheight="1px" marginwidth="1px" width="402px" height="452px"
                        src="<?php echo JRoute::_('index.php?option=com_poswhatdoyoupay&view=chart&format=raw') . "&data=" . round($net_salary) . "$" . round($income_tax) . "$" . round($VAT). "$" . round($excise_tax) ; ?>"></iframe>
            </td>
        </tr>
    </table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
