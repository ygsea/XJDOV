<?php 
/**
 * 日志模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<link rel="stylesheet" id="da-main-css" href="<?php echo TEMPLATE_URL; ?>style/image.css" type="text/css" media="all"> 
<section class="container">
  <div class="content-wrap">
    <div class="content">
      <div class="title">
      <?php 
        if(!empty($sort)) {
          //栏目页显示
          $des = $sort['description']?$sort['description']:'这家伙很懒，还没填写该栏目的介绍呢~';
          echo '<h3>'.$sortName.'</h3><p>'.$des.'</p>';
        }else{
          echo "<h3> 最新发布 </h3>";
        }
       ?>
        
        <div class="more"></div>
      </div>
      <?php 
        foreach($logs as $key=>$value): 
          if($module_thum=="0"){
            $imgsrc = GetThumFromContent($value['content']);
          }else{
            $imgsrc = get_thum($value['logid']);
          }
       ?>
       <article class="excerpt">
        <p class="image-container"><a class="focus" href="<?php echo $value['log_url']; ?>"><img class="thumb" src="<?php echo $imgsrc;?>"></a></p>
        <header><?php blog_sort_img($value['logid']); ?>
          <h2><a href="<?php echo $value['log_url']; ?>" title="<?php echo $value['log_title']; ?>"><?php echo $value['log_title']; ?></a></h2>
        </header>
        <p class="meta"><span class="pv"><i class="fa fa-eye"></i>阅读(<?php echo $value['views']; ?>)</span><a class="pc" href="<?php echo $value['log_url']; ?>#comments"><i class="fa fa-comments-o"></i>评论(<span class="ds-thread-count"><?php echo $value['comnum']; ?></span>)</a></p>
      </article>
    <?php endforeach; ?>
      <div class="pagenavi"><ul>
      <?php echo sheli_fy($lognum,$index_lognum,$page,$pageurl);?></ul>
      </div>
    </div>
  </div>
</section>



<?php
 include View::getView('footer');
?>