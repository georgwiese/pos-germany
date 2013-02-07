<div id="main-tables">
    <div class="textual">
        <div class="padding-10">
            <h1><?php echo JText::_("COM_POSSHOP_TITLE")?></h1>


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
                                                        <div class="padding-10">

                                                            <br>
                                                            <br>
                                                            <br>

                                                            <div style="text-align: center;"><?php echo JText::sprintf('COM_POSSHOP_YOUR_STATE_COSTS', $yourStateRounded); ?></div>
                                                            <br>

                                                            <div style="text-align: center;"><?php echo JText::sprintf('COM_POSSHOP_PER_CAPTIVA_TAX', $perCaptivaTax, $currentPerCaptivaTax); ?></div>
                                                            <br>

                                                            <div style="text-align: center;"><?php echo JText::sprintf(($cheaperThan > 0) ? 'COM_POSSHOP_CHEAPER_THAN' : 'COM_POSSHOP_MORE_EXPENSIVE', $cheaperThanFormatted); ?></div>
                                                            <br>

                                                            <div style="text-align: center;"><?php echo JText::sprintf(($cheaperThan > 0) ? 'COM_POSSHOP_YOU_SAVE' : 'COM_POSSHOP_YOU_INCREASE_COSTS', $savePerResident, $savePerWorking); ?></div>
                                                            <br>
                                                            <br><br>

                                                            <div style="text-align: center;"><a
                                                                    class="button"
                                                                    href="<?php echo JRoute::_('index.php?option=com_posshop&view=cart&'); ?>">
																<?php echo JText::_("COM_POSSHOP_BACK_TO_THE_SHOPPING") ?></a>
                                                            </div>
                                                            <br><br>

                                                            <div style="text-align: center;">
                                                                <iframe frameborder=0
                                                                        width='952px'
                                                                        height='332px'
                                                                        marginheight='1px'
                                                                        marginwidth='1px'
                                                                        src="<?php echo JRoute::_('index.php?option=com_posshop&view=chart&format=raw&your=' . $yourState . '&total=' . $currentState); ?>"
                                                                        scrolling=no>
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
    <div class="cb">&nbsp;</div>
</div>

