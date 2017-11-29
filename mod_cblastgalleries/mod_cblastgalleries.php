<?php
/**
 * @package Module CB Last Galleries for Joomla! 3.x
 * @version $Id: mod_cblastgalleries.php 2015-04-09 12:18:00Z 
 * @author Hector Vega
 * @copyright  Copyright (C) 2015 Hector Vega, Systemas HV, All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
**/
defined('_JEXEC') or die;

//$document = & JFactory::GetDocument();
 
//$document->addScript(JURI::base() . 'modules/mod_cblastgalleries/assets/js/jquery-2.0.3.min.js');
//$document->addScript(JURI::base() . 'modules/mod_cblastgalleries/assets/js/jgallery.min.js?v=1.5.3');
//$document->addScript(JURI::base() . 'modules/mod_cblastgalleries/assets/js/touchswipe.min.js');
//$document->addScript(JURI::base() . 'modules/mod_cblastgalleries/assets/js/tinycolor-0.9.16.min.js');


// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

require JModuleHelper::getLayoutPath('mod_cblastgalleries', $params->get('layout', 'default'));