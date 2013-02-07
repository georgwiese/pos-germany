<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: martin.maliska
	 * Date: 2.10.2012
	 * Time: 18:52
	 * To change this template use File | Settings | File Templates.
	 */
	defined('_JEXEC') or die;
	$showImages = true;
?>
<div id="main-tables-wrapper">
    <ul id="main-tables-years">
        <li style="width: 200px"><a href="<?php echo JURI::root(true)."/"; ?>"><?php echo JText::_("TPL_POS_BACK_TO_MAIN");?></a></li>
        <li style="background-image:none; width: 460px"></li>
        <div class="cb">&nbsp;</div>
    </ul>
    <div id="main-tables">
        <div class="textual">
            <div class="padding-10">
                <h1><?php echo $this->escape($this->category->title); ?></h1>

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
                                                            <div class="incomes">
                                                                <div class="padding-10">
                                                                    <table class='main-table' cellspacing=0
                                                                           width="100%">
                                                                        <col width='60px'/>
                                                                        <col/>
																		<?php include("dailynumber_content.php") ?>
                                                                    </table>
                                                                    <br>

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
</div>
