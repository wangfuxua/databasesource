<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/public/function.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/xamember/incluce/session.php');


//获取,处理=====================================================
$lx=par($_REQUEST['lx']);
$tokenkey=par($_POST['tokenkey']);

$truename=par($_POST['truename']);
$mobile_code=par($_POST['mobile_code']);
$mobile=par($_POST['mobile']);
$addid=par(ToStr($_REQUEST['addid']));

/*
echo "<pre>";
print_r($_REQUEST);
exit;*/

//添加,修改=====================================================
if($lx=='add'||$lx=='edit')
{
	//通用验证------------------------------------
	$token=new Form_token_Core();
	$token->is_token("address_add",$tokenkey); //验证令牌密钥
	
	if(!$truename||!$mobile_code||!$mobile){exit ("<script>alert('{$LG['address.pptSave1']}');window.history.go(-1);</script>");}//请填写/选择姓名、手机地区、手机号码！
	    
	if(!$_POST['add_shengfen']||!$_POST['add_chengshi']||!$_POST['add_quzhen']||!$_POST['add_dizhi']){exit ("<script>alert('{$LG['address.pptSave2']}');window.history.go(-1);</script>");}//请填写完整地址资料！
	
	//验证地址资料
	$Receive=CheckReceive('address');
	if($Receive){exit ("<script>alert('{$Receive}');window.history.go(-1);</script>");}
	
	//添加------------------------------------
	if(!$addid)
	{
		$_POST['addtime']=time();
		$_POST['edittime']=time();

		$savelx='add';//调用类型(add,edit,cache)
		$getlx='POST';//获取类型(POST,GET,REQUEST,SQL)
		$alone='addid,old_shenfenimg_z,old_shenfenimg_b';//不处理的字段
		$digital='addclass,checked,mrf,mrs';//数字字段
		$radio='';//单选、复选、空文本、数组字段
		$textarea='content';//过滤不安全的HTML代码
		$date='';//日期格式转数字
		$save=XingAoSave($_POST,$getlx,$savelx,$alone,$digital,$radio,$textarea,$html,$date);
		
		$xingao->query("insert into member_address (".$save['field'].",userid,username) values(".$save['value'].",'{$Muserid}','{$Musername}')");
		SQLError('添加');
		$rc=mysqli_affected_rows($xingao);
		if($rc>0)
		{
			$token->drop_token("address_add"); //处理完后删除密钥
			exit("<script>alert('{$LG['pptAddSucceed']}');location='m_list.php';</script>");
		}else{
			exit ("<script>alert('{$LG['pptAddFailure']}');window.history.go(-1);</script>");
		}
	} else
	
	//修改------------------------------------
	{
		
		$_POST['edittime']=time();

		//更新
		$savelx='edit';//调用类型(add,edit,cache)
		$getlx='POST';//获取类型(POST,GET,REQUEST,SQL)
		$alone='addid,old_shenfenimg_z,old_shenfenimg_b';//不处理的字段
		$digital='addclass,checked';//数字字段
		$radio='';//单选、复选、空文本、数组字段
		$textarea='content';//过滤不安全的HTML代码
		$date='';//日期格式转数字
		$save=XingAoSave($_POST,$getlx,$savelx,$alone,$digital,$radio,$textarea,$html,$date);
		$xingao->query("update member_address set ".$save." where addid='{$addid}' {$Mmy}");
		SQLError();		
		$rc=mysqli_affected_rows($xingao);

		$token->drop_token("address_add"); //处理完后删除密钥
		if($rc>0)
		{
			$ts=$LG['pptEditSucceed'];
		}else{
			$ts=$LG['pptEditNo'];
		}
		exit("<script>alert('".$ts."');location='m_list.php';</script>");
	}
	
	
	
//删除=====================================================
}elseif($lx=='del'){
	
	if(!$addid){exit ("<script>alert('addid{$LG['pptError']}');window.history.go(-1);</script>");}
	
	//删除文件
	$query="select shenfenimg_z,shenfenimg_b from member_address where addid in ({$addid}) and (shenfenimg_z<>'' or shenfenimg_b<>'')  {$Mmy}";
	$sql=$xingao->query($query);
	while($rs=$sql->fetch_array())
	{
		DelFile($rs['shenfenimg_z']);
		DelFile($rs['shenfenimg_b']);
	}
	
	$xingao->query("delete from member_address where addid in ({$addid})  {$Mmy}");
	$rc=mysqli_affected_rows($xingao);
	
	if($rc>0){
		exit("<script>alert('{$LG['pptDelSucceed']}{$rc}');location='m_list.php';</script>");
	}else{
		exit("<script>alert('{$LG['pptDelEmpty']}');location='m_list.php';</script>");
	}
	
}
//修改默认发货,收货地址=====================================================
elseif($lx=='mr'){
	if(!$addid){exit ("<script>alert('addid{$LG['pptError']}');window.history.go(-1);</script>");}
	$mrf=(int)$_GET["mrf"];
	$mrs=(int)$_GET["mrs"];

	if($mrf==1)
	{
		$xingao->query("update member_address set mrf='0' where mrf='{$mrf}'{$Mmy}");SQLError();
		$xingao->query("update member_address set mrf='{$mrf}' where addid={$addid} {$Mmy}");SQLError();
	}
	elseif($mrf==2)
	{
		$xingao->query("update member_address set mrf='0' where addid={$addid} {$Mmy}");SQLError();
	}
	elseif($mrs==1)
	{
		$xingao->query("update member_address set mrs='0' where mrs='{$mrs}'{$Mmy}");SQLError();
		$xingao->query("update member_address set mrs='{$mrs}' where addid={$addid} {$Mmy}");SQLError();
	}
	elseif($mrs==2)
	{
		$xingao->query("update member_address set mrs='0' where addid={$addid} {$Mmy}");SQLError();
	}
	
	exit("<script>location='m_list.php';</script>");
}
//修改属性=====================================================
elseif($lx=='addclass'){
	$addclass=(int)$_POST["addclass"];
	
	if(!CheckEmpty($addclass)){exit ("<script>alert('{$LG['address.pptSave3']}');window.history.go(-1);</script>");}//请选择类型！
	//更新主信息状态
	$xingao->query("update member_address set addclass='{$addclass}' where addid in ({$addid}) {$Mmy}");
	SQLError();
	$rc=mysqli_affected_rows($xingao);
	if($rc>0){
		exit("<script>location='m_list.php';</script>");
	}else{
		exit("<script>alert('{$LG['pptEditEmpty']}');window.history.go(-1);</script>");
	}
}

?>