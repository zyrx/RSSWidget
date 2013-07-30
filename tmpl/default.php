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
<title><?php echo $params->title ? $params->title_name : 'RSS Widget';?></title>
<link rel="stylesheet" href="tmpl/css/default.css" type="text/css" />
<?php if( !empty( $params->css_url ) ): ?>
<link rel="stylesheet" href="<?php echo $params->css_url; ?>" type="text/css" />
<?php endif; ?>
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js'></script>
<script type='text/javascript' src='tmpl/js/default.js'></script>
<script type="text/javascript">function InitFeed(){ CalculateContentHeight(); initAutoScroll(8); }</script>
</head>
<body>

	<div class="rssw-header">
		<?php if( $params->title ):  ?>
		<h1 class="rssw-title"><a href="<?php echo $feed->get_permalink(); ?>" target="<?php echo $params->target; ?>"><?php echo !empty($params->title_name)?$params->title_name:$feed->get_title(); ?></a></h1>
		<?php endif; ?>		
		<p class="rssw-description"><?php echo $feed->get_description(); ?></p>
	</div>

<?php foreach( $items as $item ): //var_dump($item); ?>
	<div class="rssw-item">
		<h2 class="rssw-item-title">
			<?php if( $params->item_link ): ?>
				<a href="<?php echo $item->get_permalink(); ?>" target="<?php echo $params->target; ?>"><?php echo $item->get_title(); ?></a>
			<?php else: ?>
				<?php echo $item->get_title(); ?>
			<?php endif;?>
		</h2>
		
		<?php if( $params->item_description ):  ?>
		<p  class="rssw-item-description"><?php echo $item->get_description(); ?></p>
		<?php endif; ?>
		
		<?php if( $params->item_date ):  ?>
		<p  class="rssw-item-date"><small>Publicado el <?php echo $item->get_date(); ?></small></p>
		<?php endif; ?>
	</div>
	
<?php endforeach; ?>

</body>
</html>