<?php
/**
 * @package		RSSWidget
 * @subpackage	default_template
 * @author		Lech H. Conde <lech@zyrx.com.mx>
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */
?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>RSS Widget Demo</title>
</head>
<body>
<script type="text/javascript"> 
	var params = {
		'url'						:	'http://www.e-consulta.com/puebla/feed',
		'css_url'					:	'http://e-consulta.com/sites/all/themes/econsulta/css/widget.css',
		'template'					:	'default',
		'name'						:	'rsswidget',
		'width'						:	400,
	    'height'					:	500,
	    'seamless'					:	false,
	    'scroll_step'				:	8,
	    'target'					:	'_blank',
		'cache'						:	false,
		'cache_duration'			:	400,
		
	//feed
		'feed_title'				:	true,
		'feed_link'					:	true,
		'feed_description'			:	false,
		'feed_language'				:	false,
		'feed_copyright'			:	false,
		'feed_managingEditor'		:	false,
		'feed_webMaster'			:	false,
		'feed_pubDate'				:	false,
		'feed_lastBuildDate'		:	false,
		'feed_category'				:	false,
		'feed_generator'			:	false,
		'feed_docs'					:	false,
		'feed_cloud'				:	false,
		'feed_ttl'					:	false,
		'feed_image'				:	false,
		'feed_textInput'			:	false,
		'feed_skipHours'			:	false,
		'feed_custom_title'			:	'',
		'feed_custom_link'			:	'',
		
	// item
		'item_title'				:	false,
		'item_title_length'			:	0,
		'item_link'					:	true,
		'item_description'			:	true,
		'item_description_length'	:	200,
		'item_author'				:	true,
		'item_category'				:	true,
		'item_comments'				:	true,
		'item_enclosure'			:	true,
		'item_guid'					:	true,
		'item_pubDate'				:	false,
		'item_source'				:	true,
	};
</script>
<script type="text/javascript" src="../js/rsswidget.js"></script>
</body>
</html>