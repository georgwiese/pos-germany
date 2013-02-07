<?php
// No direct access to this file
	defined('_JEXEC') or die;

// import the list field type
	jimport('joomla.form.helper');
	JFormHelper::loadFieldClass('list');

	/**
	 * TableName Form Field class for the PosDataTable component
	 */
	class JFormFieldTableName extends JFormFieldList {
		/**
		 * The field type.
		 *
		 * @var        string
		 */
		protected $type = 'TableName';

		/**
		 * Method to get a list of options for a list input.
		 *
		 * @return    array        An array of JHtml options.
		 */
		protected function getOptions() {
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('name');
			$query->from('#__pos_data_table_info');
			$query->group('name');
			$db->setQuery((string)$query);
			$tables = $db->loadObjectList();
			$options = array();
			if ($tables)
			{
				foreach($tables as $table)
				{
					$options[] = JHtml::_('select.option', $table->name, $table->name);
				}
			}
			$options = array_merge(parent::getOptions(), $options);
			return $options;
		}
	}
