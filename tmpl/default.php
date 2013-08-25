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
<meta name="author" content="Lech H. Conde">
<meta charset="UTF-8">
<title><?php echo !empty($params->feed_custom_title)?$params->feed_custom_title:$feed->get_title(); ?></title>
<?php if( !empty( $params->css_url ) ): ?>
<link rel="stylesheet" href="<?php echo $params->css_url; ?>" type="text/css" />
<?php endif; ?>
</head>
<body>

	<div class="rssw-header">
	<?php if( $params->feed_title ):  ?>
		<h1 class="rssw-title">
		<?php if( $params->feed_link ):  ?>
			<a href="<?php echo $feed->get_permalink(); ?>" target="<?php echo $params->target; ?>"><?php echo !empty($params->title_name)?$params->title_name:$feed->get_title(); ?></a>
		<?php else: ?>
			<?php echo !empty($params->feed_custom_title)?$params->feed_custom_title:$feed->get_title(); ?>
		<?php endif;?>
		</h1>
	<?php endif; ?>
	
	<?php if( $params->feed_description ):  ?>
		<p class="rssw-description"><?php echo $feed->get_description(); ?></p>
	<?php endif; ?>
	</div>

<?php foreach( $items as $item ): ?>
	<div class="rssw-item">
	<?php if( $params->item_title ):  ?>
		<?php $title = ($params->item_title_length>0)&&(strlen($item->get_title())>$params->item_title_length)?substr($item->get_title(),0,$params->item_title_length).'...':$item->get_title();?>
		<h2 class="rssw-item-title">
		<?php if( $params->item_link ): ?>
			<a href="<?php echo $item->get_permalink(); ?>" target="<?php echo $params->target; ?>"><?php echo $title; ?></a>
		<?php else: ?>
			<?php echo $title; ?>
		<?php endif;?>
		</h2>
	<?php endif; ?>
		
	<?php if( $params->item_description ):  ?>
		<?php $description = ($params->item_description_length>0)&&(strlen($item->get_description())>$params->item_description_length)?substr($item->get_description(),0,$params->item_description_length).'...':$item->get_description(); ?>
		<p  class="rssw-item-description"><?php echo $description; ?></p>
	<?php endif; ?>
		
		<?php if( $params->item_pubDate ):  ?>
		<p  class="rssw-item-date"><small>Publicado el <?php echo $item->get_date(); ?></small></p>
		<?php endif; ?>
	</div>
	
<?php endforeach; ?>

</body>
</html>