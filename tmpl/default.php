<?php
/**
 * @package		RSSWidget
 * @subpackage	default_template
 * @author		Lech H. Conde <lech@zyrx.com.mx>
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_ZRXEXEC') or die;

?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $params['title']; ?></title>
</head>
<body>
<?php if ( !empty( $feed ) ): ?>
	<div class="rssw-header">
		<h1 class="rssw-title"><a href="<?php echo $feed->get_permalink(); ?>"><?php echo $feed->get_title(); ?></a></h1>
		<p class="rssw-description"><?php echo $feed->get_description(); ?></p>
	</div>

<?php foreach( $feed->get_items() as $item ): ?>
	<div class="rssw-item">
		<h2 class="rssw-item-title"><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h2>
		<?php if( $params['item_description'] ):  ?>
		<p  class="rssw-item-description"><?php echo $item->get_description(); ?></p><?php endif; ?>
		<?php if( $params['item_date'] ):  ?>
		<p  class="rssw-item-date"><small>Publicado el <?php echo $item->get_date( 'j F Y | g:i a' ); ?></small></p><?php endif; ?>
	</div>
	
<?php endforeach; ?>
<?php endif; ?>
</body>
</html>