<?php 
require_once '../../../../init.php';
$action=$_GET["action"];
$msg = array();

function uploadFile0($fileName, $errorNum, $tmpFile, $fileSize, $type, $isIcon = false, $is_thumbnail = true) {
	$result = upload0($fileName, $errorNum, $tmpFile, $fileSize, $type, $isIcon, $is_thumbnail);
	switch ($result) {
		case '100':
			emMsg('文件大小超过系统' . ini_get('upload_max_filesize') . '限制');
			break;
		case '101':
			emMsg('上传文件失败,错误码：' . $errorNum);
			break;
		case '102':
			emMsg('错误的文件类型');
			break;
		case '103':
			$ret = changeFileSize(Option::getAttMaxSize());
			emMsg("文件大小超出{$ret}的限制");
			break;
		case '104':
			emMsg('创建文件上传目录失败');
			break;
		case '105':
			emMsg('上传失败。文件上传目录(content/uploadfile)不可写');
			break;
		default:
			return $result;
			break;
	}
}

/**
 * 文件上传
 *
 * 返回的数组索引
 * mime_type 文件类型
 * size      文件大小(单位KB)
 * file_path 文件路径
 * width     宽度
 * height    高度
 * 可选值（仅在上传文件是图片且系统开启缩略图时起作用）
 * thum_file   缩略图的路径
 * thum_width  缩略图宽度
 * thum_height 缩略图高度
 * thum_size   缩略图大小(单位KB)
 *
 * @param string $fileName 文件名
 * @param string $errorNum 错误码：$_FILES['error']
 * @param string $tmpFile 上传后的临时文件
 * @param string $fileSize 文件大小 KB
 * @param array $type 允许上传的文件类型
 * @param boolean $isIcon 是否为上传头像
 * @param boolean $is_thumbnail 是否生成缩略图
 * @return array 文件数据 索引 
 * 
 */
function upload0($fileName, $errorNum, $tmpFile, $fileSize, $type, $isIcon = false, $is_thumbnail = true) {
	if ($errorNum == 1) {
		return '100'; //文件大小超过系统限制
	} elseif ($errorNum > 1) {
		return '101'; //上传文件失败
	}
	$extension = getFileSuffix($fileName);
	if (!in_array($extension, $type)) {
		return '102'; //错误的文件类型
	}
	if ($fileSize > Option::getAttMaxSize()) {
		return '103'; //文件大小超出emlog的限制
	}
	$file_info = array();
	$file_info['file_name'] = $fileName;
	$file_info['mime_type'] = get_mimetype($extension);
	$file_info['size'] = $fileSize;
	$file_info['width'] = 0;
	$file_info['height'] = 0;
	$uploadfile_path = "../../../uploadfile/";
	//echo $uploadfile_path;
	//die();
	$uppath = $uploadfile_path . gmdate('Ym') . '/';
	$fname = substr(md5($fileName), 0, 4) . time() . '.' . $extension;
	$attachpath = $uppath . $fname;
	//echo $attachpath;
	$file_info['file_path'] = $attachpath;
	//echo is_dir($uploadfile_path);
	//die();
	if (!is_dir($uploadfile_path)) {
		@umask(0);
		$ret = @mkdir($uploadfile_path, 0777);
		if ($ret === false) {
			return '104'; //创建文件上传目录失败
		}
	}
	if (!is_dir($uppath)) {
		@umask(0);
		$ret = @mkdir($uppath, 0777);
		if ($ret === false) {
			return '105'; //上传失败。文件上传目录(content/uploadfile)不可写
		}
	}
	doAction('attach_upload', $tmpFile);

	// 生成缩略图
	$thum = $uppath . 'thum-' . $fname;
	if ($is_thumbnail) {
		if ($isIcon && resizeImage($tmpFile, $thum, Option::ICON_MAX_W, Option::ICON_MAX_H)) {
			$file_info['thum_file'] = $thum;
			$file_info['thum_size'] = filesize($thum);
			$size = getimagesize($thum);
			if ($size) {
				$file_info['thum_width'] = $size[0];
				$file_info['thum_height'] = $size[1];
			}
			resizeImage($tmpFile, $uppath . 'thum52-' . $fname, 52, 52);
		} elseif (resizeImage($tmpFile, $thum, Option::get('att_imgmaxw'), Option::get('att_imgmaxh'))) {
			$file_info['thum_file'] = $thum;
			$file_info['thum_size'] = filesize($thum);
			$size = getimagesize($thum);
			if ($size) {
				$file_info['thum_width'] = $size[0];
				$file_info['thum_height'] = $size[1];
			}
		}
	}

	if (@is_uploaded_file($tmpFile)) {
		if (@!move_uploaded_file($tmpFile, $attachpath)) {
			@unlink($tmpFile);
			return '105'; //上传失败。文件上传目录(content/uploadfile)不可写
		}
		@chmod($attachpath, 0777);
	}
	
	// 如果附件是图片需要提取宽高
	if (in_array($file_info['mime_type'], array('image/jpeg', 'image/png', 'image/gif', 'image/bmp'))) {
		$size = getimagesize($file_info['file_path']);
		if ($size) {
			$file_info['width'] = $size[0];
			$file_info['height'] = $size[1];
		}
	}
	return $file_info;
}



if ($action == 'update') {
	//LoginAuth::checkToken();
	$nickname = isset($_POST['nickname']) ? addslashes(trim($_POST['nickname'])) : '';
	$email = isset($_POST['email']) ? addslashes(trim($_POST['email'])) : '';
	$photo = isset($_POST['photo']) ? addslashes(trim($_POST['photo'])) : '';
	$description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';
	$n = empty($nickname)?'<span style="color:red">昵称不能为空</span>':'';
	$y = empty($email)?'<span style="color:red">邮箱不能为空</span>':'';
	
	$photo_type = array('gif', 'jpg', 'jpeg','png');
	$usericon = $photo;

	if ($_FILES['photo']['size'] > 0) {
		$file_info = uploadFile0($_FILES['photo']['name'], $_FILES['photo']['error'], $_FILES['photo']['tmp_name'], $_FILES['photo']['size'], $photo_type, true);
		if (!empty($file_info['file_path'])) {
			$usericon = !empty($file_info['thum_file']) ? $file_info['thum_file'] : $file_info['file_path'];
		}
		$usericon = str_replace("../","",$usericon);
		$usericon = "../content/".$usericon;
	}
	
	if(!empty($email)){$y = !checkMail($email)?'<span style="color:red"> 邮箱格式不正确</span>':'';}
		if($n=='' AND $y==''){
			$DB = MySql::getInstance();
			$uid = $userData['uid'];
				$sql = "update ".DB_PREFIX."user set nickname='$nickname',email='$email',description='$description',photo='$usericon' where uid=$uid";
				if($DB->query($sql)){
					global $CACHE;
					$CACHE->updateCache(array('sta','user'));
					$msg["msg"]=1;
					$msg["goto"]=BLOG_URL."?user&info";
					//emMsg('修改成功!',BLOG_URL.'?plugin=user&action=index',true);
				}else{
					$msg["msg"]=0;
				}
				//echo json_decode($msg);
			
		}
	if($msg["msg"] == 1){
		emMsg('修改成功!',BLOG_URL.'?user&info',true);
	}else{
		emMsg('修改失败!',BLOG_URL.'?user&info',true);
		//emDirect("./blogger.php?active_edit=1");
	}
	
}


