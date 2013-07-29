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
require_once('simplepie/autoloader.php');

class RSSWidget extends SimplePie
{
	public static function getParams( $params ){
		if( is_array( $params ) && class_exists( 'ZFilter' ) )
		{
			$filter = new ZFilter();
			$params = $filter->sanitize( $params );
			$params = $filter->xss_clean( $params );
			$params = $filter->run( $params );
			
			if( empty( $params ) )
				die( $filter->get_readable_errors( true ) );				
			
			return json_decode(json_encode( $params ), FALSE);
		}
		
		return null;
	}
	
	public static function validateInput( $url  )
	{
		if( empty( $_GET ) || empty( $_GET['rsswidget'] ) )
		{
			header( 'Location: ' . $url );
			die();
		}
	}
	
	public static function getLayout( $layout = 'default' )
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
	
	public static function reportError( $str = '', $color = 'orange' )
	{
		if( empty($str) ) $str = 'Sorry!, there is no items to show. Check your params please!';
		return "<p style='color: {$color}'>{$str}</p>";
	}
}

require("gump.class.php");
class ZFilter extends GUMP
{
	protected $validation_rules = array(
		'url'						=>	'required|valid_url',
		'css_url'					=>	'valid_url',
		'template'					=>	'required|alpha_dash',
		'frame_width'				=>	'integer',
	    'frame_height'				=>	'integer',
	    'scroll'					=>	'boolean',
	    'scroll_step'				=>	'integer',
		'scroll_bar'				=>	'boolean',
	    'target'					=>	'contains,_self _blank',
	    'border'					=>	'boolean',
	    'title'						=>	'required|boolean',
	    'title_name'				=>	'valid_name',
	    'footer'					=>	'required|boolean',
	    'footer_name'				=>	'valid_name',
		'item_link'					=>	'required|boolean',
		'item_title_length'			=>	'integer',
		'item_date'					=>	'required|boolean',
		'item_description'			=>	'required|boolean',
		'item_description_length'	=>	'integer',
		'item_description_tag'		=>	'required|boolean',
		'item_source_icon'			=>	'required|boolean',
		'no_items'					=>	'integer',
		'cache'						=>	'required|boolean',
		'cache_duration'			=>	'integer'
	);
	
	/**
	 * Perform data validation against the provided ruleset
	 *
	 * @access public
	 * @param  mixed $input
	 * @param  array $ruleset
	 * @return mixed
	 */
	public function validate( array &$input, array $ruleset )
	{
		$this->errors = array ();
		
		foreach ( $ruleset as $field => $rules ) {
			$rules = explode ( '|', $rules );
			
			foreach ( $rules as $rule ) {
				$method = NULL;
				$param = NULL;
				
				if( strstr ( $rule, ',' ) !== FALSE ) // has params
				{
					$rule = explode ( ',', $rule );
					$method = 'validate_' . $rule [0];
					$param = $rule [1];
				} else {
					$method = 'validate_' . $rule;
				}
				
				if( is_callable ( array( $this, $method ) ) ) {
					$result = $this->$method ( $field, $input, $param );
					
					// Validation Failed
					if (is_array ( $result ))
						$this->errors [] = $result;
					
				} else {
					throw new Exception ( "Validator method '$method' does not exist." );
				}
			}
		}
		
		return (count ( $this->errors ) > 0) ? $this->errors : TRUE;
	}
	
	/**
	 * Determine if the provided value is a PHP accepted boolean
	 *
	 * Usage: '<index>' => 'boolean'
	 *
	 * @access protected
	 * @param  string $field
	 * @param  array $input
	 * @return mixed
	 */
	protected function validate_boolean($field, &$input, $param = NULL)
	{
		if( !isset($input[$field]) ){ return; }
	
		$bool = filter_var($input[$field], FILTER_VALIDATE_BOOLEAN);
	
		if(!is_bool($bool)) {
			return array(
					'field' => $field,
					'value' => $input[$field],
					'rule'	=> __FUNCTION__,
					'param' => $param
			);
		} elseif( is_string($input[$field]) ) {
				$input[$field] = $this->strBoolean( $input[$field] );
		}
	}
	
	protected function strBoolean( $str ) {
		$isFalse = array( 'false', '0', 'no' );
		return ( in_array( strtolower( trim( $str ) ), $isFalse ) ) ? false : settype( $str, 'bool' );
	}
}