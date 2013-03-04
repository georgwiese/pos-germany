<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

	require("calculations.php");
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
                            <div>Your gross salary
                                of <?php echo round($hruba_mzda, 2); ?>
                                Eur costs your employer
								<?php echo round($hruba_mzda + $z_odvody_spolu, 2); ?> Eur
                                <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                     border="0" alt="bulb"
                                     title="Your employer pays more for you than your gross salary due to health insurance and social insurance contributions."/>
                                and you get <?php echo round($cista_mzda, 2); ?> Eur in cash.<br><strong>With monthly
                                    spending
                                    of <?php echo round($mesacne_vydaje, 2); ?> Eur and a gross salary
                                    of <?php echo round($hruba_mzda, 2);?> Eur
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <div class="level1" style="display:inline"><h3>
                                You pay <?php echo round($dane_a_odvody_spolu, 2); ?> Eur per month for the state's
                                services
                                <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                     border="0"
                                     alt="bulb"
                                     title="This value represents the total of your and your employer's contributions, income tax, excise taxes and VAT on your monthly spending, and TV and radio license fees as appropriate. If you are saving for retirement using the 2nd pillar, the final value is reduced by this contribution."/>
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
							if ($podiel <= 1) {
								?>
                                <div style="display:inline">This means that in an
                                    8-hour working day <strong>you work for yourself
                                        for  <?php echo formatTime(8 - round($podiel * 8, 2)); ?>
                                        and for the state
                                        for <? echo formatTime(round($podiel * 8, 2)); ?></strong>
                                    <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                         border="0" alt="bulb"
                                         title="These times are calculated based on the sum of all payments you send the state monthly, taken against the overall salary expenses your employer pays for your work."/>
                                </div>
								<?php
							} else {
								?>
                                <div><strong>You pay more to the state on taxes and
                                    contributions than you earn for
                                    yourself</strong></div>
                                <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                     border="0" alt="bulb"
                                     title="These times are calculated based on the ratio of your net salary to the sum of all payments you send the state each month."/>
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
                            <div><strong>Of
                                that <?php echo round($dane_a_odvody_spolu, 2); ?>
                                Eur, which goes to the state
                                monthly, <?php echo round($dane_spolu_pozitivne, 2); ?>
                                Eur is tax
                                and <?php echo round($odvody_celkovo, 2); ?>
                                Eur is social and health contributions</strong></div>
                        </td>
                    </tr>
                    <tr>
                        <td width="40">&nbsp;</td>
                        <td>
                            <table>
                                <tr>
                                    <td width="40"><img
                                            src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/result-tax.png"
                                            border="0" alt="tax"></td>
                                    <td class="m">
                                        <div><strong>Tax
                                            total: <?php echo round($dane_spolu_pozitivne, 2); ?> Eur</strong>
                                        </div>
                                        <div>of which:</div>
                                        <div style="display:inline">- income
                                            tax: <?php echo round($dan_z_prijmu_pozitivna, 2); ?> Eur
                                            <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                 border="0" alt="bulb"
                                                 title="This sum takes account of the tax-free minimum, which falls as income rises (<?php echo round(4025.70, 1); ?> Eur per taxpayer for 2010). If you have a minor children, income tax is reduced by <?php echo round(20.00, 2); ?> Eur for each child."/>
                                        </div>
                                        <br>

                                        <div style="display:inline">- excise
                                            tax: <?php echo round($spotrebna_dan, 2); ?> Eur
                                            <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                 border="0" alt="bulb"
                                                 title="The following parameters influence the excise tax amount: <?php echo round(0.51, 2); ?> Eur per liter of gasoline, <?php echo round(0.48, 2); ?> Eur per liter of diesel, <?php echo round(1.64, 2); ?> Eur per pack of cigarettes (at an average price of <?php echo round(2.49, 2); ?> Eur), <?php echo round(0.08, 2); ?> Eur per liter of beer (10°) or <?php echo round(0.10, 2) ?> Eur per liter of beer (12°), <?php echo round(0.19, 2); ?> Eur per shot of liquor. We roll the payments for the TV and radio <?php echo round(4.64, 2); ?> Eur license fees into excise taxes here."/>
                                        </div>
                                        <br>

                                        <div style="display:inline">-
                                            VAT: <?php echo round($dph, 2); ?> Eur
                                            <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                 border="0" alt="bulb"
                                                 title="You must pay 19% VAT on every purchase. VAT does not apply to rent payments. We also abstract out goods and services which are exempt from VAT such as postal services and social aid services. Since private expenditures on medication and books represent less than 2% of the average Slovak's spending, we do not take account of the reduced 10% VAT rate for medications and books."/>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="40">&nbsp;</td>
                        <td>
                            <table>
                                <tr>
                                    <td width="40"><img
                                            src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/result-outcomes.png"
                                            border="0" alt="outcomes"></td>
                                    <td class="m">
                                        <div style="display:inline"><strong>Contributions
                                            total: <?php echo round($odvody_celkovo, 2); ?> Eur</strong>
                                            <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                 border="0" alt="bulb"
                                                 title="Of the overall salary expenses your employer pays for your work, 35.9% are contributions for health insurance and to the Social Insurance Agency (for comparison, with a gross salary of <?php echo round(600.00, 1); ?> Eur income tax would be 7%)"/>
                                        </div>
                                        <div>Of that:</div>
                                        <!--- odvody zamestnanca: <?php echo $odvody_spolu; ?> Sk<br>
												- odvody zamestnávateľa: <?php echo $z_odvody_spolu; ?> Sk<br> -->
                                        <div style="display:inline">- health
                                            contributions: <?php echo round($zdravotne_odvody, 2); ?> Eur
                                        </div>
                                        <br>

                                        <div style="display:inline">- retirement
                                            contributions: <?php echo round($dochodkove_poistenie, 2); ?> Eur
                                            <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                 border="0" alt="bulb"
                                                 title="Including payments to the reserve fund, which only the employer pays."/>
                                        </div>
                                        <br>

                                        <div style="display:inline">- other
                                            contributions: <?php echo round($ostatne_odvody, 2); ?> Eur
                                            <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                 border="0" alt="bulb"
                                                 title="Injury, disability, guarantee, illness and unemployment insurance."/>
                                        </div>
										<?php if ($dsporenie > 0) { ?>
                                        <br>
                                        <br>
                                        <div style="display:inline"><strong>Retirement
                                            savings: <?php echo round($dsporenie, 2); ?> Eur

                                            <img src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                                                 border="0" alt="bulb"
                                                 title="We do not include this figure in contributions since your money is placed in an account with a pension administration company."/>
                                        </strong></div>
										<?php } ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <div style="display:inline">
                    <h2>Your monthly balance <img
                            src="<?php echo JURI::root(true); ?>/media/com_poswhatdoyoupay/images/bulb.jpg"
                            border="0"
                            title="If the blue section is smaller than 50% that means that each month you pay the state more than you spend and save of your own salary. Payments to the state also include VAT and excise taxes which you pay on your consumption.">

                        <h2>
                </div>
                <iframe frameborder=0 scrolling=no marginheight="1px" marginwidth="1px" width="402px" height="452px"
                        src="<?php echo JRoute::_('index.php?option=com_poswhatdoyoupay&view=chart&format=raw') . "&data=" . round($cena_prace - $dane_a_odvody_spolu) . "$" . round($dan_z_prijmu_pozitivna) . "$" . ceil($spotrebna_dan) . "$" . round($dph) . "$" . round($zdravotne_odvody) . "$" . round($dochodkove_poistenie + $fond_solidarity) . "$" . round($ostatne_odvody); ?>"></iframe>
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
