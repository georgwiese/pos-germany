<?php
	// No direct access to this file
	defined('_JEXEC') or die('Restricted access');
	require_once(JPATH_COMPONENT . '/helpers/MenuHelper.php');
	require_once(JPATH_COMPONENT . '/helpers/ConfigurationHelper.php');
	require_once("SummaryTableRenderer.php");

	$quadrantIndex = intval(MenuHelper::getQuadrant($this->getItem())) -1;
	$detailTitle = ConfigurationHelper::getQuadrantTitle($quadrantIndex);
	$baseStyle = ConfigurationHelper::getQuadrantClass($quadrantIndex);
?>

<div id="submenu">
	<?php MenuHelper::printYearMenu(JFactory::getApplication()->getMenu(), $this->getYear(), $this->getItem(),
	$this->getTableName(), $this->getRow());    ?>
</div>
<div id="main-tables">
	<div class="inner-tables">
		<div class="inner-left">
			<div class="padding-10">
				<ul class="inner-menu">
					<?php MenuHelper::printTableMenu(JFactory::getApplication()->getMenu(), $this->getYear(), $this->getItem()); ?>
				</ul>
			</div>
		</div>
		<div class="inner-right">
			<div class="padding-10">
				<table cellpadding='0' cellspacing='0'>
					<col width='400px'/>
					<col width='160px'/>
					<col/>
					<tr>
						<td><h1><?php echo $detailTitle ?></h1></td>
					</tr>
				</table>
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
															<div class="<?php echo $baseStyle; ?>">
																<div class="padding-10">
																	<div>
																		<?php
																		include("detail.php");
																		?>
																	</div>
																	<div class="cb">&nbsp;</div>
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
	</div>
	<div class="cb">&nbsp;</div>
</div>

