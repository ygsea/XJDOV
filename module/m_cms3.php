<?php 
/**
 * 站点首页模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<link rel="stylesheet" id="da-main-css" href="<?php echo TEMPLATE_URL; ?>style/zazhi1.css" type="text/css" media="all">
<?php CommonPageFromGFS(); ?>

<section class="container">
	<div class="content-wrap">

	<div class="row-fluid">
	<div class="widget widget_cms col-md-4"><div class="span_zahi"><span class="icon"><i class="fa fa-pencil-square-o"></i></span><h3>最新文章</h3>
	<div class="widget-content">
	<ul class="news-list">
	<?php foreach (zazhi_newlog("newlog") as $key => $value):?>
		<li><span><?php echo $value["date"]; ?></span><a href="<?php echo $value["url"]; ?>" title="<?php echo $value["title"]; ?>"><i class="fa fa-angle-right"></i><?php echo $value["title"]; ?></a></li>
	<?php endforeach; ?>
			</ul></div></div>
	</div>

	<div class="widget widget_cms col-md-4"><div class="span_zahi"><span class="icon"><i class="fa fa-fire"></i></span><h3>热门文章</h3>
	<div class="widget-content">
	<ul class="news-list">
	<?php foreach (zazhi_newlog("hotlog") as $key => $value):?>
		<li><span><?php echo $value["date"]; ?></span><a href="<?php echo $value["url"]; ?>" title="<?php echo $value["title"]; ?>"><i class="fa fa-angle-right"></i><?php echo $value["title"]; ?></a></li>
	<?php endforeach; ?>
	</ul></div></div>


	</div>

	<div class="widget widget_cms col-md-4"><div class="span_zahi"><span class="icon"><i class="fa fa-heart"></i></span><h3>猜你喜欢</h3>
	<div class="widget-content">
	<ul class="news-list">
	<?php foreach (zazhi_newlog("randlog") as $key => $value):?>
		<li><span><?php echo $value["date"]; ?></span><a href="<?php echo $value["url"]; ?>" title="<?php echo $value["title"]; ?>"><i class="fa fa-angle-right"></i><?php echo $value["title"]; ?></a></li>
	<?php endforeach; ?>
	</ul></div></div>


	</div>
</div>

<!-- 手绘画组合 start -->

<div class="row-fluid">
<div class="widget widget_cms pic-box"><div class="span_zahi span2"><span class="icon"><i class="fa fa-thumbs-o-up"></i></span><h3><?php echo getsotrnamefromsid($m_zazhi_config1);?>
<?php $data = sheli_tw($m_zazhi_config1,7);?></h3>
<div class="widget-content">
<ul>
<?php foreach ($data as $key => $value):
		if($module_thum=="0"){
			$imgsrc = GetThumFromContent($value['content']);
		}else{
			$imgsrc = get_thum($value['gid']);
		}
		if($key==0):?>
		<li class="first-pic"><a href="<?php echo $value["url"]; ?>" class="post-thumbnail" title="<?php echo $value["title"]; ?>" target="_blank">
		 <img class="lazy-loaded" src="<?php echo $imgsrc; ?>" width="660" height="400"></a>
		<a class="first-pic-title" href="http://www.sentyun.com/714.html" title="<?php echo $value["title"]; ?>" target="_blank"><?php echo $value["title"]; ?></a><p class="summary"><?php echo tool_purecontent($value["content"],80); ?>								</p>
		</li>
		<?php else: ?>
		<li><a href="<?php echo $value["url"]; ?>" class="post-thumbnail" title="<?php echo $value["title"]; ?>" target="_blank">
		 <img class="lazy-loaded" src="<?php echo $imgsrc; ?>" alt="<?php echo $value["title"]; ?>" width="330" height="200">
        </a><a class="row-title" href="<?php echo $value["url"]; ?>" title="<?php echo $value["title"]; ?>" rel="bookmark" target="_blank"><?php echo $value["title"]; ?></a></li>
		<?php endif;endforeach; ?>
</ul>
<div class="clear"></div>
</div>
</div></div>


</div>

<!-- 手绘画组合 end -->
<div class="row-fluid index_widget_cms">
<?php 
$array_sort = explode(",",$m_zazhi_config);
sort_name($array_sort);?>
</div>

<div class="row-fluid">
<div class="widget widget_cms"><div class="span_zahi span2"><span class="icon"><i class="fa fa-picture-o"></i></span><h3><?php echo getsotrnamefromsid($m_zazhi_config2);?></h3>
<?php $data = sheli_tw($m_zazhi_config2,30);?></h3>
		<div class="widget-content pic-list">
		<ul class="cat-scroll">
		<?php foreach ($data as $key => $value):
				if($module_thum=="0"){
					$imgsrc = GetThumFromContent($value['content']);
				}else{
					$imgsrc = get_thum($value['gid']);
				}
		?>
			<li>
				<a href="<?php echo $value["url"]; ?>" title="<?php echo $value["title"]; ?>" rel="bookmark" target="_blank">
				<img class="lazy-hidden" src="<?php echo $imgsrc; ?>" width="250" height="330"></a>
				</li>
		<?php endforeach; ?>
									
		</ul>
		<div class="clear"></div>
		</div>

</div>
</div>
</div>
<script src="<?php echo TEMPLATE_URL;?>js/jquery.bxslider.min.js"></script>
<script type="text/javascript">
	jQuery(function() {
		jQuery(".cat-scroll").bxSlider({
			minSlides: 5,
			maxSlides: 5,
			slideWidth: 250,
			slideMargin: 30,
			auto: true,
			autoHover: true,
			autoDelay:2,
			pause: 6000,
			captions: false,
			controls: true,
			adaptiveHeight:true,
			pager: false,	});
	});
</script>
	

</div>
</div>
</section>


<?php
 //include View::getView('side');
 include View::getView('footer');
?>