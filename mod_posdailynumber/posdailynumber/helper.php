<?php

// no direct access
	defined('_JEXEC') or die;

	require_once JPATH_SITE . '/components/com_content/helpers/route.php';

	jimport('joomla.application.component.model');

	JModel::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

	abstract class modPosDailyNumberHelper {
		public static function getList(&$params) {
			$app = JFactory::getApplication();
			$db = JFactory::getDbo();

			// Get an instance of the generic articles model
			$model = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

			// Set application parameters in model
			$appParams = JFactory::getApplication()->getParams();
			$model->setState('params', $appParams);

			// Set the filters based on the module params
			$model->setState('list.start', 0);
			$model->setState('list.limit', 1);

			$model->setState('filter.published', 1);

			$model->setState('list.select', 'a.fulltext, a.id, a.title, a.alias, a.title_alias, a.introtext, a.state, a.catid, a.created, a.created_by, a.created_by_alias,' .
				' a.modified, a.modified_by,a.publish_up, a.publish_down, a.attribs, a.metadata, a.metakey, a.metadesc, a.access,' .
				' a.hits, a.featured,' .
				' LENGTH(a.fulltext) AS readmore');
			// Access filter
			$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
			$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
			$model->setState('filter.access', $access);

			// Category filter
			$model->setState('filter.category_id', $params->get('catid', array()));

			// Filter by language
			$model->setState('filter.language', $app->getLanguageFilter());

			// Set ordering
			$model->setState('list.ordering', 'rand()');
			$model->setState('list.direction', '');

			//	Retrieve Content
			$items = $model->getItems();

			foreach ($items as &$item) {
				$item->readmore = (trim($item->fulltext) != '');
				$item->slug = $item->id . ':' . $item->alias;
				$item->catslug = $item->catid . ':' . $item->category_alias;

				if ($access || in_array($item->access, $authorised)) {
					// We know that user has the privilege to view the article
					$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid));
					$item->linkText = JText::_('MOD_ARTICLES_NEWS_READMORE');
				} else {
					$item->link = JRoute::_('index.php?option=com_users&view=login');
					$item->linkText = JText::_('MOD_ARTICLES_NEWS_READMORE_REGISTER');
				}

				$item->introtext = JHtml::_('content.prepare', $item->introtext, '', 'mod_articles_news.content');

				$results = $app->triggerEvent('onContentAfterDisplay', array('com_content.article', &$item, &$params, 1));
				$item->afterDisplayTitle = trim(implode("\n", $results));

				$results = $app->triggerEvent('onContentBeforeDisplay', array('com_content.article', &$item, &$params, 1));
				$item->beforeDisplayContent = trim(implode("\n", $results));
			}

			return $items;
		}
	}
