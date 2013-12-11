<?php
/**
 * Provides the search form within the search results display so that a user 
 * can modify the current search without having to start over.
 * 
 * Copy this file to override the layout and style of the search results form.
 * 
 * @package		JSolr
 * @subpackage	Search
 * @copyright	Copyright (C) 2012-2013 Wijiti Pty Ltd. All rights reserved.
 * @license     This file is part of the JSolrSearch Component for Joomla!.

   The JSolrSearch Component for Joomla! is free software: you can redistribute it 
   and/or modify it under the terms of the GNU General Public License as 
   published by the Free Software Foundation, either version 3 of the License, 
   or (at your option) any later version.

   The JSolrSearch Component for Joomla! is distributed in the hope that it will be 
   useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with the JSolrSearch Component for Joomla!.  If not, see 
   <http://www.gnu.org/licenses/>.

 * Contributors
 * Please feel free to add your name and email (optional) here if you have 
 * contributed any source code changes.
 * Name							Email
 * Hayden Young					<haydenyoung@wijiti.com>
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

JHTML::_('behavior.formvalidation');

$form = $this->get('Form');
?>
<form action="<?php echo JRoute::_("index.php"); ?>" method="get" name="adminForm" class="form-inline" id="jsolr-search-result-form">
	<input type="hidden" name="option" value="com_jsolrsearch"/>
	<input type="hidden" name="task" value="search"/>
	
	<?php if (JFactory::getApplication()->input->get('o', null)) : ?>
	<input type="hidden" name="o" value="<?php echo JFactory::getApplication()->input->get('o'); ?>"/>
	<?php endif; ?>
	
	<div class="form-group col-sm-10">
		<?php echo $form->getInput('q'); ?>
	</div>
		
	<!-- Output the hidden form fields for the various selected facet filters. -->
	<?php foreach ($this->get('Form')->getFieldset('facets') as $field): ?>
		<?php if (trim($field->value)) : ?>
			<?php echo $this->form->getInput($field->fieldname); ?>
		<?php endif; ?>
	<?php endforeach;?>
		
	<button type="submit" class="btn btn-primary"><?php echo JText::_("COM_JSOLRSEARCH_BUTTON_SUBMIT"); ?></button>

	<a href="<?php echo JRoute::_($this->get('AdvancedURI')); ?>">Advanced search</a>

	<?php $components = $this->get('Extensions'); ?>

	<nav>			
		<ul class="nav nav-tabs">
			<?php 
			for ($i = 0; $i < count($components); ++$i): 
				$isSelected = ($components[$i]['plugin'] == JFactory::getApplication()->input->get('o')) ? true : false;
			
				echo '<li'.($isSelected ? ' class="active"' : '').'>';
			
				echo JHTML::_(
					'link', 
					$components[$i]['uri'], 
					$components[$i]['name'], 
					array(
						'data-category'=>$components[$i]['plugin'])); 

				echo '</li>';
        	endfor 
        	?>
		</ul>
    </nav>

	<ul class="nav nav-pills">
	<?php foreach ($this->get('Form')->getFieldset('tools') as $field): ?>
		<?php if (strtolower($field->type) != 'jsolr.advancedfilter') : ?>
		<li class="dropdown"><?php echo $this->form->getInput($field->name); ?></li>
		<?php else : ?>
		<?php echo $this->form->getInput($field->name); ?>
		<?php endif; ?>
	<?php endforeach;?>
	</ul>

	<?php echo JHTML::_('form.token'); ?>
</form>