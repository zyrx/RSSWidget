<?php
/**
 * @package		RSSWidget
 * @subpackage	default_template
 * @author		Lech H. Conde <lech@zyrx.com.mx>
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// Set flag that this is a parent file.
define('_ZRXEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);
define('RSSW_PATH_BASE', dirname(__FILE__));

require_once('lib/simplepie/autoloader.php');
require_once('lib/helper.php');

RSSWidget::validateInput( 'http://www.e-consulta.com' );

$filter = new ZFilter();
$params = $filter->sanitize( $_GET['rsswidget'] );
$params = $filter->run( $params );
if( !$params ) die( $filter->get_readable_errors( true ) );

$feed = new SimplePie();
$feed->set_feed_url( $params['url'] );

//Enable caching
if( $params['cache'] )
{
	$duration = $params['cache_duration'];
	if( $duration < 0 || $duration > 3600 ) $duration = 1800;
	$feed->enable_cache(true);
	$feed->set_cache_location( 'cache' );
	$feed->set_cache_duration( $duration );
}

$feed->init();
$feed->handle_content_type();

require RSSWidget::getLayoutPath( $params['template'] );