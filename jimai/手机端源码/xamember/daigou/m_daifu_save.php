<?php
/*
软件著作权：=====================================================
软件名称：兴奥国际物流转运网站管理系统(简称：兴奥转运系统)V7.0
著作权人：广西兴奥网络科技有限责任公司
软件登记号：2016SR041223
网址：www.xingaowl.com
本系统已在中华人民共和国国家版权局注册，著作权受法律及国际公约保护！
版权所有，未购买严禁使用，未经书面许可严禁开发衍生品，违反将追究法律责任！
*/
require_once($_SERVER['DOCUMENT_ROOT'].'/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/public/function.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/xamember/incluce/session.php');


//获取,处理=====================================================
$my=par($_REQUEST['my']);
$lx='add';
$id=par(ToStr($_REQUEST['id']));
$tokenkey=par($_POST['tokenkey']);
$file=par($_POST['file'],'',1);
$status=par($_POST['status']);
$title=par($_POST['title']);
$content=html($_POST['content']);
$code=strtolower(par($_POST['code']));


echo "<pre>";
print_r($_REQUEST);
print_r($_FILES);
exit;

//添加、回复=====================================================
if($lx=='add')
{
	if(!$content){exit ("<script>alert('{$LG['msg.save_2']}');goBack();</script>");}
	
	if($off_code_liuyan)
	{
		if(!$code){exit ( "<script>alert('{$LG['codeEmpty']}');goBack();</script>");}
		
		$vname=xaReturnKeyVarname('gbook');
		if($code!=$_SESSION[$vname]){unset($_SESSION[$vname]);exit ( "<script>alert('{$LG['codeOverdue']}');goBack();</script>");}
		unset($_SESSION[$vname]);
	}

	//添加------------------------------------
	
	
	if(!$title){exit ("<script>alert('{$LG['msg.save_3']}');goBack();</script>");}

	//发站内信息
	$rc=SendMsg($Muserid,$Musername,add($title),html($content),$file,$from_userid='0',$from_username='',$new=0,$status,$issys=0,$xs=0);

	if($rc>0)
	{
		exit("<script>alert('{$LG['msg.save_4']}');location='m_list.php';</script>");
	}else{
		exit ("<script>alert('{$LG['msg.save_5']}');goBack();</script>");
	}


	
	
}


?>