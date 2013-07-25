<?php
/**
 * @package		RSSWidget
 * @subpackage	helper
 * @author		Lech H. Conde <lech@zyrx.com.mx>
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_ZRXEXEC') or die;

class RSSWidget
{
	public static function validateInput( $url  )
	{
		if( empty( $_GET ) || empty( $_GET['rsswidget'] ) )
		{
			header( 'Location: ' . $url );
			die();
		}
	}
	
	public static function getLayoutPath( $layout = 'default' )
	{
	
		$tPath = RSSW_PATH_BASE . DS . 'tmpl' . DS . $layout . '.php';
		$dPath = RSSW_PATH_BASE . DS . 'tmpl' . DS . 'default.php';
	
		if (file_exists($tPath)) {
			return $tPath;
		}
		else {
			return $dPath;
		}
	}
}

require("gump.class.php");
class ZFilter extends GUMP
{
	protected $validation_rules = array(
		'url'						=>	'valid_url',
		'css_url'					=>	'valid_url',
		'template'					=>	'alpha_dash',
		'frame_width'				=>	'integer',
	    'frame_height'				=>	'integer',
	    'scroll'					=>	'boolean',
		'scroll_bar'				=>	'boolean',
	    'scroll_step'				=>	'integer',
	    'target'					=>	'contains,_self _blank',
	    'border'					=>	'boolean',
	    'title'						=>	'boolean',
	    'title_name'				=>	'valid_name',
	    'footer'					=>	'boolean',
	    'footer_name'				=>	'valid_name',
		'item_title_length'			=>	'integer',
		'item_date'					=>	'boolean',
		'item_description'			=>	'boolean',
		'item_description_length'	=>	'integer',
		'item_description_tag'		=>	'boolean',
		'item_source_icon'			=>	'boolean',
		'cache'						=>	'boolean',
		'cache_duration'			=>	'integer',
		'no_items'					=>	'integer',
	);
}