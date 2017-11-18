<?php 
/**
 * 自建页面模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
if(!isLogin()){
		emMsg('请先登录！',BLOG_URL,true);
	}
?>
<?php 
//获取用户发表文章
function myblog(){
		global $userData;
		global $CACHE;
		$Log_Model = new Log_Model();
		$sorts = $CACHE->readCache('sort');
		$userid = $userData['uid'];
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$hide_state = "";
		$sqlSegment = "and author=$userid order by date desc";
		$logNum = $Log_Model->getLogNum($hide_state, $sqlSegment, 'blog', 1);
		$logs = $Log_Model->getLogsForAdmin($sqlSegment, $hide_state, $page);
		$pageurl =  sheli_fy($logNum, Option::get('admin_perpage_num'), $page, "http://127.0.0.1/src/?user&posts&page=");
		$f.='<div class="table-responsive">
   <table class="table">
      <thead>
         <tr>
            <th>审核状态</th>
            <th>标题</th>
            <th>日期</th>
         </tr>
      </thead>
      <tbody>';
      	if($logs):
      	foreach($logs as $key=>$value):
      	$sortName = $value['sortid'] == -1 && !array_key_exists($value['sortid'], $sorts) ? '未分类' : $sorts[$value['sortid']]['sortname'];
      	$author = $user_cache[$value['author']]['name'];
        $author_role = $user_cache[$value['author']]['role'];

		$hide = $value['hide']=='y'?'(<span style="color:red;">待审核</span>)':'(已审核)';
		$hidetitle = $value['hide']=='y'?' '.$value['title']:' <a href="'.Url::log($value['gid']).'" target="_blank">'.$value['title'].'</a>';
		$date = $value["date"];
		$f.="<tr>
        <td>$hide</td>
        <td>[$sortName] $hidetitle</td>
        <td>$date</td>
         </tr>";
		
		endforeach;endif;
		$f.='</tbody>
   </table>
   <div class="page comment-page"><ul>
   '.$pageurl.'</ul>
</div>
</div>  ';
		if($logNum==0){
			return '您还没有发表过文章哦!';
		}else{
			return $f;
		}
	}

//获取用户发表评论
function mycomment(){
		$Comment_Model = new Comment_Model();
		global $userData;
		$userEmail = $userData['email'];
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$blogId = "";
		$hide = "";
		$comment = $Comment_Model->getComments(1, $blogId, $hide, $page);
		$cmnum = $Comment_Model->getCommentNum($blogId, $hide);
		$hideCommNum = $Comment_Model->getCommentNum($blogId, 'y');
		$pageurl =  sheli_fy($cmnum, Option::get('admin_perpage_num'), $page, "?user&comments&page=");
		$f.='<div class="table-responsive">
   <table class="table">
      <thead>
         <tr>
            <th>帖子标题</th>
            <th>回复内容</th>
            <th>回复日期</th>
            <th>IP地址</th>
         </tr>
      </thead>
      <tbody>';
      		foreach($comment as $key=>$value):
				$mail = !empty($value['mail']) ? "({$value['mail']})" : '';
				$ip = !empty($value['ip']) ? "{$value['ip']}" : '';
				$value['content'] = str_replace('<br>',' ',$value['content']);
				$sub_content = subString($value['content'], 0, 50);
				$value['title'] = subString($value['title'], 0, 42);
				$hidetitle = '<a href="'.Url::log($value['gid']).'" target="_blank">'.$value['title'].'</a>';
			$f.="<tr>
            <td>{$hidetitle}</td>
            <td>{$sub_content}</td>
            <td>{$value["date"]}</td>
            <td>{$ip}</td>
         </tr>";
			endforeach;
		$f.='</tbody>
   </table><div class="page comment-page"><ul>'.$pageurl.'
	</ul></div></div>  ';
		if($comment){
			return $f;
		}
		else{
			return '您还没有发表过文章哦!';
		}
	}


	?>
<?php global $userData;
?>
<script charset="utf-8" src="<?php echo BLOG_URL; ?>/admin/editor/kindeditor.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<script charset="utf-8" src="<?php echo BLOG_URL; ?>/admin/editor/lang/zh_CN.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<script>
function includeLinkStyle(url) {
 var link = document.createElement("link");
 link.rel = "stylesheet";
 link.type = "text/css";
 link.href = url;
 document.getElementsByTagName("head")[0].appendChild(link);
}
includeLinkStyle("./content/templates/emlog_dux/style/user.css");
</script>
<div class="single single-post postid- single-format-standard nav_fixed">
<section class="container"><div class="content-wrap">
<div class="container-user">
		<div class="userside">
			<div class="usertitle"><a href="#user-avatar">
			<?php
			$imgavatar = empty($userData['photo']) ? 
                BLOG_URL . 'admin/views/images/avatar.jpg' : 
                BLOG_URL . substr($userData['photo'],3);?>
			<img alt="" height="50" width="50" src="<?php echo myGravatar($userData["email"],$imgavatar);?>" style="display: inline;"></a>
				<h2><?php if(empty($userData["nickname"])){echo $userData["username"];}else{echo $userData["nickname"];}?>  </h2>
			</div>
			<div class="usermenus">	
				<ul class="usermenu">
					<li class="usermenu-post-new"><a href="?user&post-new"><i class="fa fa-plus-circle"></i> 发布文章</a></li>
					<li class="usermenu-posts "><a href="?user&posts"><i class="fa fa-file-o"></i> 我的文章</a></li>
					<li class="usermenu-comments"><a href="?user&comments"><i class="fa fa-comment-o"></i> 我的评论</a></li>
					<li class="usermenu-info"><a href="?user&info"><i class="fa fa-cog"></i> 修改资料</a></li>
					<li class="usermenu-password"><a href="?user&password"><i class="fa fa-unlock"></i> 修改密码</a></li>
					<li class="usermenu-signout"><a href="admin/?action=logout" onclick=""><i class="fa fa-sign-out"></i> 退出</a></li>
				</ul>
				
			</div>
		</div>
		<?php 
		if(isset($_GET['posts'])):
		?>
		<div class="content posts" id="contentframe">
		<div class="hide useridx">posts</div>
			<div class="user-main"><ul class="list">
			<?php echo myblog();?>
		</ul></div>
			<div class="user-tips"></div>
		</div>
		<?php 
		endif;
		if(isset($_GET['post-new'])):
		?>
		<div class="content post-new" id="contentframe">
		<div class="hide useridx">post-new</div>
			<div class="user-main">
	<form class="postform">
	  	<ul class="user-meta user-postnew">
			
	  		<li><label>标题</label>
				<input type="text" class="form-control" name="post_title" placeholder="文章标题">
	  		</li>
	  		<li><label>内容</label>
				<textarea name="post_content" id="post_content" class="form-control" rows="12" placeholder="文章内容"></textarea>
	  		</li>
	  		<li><label>来源链接</label>
				<input type="text" class="form-control" name="post_url" placeholder="文章来源链接">
	  		</li>
	  		<li><label>分类</label>
			<?php
				global $CACHE;
				$sort = $CACHE->readCache('sort');
				$blogsort = '<select id="sort" name="blogsort">';
				$blogsort .= '<option value="-1">选择分类...</option>';
				foreach ($sort as $value) {
					$blogsort .= '<option value="'.$value['sid'].'">'.$value['sortname'].'</option>';
				}
				$blogsort .= '</select>';
				echo $blogsort;
			?>
				
	  		</li>
	  		<li>
	  			<br>
				<input type="button" class="btn btn-primary user_post" name="submit" value="投稿">
				<input type="hidden" name="action" value="post.new">
	  		</li>
	  	</ul>
	<script>
	KindEditor.ready(function(K) {
    var options = {
        resizeMode:1,
		allowUpload:false,
		allowImageUpload:false,
		allowFlashUpload:false,
		allowPreviewEmoticons:false,
		filterMode:false,
		urlType:'domain',
		items:['bold','italic','underline','strikethrough','forecolor','hilitecolor','fontname','fontsize','lineheight','|','removeformat','plainpaste','quickformat','clearhtml','selectall','|','insertorderedlist','insertunorderedlist','indent','outdent','subscript',
        'superscript','justifyleft','justifycenter','justifyright','|','link','unlink','image','flash','table','emoticons','code','fullscreen','source','|','about'],
		afterBlur: function(){this.sync();}
};
var editor = K.create('#post_content', options);
	})
</script>
	</form>
</div>
			<div class="user-tips"></div>
		</div>
			<?php 
		endif;
		if(isset($_GET['comments'])):
		?>
		<div class="content comments" id="contentframe">
			<div class="user-main">
			<div class="hide useridx">comments</div>
			<label style="width:100%;"><?php echo mycomment();?></label>
</div>
			<div class="user-tips"></div>
		</div>
		<?php 
		endif;
		if(isset($_GET['info'])):
		?>
		<div class="content info" id="contentframe">
			<div class="hide useridx">info</div>
			<div class="user-main">
	<form action="<?php echo TEMPLATE_URL;?>user/edit.php?action=update" method="post" name="blooger" enctype="multipart/form-data">
	  	<ul class="user-meta">
			<li><label>头像</label>
			<?php 
			$photo = $userData['photo'];
			if ($photo) {
				$imgsize = chImageSize($photo, Option::ICON_MAX_W, Option::ICON_MAX_H);
				$ico = BLOG_URL . substr($userData['photo'],3);
				$icon = "<img src=\"{$ico}\" width=\"{$imgsize['w']}\" height=\"{$imgsize['h']}\" style=\"border:1px solid #CCCCCC;padding:1px;\" />
				<br />";
			} else {
				$icon = "<img src='".BLOG_URL."admin/views/images/avatar.jpg' />";
			}
			echo $icon;
			?><input type="hidden" name="photo" value="<?php echo $photo; ?>"/><br />
			<input name="photo" type="file" /> (支持JPG、PNG格式图片)
			</li>
	  		<li><label>用户名</label>
				<input type="input" class="form-control" disabled="" value="<?php echo $userData["username"];?>">
	  		</li>
	  		<li><label>邮箱</label>
				<input type="email" class="form-control" name="email" value="<?php echo $userData["email"];?>">
	  		</li>
	  		<li><label>昵称</label>
				<input type="input" class="form-control" name="nickname" value="<?php echo $userData["nickname"];?>">
	  		</li>
	  		<li>
				<input type="submit" evt="info.submit" class="btn btn-primary user_post0" name="submit" value="确认修改资料">
				<input type="hidden" name="action" value="info.edit">
	  		</li>
	  	</ul>
	</form>
</div>
			<div class="user-tips"></div>
		</div>	
		<?php 
		endif;
		if(isset($_GET['password'])):
		?>	
			
		<div class="content password" id="contentframe">
			<div class="user-main"><div class="useridx hide">password</div>
	<form>
	  	<ul class="user-meta">
	  		<li><label>新密码</label>
				<input type="password" class="form-control" name="password">
	  		</li>
	  		<li><label>重复新密码</label>
				<input type="password" class="form-control" name="password2">
	  		</li>
	  		<li>
				<input type="button" evt="password.submit" class="btn btn-primary user_post" name="submit" value="确认修改密码">
				<input type="hidden" name="action" value="password.edit">
	  		</li>
	  	</ul>
	</form>
</div>
			<div class="user-tips"></div>
		</div>
			<?php 
		endif;
		?>
			</div>

</div>
<?php
 include View::getView('footer');
?>

<script type='text/javascript' src='<?php echo TEMPLATE_URL; ?>js/user.js'></script>
</section>
</div>