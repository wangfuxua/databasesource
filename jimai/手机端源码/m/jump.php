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
require_once($_SERVER['DOCUMENT_ROOT'].'/public/function.php');

//获取,处理
$prevurl = isset($_SERVER['HTTP_REFERER']) ? trim($_SERVER['HTTP_REFERER']) : '';
if($prevurl){
	if(stristr($prevurl,'/comments/')||stristr($prevurl,'/allnav')||stristr($prevurl,'cart.php')){//不转向

	}elseif(stristr($prevurl,'/m/')&&!isMobile()){//转向电脑版
		$url=str_ireplace('/m/','/',$prevurl);
	}elseif(!stristr($prevurl,'/m/')&&isMobile()){//转向移动版
		$url=str_ireplace("/{$_SERVER['HTTP_HOST']}/","/{$_SERVER['HTTP_HOST']}/m/",$prevurl);
	}
	
	if($url){echo 'location.href="'.$url.'";';}
}
?>

