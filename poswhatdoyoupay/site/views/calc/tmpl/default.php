<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');
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
                                                            <p><b>In order to calculate how much you pay for the state's
                                                                services, we must request the following information:</b>
                                                            </p>

                                                            <form action="<?php echo JRoute::_('index.php?option=com_poswhatdoyoupay&view=results'); ?>"
                                                                  method="post"
                                                                  onSubmit="return verifyCalcForm(this)">
                                                                <table cellpadding="4" cellspacing="0" border="0"
                                                                       class="calc-table">
                                                                    <col width="40"/>
                                                                    <col width="225"/>
                                                                    <col width="150"/>
                                                                    <col/>
                                                                    <tr>
                                                                        <td><img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/salary.png"/>
                                                                        </td>
                                                                        <th>Your gross monthly salary:</th>
                                                                        <td><input type="text" name="hrubaMzda"></td>
                                                                        <td>Eur
                                                                            <div style="display:inline"
                                                                                 title="Calculations are based on full-time employment">
                                                                                <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                                                     border="0">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/pension.png"/>
                                                                        </td>
                                                                        <td>Do you save for retirement using the 2<sup>nd</sup>
                                                                            pillar?
                                                                        </td>
                                                                        <td><input type="radio" name="maDruhyPilier"
                                                                                   value="1"> Yes <input type="radio"
                                                                                                         name="maDruhyPilier"
                                                                                                         value="0"> No
                                                                        </td>
                                                                        <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/month.png"/>
                                                                        </td>
                                                                        <th>Your total monthly expenditures:</th>
                                                                        <td><input type="text" name="mesacneVydaje">
                                                                        </td>
                                                                        <td>Eur
                                                                            <div style="display:inline"
                                                                                 title="Enter your monthly spending including rent, fuels, mobile phone, groceries, clothing, entertainment, electricity, gas, water, alcohol, cigarettes, etc. (Tip: You can also work out your spending by subtracting what you put into savings each month from your net income.)">
                                                                                <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                                                     border="0">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                        <td colspan="3">Of this amount:</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/flat.png"/>
                                                                        </td>
                                                                        <td>Monthly rent (including mortgage payment):
                                                                        </td>
                                                                        <td><input type="text" name="mesacneNajomne">
                                                                        </td>
                                                                        <td>Eur
                                                                            <div style="display:inline"
                                                                                 title="Enter how much you pay for rent, not counting utilities, on a per-person basis (e.g. if you live with your spouse in a rented flat, enter half of the total rent)">
                                                                                <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                                                     border="0">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/gas.png"/>
                                                                        </td>
                                                                        <td>Monthly spending on fuels:</td>
                                                                        <td><input type="text" name="benzinMesacne">
                                                                        </td>
                                                                        <td>Eur
                                                                            <div style="display:inline"
                                                                                 title="Enter how much you pay for gasoline or diesel each month for private consumption">
                                                                                <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                                                     border="0">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/smoke.png"/>
                                                                        </td>
                                                                        <td>Each week you smoke</td>
                                                                        <td><input type="text" name="cigaretyTyzdenne">
                                                                        </td>
                                                                        <td>packs of cigarettes</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/beer.png"/>
                                                                        </td>
                                                                        <td>Each week you drink</td>
                                                                        <td><input type="text" name="pivoTyzdenne"></td>
                                                                        <td>beers</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/drink.png"/>
                                                                        </td>
                                                                        <td>Each week you drink:</td>
                                                                        <td><input type="text" name="palenkaTyzdenne">
                                                                        </td>
                                                                        <td>shots of liquor</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><img
                                                                                src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/tv.png"/>
                                                                        </td>
                                                                        <td>Do you pay the television and radio license
                                                                            fee?
                                                                        </td>
                                                                        <td><input type="radio" name="maTelevizor"
                                                                                   value="4.64"> Yes <input type="radio"
                                                                                                            name="maTelevizor"
                                                                                                            value="0">
                                                                            No
                                                                        </td>
                                                                        <td>&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">&nbsp;</td>
                                                                        <td colspan="2"><input type="submit"
                                                                                               value="Submit"
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
