<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

?>

<div class="main-table-wrapper"
     style="background-position: bottom; background-image: url(/templates/pos/images/bg-incomes.png)">
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
												<?php
												if ($this->isQuadrantEnabled(1)) {
													$item = MenuHelper::findFirstDisplayableItem(ConfigurationHelper::getQuadrantMenuType(1));
													if ($item != MenuHelper::NOT_FOUND) {
														?>
                                                        <div class="padding-10"
                                                             onMouseOver="this.style.cursor='pointer'"
                                                             onClick="parent.location='<?php echo NavigationHelper::routeTableView($item, $this->getYear())?>'">
															<?php TableRenderer::render($this->getQuadrantTableInfo(1), $this->getQuadrantTableData(1), $this->getYear(), 340, "", "", true); ?>
                                                        </div>
														<?php
													}
												} else {
													$modules =& JModuleHelper::getModules("quadrant2");
													if (sizeof($modules) > 0) {
														foreach ($modules as $module) {
															echo JModuleHelper::renderModule($module);
														}
													} else {
														echo "
                                                    <div class='padding-10'>Quadrant 2</div>";
													}
												}   ?>
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
