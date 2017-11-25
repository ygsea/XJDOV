<?php 
/**
 * 日志模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<section class="container">
	<div class="content-wrap">
	<div class="content">
		<?php if(blog_tool_ishome()&& $ppt_zhiding==2){?>
<div id="homeslider" class="carousel slide" data-ride="carousel"><ol class="carousel-indicators"><li data-target="#homeslider" data-slide-to="0" class="active"></li><li data-target="#homeslider" data-slide-to="1" class=""></li><li data-target="#homeslider" data-slide-to="2" class=""></li></ol><div class="carousel-inner" role="listbox"><div class="item active"><a target="_blank" href="<?php echo $ppt_titleurl;?>"><img src="<?php echo $ppt_picurl;?>" alt="blog.yesfree.pw"></a></div><div class="item"><a target="_blank" href="<?php echo $ppt_titleur2;?>"><img src="<?php echo $ppt_picur2;?>" alt="blog.yesfree.pw"></a></div><div class="item"><a target="_blank" href="<?php echo $ppt_titleur3;?>"><img src="<?php echo $ppt_picur3;?>" alt="blog.yesfree.pw"></a></div></div><a class="left carousel-control" href="#homeslider" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a><a class="right carousel-control" href="#homeslider" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a></div>		
<?php }
if(blog_tool_ishome()&&$radio_zhiding=='2'):
?>
<article class="excerpt-see excerpt-see-index">
<p class="note">
<div class="widget widget_efui_posts "><span class="icon"><i class="fa fa-bullhorn"></i></span>
<ul><?php echo index_t(1); ?></ul>
</div>
</p></article>
<?php endif;?>
<?php doAction('index_loglist_top'); 
if (!empty($logs)){
		if(blog_tool_ishome() && empty($keyword)) {
			//echo '<div class="title"><h3>最新更新</h3></div>';
		}
		if(!empty($sort)) {
			//栏目页显示
			$des = $sort['description']?$sort['description']:'这家伙很懒，还没填写该栏目的介绍呢~';
			echo '<div class="content_catag_container"><h2 class="content_catag_title isKeywords font_title">'.$sortName.'</h2><p>'.$des.'</p></div>';
		}
		if(!empty($record)) {
			//日期记录
			$year    = substr($record,0,4);
			$month   = ltrim(substr($record,4,2),'0');
			$day     = substr($record,6,2);
			$archive = $day?$year.'年'.$month.'月'.ltrim($day,'0').'日':$year.'年'.$month.'月';
			echo '<div class="content_catag_container"><h2 class="content_catag_title isKeywords font_title">日志归档</h2><p>'.$archive.'发布的文章</p></div>';
		}
		if(!empty($author_name)) {
			//作者日志显示
			
			echo '<div class="content_catag_container"><h2 class="content_catag_title isKeywords font_title">作者</h2><p>本站作者<strong>'.$author_name.'</strong> 共计发布文章'.$lognum.'篇</p></div>';
		}
		if(!empty($keyword)) {
			//搜索
			echo '<div class="content_catag_container"><h2 class="content_catag_title isKeywords font_title">站内搜索</h2><p>本次搜索帮您找到有关 <strong>'.$keyword.'</strong> 的结果'.$lognum.'条</p></div>';
		}
		if(!empty($tag)) {
			//关键词
			echo '<div class="content_catag_container"><h2 class="content_catag_title isKeywords font_title">标签关键词</h2><p>关于 <strong>'.$tag.'</strong> 的文章共有'.$lognum.'条</p></div>';
		}
}

foreach($logs as $key=>$value): 
	$picnum = pic($value['content']);
	$muti = False;
	if($picnum>=4){
		$muti = True;
	}else{
		if($module_thum=="0"){
			$imgsrc = GetThumFromContent($value['content']);
		}else{
			$imgsrc = get_thum($value['logid']);
		}
	}
	$keys = $key+1;
	
?>
	<article class="excerpt <?php if($muti):echo "excerpt-multi";else:echo "excerpt-{$keys}";endif; ?>">
	<?php if(!$muti): ?>
	<p class="focus"><a class="thumbnail" href="<?php echo $value['log_url']; ?>">
	<span class="item"><span class="thumb-span"><img class="thumb" src="<?php echo $imgsrc;?>" style="display: inline;"></span></span></a></p>
	<?php endif; ?>
	
	<header><?php blog_sort($value['logid']); ?> <h2><a href="<?php echo $value['log_url']; ?>" title="<?php echo $value['log_title']; ?>"><?php echo $value['log_title']; ?></a></h2></header><p class="meta"><time><i class="fa fa-clock-o"></i><?php echo gmdate('Y-n-j', $value['date']); ?></time><span class="pv"><i class="fa fa-eye"></i>阅读(<?php echo $value['views']; ?>)</span><span class="pc"><i class="fa fa-comments-o"></i>评论(<span id="sourceId::6312" class="cy_cmt_count"><?php echo $value['comnum']; ?></span>)</span></p>
	<?php 
		if($muti):
		echo '<p class="focus"><a class="thumbnail" href="'.$value['log_url'].'">';
 		if(preg_match_all("/<img.*src=[\"'](.*)[\"']/Ui", $value['content'], $imgs) && !empty($imgs[1])){
            $imgNum = count($imgs[1]);
            if($imgNum < 4){$n = 1;
            }elseif($imgNum < 8){$n = 4;
            }else{ $n = 8;}
            for($i=0; $i < $n; $i++){
                $img = $imgs[1][$i];
                echo "<span class=\"item\"><span class=\"thumb-span\"><img src='$img' class=\"thumb\" ></span></span>";
            }}
        echo "</a></p>";
        endif;
	 ?>
	<p class="note"><?php echo $logdes = tool_purecontent($value['content'], 180); ?></p></article>
<?php 
endforeach;
?>

<div class="pagenavi"><ul>
<?php echo sheli_fy($lognum,$index_lognum,$page,$pageurl);?></ul>
</div>

</div></div>
<?php
 include View::getView('side');
 include View::getView('footer');
?>