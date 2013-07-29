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
setlocale( LC_ALL, 'es_MX' );

require_once('lib/helper.php');

// Validates params or redirects to the given url
RSSWidget::validateInput( 'http://www.example.com' );
$params = RSSWidget::getParams( $_GET['rsswidget'] );

$feed = new RSSWidget();
$feed->set_feed_url( $params->url );

//Enable caching
if( $params->cache ) {
	$duration = $params->cache_duration;
	if( $duration < 0 || $duration > 3600 ) $duration = 1800;
	$feed->enable_cache( true );
	$feed->set_cache_location( 'cache' );
	$feed->set_cache_duration( $duration );
} else {
	$feed->enable_cache( false );
}

$feed->init();
$feed->handle_content_type();

if( !empty( $feed ) && $items = $feed->get_items() ) {
	require RSSWidget::getLayout( $params->template );
} else {
	echo RSSWidget::reportError();
}
