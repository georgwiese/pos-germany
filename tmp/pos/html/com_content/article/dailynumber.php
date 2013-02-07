<div id="main-tables-wrapper">
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
