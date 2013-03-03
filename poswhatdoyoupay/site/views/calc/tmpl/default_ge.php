<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	require_once("verify_form_ge.php")
?>

<ul id="main-tables-years">
    <li style="width: 200px"><a
            href="<?php echo JURI::root(true)?>"><?php echo JText::_("COM_POSWHATDOYOUPAY_BACK_TO_THE_MAIN")?></a></li>
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
                                                            <p>
                                                                <b><?php echo JText::_("COM_POSWHATDOYOUPAY_INFORMATION_REQUEST");?></b>
                                                            </p>

                                                            <form action="<?php echo JRoute::_('index.php?option=com_poswhatdoyoupay&view=results'); ?>"
                                                                  method="post"
                                                                  onSubmit="return verifyCalcFormGe(this)">
                                                                <table cellpadding="4" cellspacing="0" border="0"
                                                                       class="calc-table">
                                                                    <col width="40"/>
                                                                    <col width="225"/>
                                                                    <col width="150"/>
                                                                    <col/>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/salary.png"/>
                                                                        </td>
                                                                        <th><?php echo JText::_("COM_POSWHATDOYOUPAY_GROSS_SALARY");?></th>
                                                                        <td><input type="text" name="grossSalary"></td>
                                                                        <td><?php echo JText::_('COM_POSWHATDOYOUPAY_GEL');?>
                                                                            <div style="display:inline"
                                                                                 title="<?php echo JText::_('COM_POSWHATDOYOUPAY_SALARY_TOOLTIP');?>">
                                                                                <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                                                     border="0">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/month.png"/>
                                                                        </td>
                                                                        <th><?php echo JText::_('COM_POSWHATDOYOUPAY_EXPENDITURES');?></th>
                                                                        <td><input type="text" name="monthlyExpenses">
                                                                        </td>
                                                                        <td><?php echo JText::_('COM_POSWHATDOYOUPAY_GEL');?>
                                                                            <div style="display:inline"
                                                                                 title="<?php echo JText::_('COM_POSWHATDOYOUPAY_EXPENDITURES_TOOLTIP');?>">
                                                                                <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                                                     border="0">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                        <td colspan="3"><?php echo JText::_('COM_POSWHATDOYOUPAY_OF_THIS');?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/flat.png"/>
                                                                        </td>
                                                                        <td><?php echo JText::_('COM_POSWHATDOYOUPAY_MONTHLY_RENT');?>
                                                                        </td>
                                                                        <td><input type="text" name="monthlyRent">
                                                                        </td>
                                                                        <td><?php echo JText::_('COM_POSWHATDOYOUPAY_GEL');?>
                                                                            <div style="display:inline"
                                                                                 title="<?php echo JText::_('COM_POSWHATDOYOUPAY_RENT_TOOLTIP');?>">
                                                                                <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                                                     border="0">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/gas.png"/>
                                                                        </td>
                                                                        <td><?php echo JText::_('COM_POSWHATDOYOUPAY_MONTHLY_FUEL');?></td>
                                                                        <td><input type="text" name="petrolMonthly">
                                                                        </td>
                                                                        <td><?php echo JText::_('COM_POSWHATDOYOUPAY_GEL');?>
                                                                            <div style="display:inline"
                                                                                 title="<?php echo JText::_('COM_POSWHATDOYOUPAY_FUEL_TOOLTIP');?>">
                                                                                <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                                                     border="0">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/smoke.png"/>
                                                                        </td>
                                                                        <td><?php echo JText::_('COM_POSWHATDOYOUPAY_YOU_SMOKE');?></td>
                                                                        <td><input type="text" name="cigarettesWeekly">
                                                                        </td>
                                                                        <td><?php echo JText::_('COM_POSWHATDOYOUPAY_CIGARETTES');?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/beer.png"/>
                                                                        </td>
                                                                        <td><?php echo JText::_('COM_POSWHATDOYOUPAY_YOU_DRINK');?></td>
                                                                        <td><input type="text" name="beerWeekly"></td>
                                                                        <td><?php echo JText::_('COM_POSWHATDOYOUPAY_BEERS');?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/drink.png"/>
                                                                        </td>
                                                                        <td><?php echo JText::_('COM_POSWHATDOYOUPAY_YOU_DRINK');?></td>
                                                                        <td><input type="text" name="alcoholWeekly">
                                                                        </td>
                                                                        <td><?php echo JText::_('COM_POSWHATDOYOUPAY_BOTTLES_OF_ALCOHOL');?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/gruzia-wine.jpg"/>
                                                                        </td>
                                                                        <td><?php echo JText::_('COM_POSWHATDOYOUPAY_YOU_DRINK');?></td>
                                                                        <td><input type="text" name="wineWeekly">
                                                                        </td>
                                                                        <td><?php echo JText::_('COM_POSWHATDOYOUPAY_BOTTLES_OF_WINE');?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">&nbsp;</td>
                                                                        <td colspan="2"><input type="submit"
                                                                                               value="<?php echo JText::_('COM_POSWHATDOYOUPAY_SUBMIT');?>"
                                                                                               class="button"/></td>
                                                                    </tr>
                                                                </table>
                                                            </form>
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
</div>
