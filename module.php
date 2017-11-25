﻿<?php
/*
 * @XJDOV   1.0.1
 * @authors 小俊博客：www.xjdog.cn
 * @date    2017-07-21
 * @version 1.0.1
 */
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="load"></div>
<?php
//统计文章总数
function count_log_all(){
$db = MySql::getInstance();
$data = $db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog WHERE type = 'blog'");
return $data['total'];
}
?>
<?php
//统计评论总数
function count_com_all(){
$db = MySql::getInstance();
$data = $db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "comment");
return $data['total'];
}
?>
<?php
//统计微语总数
function count_tw_all(){
$db = MySql::getInstance();
$data = $db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "twitter");
return $data['total'];
}
?>
<?php
//获取评论用户操作系统、浏览器等信息
function useragent($info){
	require_once 'useragent.class.php';
	$useragent = UserAgentFactory::analyze($info);
?>
<img src="<?php echo TEMPLATE_URL.$useragent->platform['image']?>">&nbsp;<?php echo $useragent->platform['title']; ?>&nbsp;
<img src="<?php echo TEMPLATE_URL.$useragent->browser['image']?>">&nbsp;<?php echo $useragent->browser['title']; ?>
<?php
}
?>
<?php
//widget：blogger
function widget_blogger($title){
    global $CACHE;
    $user_cache = $CACHE->readCache('user');
    $name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\">".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];?>
   
	<article class="panel">
	<div class="widget widget-tie fy_weibo">	
	    <ul>
		     <div id="weiboShow">
	        <div class="grid-weibo-show shadow-hover">
		        <header>&nbsp;</header>
		        <div class="contentt">
			        <div class="avatar">
	                <?php if (!empty($user_cache[1]['photo']['src'])): ?>
	                    <img src="<?php echo BLOG_URL.$user_cache[1]['photo']['src']; ?>">
	                <?php endif;?> 
				        <span class="rank"></span>
			        </div>
			        <h4><?php echo $name; ?></h4>
			        <p class="seta"><?php echo $user_cache[1]['des']; ?></p><br>
			        <center><a href="https://jq.qq.com/?_wv=1027&k=5F4TD3M" target="_blank">小俊博客交流群&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://wpa.qq.com/msgrd?v=3&uin=2647386761&site=qq&menu=yes" target="_blank">小俊阁下&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="https://weibo.com/u/6035706199" target="_blank">官方微博</center></a><br>
			        </a>				
		             </div>
		        <footer>
					<ul>
						<li><strong><?php echo count_log_all();?></strong><span>文章</span></li>
						<li><strong><?php echo count_com_all();?></strong><span>热评</span></li>
					    <li><strong><?php echo count_tw_all();?></strong><span>微语</span></li>
					</ul>
		        </footer>
	        </div>
        </div>	    </ul>
	

    </div>
	</article>
   
<?php }?>
<?php
//widget：日历
function widget_calendar($title){ ?>
	<div class="widget widget_calendar">
	<div id="calendar_wrap" class="calendar_wrap">
	<span class="icon"><i class="fa fa-calendar fa-fw"></i></span>
	<h3><?php echo $title; ?></h3>
    <div id="calendar" class="f_calendar">
    </div>
	<script>sendinfo('<?php echo Calendar::url(); ?>','calendar');</script>
	</div></div>
<?php }?>
<?php
//widget：标签
function widget_tag($title){
	global $CACHE;
	$tag_cache = $CACHE->readCache('tags');?>
	<div class="widget widget_ui_tags"><span class="icon"><i class="fa fa-tags"></i></span><h3><?php echo $title; ?>云</h3><div class="items">
	<?php foreach($tag_cache as $value): ?>
	<a href="<?php echo Url::tag($value['tagurl']); ?>"><?php echo $value['tagname']; ?> (<?php echo $value['usenum']; ?>)</a>
	<?php endforeach; ?>
	</div>
	</div>
<?php }?>
<?php
//page-tags：标签云
function page_tags(){
	global $CACHE;
	$tag_cache = $CACHE->readCache('tags');?>
	<?php foreach($tag_cache as $value): ?>
	<a href="<?php echo Url::tag($value['tagurl']); ?>" target="_blank"><?php echo $value['tagname']; ?><em>(<?php echo $value['usenum']; ?>)</em></a>
	<?php endforeach; ?>
<?php }?>
<?php
//widget：分类
function widget_sort($title){
	global $CACHE;
	global $arr_sortico1; 
	$sort_cache = $CACHE->readCache('sort'); 
	?>
	<div class="widget widget_ui_sort"><h3 class="widget-title"><i class="fa fa-sort"></i><?php echo $title; ?></h3><div class="items"> <ul id="blogsort"> 

	<?php
	foreach($sort_cache as $value):
		$sid=$value["sid"];
		if ($value['pid'] != 0) continue;
	?>
		<li> <a title="<?php echo $value['lognum'] ?> 篇文章" href="<?php echo Url::sort($value['sid']); ?>"><i class="<?php if(empty($arr_sortico1[$sid])){echo "fa fa-code";}else{echo $arr_sortico1[$sid];}?>"></i> <?php echo $value['sortname']; ?></a> </li> 
	<?php endforeach; ?>
	</ul> </div> </div>
<?php }?>
<?php
//首页微语调用
function index_t($num){
	$t = MySql::getInstance();
	?>
	<?php
	$sql = "SELECT id,content,img,author,date,replynum FROM ".DB_PREFIX."twitter ORDER BY `date` DESC LIMIT $num";
	$list = $t->query($sql);
	while($row = $t->fetch_array($list)){
	?>
	<li>
	<a rel="nofollow" class="typItem" href="javascript:"><?php echo $row['content'];?> </a></li>
	<?php }?>
<?php } ?>
<?php
//widget：最新微语 
function widget_twitter($title){
	global $CACHE; 
	$newtws_cache = $CACHE->readCache('newtw');
	$istwitter = Option::get('istwitter');
	?>
	<div class="widget widget_ui_textads widget_twitter"><a class="style01"><strong>最新微语</strong>
	<?php //foreach($newtws_cache as $value): ?>
	<br><br><font size="2" color="#999">	
	<?php echo comment2emoji($newtws_cache[0]['t']); ?>
	</font><br><br>
	<font color="#999"><?php echo smartDate($newtws_cache[0]['date']); ?></font>
	<?php //endforeach; ?>
	</a>
	</div>
<?php }?>

<?php
function commtent_title($gid){
 $db = MySql::getInstance();
 $sql = "SELECT title FROM ".DB_PREFIX."blog WHERE hide='n' and gid in ($gid) ORDER BY `date` DESC LIMIT 0,1";
 $list = $db->query($sql);while($row = $db->fetch_array($list)){return $row['title'];}}?>
<?php
//widget：最新评论
function widget_newcomm($title){
	global $CACHE; 
	$com_cache = $CACHE->readCache('comment');
	//取前6个评论
	$com_cache_slice = array_slice($com_cache, 0,6);
	//if (!blog_tool_ishome()) return;#只在首页显示友链去掉双斜杠注释即可
	?>
<div class="widget widget_ui_comments"> <span class="icon"><i class="fa fa-pencil-square-o"></i></span><h3> 最新评论</h3> <ul> 
	<?php
	foreach($com_cache_slice as $value):
	$url = Url::comment($value['gid'], $value['page'], $value['cid']);
	$imgaa=getqqxx($value['mail'],'');
	$title = commtent_title($value['gid']);
			?>
	<li><a href="<?php echo $url; ?>" title="<?php echo $title." 上的评论"; ?>"><img class="avatar avatar-50 photo avatar-default" height="50" width="50" src="<?php echo $imgaa; ?>" style="display: block;" /> <strong><?php echo $value['name']; ?></strong> <?php echo sydate($value['date'],true);?> 说<br /><?php echo comment2emoji($value['content']); ?></a></li>
	<?php endforeach; ?>
</ul> </div>
<?php }?>
<?php
//widget：最新文章
function widget_newlog($title){
$index_newlognum = Option::get('index_newlognum');?>
	<div class="widget widget_ui_posts"><span class="icon"><i class="fa fa-pencil-square-o"></i></span><h3><?php echo $title; ?></h3><ul>
<?php 
$db = MySql::getInstance();
$sql = $db->query ("SELECT * FROM ".DB_PREFIX."blog inner join ".DB_PREFIX."sort WHERE hide='n' AND type='blog' AND top='n' AND sortid=sid order by date DESC limit 0,$index_newlognum"); 

while($row = $db->fetch_array($sql)){
	if($module_thum==0){
		$imgsrc = GetThumFromContent($row['content']);
	}else{
		$imgsrc = get_thum($row['gid']);
	}
?>
	<li><a href="<?php echo Url::log($row['gid']);?>"><span class="thumbnail"><img class="thumb" src="<?php echo $imgsrc;?>" style="display: block;"></span><span class="text"><?php echo $row['title'];?></span><i class="fa fa-clock-o fa-fw"></i><span class="muted"><?php echo gmdate('Y-m-d', $row['date']);?></span></a></li>
	<?php }?>
</ul></div>
<?php }?>
<?php
//widget：热门文章
function widget_hotlog($title){
	$db = MySql::getInstance();
	$hot_num = Option::get('index_hotlognum');
	?>
	<div class="widget widget_ui_posts "><span class="icon"><i class="fa fa-fire"></i></span><h3><?php echo $title; ?></h3><ul>
		<?php
	$sql = "SELECT gid,title,date,content FROM ".DB_PREFIX."blog inner join ".DB_PREFIX."sort WHERE hide='n' AND type='blog' AND date > $time - 30*24*60*60 AND top='n' AND sortid=sid order by `views` DESC limit $hot_num";
	$list = $db->query($sql);
	while($row = $db->fetch_array($list)){
		if($module_thum==0){
			$imgsrc = GetThumFromContent($row['content']);
		}else{
			$imgsrc = get_thum($row['gid']);
		}
	?> 	
	<li><a href="<?php echo Url::log($row['gid']);?>"><span class="thumbnail"><img class="thumb" src="<?php echo $imgsrc;?>" style="display: block;"></span><span class="text"><?php echo $row['title'];?></span><i class="fa fa-clock-o fa-fw"></i><span class="muted"><?php echo gmdate('Y-m-d', $row['date']);?></span></a></li>
	<?php }?>
</ul></div>
<?php }?>
<?php
//widget：随机文章
function widget_random_log($title){
	$db = MySql::getInstance();
	$sj_num = Option::get('index_randlognum');
	?>
	<div class="widget widget_ui_posts widget_fix"><span class="icon"><i class="fa fa-pencil-square-o"></i></span><h3>猜你喜欢</h3><ul>
<?php
	$sql = "SELECT gid,title,date,views,content FROM ".DB_PREFIX."blog ORDER BY RAND() LIMIT $sj_num";
	$list = $db->query($sql);
	while($row = $db->fetch_array($list)){
		if($module_thum=="0"){
			$imgsrc = GetThumFromContent($row['content']);
		}else{
			$imgsrc = get_thum($row['gid']);
		}
	?> 	
	<li><a href="<?php echo Url::log($row['gid']);?>"><span class="thumbnail"><img  class="thumb" src="<?php echo $imgsrc;?>" style="display: block;"></span><span class="text"><?php echo $row['title'];?></span><i class="fa fa-clock-o fa-fw"></i><span class="muted"><?php echo gmdate('Y-m-d', $row['date']);?></span></a></li>
	<?php }?>
</ul></div>
<?php }?>
<?php
//widget：搜索
function widget_search($title){ ?>
<?php } ?>
<?php
//widget：归档
function widget_archive($title){
	global $CACHE; 
	$record_cache = $CACHE->readCache('record');
	?>
	<div class="widget widget_ui_tags"><span class="icon"><i class="fa fa-pencil"></i></span><h3><?php echo $title; ?>云</h3><div class="items">
	<?php foreach($record_cache as $value): ?>
	<a href="<?php echo Url::record($value['date']); ?>"><?php echo $value['record']; ?> (<?php echo $value['lognum']; ?>)</a>
	<?php endforeach; ?>
	</div>
	</div>
<?php } ?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content){ ?>
<div class="widget widget_ui_textads"><a class="style01" href="#"><strong><?php echo $title; ?></strong><h2></h2><p><?php echo $content; ?></p></a></div>
<?php } ?>
<?php
//widget：链接
function widget_link($title){
	global $CACHE; 
	$link_cache = $CACHE->readCache('link');
    //if (!blog_tool_ishome()) return;#只在首页显示友链去掉双斜杠注释即可
	?>
	<div class="widget widget_links"><span class="icon"><i class="fa fa-link"></i></span><a href="http://liuniange.cn/post/25"><h3>友情链接</h3></a>
	<?php foreach($link_cache as $value): ?>
	<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><i class="fa fa-link fa-fw"></i><?php echo $value['link']; ?></a></li>  
	<?php endforeach; ?></ul>
 </div>
<?php }?>
<?php
//blog：导航
function blog_navi(){
	global $CACHE; 
	global $arr_navico1;
	$navi_cache = $CACHE->readCache('navi');
	foreach($navi_cache as $num=>$value):
		$id=$value["id"];
        if ($value['pid'] != 0) {
            continue;
        }
		if($value['url'] == ROLE_ADMIN && (ROLE == ROLE_ADMIN || ROLE == ROLE_WRITER)):
			?>
			<?php if(ROLE == ROLE_ADMIN):?>
			<li class="item common"><a href="<?php echo BLOG_URL; ?>admin/">管理站点</a></li>
			<li class="item common"><a href="<?php echo BLOG_URL; ?>?setting">站点配置</a></li>
			<?php endif;?>
			<li class="item common"><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
			<?php 
			continue;
		endif;
		$newtab = $value['newtab'] == 'y' ? 'target="_blank"' : '';
        $value['url'] = $value['isdefault'] == 'y' ? BLOG_URL . $value['url'] : trim($value['url'], '/');
        $current_tab = BLOG_URL . trim(Dispatcher::setPath(), '/') == $value['url'] ? 'current' : 'common';
		?>
		<li class="item <?php echo $current_tab;?>">
		
					<a href="<?php echo $value['url']; ?>" <?php echo $newtab;?>> <?php
					//print_r($arr_navico);
					//die();
					if(empty($arr_navico1[$id])) {echo $value['naviname'];}else {echo "<i class='".$arr_navico1[$id]."'></i> ".$value['naviname']."";} ?></a>
			<?php if (!empty($value['children'])) :?>
            <ul class="sub-menu">
                <?php foreach ($value['children'] as $row){
                        echo '<li><a href="'.Url::sort($row['sid']).'">'.$row['sortname'].'</a></li>';
                }?>
			</ul>
            <?php endif;?>
            <?php if (!empty($value['childnavi'])) :?>
            <ul class="sub-menu">
                <?php foreach ($value['childnavi'] as $row){
                        $newtab = $row['newtab'] == 'y' ? 'target="_blank"' : '';
                        echo '<li><a href="' . $row['url'] . "\" $newtab >" . $row['naviname'].'</a></li>';
                }?>
			</ul>
            <?php endif;?>
		</li>
	<?php endforeach; ?>
<?php }?>
<?php
//blog：置顶
function topflg($top, $sortop='n', $sortid=null){
    if(blog_tool_ishome()) {
       echo $top == 'y' ? "<img src=\"".TEMPLATE_URL."/images/top.png\" title=\"首页置顶文章\" /> " : '';
    } elseif($sortid){
       echo $sortop == 'y' ? "<img src=\"".TEMPLATE_URL."/images/sortop.png\" title=\"分类置顶文章\" /> " : '';
    }
}
?>
<?php
//blog：编辑
function editflg($logid,$author){
	$editflg = ROLE == ROLE_ADMIN || $author == UID ? '<a href="'.BLOG_URL.'admin/write_log.php?action=edit&gid='.$logid.'" target="_blank">编辑</a>' : '';
	echo $editflg;
}
?>
<?php
//blog：分类
function blog_sort($blogid){
	global $CACHE; 
	$log_cache_sort = $CACHE->readCache('logsort');
	?>
	<?php if(!empty($log_cache_sort[$blogid])): ?>
    <a class="cat" href="<?php echo Url::sort($log_cache_sort[$blogid]['id']); ?>"><?php echo $log_cache_sort[$blogid]['name']; ?></a>
	<?php endif;?>
<?php }?>
<?php
//blog：面包屑导航
function mianbao_sort($blogid,$log_title){
	global $CACHE; 
	$log_cache_sort = $CACHE->readCache('logsort');
	?>
	<div class="article_position">
	<ul class="breadcrumb" style="background-color:#FFFFFF">
	<li>
		<a href="<?php echo BLOG_URL; ?>" title="<?php echo $blogname; ?>">主页</a> <span class="divider"></span>
	</li>			
	<?php if(!empty($log_cache_sort[$blogid])): ?>
	<li><a href="<?php echo Url::sort($log_cache_sort[$blogid]['id']); ?>"><?php echo $log_cache_sort[$blogid]['name']; ?></a> <span class="divider"></span></li>
	<?php else:?>
	<li>
		未分类<span class="divider"></span>
	</li>
	<?php endif;?>
	<li class="active"><?php echo $log_title; ?></li></ul></div>
<?php }?>
<?php
//blog：文章标签
function blog_tag($blogid){
	global $CACHE;
	$log_cache_tags = $CACHE->readCache('logtags');
	if (!empty($log_cache_tags[$blogid])){
		$tag = '';
		foreach ($log_cache_tags[$blogid] as $value){
			$tag .= "	<a href=\"".Url::tag($value['tagurl'])."\">".$value['tagname'].'</a>';
		}
		echo $tag;
	}
}
?>
<?php
//blog：文章作者
function blog_author($uid){
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	$author = $user_cache[$uid]['name'];
	$mail = $user_cache[$uid]['mail'];
	$des = $user_cache[$uid]['des'];
	$title = !empty($mail) || !empty($des) ? "title=\"$des $mail\"" : '';
	echo '<a href="'.Url::author($uid)."\" $title>$author</a>";
}
?>
<?php
//blog：相邻文章
function neighbor_log($neighborLog){
	extract($neighborLog);?>
	<?php if($prevLog):?>
	<span class="article-nav-prev">上一篇<br><a href="<?php echo Url::log($prevLog['gid']) ?>"><?php echo $prevLog['title'];?></a></span>
	<?php endif;?>
	<?php if($nextLog && $prevLog):?>
	<?php endif;?>
	<?php if($nextLog):?>
		 <span class="article-nav-next">下一篇<br><a href="<?php echo Url::log($nextLog['gid']) ?>"><?php echo $nextLog['title'];?></a></span>
	<?php endif;?>
<?php }?>
<?php
//blog：评论列表
function blog_comments($comments,$comnum){
    extract($comments);
    if($commentStacks): ?>
	<?php endif; ?>
	<?php
	$isGravatar 	   = Option::get('isgravatar');
	global $CACHE;$user_cache = $CACHE->readCache('user');
	foreach($commentStacks as $cid):
	$ls_role='';
    $comment 		   = $comments[$cid];
	$isNofollow   	   = $comment['url'] && $comment['url'] != BLOG_URL ? 'rel="nofollow"':'';
	foreach($user_cache as $k=>$a){
		$role = $a["role"];
		$name = $a["name"];
		$mail = $a["mail"];
		if($comment['poster']==$name&&$comment['mail']==$mail){
			if($role=="admin"){
				//class="comment-poster c_admin" title="帅比博主"
				$ls_role='class="comment-poster c_admin" title="帅比博主"';
				$imgavatar = empty($user_cache[$k]['avatar']) ? 
                BLOG_URL . 'admin/views/images/avatar.jpg' : 
                BLOG_URL . $user_cache[$k]['avatar'];
			}
			if($role=="writer"){
				$ls_role='class="comment-poster c_user" title="本站会员"';
				$imgavatar = empty($user_cache[$k]['avatar']) ? 
                BLOG_URL . 'admin/views/images/avatar.jpg' : 
                BLOG_URL . $user_cache[$k]['avatar'];
			}
			break;
		}
	}
	if(empty($ls_role)){
		$imgavatar='';
		$ls_role='class="c_visiter" title="打酱油"';
	}
	
				
	$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank" '.$isNofollow.'>'.$comment['poster'].'</a>' : $comment['poster'];
	?>
	<h5><?php echo convertip($comment['ip']); ?>&nbsp;&nbsp;&nbsp;
	<?php echo useragent($comment['useragent']); ?>
	<div class="comment dpt_line" id="comment-<?php echo $comment['cid']; ?>">
		<a name="<?php echo $comment['cid']; ?>"></a>
		<?php
			
				echo '<div class="avatar"><img src="'.getqqxx($comment['mail'],$imgavatar).'" /></div>';
			
		?>   
		<div class="comment-info">
			<div class="comment-content" ><?php echo comment2emoji($comment['content']); ?></div>	
			<div class="comment-meata">
			<span <?php echo $ls_role;?>><?php echo $comment['poster']; ?> <?php $mail_str="\"".strip_tags($comment['mail'])."\"";echo_levels($mail_str,"\"".$comment['url']."\""); ?> </span> <span class="comment-time"><?php if(strtotime($comment['date'])) { echo sydate($comment['date']);}else {echo str_replace(' ','',$comment['date']);} ?></span> <a href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)" class="comment-reply-btn">回复</a></div><br>
		</div>
		<?php blog_comments_children($comments, $comment['children']); ?>
	</div>
	<?php endforeach; ?>
    <div class="page comment-page">
	    <?php echo $commentPageUrl;?>
    </div>
<?php }?>
<?php
//blog：子评论列表
function blog_comments_children($comments, $children){
	$isGravatar = Option::get('isgravatar');
	global $CACHE;$user_cache = $CACHE->readCache('user');
	foreach($children as $child):
	$comment 		   = $comments[$child];
	$isNofollow   	   = $comment['url'] && $comment['url'] != BLOG_URL ? 'rel="nofollow"':'';
	$ls_role='';
	foreach($user_cache as $k=>$a){
		$role = $a["role"];
		$name = $a["name"];
		$mail = $a["mail"];
		if($comment['poster']==$name&&$comment['mail']==$mail){
			if($role=="admin"){
				//class="comment-poster c_admin" title="帅比博主"
				$ls_role='class="comment-poster c_admin" title="帅比博主"';
				$imgavatar = empty($user_cache[$k]['avatar']) ? 
                BLOG_URL . 'admin/views/images/avatar.jpg' : 
                BLOG_URL . $user_cache[$k]['avatar'];
			}
			if($role=="writer"){
				$ls_role='class="comment-poster c_user" title="本站会员"';
				$imgavatar = empty($user_cache[$k]['avatar']) ? 
                BLOG_URL . 'admin/views/images/avatar.jpg' : 
                BLOG_URL . $user_cache[$k]['avatar'];
			}
			break;
		}
	}
	if(empty($ls_role)){
		$imgavatar='';
		$ls_role='class="c_visiter" title="打酱油"';
	}
	$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank" '.$isNofollow.'>'.$comment['poster'].'</a>' : $comment['poster'];
	?>
	<h5><?php echo convertip($comment['ip']); ?>&nbsp;&nbsp;&nbsp;
	<?php echo useragent($comment['useragent']); ?>
	<div class="comment comment-children" id="comment-<?php echo $comment['cid']; ?>">
		<a name="<?php echo $comment['cid']; ?>"></a>
		<?php
			
				echo '<div class="avatar"><img src="'.getqqxx($comment['mail'],$imgavatar).'" /></div>';
			
		?> 
		<div class="comment-info">
			<div class="comment-content" ><?php echo comment2emoji($comment['content']); ?></div>
			<div class="comment-meata">
				<span <?php echo $ls_role;?>><?php echo $comment['poster']; ?> <?php $mail_str="\"".strip_tags($comment['mail'])."\"";echo_levels($mail_str,"\"".$comment['url']."\""); ?> </span> 
				<span class="comment-time"><?php if(strtotime($comment['date'])) { echo sydate($comment['date']);}else {echo str_replace(' ','',$comment['date']);} ?></span>
				<?php if($comment['level']<3){ echo '<a href="#comment-'.$comment['cid'].'" onclick="commentReply('.$comment['cid'].',this)" class="comment-reply-btn">回复</a>';}?>
			</div>
		</div>
		
	</div>
	<?php blog_comments_children($comments, $comment['children']);?>
	<?php endforeach; ?>
<?php }?>
<?php
//blog：发表评论表单
function blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark){
	if($allow_remark == 'y'): ?>
	<div class="comment_post_wrap comment_post comment-open" id="comment-post">
		<h3 class="comment-header"><span class="cancel-reply" id="cancel-reply" style="display:none;"><a href="javascript:void(0);" onclick="cancelReply()">取消回复</a></span>发表评论<a name="respond"></a></h3>
		<form method="post" name="commentform" id="commentform" action="<?php echo BLOG_URL; ?>index.php?action=addcom">
			<input type="hidden" name="gid" id="comment-gid" value="<?php echo $logid; ?>" />
			<input type="hidden" name="pid" id="comment-pid" value="0"/>
			
			<div class="comment_user_info" style="
    margin-top: 15px;
"><div id="loging"></div>
			<?php if(ROLE == ROLE_VISITOR): ?>
			<div class="form-group">
					<div class="comment-form-author form-group has-feedback"> <div class="input-group"> <div class="input-group-addon"><i class="fa fa-qq"></i></div> <input class="form-control" placeholder="输入QQ号码可以快速获取资料" id="qqnum" name="qqnum" type="text" size="30" value="" onblur="huoquqq()"> </div> </div> 
				</div>
				<div class="form-group">
					<div class="comment-form-author form-group has-feedback"> <div class="input-group"> <div class="input-group-addon"><i class="fa fa-user"></i></div> <input class="form-control" placeholder="昵称" id="comname" name="comname" type="text" size="30" required="required" value="<?php echo $ckname; ?>"> <span class="form-control-feedback required" style="color:#F00">*</span> </div> </div> 
				</div>
				<div class="form-group">
					<div class="comment-form-email form-group has-feedback"> <div class="input-group"> <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div> <input class="form-control" placeholder="邮箱" id="commail" name="commail" type="text" size="30" required="required" value="<?php echo $ckmail; ?>"> <span class="form-control-feedback required" style="color:#F00">*</span> </div> </div>
				</div>
				
			<?php endif; ?>
			<div class="form-group">
					<div class="comment-form-email form-group has-feedback"> <div class="input-group"> <div class="input-group-addon"><i class="fa fa-link"></i></div> <input class="form-control" placeholder="网址（选填）" id="comurl" name="comurl" type="text" size="30"  value="<?php echo $ckurl; ?>"> </div> </div>
				</div>

			</div>
			
			<div class="form-group form_textarea">
				<div class="comment_textare"><textarea name="comment" id="comment" class="OwO-textarea" placeholder="让我们一起文明的谈天说地-小俊博客" title="让我们一起谈天说地-流年博客"></textarea>
				<div title="OwO" class="OwO"></div>
                <script>
				var OwO_demo = new OwO({
	            logo: 'OωO表情',
	            container: document.getElementsByClassName('OwO')[0],
	            target: document.getElementsByClassName('OwO-textarea')[0],
	            api: './content/templates/XJDOV/content/templates/XJDOV/OwO/OwO.min.json',
	            position: 'down',
	            width: '100%',
	            maxHeight: '250px'});
			    </script>
				</div>
				<div class="form-group submit_container">
					<div class="comment_tools">
						<?php 
							if(ROLE==ROLE_VISITOR) {
								echo '<span class="comment_avator"><img id="toux" src="'.TEMPLATE_URL.'images/noAvator.jpg" title="打酱油"><em class="commentUser_type none_user" title="打酱油">打酱油</em></span>';
							}else{
								global $userData;
								$imgavatar = empty($user_cache[$k]['avatar']) ? 
								BLOG_URL . 'admin/views/images/avatar.jpg' : 
								BLOG_URL . $user_cache[$k]['avatar'];
								echo '<span class="comment_avator"><img id="toux" src="'.getqqxx($userData["mail"],$imgavatar).'" title="'.$userData["nickname"].'"><em>'.$userData["nickname"].'</em></span>';
							}
						?>
						
						<span class="comment_face_btn"><img src="/hj.png"></i>&nbsp;表情</span></a>
						<div class="comment_submit_wrap">
							<?php if(!empty($verifyCode)) {echo '<span class="comment_verfiy_container"><img src="'.BLOG_URL.'include/lib/checkcode.php" class="c_code" alt="看不清楚？点图切换" title="看不清楚？点图切换"><input type="text" name="imgcode" class="comment_verfiy_code" placeholder="输入验证码" autocomplete="off" title="看不清楚？点图切换"></span>';}; ?>
							<button type="submit" name="submit" id="comment_submit" class="sub_btn"><i class="fa fa-check-circle-o"></i>提交评论</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div id="Face" class="faceContainer"><p><?php GetFaceImg();?></p></div>
	</div>
	<?php endif; ?>

<?php

//comment：输出等级
function echo_levels($comment_author_email,$comment_author_url){
  $DB = MySql::getInstance();
  $adminEmail = '"2647386761@qq.com"';
  if($comment_author_email==$adminEmail)
  {
    echo '<a class="vp" href="2647386761@qq.com" title="帅比博主"></a><a class="vip7" title="特别认证"></a>';
  }
  
  $sql = "SELECT cid as author_count FROM emlog_comment WHERE mail = ".$comment_author_email;
  $res = $DB->query($sql);
  $author_count = mysql_num_rows($res);
  if($author_count>=1 && $author_count<10 && $comment_author_email!=$adminEmail)
    echo '<a class="vip1" title="评论之星 LV.1"></a>';
  else if($author_count>=10 && $author_count<20 && $comment_author_email!=$adminEmail)
    echo '<a class="vip2" title="评论之星 LV.2"></a>';
  else if($author_count>=20 && $author_count<40 && $comment_author_email!=$adminEmail)
    echo '<a class="vip3" title="评论之星 LV.3"></a>';
  else if($author_count>=40 && $author_count<80 && $comment_author_email!=$adminEmail)
    echo '<a class="vip4" title="评论之星 LV.4"></a>';
  else if($author_count>=80 &&$author_count<160 && $comment_author_email!=$adminEmail)
    echo '<a class="vip5" title="评论之星 LV.5"></a>';
  else if($author_count>=160 && $author_coun<320 && $comment_author_email!=$adminEmail)
    echo '<a class="vip6" title="评论之星 LV.6"></a>';
  else if($author_count>=320 && $comment_author_email!=$adminEmail)
    echo '<a class="vip7" title="评论之星 LV.7"></a>';
}
?>
<?php }?>

<?php
//blog-tool:判断是否是首页
function blog_tool_ishome(){
    if (BLOG_URL . trim(Dispatcher::setPath(), '/') == BLOG_URL){
        return true;
    } else {
        return FALSE;
    }
}
?>
<?php
//blog-tool:获取Gravatar头像
function myGravatar($email,$role='' ,$s = 50, $d = 'wavatar', $g = 'g') {
	if(!empty($role)){
		return $role;
	}
$hash = md5($email);
$avatar = "http://secure.gravatar.com/avatar/$hash?s=$s&d=$d&r=$g";
return $avatar;
}?>
<?php //分页函数
function sheli_fy($count,$perlogs,$page,$url,$anchor=''){
$pnums = @ceil($count / $perlogs);
$page = @min($pnums,$page);
$prepg=$page-1;                 //shuyong.net上一页
$nextpg=($page==$pnums ? 0 : $page+1); //shuyong.net下一页
$urlHome = preg_replace("|[\?&/][^\./\?&=]*page[=/\-]|","",$url);
//开始分页导航内容
$re = "";
if($pnums<=1) return false;	//如果只有一页则跳出	
if($page!=1) $re .=" <a href=\"$urlHome$anchor\">首页</a> "; 
if($prepg) $re .=" <a href=\"$url$prepg$anchor\" >‹‹</a> ";
for ($i = $page-2;$i <= $page+2 && $i <= $pnums; $i++){
if ($i > 0){if ($i == $page){$re .= " <span class='page now-page'>$i</span> ";
}elseif($i == 1){$re .= " <a href=\"$urlHome$anchor\">$i</a> ";
}else{$re .= " <a href=\"$url$i$anchor\">$i</a> ";}
}}
if($nextpg) $re .=" <a href=\"$url$nextpg$anchor\" class='nextpages'>››</a> "; 
if($page!=$pnums) $re.=" <a href=\"$url$pnums$anchor\" title=\"尾页\">尾页</a>";
return $re;}
?>
<?php
function getrandomim(){
	$imgsrc = TEMPLATE_URL."images/random/".rand(1,3).".jpg";
	return $imgsrc;
}
?>
<?php
//获取图片
function get_thum($logid){
 $db = MySql::getInstance();

	$sqlimg = "SELECT * FROM ".DB_PREFIX."attachment WHERE blogid=".$logid." AND (`filepath` LIKE '%jpg' OR `filepath` LIKE '%gif' OR `filepath` LIKE '%png') ORDER BY `aid` ASC LIMIT 0,1";
//    die($sql);
	$img = $db->query($sqlimg);
    while($roww = $db->fetch_array($img)){
	 $thum_url=BLOG_URL.substr($roww['filepath'],3,strlen($roww['filepath']));
    }
    if (empty($thum_url)) {
            $thum_url = getrandomim();
        }
  
return $thum_url;
}
?>
<?php
function GetThumFromContent($content){
	/*图片和摘要*/
	preg_match_all("|<img[^>]+src=\"([^>\"]+)\"?[^>]*>|is", $content, $img);
	if($imgsrc = !empty($img[1])){
		 $imgsrc = $img[1][0];}else{ 
			preg_match_all("|<img[^>]+src=\"([^>\"]+)\"?[^>]*>|is", $content ,$img);
			if($imgsrc = !empty($img[1])){ $imgsrc = $img[1][0];  }else{
				$imgsrc =getrandomim();	
			}
	}
	return $imgsrc;
}
?>
<?php
//格式化内容工具
function tool_purecontent($content, $strlen = null){
        $content = str_replace('继续阅读&gt;&gt;', '', $content);
		$content = preg_replace("/\[hide\](.*)\[\/hide\]/Uims", '|*********此处内容回复可见*********|', strip_tags($content));
        if ($strlen) {
            $content = subString($content, 0, $strlen);
        }
        return $content;
}
?>
<?php
function sydate($ptime,$isunix=false){
	if(!$isunix){
		$ptime = strtotime($ptime);
	}
	$etime = time() - $ptime;
	if($etime < 1){return '刚刚';}
	$interval = array(
		12 * 30 * 24 * 60 * 60 => '年前 ('.date('Y-m-d', $ptime).')',
		30 * 24 * 60 * 60      => '个月前 ('.date('Y-m-d', $ptime).')',
		7 * 24 * 60 * 60       => '周前 ('.date('Y-m-d', $ptime).')',
		24 * 60 * 60           => '天前',
		60 * 60                => '小时前',
		60                     => '分钟前',
		1                      => '秒前',
	);
foreach ($interval as $secs => $str) {
		$d = $etime / $secs;
		if ($d >= 1){
			$r = round($d);
			return $r . $str ;
		}
	}
}
?>
<?php
//widget：pages_links
function pages_links(){
	global $CACHE; 
	$link_cache = $CACHE->readCache('link');
    //if (!blog_tool_ishome()) return;#只在首页显示友链去掉双斜杠注释即可
    foreach($link_cache as $value): ?>
	<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank" rel="nofollow"><?php echo $value['link']; ?></a></li>
	<?php endforeach;}?>
<?php
/**
 * @des 显示评论列表与否的判定方法
 * @param $comnum 评论内容体
 * @return string 
 */
function isShowComment($comnum) {
	return !!$comnum;
} 
?>
<?php
function GetFaceImg(){
	$Face = array(array('url' => 'images/face/1.png',
						'title' =>  "微笑") ,
				  array('url' => 'images/face/5.png',
						'title' => "得意" ) ,
				  array('url' => 'images/face/6.png',
						'title' =>"愤怒") ,
				  array('url' => 'images/face/7.png',
						'title' => "调戏" ) ,
				  array('url' => 'images/face/9.png',
						'title' => "大哭" ) ,
				  array('url' => 'images/face/10.png',
						'title' =>"汗"  ) ,
				  array('url' => 'images/face/11.png',
						'title' => "鄙视" ) ,
				  array('url' => 'images/face/13.png',
						'title' =>  "真棒") ,
				  array('url' => 'images/face/14.png',
						'title' => "金钱" ) ,
				  array('url' => 'images/face/16.png',
						'title' => "瞧不起" ) ,
				  array('url' => 'images/face/19.png',
						'title' =>  "委屈") ,
				  array('url' => 'images/face/21.png',
						'title' =>"惊讶") ,
				  array('url' => 'images/face/24.png',
						'title' =>"可爱") ,
				  array('url' => 'images/face/25.png',
						'title' => "滑稽" ) ,
				  array('url' => 'images/face/26.png',
						'title' => "调皮") ,
				  array('url' => 'images/face/27.png',
						'title' => "大汉") ,
				  array('url' => 'images/face/28.png',
						'title' =>"可怜") ,
				  array('url' => 'images/face/29.png',
						'title' => "睡觉" ) ,
				  array('url' => 'images/face/30.png',
						'title' => "流泪" ) ,
				  array('url' => 'images/face/31.png',
						'title' => "气出泪" ) ,
				  array('url' => 'images/face/33.png',
						'title' =>"喷") ,
				  array('url' => 'images/face/39.png',
						'title' => "月亮")  ,
				  array('url' => 'images/face/40.png',
						'title' => "太阳")  ,
		 		  array('url' => 'images/face/43.png',
						'title' => "咖啡")  ,
				  array('url' => 'images/face/44.png',
						'title' => "蛋糕")  ,
				  array('url' => 'images/face/45.png',
						'title' => "音乐")  ,
				  array('url' => 'images/face/47.png',
						'title' => "yes")  ,
				  array('url' => 'images/face/48.png',
						'title' => "大拇指")  ,
				  array('url' => 'images/face/49.png',
						'title' => "鄙视你"),
				  array('url' => 'images/face/50.png',
						'title' => "程序猿"),
				  array('url' => 'images/face/51.png',
						'title' => "爱你"),
				  array('url' => 'images/face/52.png',
						'title' => "ok"),
				  array('url' => 'images/face/53.png',
						'title' => "what"),
				  array('url' => 'images/face/54.png',
						'title' => "啊"),
				  array('url' => 'images/face/55.png',
						'title' => "爱心"),
				  array('url' => 'images/face/56.png',
						'title' => "鄙视"),	
				  array('url' => 'images/face/57.png',
						'title' => "大便"),
				  array('url' => 'images/face/58.png',
						'title' => "不开心"),
				  array('url' => 'images/face/59.png',
						'title' => "彩虹"),
				  array('url' => 'images/face/60.png',
						'title' => "咖啡"),							
				  array('url' => 'images/face/61.png',
						'title' => "吃瓜观众"),							
				  array('url' => 'images/face/62.png',
						'title' => "吃翔"),							
				  array('url' => 'images/face/63.png',
						'title' => "赞"),							
				  array('url' => 'images/face/64.png',
						'title' => "蛋糕"),							
				  array('url' => 'images/face/65.png',
						'title' => "得瑟"),							
				  array('url' => 'images/face/66.png',
						'title' => "灯泡"),													
				  array('url' => 'images/face/67.png',
						'title' => "可怜"),							
				  array('url' => 'images/face/68.png',
						'title' => "开心"),							
				  array('url' => 'images/face/69.png',
						'title' => "汗"),							
				  array('url' => 'images/face/70.png',
						'title' => "呵呵"),													
				  array('url' => 'images/face/71.png',
						'title' => "呃"),
				  array('url' => 'images/face/72.png',
						'title' => "红领巾"),
				  array('url' => 'images/face/73.png',
						'title' => "呼"),
				  array('url' => 'images/face/74.png',
						'title' => "花心"),
				  array('url' => 'images/face/75.png',
						'title' => "滑小稽"),
				  array('url' => 'images/face/76.png',
						'title' => "惊恐"),
				  array('url' => 'images/face/77.png',
						'title' => "惊哭"),
				  array('url' => 'images/face/78.png',
						'title' => "惊讶"),
				  array('url' => 'images/face/79.png',
						'title' => "自信"),
				  array('url' => 'images/face/80.png',
						'title' => "酷"),	
				  array('url' => 'images/face/81.png',
						'title' => "狂汗"),
				  array('url' => 'images/face/82.png',
						'title' => "蜡烛"),
				  array('url' => 'images/face/83.png',
						'title' => "懒得理"),
				  array('url' => 'images/face/84.png',
						'title' => "大哭"),
				  array('url' => 'images/face/85.png',
						'title' => "坏笑"),
				  array('url' => 'images/face/86.png',
						'title' => "礼物"),
				  array('url' => 'images/face/87.png',
						'title' => "玫瑰"),
				  array('url' => 'images/face/88.png',
						'title' => "勉强"),
				  array('url' => 'images/face/89.png',
						'title' => "你懂得"),
				  array('url' => 'images/face/90.png',
						'title' => "生气"),
				  array('url' => 'images/face/91.png',
						'title' => "喷"),	
				  array('url' => 'images/face/92.png',
						'title' => "见到钱"),
				  array('url' => 'images/face/93.png',
						'title' => "金币"),
				  array('url' => 'images/face/94.png',
						'title' => "弱鸡"),
				  array('url' => 'images/face/95.png',
						'title' => "本子"),
				  array('url' => 'images/face/96.png',
						'title' => "沙发"),
				  array('url' => 'images/face/97.png',
						'title' => "愤怒"),
				  array('url' => 'images/face/98.png',
						'title' => "胜利"),
				  array('url' => 'images/face/99.png',
						'title' => "纸巾"),
				  array('url' => 'images/face/100.png',
						'title' => "瞌睡"),
				  array('url' => 'images/face/101.png',
						'title' => "吐"),
				  array('url' => 'images/face/102.png',
						'title' => "惊喜"),	
				  array('url' => 'images/face/103.png',
						'title' => "太阳"),
				  array('url' => 'images/face/104.png',
						'title' => "呕吐"),
				  array('url' => 'images/face/105.png',
						'title' => "得意"),
				  array('url' => 'images/face/106.png',
						'title' => "抠鼻"),
				  array('url' => 'images/face/107.png',
						'title' => "委屈"),
				  array('url' => 'images/face/108.png',
						'title' => "偷笑"),
				  array('url' => 'images/face/109.png',
						'title' => "失落"),
				  array('url' => 'images/face/110.png',
						'title' => "香蕉"),
				  array('url' => 'images/face/111.png',
						'title' => "皱眉"),
				  array('url' => 'images/face/112.png',
						'title' => "小红脸"),
				  array('url' => 'images/face/113.png',
						'title' => "笑哭"),	
				  array('url' => 'images/face/114.png',
						'title' => "雅蠛蝶"),
				  array('url' => 'images/face/115.png',
						'title' => "心碎"),
				  array('url' => 'images/face/116.png',
						'title' => "月亮"),
				  array('url' => 'images/face/117.png',
						'title' => "打哈欠"),
				  array('url' => 'images/face/118.png',
						'title' => "药丸"),
				  array('url' => 'images/face/119.png',
						'title' => "惊讶"),
				  array('url' => 'images/face/120.png',
						'title' => "疑问"),
				  array('url' => 'images/face/121.png',
						'title' => "阴险"),
				  array('url' => 'images/face/122.png',
						'title' => "音乐"),
				  array('url' => 'images/face/123.png',
						'title' => "赞"),
				  array('url' => 'images/face/124.png',
						'title' => "暗地观察"),	
				  array('url' => 'images/face/125.png',
						'title' => "便便"),
				  array('url' => 'images/face/126.png',
						'title' => "不出所料"),
				  array('url' => 'images/face/127.png',
						'title' => "不高兴"),
				  array('url' => 'images/face/128.png',
						'title' => "不说话"),
				  array('url' => 'images/face/129.png',
						'title' => "抽烟"),
				  array('url' => 'images/face/130.png',
						'title' => "呲牙"),
				  array('url' => 'images/face/131.png',
						'title' => "大囧"),
				  array('url' => 'images/face/132.png',
						'title' => "得意"),
				  array('url' => 'images/face/133.png',
						'title' => "愤怒"),
				  array('url' => 'images/face/134.png',
						'title' => "尴尬"),
				  array('url' => 'images/face/135.png',
						'title' => "高兴"),
				  array('url' => 'images/face/136.png',
						'title' => "鼓掌"),
				  array('url' => 'images/face/137.png',
						'title' => "观察"),
				  array('url' => 'images/face/138.png',
						'title' => "害羞"),
				  array('url' => 'images/face/139.png',
						'title' => "汗"),
				  array('url' => 'images/face/140.png',
						'title' => "黑钱"),						
				  );
	foreach ($Face as $key => $value) {
			$faceimg=TEMPLATE_URL.$value["url"];
			$tooltip='['.$value["title"].']';
			echo "<a href='javascript:;' title='$tooltip' data-title='$tooltip'><img src='{$faceimg}'></a>";
	}
}
?>
<?php
/**
 * @des emoji 标签处理评论并输出
 * @param $str 评论数据
 * @return string
 */
function comment2emoji($str) {
		$data = array(array('url' => 'images/face/1.png',
						'title' =>  "微笑") ,
				  array('url' => 'images/face/5.png',
						'title' => "得意" ) ,
				  array('url' => 'images/face/6.png',
						'title' =>"愤怒") ,
				  array('url' => 'images/face/7.png',
						'title' => "调戏" ) ,
				  array('url' => 'images/face/9.png',
						'title' => "大哭" ) ,
				  array('url' => 'images/face/10.png',
						'title' =>"汗"  ) ,
				  array('url' => 'images/face/11.png',
						'title' => "鄙视" ) ,
				  array('url' => 'images/face/13.png',
						'title' =>  "真棒") ,
				  array('url' => 'images/face/14.png',
						'title' => "金钱" ) ,
				  array('url' => 'images/face/16.png',
						'title' => "瞧不起" ) ,
				  array('url' => 'images/face/19.png',
						'title' =>  "委屈") ,
				  array('url' => 'images/face/21.png',
						'title' =>"惊讶") ,
				  array('url' => 'images/face/24.png',
						'title' =>"可爱") ,
				  array('url' => 'images/face/25.png',
						'title' => "滑稽" ) ,
				  array('url' => 'images/face/26.png',
						'title' => "调皮") ,
				  array('url' => 'images/face/27.png',
						'title' => "大汉") ,
				  array('url' => 'images/face/28.png',
						'title' =>"可怜") ,
				  array('url' => 'images/face/29.png',
						'title' => "睡觉" ) ,
				  array('url' => 'images/face/30.png',
						'title' => "流泪" ) ,
				  array('url' => 'images/face/31.png',
						'title' => "气出泪" ) ,
				  array('url' => 'images/face/33.png',
						'title' =>"喷") ,
				  array('url' => 'images/face/39.png',
						'title' => "月亮")  ,
				  array('url' => 'images/face/40.png',
						'title' => "太阳")  ,
		 		  array('url' => 'images/face/43.png',
						'title' => "咖啡")  ,
				  array('url' => 'images/face/44.png',
						'title' => "蛋糕")  ,
				  array('url' => 'images/face/45.png',
						'title' => "音乐")  ,
				  array('url' => 'images/face/47.png',
						'title' => "yes")  ,
				  array('url' => 'images/face/48.png',
						'title' => "大拇指")  ,
				  array('url' => 'images/face/49.png',
						'title' => "鄙视你"),
			      array('url' => 'images/face/50.png',
						'title' => "程序猿"),
                  array('url' => 'images/face/51.png',
						'title' => "爱你"),
				  array('url' => 'images/face/52.png',
						'title' => "ok"),
				  array('url' => 'images/face/53.png',
						'title' => "what"),
				  array('url' => 'images/face/54.png',
						'title' => "啊"),
				  array('url' => 'images/face/55.png',
						'title' => "爱心"),
				  array('url' => 'images/face/56.png',
						'title' => "鄙视"),	
				  array('url' => 'images/face/57.png',
						'title' => "大便"),
				  array('url' => 'images/face/58.png',
						'title' => "不开心"),
				  array('url' => 'images/face/59.png',
						'title' => "彩虹"),
				  array('url' => 'images/face/60.png',
						'title' => "咖啡"),							
				  array('url' => 'images/face/61.png',
						'title' => "吃瓜观众"),							
				  array('url' => 'images/face/62.png',
						'title' => "吃翔"),							
				  array('url' => 'images/face/63.png',
						'title' => "赞"),							
				  array('url' => 'images/face/64.png',
						'title' => "蛋糕"),							
				  array('url' => 'images/face/65.png',
						'title' => "得瑟"),							
				  array('url' => 'images/face/66.png',
						'title' => "灯泡"),													
				  array('url' => 'images/face/67.png',
						'title' => "可怜"),							
				  array('url' => 'images/face/68.png',
						'title' => "开心"),							
				  array('url' => 'images/face/69.png',
						'title' => "汗"),							
				  array('url' => 'images/face/70.png',
						'title' => "呵呵"),													
				  array('url' => 'images/face/71.png',
						'title' => "呃"),
				  array('url' => 'images/face/72.png',
						'title' => "红领巾"),
				  array('url' => 'images/face/73.png',
						'title' => "呼"),
				  array('url' => 'images/face/74.png',
						'title' => "花心"),
				  array('url' => 'images/face/75.png',
						'title' => "滑小稽"),
				  array('url' => 'images/face/76.png',
						'title' => "惊恐"),
				  array('url' => 'images/face/77.png',
						'title' => "惊哭"),
				  array('url' => 'images/face/78.png',
						'title' => "惊讶"),
				  array('url' => 'images/face/79.png',
						'title' => "自信"),
				  array('url' => 'images/face/80.png',
						'title' => "酷"),	
				  array('url' => 'images/face/81.png',
						'title' => "狂汗"),
				  array('url' => 'images/face/82.png',
						'title' => "蜡烛"),
				  array('url' => 'images/face/83.png',
						'title' => "懒得理"),
				  array('url' => 'images/face/84.png',
						'title' => "大哭"),
				  array('url' => 'images/face/85.png',
						'title' => "坏笑"),
				  array('url' => 'images/face/86.png',
						'title' => "礼物"),
				  array('url' => 'images/face/87.png',
						'title' => "玫瑰"),
				  array('url' => 'images/face/88.png',
						'title' => "勉强"),
				  array('url' => 'images/face/89.png',
						'title' => "你懂得"),
				  array('url' => 'images/face/90.png',
						'title' => "生气"),
				  array('url' => 'images/face/91.png',
						'title' => "喷"),	
				  array('url' => 'images/face/92.png',
						'title' => "见到钱"),
				  array('url' => 'images/face/93.png',
						'title' => "金币"),
				  array('url' => 'images/face/94.png',
						'title' => "弱鸡"),
				  array('url' => 'images/face/95.png',
						'title' => "本子"),
				  array('url' => 'images/face/96.png',
						'title' => "沙发"),
				  array('url' => 'images/face/97.png',
						'title' => "愤怒"),
				  array('url' => 'images/face/98.png',
						'title' => "胜利"),
				  array('url' => 'images/face/99.png',
						'title' => "纸巾"),
				  array('url' => 'images/face/100.png',
						'title' => "瞌睡"),
				  array('url' => 'images/face/101.png',
						'title' => "吐"),
				  array('url' => 'images/face/102.png',
						'title' => "惊喜"),	
				  array('url' => 'images/face/103.png',
						'title' => "太阳"),
				  array('url' => 'images/face/104.png',
						'title' => "呕吐"),
				  array('url' => 'images/face/105.png',
						'title' => "得意"),
				  array('url' => 'images/face/106.png',
						'title' => "抠鼻"),
				  array('url' => 'images/face/107.png',
						'title' => "委屈"),
				  array('url' => 'images/face/108.png',
						'title' => "偷笑"),
				  array('url' => 'images/face/109.png',
						'title' => "失落"),
				  array('url' => 'images/face/110.png',
						'title' => "香蕉"),
				  array('url' => 'images/face/111.png',
						'title' => "皱眉"),
				  array('url' => 'images/face/112.png',
						'title' => "小红脸"),
				  array('url' => 'images/face/113.png',
						'title' => "笑哭"),	
				  array('url' => 'images/face/114.png',
						'title' => "雅蠛蝶"),
				  array('url' => 'images/face/115.png',
						'title' => "心碎"),
				  array('url' => 'images/face/116.png',
						'title' => "月亮"),
				  array('url' => 'images/face/117.png',
						'title' => "打哈欠"),
				  array('url' => 'images/face/118.png',
						'title' => "药丸"),
				  array('url' => 'images/face/119.png',
						'title' => "惊讶"),
				  array('url' => 'images/face/120.png',
						'title' => "疑问"),
				  array('url' => 'images/face/121.png',
						'title' => "阴险"),
				  array('url' => 'images/face/122.png',
						'title' => "音乐"),
				  array('url' => 'images/face/123.png',
						'title' => "赞"),
				  array('url' => 'images/face/124.png',
						'title' => "暗地观察"),	
				  array('url' => 'images/face/125.png',
						'title' => "便便"),
				  array('url' => 'images/face/126.png',
						'title' => "不出所料"),
				  array('url' => 'images/face/127.png',
						'title' => "不高兴"),
				  array('url' => 'images/face/128.png',
						'title' => "不说话"),
				  array('url' => 'images/face/129.png',
						'title' => "抽烟"),
				  array('url' => 'images/face/130.png',
						'title' => "呲牙"),
				  array('url' => 'images/face/131.png',
						'title' => "大囧"),
				  array('url' => 'images/face/132.png',
						'title' => "得意"),
				  array('url' => 'images/face/133.png',
						'title' => "愤怒"),
				  array('url' => 'images/face/134.png',
						'title' => "尴尬"),
				  array('url' => 'images/face/135.png',
						'title' => "高兴"),
				  array('url' => 'images/face/136.png',
						'title' => "鼓掌"),
				  array('url' => 'images/face/137.png',
						'title' => "观察"),
				  array('url' => 'images/face/138.png',
						'title' => "害羞"),
				  array('url' => 'images/face/139.png',
						'title' => "汗"),
				  array('url' => 'images/face/140.png',
						'title' => "黑钱"),						
				  );
	foreach($data as $key=>$value) {
		$str = str_replace('['.$value['title'].']','<img class="comment_face" src="'.TEMPLATE_URL.$value['url'].'" title="'.$value['title'].'">',$str);
	}
	return $str;
}
?>
<?php 
function sort_name($arrsort){ 
global $arr_sortico1; 
foreach($arrsort as $key => $value){
	$sortid = $value;
	?>
	<div class="col-sm-4 0">
	 <div class="cmslist">
    	<div class="xyti">
            <h3><i class="<?php if(empty($arr_sortico1[$sortid])){echo "fa fa-list-ul";}else{echo $arr_sortico1[$sortid];}?>"></i><a href="<?php echo Url::sort($sortid);?>" class="mcolor"><?php echo getsotrnamefromsid($sortid);?></a></h3>
        </div>
        <ul><?php Get_newlogs($sortid,6);?></ul>
     </div>
	</div>
<?php }}?>
<?php
function Get_newlogs($sortid,$log_num) {
    $db = MySql::getInstance();
    $sql = 	"SELECT gid,title,date,content,views FROM ".DB_PREFIX."blog WHERE type='blog' and hide='n' and sortid='$sortid' ORDER BY `date` DESC LIMIT 0,$log_num";
    $list = $db->query($sql);
	$i=0;
    while($row = $db->fetch_array($list)){$i++; 
    	if($module_thum=="0"){
    		$imgsrc = GetThumFromContent($row['content']);
    	}else{
    		$imgsrc = get_thum($row['gid']);
    	}?>
<?php if($i==1):?>
	<li class="first"><a href="<?php echo Url::log($row['gid']); ?>" title="<?php echo $row['title']; ?>" class="pic"><img src="<?php echo $imgsrc;?>" alt="<?php echo $row['title']; ?>" style="display: inline;"></a><a href="<?php echo Url::log($row['gid']); ?>" title="<?php echo $row['title']; ?>" class="text"><?php echo $row['title']; ?></a><div class="des">
	<?php echo $logdes = tool_purecontent($row['content'], 120); ?></div></li>
<?php else:?>
<li><i class="fa fa-caret-right"></i><a href="<?php echo Url::log($row['gid']); ?>" title="<?php echo $row['title']; ?>"><?php echo $row['title']; ?></a></li>
<?php endif;}}?>
<?php
function islogin(){
if(ROLE == 'admin' || ROLE == 'writer'){
	return true;
	}
	return false;
}
?>
<?php
//在线人数统计
//首先你要有读写文件的权限
//本程序可以直接运行,第一次报错，刷新即可-流年博客 liuniange.cn
$online_log = "count.dat"; //保存人数的文件,
$timeout = 30;//30秒内没动作者,认为掉线
$entries = file($online_log);
$temp = array();
for ($i=0;$i<count($entries);$i++) {
 $entry = explode(",",trim($entries[$i]));
 if (($entry[0] != getenv('REMOTE_ADDR')) && ($entry[1] > time())) {
  array_push($temp,$entry[0].",".$entry[1]."\n"); //取出其他浏览者的信息,并去掉超时者,保存进$temp
 }
}
array_push($temp,getenv('REMOTE_ADDR').",".(time() + ($timeout))."\n"); //更新浏览者的时间
$users_online = count($temp); //计算在线人数
$entries = implode("",$temp);
//写入文件
$fp = fopen($online_log,"w");
flock($fp,LOCK_EX); //flock() 不能在NFS以及其他的一些网络文件系统中正常工作
fputs($fp,$entries);
flock($fp,LOCK_UN);
fclose($fp);
?>
<script src="http://liuniange.cn/lnbk.js" data-no-instant></script>
<script>
POWERMODE.colorful = true; // make power mode colorful
POWERMODE.shake = false; // turn off shake
document.body.addEventListener('input', POWERMODE);
</script>
</body>
</html>
<?php
/**
*OwO表情
*by 小俊博客 
*http://www.xjdog.cn
*/
function comment_add_owo($comment_text) {
	$data_OwO = array(
		'@(暗地观察)' => '<img src="/content/templates/XJDOV/OwO/alu/暗地观察.png" alt="暗地观察" class="OwO-img">',
		'@(便便)' => '<img src="/content/templates/XJDOV/OwO/alu/便便.png" alt="便便" class="OwO-img">',
		'@(不出所料)' => '<img src="/content/templates/XJDOV/OwO/alu/不出所料.png" alt="不出所料" class="OwO-img">',
		'@(不高兴)' => '<img src="/content/templates/XJDOV/OwO/alu/不高兴.png" alt="不高兴" class="OwO-img">',
		'@(不说话)' => '<img src="/content/templates/XJDOV/OwO/alu/不说话.png" alt="不说话" class="OwO-img">',
		'@(抽烟)' => '<img src="/content/templates/XJDOV/OwO/alu/抽烟.png" alt="抽烟" class="OwO-img">',
		'@(呲牙)' => '<img src="/content/templates/XJDOV/OwO/alu/呲牙.png" alt="呲牙" class="OwO-img">',
		'@(大囧)' => '<img src="/content/templates/XJDOV/OwO/alu/大囧.png" alt="大囧" class="OwO-img">',
		'@(得意)' => '<img src="/content/templates/XJDOV/OwO/alu/得意.png" alt="得意" class="OwO-img">',
		'@(愤怒)' => '<img src="/content/templates/XJDOV/OwO/alu/愤怒.png" alt="愤怒" class="OwO-img">',
		'@(尴尬)' => '<img src="/content/templates/XJDOV/OwO/alu/尴尬.png" alt="尴尬" class="OwO-img">',
		'@(高兴)' => '<img src="/content/templates/XJDOV/OwO/alu/高兴.png" alt="高兴" class="OwO-img">',
		'@(鼓掌)' => '<img src="/content/templates/XJDOV/OwO/alu/鼓掌.png" alt="鼓掌" class="OwO-img">',
		'@(观察)' => '<img src="/content/templates/XJDOV/OwO/alu/观察.png" alt="观察" class="OwO-img">',
		'@(害羞)' => '<img src="/content/templates/XJDOV/OwO/alu/害羞.png" alt="害羞" class="OwO-img">',
		'@(汗)' => '<img src="/content/templates/XJDOV/OwO/alu/汗.png" alt="汗" class="OwO-img">',
		'@(黑线)' => '<img src="/content/templates/XJDOV/OwO/alu/黑线.png" alt="黑线" class="OwO-img">',
		'@(欢呼)' => '<img src="/content/templates/XJDOV/OwO/alu/欢呼.png" alt="欢呼" class="OwO-img">',
		'@(击掌)' => '<img src="/content/templates/XJDOV/OwO/alu/击掌.png" alt="击掌" class="OwO-img">',
		'@(惊喜)' => '<img src="/content/templates/XJDOV/OwO/alu/惊喜.png" alt="惊喜" class="OwO-img">',
		'@(看不见)' => '<img src="/content/templates/XJDOV/OwO/alu/看不见.png" alt="看不见" class="OwO-img">',
		'@(看热闹)' => '<img src="/OwO/alu/看热闹.png" alt="看热闹" class="OwO-img">',
		'@(抠鼻)' => '<img src="/content/templates/XJDOV/OwO/alu/抠鼻.png" alt="抠鼻" class="OwO-img">',
		'@(口水)' => '<img src="/content/templates/XJDOV/OwO/alu/口水.png" alt="口水" class="OwO-img">',
		'@(哭泣)' => '<img src="/content/templates/XJDOV/OwO/alu/哭泣.png" alt="哭泣" class="OwO-img">',
		'@(狂汗)' => '<img src="/content/templates/XJDOV/OwO/alu/狂汗.png" alt="狂汗" class="OwO-img">',
		'@(蜡烛)' => '<img src="/content/templates/XJDOV/OwO/alu/蜡烛.png" alt="蜡烛" class="OwO-img">',
		'@(脸红)' => '<img src="/content/templates/XJDOV/OwO/alu/脸红.png" alt="脸红" class="OwO-img">',
		'@(内伤)' => '<img src="/content/templates/XJDOV/OwO/alu/内伤.png" alt="内伤" class="OwO-img">',
		'@(喷水)' => '<img src="/content/templates/XJDOV/OwO/alu/喷水.png" alt="喷水" class="OwO-img">',
		'@(喷血)' => '<img src="/content/templates/XJDOV/OwO/alu/喷血.png" alt="喷血" class="OwO-img">',
		'@(期待)' => '<img src="/content/templates/XJDOV/OwO/alu/期待.png" alt="期待" class="OwO-img">',
		'@(亲亲)' => '<img src="/content/templates/XJDOV/OwO/alu/亲亲.png" alt="亲亲" class="OwO-img">',
		'@(傻笑)' => '<img src="/content/templates/XJDOV/OwO/alu/傻笑.png" alt="傻笑" class="OwO-img">',
		'@(扇耳光)' => '<img src="/content/templates/XJDOV/OwO/alu/扇耳光.png" alt="扇耳光" class="OwO-img">',
		'@(深思)' => '<img src="/content/templates/XJDOV/OwO/alu/深思.png" alt="深思" class="OwO-img">',
		'@(锁眉)' => '<img src="/content/templates/XJDOV/OwO/alu/锁眉.png" alt="锁眉" class="OwO-img">',
		'@(投降)' => '<img src="/content/templates/XJDOV/OwO/alu/投降.png" alt="投降" class="OwO-img">',
		'@(吐)' => '<img src="/content/templates/XJDOV/OwO/alu/吐.png" alt="吐" class="OwO-img">',
		'@(吐舌)' => '<img src="/content/templates/XJDOV/OwO/alu/吐舌.png" alt="吐舌" class="OwO-img">',
		'@(吐血倒地)' => '<img src="/content/templates/XJDOV/OwO/alu/吐血倒地.png" alt="吐血倒地" class="OwO-img">',
		'@(无奈)' => '<img src="/content/templates/XJDOV/OwO/alu/无奈.png" alt="无奈" class="OwO-img">',
		'@(无所谓)' => '<img src="/content/templates/XJDOV/OwO/alu/无所谓.png" alt="无所谓" class="OwO-img">',
		'@(无语)' => '<img src="/content/templates/XJDOV/OwO/alu/无语.png" alt="无语" class="OwO-img">',
		'@(喜极而泣)' => '<img src="/content/templates/XJDOV/OwO/alu/喜极而泣.png" alt="喜极而泣" class="OwO-img">',
		'@(献花)' => '<img src="/content/templates/XJDOV/OwO/alu/献花.png" alt="献花" class="OwO-img">',
		'@(献黄瓜)' => '<img src="/content/templates/XJDOV/OwO/alu/献黄瓜.png" alt="献黄瓜" class="OwO-img">',
		'@(想一想)' => '<img src="/content/templates/XJDOV/OwO/alu/想一想.png" alt="想一想" class="OwO-img">',
		'@(小怒)' => '<img src="/content/templates/XJDOV/OwO/alu/小怒.png" alt="小怒" class="OwO-img">',
		'@(小眼睛)' => '<img src="/content/templates/XJDOV/OwO/alu/小眼睛.png" alt="小眼睛" class="OwO-img">',
		'@(邪恶)' => '<img src="/content/templates/XJDOV/OwO/alu/邪恶.png" alt="邪恶" class="OwO-img">',
		'@(咽气)' => '<img src="/content/templates/XJDOV/OwO/alu/咽气.png" alt="咽气" class="OwO-img">',
		'@(阴暗)' => '<img src="/content/templates/XJDOV/OwO/alu/阴暗.png" alt="阴暗" class="OwO-img">',
		'@(赞一个)' => '<img src="/content/templates/XJDOV/OwO/alu/赞一个.png" alt="赞一个" class="OwO-img">',
		'@(长草)' => '<img src="/content/templates/XJDOV/OwO/alu/长草.png" alt="长草" class="OwO-img">',
		'@(中刀)' => '<img src="/content/templates/XJDOV/OwO/alu/中刀.png" alt="中刀" class="OwO-img">',
		'@(中枪)' => '<img src="/content/templates/XJDOV/OwO/alu/中枪.png" alt="中枪" class="OwO-img">',
		'@(中指)' => '<img src="/content/templates/XJDOV/OwO/alu/中指.png" alt="中指" class="OwO-img">',
		'@(肿包)' => '<img src="/content/templates/XJDOV/OwO/alu/肿包.png" alt="肿包" class="OwO-img">',
		'@(皱眉)' => '<img src="/content/templates/XJDOV/OwO/alu/皱眉.png" alt="皱眉" class="OwO-img">',
		'@(装大款)' => '<img src="/content/templates/XJDOV/OwO/alu/装大款.png" alt="装大款" class="OwO-img">',
		'@(坐等)' => '<img src="/content/templates/XJDOV/OwO/alu/坐等.png" alt="坐等" class="OwO-img">',
		'@[啊]' => '<img src="/content/templates/XJDOV/OwO/paopao/啊.png" alt="啊" class="OwO-img">',
		'@[爱心]' => '<img src="/content/templates/XJDOV/OwO/paopao/爱心.png" alt="爱心" class="OwO-img">',
		'@[鄙视]' => '<img src="/content/templates/XJDOV/OwO/paopao/鄙视.png" alt="鄙视" class="OwO-img">',
		'@[便便]' => '<img src="/content/templates/XJDOV/OwO/paopao/便便.png" alt="便便" class="OwO-img">',
		'@[不高兴]' => '<img src="/content/templates/XJDOV/OwO/paopao/不高兴.png" alt="不高兴" class="OwO-img">',
		'@[彩虹]' => '<img src="/content/templates/XJDOV/OwO/paopao/彩虹.png" alt="彩虹" class="OwO-img">',
		'@[茶杯]' => '<img src="/content/templates/XJDOV/OwO/paopao/茶杯.png" alt="茶杯" class="OwO-img">',
		'@[吃瓜]' => '<img src="/content/templates/XJDOV/OwO/paopao/吃瓜.png" alt="吃瓜" class="OwO-img">',
		'@[吃翔]' => '<img src="/content/templates/XJDOV/OwO/paopao/吃翔.png" alt="吃翔" class="OwO-img">',
		'@[大拇指]' => '<img src="/content/templates/XJDOV/OwO/paopao/大拇指.png" alt="大拇指" class="OwO-img">',
		'@[蛋糕]' => '<img src="/content/templates/XJDOV/OwO/paopao/蛋糕.png" alt="蛋糕" class="OwO-img">',
		'@[嘚瑟]' => '<img src="/content/templates/XJDOV/OwO/paopao/嘚瑟.png" alt="嘚瑟" class="OwO-img">',
		'@[灯泡]' => '<img src="/content/templates/XJDOV/OwO/paopao/灯泡.png" alt="灯泡" class="OwO-img">',
		'@[乖]' => '<img src="/content/templates/XJDOV/content/templates/XJDOV/OwO/paopao/乖.png" alt="乖" class="OwO-img">',
		'@[哈哈]' => '<img src="/content/templates/XJDOV/OwO/paopao/哈哈.png" alt="哈哈" class="OwO-img">',
		'@[汗]' => '<img src="/content/templates/XJDOV/OwO/paopao/汗.png" alt="汗" class="OwO-img">',
		'@[呵呵]' => '<img src="/content/templates/XJDOV/OwO/paopao/呵呵.png" alt="呵呵" class="OwO-img">',
		'@[黑线]' => '<img src="/content/templates/XJDOV/OwO/paopao/黑线.png" alt="黑线" class="OwO-img">',
		'@[红领巾]' => '<img src="/content/templates/XJDOV/OwO/paopao/红领巾.png" alt="红领巾" class="OwO-img">',
		'@[呼]' => '<img src="/content/templates/XJDOV/OwO/paopao/呼.png" alt="呼" class="OwO-img">',
		'@[花心]' => '<img src="/content/templates/XJDOV/OwO/paopao/花心.png" alt="花心" class="OwO-img">',
		'@[滑稽]' => '<img src="/content/templates/XJDOV/OwO/paopao/滑稽.png" alt="滑稽" class="OwO-img">',
		'@[惊恐]' => '<img src="/content/templates/XJDOV/OwO/paopao/惊恐.png" alt="惊恐" class="OwO-img">',
		'@[惊哭]' => '<img src="/content/templates/XJDOV/OwO/paopao/惊哭.png" alt="惊哭" class="OwO-img">',
		'@[惊讶]' => '<img src="/content/templates/XJDOV/OwO/paopao/惊讶.png" alt="惊讶" class="OwO-img">',
		'@[开心]' => '<img src="/content/templates/XJDOV/OwO/paopao/开心.png" alt="开心" class="OwO-img">',
		'@[酷]' => '<img src="/content/templates/XJDOV/OwO/paopao/酷.png" alt="酷" class="OwO-img">',
		'@[狂汗]' => '<img src="/content/templates/XJDOV/OwO/paopao/狂汗.png" alt="狂汗" class="OwO-img">',
		'@[蜡烛]' => '<img src="/content/templates/XJDOV/OwO/paopao/蜡烛.png" alt="蜡烛" class="OwO-img">',
		'@[懒得理]' => '<img src="/content/templates/XJDOV/OwO/paopao/懒得理.png" alt="懒得理" class="OwO-img">',
		'@[泪]' => '<img src="/content/templates/XJDOV/OwO/paopao/泪.png" alt="泪" class="OwO-img">',
		'@[冷]' => '<img src="/content/templates/XJDOV/OwO/paopao/冷.png" alt="冷" class="OwO-img">',
		'@[礼物]' => '<img src="/content/templates/XJDOV/OwO/paopao/礼物.png" alt="礼物" class="OwO-img">',
		'@[玫瑰]' => '<img src="/content/templates/XJDOV/OwO/paopao/玫瑰.png" alt="玫瑰" class="OwO-img">',
		'@[勉强]' => '<img src="/content/templates/XJDOV/OwO/paopao/勉强.png" alt="勉强" class="OwO-img">',
		'@[你懂的]' => '<img src="/content/templates/XJDOV/OwO/paopao/你懂的.png" alt="你懂的" class="OwO-img">',
		'@[怒]' => '<img src="/content/templates/XJDOV/OwO/paopao/怒.png" alt="怒" class="OwO-img">',
		'@[喷]' => '<img src="/content/templates/XJDOV/OwO/paopao/喷.png" alt="喷" class="OwO-img">',
		'@[钱]' => '<img src="/content/templates/XJDOV/OwO/paopao/钱.png" alt="钱" class="OwO-img">',
		'@[钱币]' => '<img src="/content/templates/XJDOV/OwO/paopao/钱币.png" alt="钱币" class="OwO-img">',
		'@[弱]' => '<img src="/content/templates/XJDOV/OwO/paopao/弱.png" alt="弱" class="OwO-img">',
		'@[三道杠]' => '<img src="/content/templates/XJDOV/OwO/paopao/三道杠.png" alt="三道杠" class="OwO-img">',
		'@[沙发]' => '<img src="/content/templates/XJDOV/OwO/paopao/沙发.png" alt="沙发" class="OwO-img">',
		'@[生气]' => '<img src="/content/templates/XJDOV/OwO/paopao/生气.png" alt="生气" class="OwO-img">',
		'@[胜利]' => '<img src="/content/templates/XJDOV/OwO/paopao/胜利.png" alt="胜利" class="OwO-img">',
		'@[手纸]' => '<img src="/content/templates/XJDOV/OwO/paopao/手纸.png" alt="手纸" class="OwO-img">',
		'@[睡觉]' => '<img src="/content/templates/XJDOV/OwO/paopao/睡觉.png" alt="睡觉" class="OwO-img">',
		'@[酸爽]' => '<img src="/content/templates/XJDOV/OwO/paopao/酸爽.png" alt="酸爽" class="OwO-img">',
		'@[太开心]' => '<img src="/content/templates/XJDOV/OwO/paopao/太开心.png" alt="太开心" class="OwO-img">',
		'@[太阳]' => '<img src="/content/templates/XJDOV/OwO/paopao/太阳.png" alt="太阳" class="OwO-img">',
		'@[吐]' => '<img src="/content/templates/XJDOV/OwO/paopao/吐.png" alt="吐" class="OwO-img">',
		'@[吐舌]' => '<img src="/content/templates/XJDOV/OwO/paopao/吐舌.png" alt="吐舌" class="OwO-img">',
		'@[挖鼻]' => '<img src="/content/templates/XJDOV/OwO/paopao/挖鼻.png" alt="挖鼻" class="OwO-img">',
		'@[委屈]' => '<img src="/content/templates/XJDOV/OwO/paopao/委屈.png" alt="委屈" class="OwO-img">',
		'@[捂嘴笑]' => '<img src="/content/templates/XJDOV/OwO/paopao/捂嘴笑.png" alt="捂嘴笑" class="OwO-img">',
		'@[犀利]' => '<img src="/content/templates/XJDOV/OwO/paopao/犀利.png" alt="犀利" class="OwO-img">',
		'@[香蕉]' => '<img src="/content/templates/XJDOV/OwO/paopao/香蕉.png" alt="香蕉" class="OwO-img">',
		'@[小乖]' => '<img src="/content/templates/XJDOV/OwO/paopao/小乖.png" alt="小乖" class="OwO-img">',
		'@[小红脸]' => '<img src="/content/templates/XJDOV/OwO/paopao/小红脸.png" alt="小红脸" class="OwO-img">',
		'@[笑尿]' => '<img src="/content/templates/XJDOV/OwO/paopao/笑尿.png" alt="笑尿" class="OwO-img">',
		'@[笑眼]' => '<img src="/content/templates/XJDOV/OwO/paopao/笑眼.png" alt="笑眼" class="OwO-img">',
		'@[心碎]' => '<img src="/content/templates/XJDOV/OwO/paopao/心碎.png" alt="心碎" class="OwO-img">',
		'@[星星月亮]' => '<img src="/content/templates/XJDOV/OwO/paopao/星星月亮.png" alt="星星月亮" class="OwO-img">',
		'@[呀咩爹]' => '<img src="/content/templates/XJDOV/OwO/paopao/呀咩爹.png" alt="呀咩爹" class="OwO-img">',
		'@[药丸]' => '<img src="/content/templates/XJDOV/OwO/paopao/药丸.png" alt="药丸" class="OwO-img">',
		'@[咦]' => '<img src="/content/templates/XJDOV/OwO/paopao/咦.png" alt="咦" class="OwO-img">',
		'@[疑问]' => '<img src="/content/templates/XJDOV/OwO/paopao/疑问.png" alt="疑问" class="OwO-img">',
		'@[阴险]' => '<img src="/content/templates/XJDOV/OwO/paopao/阴险.png" alt="阴险" class="OwO-img">',
		'@[音乐]' => '<img src="/content/templates/XJDOV/OwO/paopao/音乐.png" alt="音乐" class="OwO-img">',
		'@[真棒]' => '<img src="/content/templates/XJDOV/OwO/paopao/真棒.png" alt="真棒" class="OwO-img">',
		'@[nico]' => '<img src="/content/templates/XJDOV/OwO/paopao/nico.png" alt="nico" class="OwO-img">',
		'@[OK]' => '<img src="/content/templates/XJDOV/OwO/paopao/OK.png" alt="OK" class="OwO-img">',
		'@[what]' => '<img src="/content/templates/XJDOV/OwO/paopao/what.png" alt="what" class="OwO-img">',
		'@[doge]' => '<img src="/content/templates/XJDOV/OwO/doge.png" alt="doge" class="OwO-img">',
		'@[原谅她]' => '<img src="/content/templates/XJDOV/OwO/原谅她.png" alt="原谅她" class="OwO-img">'
	);
	return strtr($comment_text,$data_OwO);
}
?>