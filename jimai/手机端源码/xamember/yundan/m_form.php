<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/function.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/session.php');


$groupid = $Mgroupid;
require_once($_SERVER['DOCUMENT_ROOT'] . '/xingao/yundan/call/get_price.php');

$headtitle = $LG['name.nav_67']; //运单


$_SESSION['isMobile']	 = 1;
$ism					 = 1;
$m						 = '/m';

//获取,处理
$lx			 = par($_GET['lx']);
$ydid		 = par($_GET['ydid']);
$addSource	 = spr($_GET['addSource']);
$bg_zxyd	 = par($_GET['bg_zxyd']);
$fx			 = spr($_GET['fx']);
$fx_total	 = spr($_GET['fx_total']);
$fx_number	 = spr($_GET['fx_number']);
$bgid		 = par(ToStr($_REQUEST['bgid']));
$goid		 = par(ToStr($_REQUEST['goid']));
$warehouse	 = spr($_GET['warehouse']);
$country	 = spr($_GET['country']);
$channel	 = spr($_GET['channel']);
$callFrom	 = 'member'; //manage member

if ($_GET['tag']) {
	$_SESSION[$_GET['tag']] = '';
}
if ($fx_total) {
	$fx_count = $fx_total - $fx_number + 1;
}

if (!$lx) {
	$lx = 'add';
}

if ($ydid) {
	$headtitle = "编辑运单";
} else {
	$headtitle = "新增运单";
}

//修改==============
if ($lx == 'edit') {
	if (!$ydid) {
		exit("<script>alert('ydid{$LG['pptError']}');window.history.go(-1);</script>");
	}
	$rs = FeData('yundan', '*', "ydid='{$ydid}' {$Mmy}");
	if (spr($rs['status']) > 1) {
		exit("<script>alert('{$LG['yundan.form_1']}');window.history.go(-1);</script>");
	}

	$bgid			 = cadd($rs['bgid']);
	$goid			 = cadd($rs['goid']);
	$bg_number		 = arrcount($rs['bgid']);
	$go_number		 = arrcount($rs['goid']);
	$addSource		 = spr($rs['addSource']);
	$weightEstimate	 = spr($rs['weightEstimate']);

	//必须优先用所传参数,否则无法修改这3个
	if (!$warehouse) {
		$warehouse = $rs['warehouse'];
	}
	if (!$country) {
		$country = $rs['country'];
	}
	if (!$channel) {
		$channel = $rs['channel'];
	}

	//备案渠道:新渠道商品分类限制是否支持旧渠道的商品分类限制:检查新渠道是否可以保留旧渠道的物品
	$customs_types_limit_old = channelPar($rs['warehouse'], $rs['channel'], 'customs_types_limit');
	$customs_types_limit_new = channelPar($_GET['warehouse'], $_GET['channel'], 'customs_types_limit');
	if ($customs_types_limit_new && $_GET['warehouse'] && $_GET['channel']) {
		if (!have($customs_types_limit_new, $customs_types_limit_old)) {
			$wupinNotKeep = 1;
		}//$wupinNotKeep=1 清空物品
	}

	//包裹/代购下单时
	$customs_old = channelPar($rs['warehouse'], $rs['channel'], 'customs');
	$customs_new = channelPar($_GET['warehouse'], $_GET['channel'], 'customs');
	if (($addSource == 1 || $addSource == 7) && $customs_new != $customs_old && $_GET['warehouse'] && $_GET['channel']) {
		exit("<script>alert('{$LG['yundan.31']}');window.history.go(-1);</script>"); //只能选择同类型渠道,如要选择该渠道,请删除该运单并重新下单
	}
}




//下单==============
elseif ($lx == 'add') {
	//直接下单----------------------------------------------------------------------------------
	if (!$addSource) {
		$addSource = 2;
		if (!$member_per[$Mgroupid]['off_zjxd']) {
			exit("<script>alert('{$LG['yundan.form_2']}');window.history.go(-1);</script>");
		}

		//包裹下单----------------------------------------------------------------------------------
	} elseif ($addSource == 1) {

		if (!$off_baoguo || !$member_per[$Mgroupid]['ON_Mbaoguo']) {
			exit("<script>alert('{$LG['baoguo.add_form_2']}');window.history.go(-1);</script>");
		}
		if (!$bgid) {
			exit("<script>alert('{$LG['yundan.form_3']}');window.history.go(-1);</script>");
		}

		$r				 = baoguo_deliveryCHK($bgid);
		$warehouse		 = $r['warehouse'];
		$bgid			 = $r['bgid'];
		$weightEstimate	 = $r['weightEstimate'];  //if($ON_yundan_prepay&&$weightEstimate){$weightEstimate+=0.5;}//多加点重量,减少后期补款流程
		$addid			 = $r['addid'];
		$bg_number		 = arrcount($r['bgid']);

		//代购下单----------------------------------------------------------------------------------
	} elseif ($addSource == 7) {

		if (!$ON_daigou || !$member_per[$Mgroupid]['daigou']) {
			exit("<script>alert('{$LG['daigou.45']}');goBack('c');</script>");
		}
		if (!$goid) {
			exit("<script>alert('{$LG['daigou.187']}');goBack('c');</script>");
		}

		//获取代购单资料
		$gd	 = FeData('daigou_goods', 'dgid,addid', "goid in ({$goid})");
		$dg	 = FeData('daigou', 'status,warehouse', "dgid='{$gd['dgid']}'");

		$warehouse	 = $dg['warehouse'];
		$goid		 = $goid;
		//$weightEstimate=	$r['weightEstimate'];//在wupin_from_general( 有全局返回
		$addid		 = $gd['addid'];
		$go_number	 = arrcount($goid);
	}
}


//变更渠道时,显示不同物品表单
$status = "lx={$lx}&ydid={$ydid}&addSource={$addSource}&bg_zxyd={$bg_zxyd}&fx={$fx}&fx_total={$fx_total}&fx_number={$fx_number}&bgid={$bgid}&goid={$goid}&warehouse={$warehouse}&country={$country}&channel={$channel}";

//生成令牌密钥(为安全要放在所有验证的最后面)
$token		 = new Form_token_Core();
$tokenkey	 = $token->grante_token("yundan");

require_once($_SERVER['DOCUMENT_ROOT'] . '/m/template/incluce/header.php');
?>

<style>
	.main-1{
		background: #ededed;
	}
	.main-1-top{
		width: 95%;
		text-align: center;
		margin: 0 auto;
	}
	.main-1-top img{
		width: 100%;
	}

	.div-1{
		margin: 0 auto;
		width: 95%;
	}
	.div-1-top{
		padding: .5rem;
		background: #f1565a;
		color: #fff;
		border-radius: 1rem 1rem 0px 0px;
		font-size: .8rem;
		text-indent: .5rem
	}
	.div-1-top span{
		font-size: 0.7rem;
	}
	.div-1-con{
		background: #FFFFFF;
		padding: .6rem;
	}
	.input_b{
		border-radius: 0.5rem;
		border: 1px solid #ccc;
		line-height: 3rem;
		font-size: .8rem;
		height: 3rem;
		margin-top: 1rem;
	}
	.text-b {
		border-right:1px solid #ccc; 
		padding-left: 1rem;
		padding-right: 1rem;
		float: left;

	}
	.input_b .text-input{
		width:60%;
		float: left;
	}
	.input_b .text-input input[type='text']{
		width: 98%;
		padding-left: .5rem;
		height: 100%;
		border:0px;
		background-color:transparent;
		padding-top:.9rem;
	}
	.input_b .text-input select{
		width: 98%;
		padding: 0px;
		padding-left: 1rem;
		height: 100%;
		border:0px;
		background-color:transparent;
		margin-top:.1rem;
		color: #6a6a6a;
		font-size:.8rem;

	}
	.btn-yuan{
		width: 70%;
		margin: 0 auto;
		background: #f1565a;
		color:#ffffff;
		height: 2rem;
		line-height: 2rem;
		border-radius:.5rem;
		margin-top: 1rem;
		margin-bottom:1rem;
		border: 0px;
		font-size: .9rem;
	}
	.div-2-con{
		background: #FFFFFF;
		padding-top: .8rem;
		text-align: center;
	}
	.div-2-con .img img{
		width: 60%;
	}
	.b-btn{
		background: #f1565a;
		height: 2.5rem;
		line-height: 2.5rem;
		font-size:.85rem;
		color: #ffffff;
	}
</style>


<div class="bc-bg" tabindex="0" data-control="PAGE" id="Page" style="background:#eeeeee">
	<div class="uh cc-head  ubb bc-border" data-control="HEADER" id="Header">
		<div class="ub">
			<div class="nav-btn" id="nav-left">
				<div class="fa fa-1g fa-chevron-left ub-img1" onclick="window.history.go(-1)">
				</div>
			</div>
			<h1 class="ut ub-f1 ulev-3 ut-s tx-c" tabindex="0"><?php
if ($ydid) {
	echo "编辑运单";
} else {
	echo "新增运单";
}
?></h1>
			<div class="nav-btn" id="nav-right">

			</div>
		</div>


	</div>

	<div class="uf sc-bg  bc-border" id="form" style="top: 3.3rem;padding-bottom: 5rem;">
		<div class="div-1">

			<div class="div-1-con">
				<form action="m_save.php" method="post" class="form-horizontal form-bordered" name="xingao">
					<input name="lx" type="hidden" value="<?= add($lx) ?>">
					<input name="ydid" type="hidden" value="<?= $rs['ydid'] ?>">
					<input name="bgid" type="hidden" value="<?= $bgid ?>">
					<input name="goid" type="hidden" value="<?= $goid ?>">
					<input name="bg_zxyd" type="hidden" value="<?= $bg_zxyd ?>" />
					<input name="tokenkey" type="hidden" value="<?= $tokenkey ?>">

					<!-- 用于获取计算费用-->
					<input name="bg_number" type="hidden" value="<?= $bg_number ?>" />
					<input name="go_number" type="hidden" value="<?= $go_number ?>" />

					<input name="addSource" type="hidden" value="<?= $addSource ?>" />

<?php if (spr($rs['status']) == 1) { ?>
						<div class="input_b">
							<div class="text-b">申请重审</div>
							<div class="text-input uinput">
								<input type="checkbox" class="toggle" name="status" value="0"  <?php if (spr($rs['status']) == 0) {
		echo 'checked';
	} ?> />
							</div>
						</div>
<?php } ?>

					<!--是包裹下单-------------------------------------------------------------------->
<?php if ($addSource == 1) { ?>
						哈哈哈哈
						<!--代购下单-------------------------------------------------------------------->
<?php } elseif ($addSource == 7) { ?>
						快快快快快快
						<!--直接下单-------------------------------------------------------------------->
<?php } else { ?>
						<div class="input_b">
							<div class="text-b">所在仓库</div>
							<div class="text-input uinput">
								<select name="warehouse" required  data-placeholder="<?= $LG['yundan.form_18']; //请选择 ?>" onChange="refresh_form();"><!--country_show('<?= $Mgroupid ?>','<?= spr($country) ?>');-->
	<?php warehouse($warehouse, 1); ?>
								</select>
								<script>

	//刷新表单页
									function refresh_form() {
										if ($('[name="warehouse"]').length <= 0 || $('[name="channel"]').length <= 0) {
											return;
										}//不存在
										var warehouse = document.getElementsByName('warehouse')[0].value;
										var channel = document.getElementsByName('channel')[0].value;

										var fx_number = 0;
										if ($('[name="fx_number"]').length > 0)
										{
											fx_number = document.getElementsByName('fx_number')[0].value;
										}


										//获取单选值
										var fx = 0;
										if ($('[name="fx"]').length > 0)
										{
											var eless = document.getElementsByName("fx");//必须用Name
											for (var i = 0; i < eless.length; i++)
											{
												if (eless[i].checked)
												{
													var fx = eless[i].value;//必须加var全局变量 
													break;//获取后退出，不再获取后面 
												}
											}
											if (typeof (fx) == "undefined") {
												var fx = 0;
											}//判断
										}

										if (fx == 0) {
											fx_number = 0;
										}


										//后台用
										var username = '';
										if ($('[name="username"]').length > 0) {
											username = $('[name="username"]')[0].value;
										}
										var userid = '';
										if ($('[name="userid"]').length > 0) {
											userid = $('[name="userid"]')[0].value;
										}

										//通用:URL需要有国家
										var country = '';
										if ($('[name="country"]').length > 0) {
											country = $('[name="country"]')[0].value;
										}
										if ($('[name="tag"]').length > 0) {
											tag = $('[name="tag"]')[0].value;
										}
										//刷新页面
										location = '?lx=add&ydid=&addSource=2&bg_zxyd=&fx=0&fx_total=0&fx_number=0&bgid=&goid=&warehouse=0&country=0&channel=0&tag=' + tag + '&warehouse=' + warehouse + '&country=' + country + '&channel=' + channel + '&username=' + username + '&userid=' + userid + '&fx=' + fx + '&fx_number=' + fx_number + '';

									}
								</script>
							</div>
						</div>
<?php } ?>




<?php if ($ON_country) { ?>
						<div class="input_b">
							<div class="text-b">寄往国家</div>
							<div class="text-input uinput">
								<select class="form-control select2me xa_select2" data-placeholder="请选择" name="country" required="" onchange="refresh_form();">
									<option value="601" selected="">澳大利亚</option>
								</select>
							</div>
						</div>
<?php } else { ?>
						<input type="hidden"  name="country" value="<?= $country ? $country : $openCountry; ?>">
<?php } ?>

					<div class="input_b">
						<div class="text-b"><?=$LG['yundan.form_19'];//运输渠道?></div>
						<div class="text-input uinput">
							<span id='channel'></span>
						</div>
					</div>
<?php if($addSource==2){?>
					<div class="input_b">
						<div class="text-b">邮寄单号</div>
						<div class="text-input uinput">
							<input  name="add_chengshi" required value="<?= cadd($rs['add_chengshi']) ?>" type="text"   placeholder=""/>	
						</div>
					</div>
						
						<?php }?>

					<!--

					<div class="input_b" style="height:5rem;">
						<div class="text-b" style="line-height:5rem;">地址备注</div>
						<div class="text-input uinput" style="height:5rem;">
							<textarea name="content" style="border:0px;"><?= cadd($rs['content']) ?> </textarea>
						</div>
					</div>-->
					<!--<center style="clear:both;">
						<button type="button" class="btn-yuan" style="margin-top: 2rem;" onclick="$('#form33').submit();">
							添加国内物流单
						</button>
					</center>   -->  
				</form>
			</div>
		</div>
	</div>


	

	<div style="background: #FFFFFF;padding-top: .5rem;padding-bottom:.5rem;text-align: center;position: fixed;bottom: 0;width: 100%;">
		<div class="btn-yuan" onclick="$('#form33').submit();">提 交</div>
	</div>