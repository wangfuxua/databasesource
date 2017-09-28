<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/public/function.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/xamember/incluce/session.php');

$bg_zxyd=par($_POST['bg_zxyd']);

/*echo "<pre>";
print_r($_REQUEST);
exit;*/

//通用获取,处理-------------------------------------------------------------------------------------------
$lx=par($_REQUEST['lx']);
$tokenkey=par($_POST['tokenkey']);
$bgid='';
//添加=========================================================================================
if($lx=='add')
{
	
	$token=new Form_token_Core();
	$token->is_token('baoguo',$tokenkey); //验证令牌密钥

	//获取(数组不能加处理)***************************************************************
	$bgydh=$_POST['bgydh'];
	$kuaidi=$_POST['kuaidi'];
	$warehouse=$_POST['warehouse'];
	$fahuodiqu=$_POST['fahuodiqu'];
	$fahuotime=$_POST['fahuotime'];
	$wangzhan=$_POST['wangzhan'];
	$wangzhan_other=$_POST['wangzhan_other'];
	$content=$_POST['content'];
	
	$wupin_id_s=$_POST['wupin_id_s'];
	$wupin_id_b=$_POST['wupin_id_b'];
	$wupin_type=$_POST['wupin_type'];
	$wupin_name=$_POST['wupin_name'];
	$wupin_brand=$_POST['wupin_brand'];
	$wupin_spec=$_POST['wupin_spec'];
	$wupin_number=$_POST['wupin_number'];
	$wupin_unit=$_POST['wupin_unit'];
	$wupin_price=$_POST['wupin_price'];
	$wupin_total=$_POST['wupin_total'];
	$wupin_weight=$_POST['wupin_weight'];

	//不验证,因为返回会清空物品***************************************************************
		
	//处理***************************************************************
	$rc=0;$error_have=0;
	foreach($bgydh as $key=>$value)
	{
		$error_result=0;
		
		if(!$error_result&&!$bgydh[$key])
		{
			echo '<script>alert("'.$LG['baoguo.add_save_7'].'");window.history.go(-1);</script>';
			$error_result=1;$error_have=1;
		}

		if(!$error_result&&!$warehouse[$key])
		{
			echo '<script>alert("'.$bgydh[$key].'：'.$LG['baoguo.add_save_8'].'");window.history.go(-1);</script>';
			$error_result=1;$error_have=1;
		}

		//判断单号是否已经存在
		if(!$error_result)
		{
			$num=mysqli_num_rows($xingao->query("select bgydh from baoguo where bgydh='{$value}' "));
			if($num)
			{
				echo '<script>alert("'.$bgydh[$key].'：'.$LG['baoguo.add_save_9'].'");window.history.go(-1);</script>';
				$error_result=1;$error_have=1;
			}
		}

		if(!$error_result)
		{
	    	//保存部分-开始***************************************************************
			
			//保存包裹-开始
			$status=0;
			$xingao->query("insert into baoguo (`bgydh`,   `kuaidi`, `warehouse`, `fahuodiqu`, `fahuotime`, `wangzhan`, `wangzhan_other`,  `content`,`addSource`, `status`,`addtime`, `userid`,`useric`, `username`) values('".add($bgydh[$key])."','".add($kuaidi[$key])."','".add($warehouse[$key])."','".add($fahuodiqu[$key])."','".ToStrtotime($fahuotime[$key])."','".add($wangzhan[$key])."','".add($wangzhan_other[$key])."','".html($content[$key])."','1','{$status}','".time()."','{$Muserid}','{$Museric}','{$Musername}')");
			SQLError('添加');
			$rc+=mysqli_affected_rows($xingao);
			$fromid=mysqli_insert_id($xingao);
			//保存包裹-结束
			
			/*if($fromid>0&&$_POST['wupin_id_s'])
			{
				//处理保存物品-开始
				$fromtable='baoguo';//$fromid=0;
				$wupin_id_b_now=$wupin_id_b[$key];//大框ID  $wupin_id_b=$wupin_id_b[$key]; 不能用这种
				foreach($_POST['wupin_id_s'] as $key_w=>$value_w)//$_POST["wupin_id_s"]必须重新获取，否则只执行一次
				{
					$wupin_id_s=$value_w;//小框ID
					if($wupin_id_b_now==$wupin_id_s)//$wupin_id_b_now==$wupin_id_s判断该物品属于哪个包裹
					{	
						 foreach($_POST['wupin_name'.$wupin_id_s] as $key_line=>$value_line)
						 {
							  $xingao->query("insert into wupin (fromtable,fromid,wupin_type,wupin_name,wupin_brand,wupin_spec,wupin_price,wupin_unit,wupin_weight,wupin_number,wupin_total) values ('".add($fromtable)."','".spr($fromid)."','".add($_POST['wupin_type'.$wupin_id_s][$key_line])."','".add($_POST['wupin_name'.$wupin_id_s][$key_line])."','".add($_POST['wupin_brand'.$wupin_id_s][$key_line])."','".add($_POST['wupin_spec'.$wupin_id_s][$key_line])."','".spr($_POST['wupin_price'.$wupin_id_s][$key_line])."','".add($_POST['wupin_unit'.$wupin_id_s][$key_line])."','".spr($_POST['wupin_weight'.$wupin_id_s][$key_line])."','".spr($_POST['wupin_number'.$wupin_id_s][$key_line])."','".spr($_POST['wupin_total'.$wupin_id_s][$key_line])."')");
							  SQLError('保存物品');
						  }
					}
				}
				//处理保存物品-结束

				$bgid.=$fromid.',';//用于下运单
			}*/

	    	//保存部分-结束***************************************************************
	
		}//if(!$error_result){
	}//foreach($bgydh as $key=>$value)
	
	if($rc>0)
	{
		$token->drop_token('baoguo'); //处理完后删除密钥
		$str = LGtag($LG['baoguo.add_save_10']);
		//echo '<script>alert("'.$str.'<tag1>=='.$rc.'");window.location.href="/xamember/baoguo/m_add.php";</script>';
		echo '<script>alert("提交成功！");window.location.href="/xamember/baoguo/m_add.php";</script>';
		
	}else{
		echo '<script>alert('.$LG['baoguo.add_save_13'].');window.history.go(-1);</script>';
	}
}

?>