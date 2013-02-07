<ul id="main-tables-years">
    <li style="width: 200px"><a href="<?php echo JURI::root(true)?>"><?php echo JText::_("COM_POSSHOP_BACK_TO_THE_MAIN")?></a></li>
    <div class="cb">&nbsp;</div>
</ul>
                        <div id="main-tables">
                            <div class="textual">
                                <div class="padding-10">
                                    <h1><?php echo JText::_("COM_POSSHOP_TITLE")?></h1>

                                    <form method="POST"
                                          action="<?php echo JRoute::_('index.php?option=com_posshop&view=results&task=results.calculate'); ?>"
                                          name="form1">
