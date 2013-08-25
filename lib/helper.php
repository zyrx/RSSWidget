<?php
/**
 * @package		RSSWidget
 * @subpackage	helper
 * @author		Lech H. Conde <lech@zyrx.com.mx>
 * @copyright	Copyright (c) 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_ZRXEXEC') or die;
require_once('simplepie/autoloader.php');

class RSSWidget extends SimplePie
{
	public static function getParams( $params ){
		if( is_array( $data = $_REQUEST[$params] ) && class_exists( 'ZFilter' ) )
		{
			$filter = new ZFilter();
			$data = $filter->sanitize( $data );
			$data = $filter->xss_clean( $data );
			$data = $filter->run( $data );
			
			if( empty( $data ) )
				die( $filter->get_readable_errors( true ) );				
			
			return json_decode(json_encode( $data ), FALSE);
		}
		
		return null;
	}
	
	public static function validateInput( $params, $url  )
	{
		if( empty( $_REQUEST ) || empty( $_REQUEST[$params] ) )
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
	protected $params = array(
		'url'						=>	'required|valid_url',
		'css_url'					=>	'valid_url',
		'template'					=>	'required|alpha_dash',
		'name'						=>	'alpha_numeric',
		'width'						=>	'required|integer',
	    'height'					=>	'required|integer',
		'seamless'					=>	'boolean',
	    'scroll_step'				=>	'integer',
	    'target'					=>	'contains,_self _blank',
		'cache'						=>	'required|boolean',
		'cache_duration'			=>	'integer'
	);
	
	protected $feed = array (
		'feed_title'					=>	'boolean',
		'feed_link'						=>	'boolean',
		'feed_description'				=>	'boolean',
		'feed_language'					=>	'boolean',
		'feed_copyright'				=>	'boolean',
		'feed_managingEditor'			=>	'boolean',
		'feed_webMaster'				=>	'boolean',
		'feed_pubDate'					=>	'boolean',
		'feed_lastBuildDate'			=>	'boolean',
		'feed_category'					=>	'boolean',
		'feed_generator'				=>	'boolean',
		'feed_docs'						=>	'boolean',
		'feed_cloud'					=>	'boolean',
		'feed_ttl'						=>	'boolean',
		'feed_image'					=>	'boolean',
		'feed_textInput'				=>	'boolean',
		'feed_skipHours'				=>	'boolean',
		'feed_custom_title'				=>	'valid_name',
		'feed_custom_link'				=>	'valid_url',
	);
	
	protected $item = array (
		'item_title'					=>	'boolean',
		'item_title_length'				=>	'integer',
		'item_link'						=>	'boolean',
		'item_description'				=>	'boolean',
		'item_description_length'		=>	'integer',
		'item_author'					=>	'boolean',
		'item_category'					=>	'boolean',
		'item_comments'					=>	'boolean',
		'item_enclosure'				=>	'boolean',
		'item_guid'						=>	'boolean',
		'item_pubDate'					=>	'boolean',
		'item_source'					=>	'boolean',
	);
	
	/**
	 * Class Constructor
	 */
	function __construct(){ $this->validation_rules = array_merge( $this->params, $this->feed, $this->item ); }
	
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