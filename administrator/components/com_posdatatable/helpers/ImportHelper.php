<?php
defined('_JEXEC') or die;
require("ExcelParser.php");
require_once(JPATH_COMPONENT_SITE . '/helpers/ConfigurationHelper.php');

class ImportHelper {

	private $tableDao;
	private $message;

	public function import() {

		$this->message =  "<pre>\n";
		if (isset($_FILES['data_file'])) {

			$zipCandidate = $_FILES['data_file']['name'];

			if ($this->isZipFile($zipCandidate)) {
				$this->processZipFile($_FILES['data_file']['tmp_name']);
			} else {
				$this->processFile($_FILES['data_file']['name'], $_FILES['data_file']['tmp_name']);
			}
		}
		$this->message .= "</pre>";
		return $this->message;
	}

	public function processZipFile($uploadedFileName) {
		$zip = zip_open($uploadedFileName);
		if (is_resource($zip)) {
			while ($zip_entry = zip_read($zip)) {
				if (zip_entry_open($zip, $zip_entry, "r")) {
					$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
					$this->processFile(zip_entry_name($zip_entry), $buf);

					zip_entry_close($zip_entry);
				}
			}
			zip_close($zip);
		} else {
			echo 'Unable to extract zip file.<br>';
		}
	}

	public function isZipFile($zipCandidate) {
		return !(strpos($zipCandidate, ".zip", strlen($zipCandidate) - 5) === false);
	}

	public function processFile($originalFileName, $filePath) {
		$parser = new ExcelParser();
		$parser->setUseFirstLanguage(ConfigurationHelper::useFirstLanguage());
		$parser->setTableDao($this->getTableDao());
		$this->message .= $parser->parseExcel($originalFileName, $filePath);

	}

	public function setTableDao($tableDao) {
		$this->tableDao = $tableDao;
	}

	public function getTableDao() {
		return $this->tableDao;
	}
}

?>