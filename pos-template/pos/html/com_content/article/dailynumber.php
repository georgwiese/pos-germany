<div id="main-tables-wrapper">
    <ul id="main-tables-years">
        <li style="width: 200px; padding-left: 4px; padding-right: 4px;  "><a href="<?php echo JURI::root(true).'/'; ?>"><?php echo JText::_("TPL_POS_BACK_TO_MAIN");?></a>
        </li>
        <li style="background-image:none;"></li>
        <div class="cb">&nbsp;</div>
    </ul>
    <div id="main-tables">
        <div class="textual">
            <div class="padding-10">
				<?php if ($this->item->params->get('show_title')) { ?>
                <h1><?php echo $this->item->category_title; ?></h1>
				<?php } ?>
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
																<?php include("dailynumber_content.php"); ?>
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
</div>
