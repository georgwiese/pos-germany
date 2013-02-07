<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');

?>

<div class="main-table-wrapper"
     style="background-position: bottom; background-image: url(/templates/pos/images/bg-debts.png)">
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
                                            <div class="debts">
												<?php
												if ($this->isQuadrantEnabled(3)) {
													$item = MenuHelper::findFirstDisplayableItem(ConfigurationHelper::getQuadrantMenuType(3));
													if ($item != MenuHelper::NOT_FOUND) {
														?>
                                                        <div class="padding-10"
                                                             onMouseOver="this.style.cursor='pointer'"
                                                             onClick="parent.location='<?php echo NavigationHelper::routeTableView($item, $this->getYear())?>'">
															<?php TableRenderer::render($this->getQuadrantTableInfo(3), $this->getQuadrantTableData(3), $this->getYear(), 340, "", "", true); ?>
                                                        </div>
														<?php
													}
												} else {
													$modules =& JModuleHelper::getModules("quadrant4");
													if (sizeof($modules) > 0) {
														foreach ($modules as $module) {
															echo JModuleHelper::renderModule($module);
														}
													} else {
														echo "<div class='padding-10'>Quadrant 4</div>";
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
