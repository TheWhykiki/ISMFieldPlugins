<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.Sql
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::import('components.com_fields.libraries.fieldslistplugin', JPATH_ADMINISTRATOR);

/**
 * Fields Sql Plugin
 *
 * @since  3.7.0
 */
class PlgFieldsSqlwhykiki extends FieldsListPlugin
{
	/**
	 * Transforms the field into a DOM XML element and appends it as a child on the given parent.
	 *
	 * @param   stdClass    $field   The field.
	 * @param   DOMElement  $parent  The field node parent.
	 * @param   JForm       $form    The form.
	 *
	 * @return  DOMElement
	 *
	 * @since   3.7.0
	 */
	public function onCustomFieldsPrepareDom($field, DOMElement $parent, JForm $form)
	{
        //$field->type = 'sql';
		$fieldNode = parent::onCustomFieldsPrepareDom($field, $parent, $form);
        $header = $field->fieldparams->get('header');

		if (!$fieldNode)
		{
			return $fieldNode;
		}

		$fieldNode->setAttribute('type', 'sql');
		$fieldNode->setAttribute('value_field', 'text');

		if(!empty($header)){
            $fieldNode->setAttribute('header', $header);
        }
		$fieldNode->setAttribute('key_field', 'value');

		return $fieldNode;
	}

	/**
	 * The save event.
	 *
	 * @param   string   $context  The context
	 * @param   JTable   $item     The table
	 * @param   boolean  $isNew    Is new item
	 * @param   array    $data     The validated data
	 *
	 * @return  boolean
	 *
	 * @since   3.7.0
	 */
	public function onContentBeforeSave($context, $item, $isNew, $data = array())
	{
		// Only work on new SQL fields
		if ($context != 'com_fields.field' || !isset($item->type) || $item->type != 'sqlwhykiki')
		{
			return true;
		}

		// If we are not a super admin, don't let the user create or update a SQL field
		if (!JAccess::getAssetRules(1)->allow('core.admin', JFactory::getUser()->getAuthorisedGroups()))
		{
			$item->setError(JText::_('PLG_FIELDS_SQL_CREATE_NOT_POSSIBLE'));

			return false;
		}

		return true;
	}
}
