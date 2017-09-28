<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/function.php');
$pervar		 = 'daigou';
require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/session.php');
$headtitle	 = $LG['name.nav_70']; //代购
require_once($_SERVER['DOCUMENT_ROOT'] . '/m/template/incluce/header.php');

if (!$ON_daigou) {
	exit("<script>alert('{$LG['daigou.45']}');goBack('uc');</script>");
}

//获取,处理
$typ		 = par($_GET['typ']);
$dgid		 = spr($_GET['dgid'], 0, 0); //禁止为0,否则token错误
$callFrom	 = 'member'; //member 会员中心

if (!$typ) {
	//添加-----------------------------------------------------------------------------
	$typ = 'add';
} elseif ($typ == 'edit') {

	//修改-----------------------------------------------------------------------------
	if (!$dgid) {
		exit("<script>alert('dgid{$LG['pptError']}');goBack();</script>");
	}
	$rs = FeData('daigou', '*', "dgid='{$dgid}' {$Mmy}");
	if ($dg_checked && spr($rs['status']) >= 2 || !$dg_checked && spr($rs['status']) >= 3) {
		exit("<script>alert('{$LG['lipei.form_1']}');goBack('uc');</script>");
	}
}
$tmp = make_NoAndPa(32);

//生成令牌密钥(为安全要放在所有验证的最后面)
$token		 = new Form_token_Core();
$tokenkey	 = $token->grante_token("daigou{$dgid}");
?>

<style>

	.hong{
		border-radius: 50%;
		width: .6rem;
		height: .6rem;
		background: #F1565A;
		text-align: center;
		position: absolute;
		margin-top: -1.4rem;
		font-size: .5rem;
		margin-left: .8rem;
	}
	.yindao{
		display:none;
		top:0;
		width: 100%;height: 100%;
		position: fixed;
		z-index: 99999;
		background: rgba(0,0,0,0.8);
		text-align: center;
		padding-top:30%; 
	}


	.main-1{
		background: #ededed;
	}
	.main-1-top{
		width: 100%;
		background: #fff6e1;
		color: #e87e57;
		padding: .7em;
		font-size: .8em;
		font-weight: bold;
		text-indent: 2em;
	}

	.div-1{
		margin: 0 auto;
		width: 100%;
		background: #FFFFFF;

	}


	.div-1-con{
		background: #FFFFFF;
		padding: .6em;
		padding-top: 1em;
	}
	.input_b{
		border-radius: 0.5em;
		border: 1px solid #ccc;
		line-height: 3em;
		font-size: .8em;
		height: 3em;
		margin-top: 1em;
	}
	.text-b {
		border-right:1px solid #ccc; 
		padding-left: 1em;
		padding-right: 1em;
		float: left;
		width: 18%;
		text-align: center;
	}
	.input_b .text-input{
		width:90%;
		float: left;
	}
	.input_b .text-input input{
		width: 98%;
		padding-left: 1em;
		height: 100%;
		border:0px;
		background-color:transparent;
		padding-top:.9em;
	}
	.input_b .text-input select{
		border:0px;
		background-color:transparent;
	}
	.input_b .text-input textarea{
		width: 100%;
		padding: .3em;
		border:0px;
		background-color:transparent;
		font-size:1em;
	}
	.btn-yuan{
		width: 85%;
		margin: 0 auto;
		background: #f1565a;
		color:#ffffff;
		height: 2.5em;
		line-height: 2.5em;
		border-radius:.5em;
		margin-top: 1em;
		margin-bottom:1em;
		border: 0px;
		font-size: .9em;
	}

	.div-2{
		width: 80%;
		background: #FFFFFF;
		border-bottom: 1px solid #ccc;
		float: left;
		padding-top: 1em;
		font-size: .8em;
		border-top: 3px solid #f1565a;
		margin: 0 auto;
	}
	.div-2-con{
		width: 90%;
		margin: 0 auto;
		margin-top: 1.5em;
		margin-bottom: 1.5em;
		font-size: .85em;
		text-align: left
	}
	.div-2-b{
		width: 100%;
		text-align: center;
		border-top:1px solid #CCCCCC;
		line-height: 2.5em;

	}
	.div-2-b .c1,.div-2-b .c3{
		width: 48%;
		float: left;
	}
	.div-2-b .c3{
		color: #f1565a;
	}
	.div-2-b .c2{
		float: left;
		width: 2%;
		color: #CCCCCC
	}
</style>

<div class="yindao" id="rhfz">
	<img src="/m/css/images/rhfz.png" style="width: 80%"/>
	<div>
		<div class="fa fa-close" onclick="$('#rhfz').hide();" style="color: #ffffff"></div>
	</div>
</div>

<div class="bc-bg" tabindex="0" data-control="PAGE" id="Page">



	<div class="uh cc-head ubb bc-border" data-control="HEADER" id="Header">
		<div class="ub">
			<div class="nav-btn" id="nav-left">
				<div class="fa fa-1g fa-chevron-left ub-img1" onclick="ylapp.window.close(1)">
				</div>
			</div>
			<h1 class="ut ub-f1 ulev-3 ut-s tx-c" tabindex="0">添加代购</h1>
			<div class="nav-btn" id="nav-right">
				<!--<div class="fa fa-1g ub-img1 fa-shopping-cart" style="margin-right: 1em;" onclick="ylapp.window.open('daigoucart', 'daigoucart.html', 2, 128);">
				</div>
				<div class="hong">1</div>-->
				<div class="fa fa-headphones ub-img1" onclick="ylapp.window.open('im', '/xamember/im.php', 2, 128);">
				</div>
			</div>
		</div>
		<div class="ub ub-ver ub-fv main-1">
			<div class="main-1-top">
				暂不支持购买虚拟物品<div style="float: right;padding-right: 2em;" class="fa fa-info" onclick="$('#tips').show();"></div>
			</div>
		</div>
	</div>

	<div class="uf sc-bg  bc-border" style="top: 4em;">
		<div class="div-1">
			<div class="div-1-con">
				<form action="m_save.php" method="post" class="form-horizontal form-bordered" name="xingao">
					<input name="typ" type="hidden" value="<?= add($typ) ?>">
					<input name="dgid" type="hidden" value="<?= $dgid ?>">
					<input name="tokenkey" type="hidden" value="<?= $tokenkey ?>">
					<input name="groupid"  type="hidden" value="<?= $Mgroupid ?>">
					<input name="userid" autocomplete="off"  type="hidden" value="<?= $Muserid ?>">
					<input name="username" autocomplete="off" type="hidden" value="<?= $Musername ?>">
					<input name="tmp" autocomplete="off" type="hidden" value="<?= $tmp ?>">

					<div class="input_b">
						<div class="text-input uinput" style="width: 65%;">
							<input type="text" placeholder="代购商品链接" id="address" name="address" value="<?= cadd($rs['address']) ?>" onBlur="daigouPar();">
						</div>
						<div class="uinn sc-text" onclick="$('#rhfz').show();" style="margin-top: -.3rem;width:32%;float: right">
							如何复制链接？
						</div>
					</div>

					<div class="input_b">

						<div class="text-input uinput">
							<input type="number" placeholder="寄库运费" name="freightFee" value="<?= spr($rs['freightFee'], 2, 0) ?>" onBlur="daigouPar();">

						</div>

					</div>
					<div style="font-size: .8rem;margin-top: 0.7rem">选择币种</div>
					<div class="input_b">

						<div class="text-input uinput">
							<select name="priceCurrency" onchange="daigouPar();" required data-placeholder="<?= $LG['currency']; //币种 ?>">
<?= openCurrency(cadd($_POST['priceCurrency'] . $rs['priceCurrency']), 3) ?>
							</select>
						</div>

					</div>
					
					<div style="font-size: .8rem;margin-top: 0.7rem">选择货源</div>

					<div class="input_b">

						<div class="text-input uinput">
							<select name="source" class="form-control select2me input-medium"  data-placeholder="<?= $LG['pleaseSelect']; //请选择 ?>" required onchange="get_source();daigouPar();">
<?php daigou_source(spr($rs['source']), 1) ?>
							</select>
						</div>
					</div>

					<div style="font-size: .8rem;margin-top: 0.7rem">选择品类</div>
					
					<div class="input_b">

						<div class="text-input uinput">
							<select name="brand" class="form-control select2me input-msmall"  data-placeholder="<?= $LG['pleaseSelect']; //请选择 ?>" >
<?php daigou_brand($rs['brand'], $Mgroupid, 1) ?>
							</select>
						</div>
					</div>

					<div class="input_b">

						<div class="text-input uinput">
							<input type="text" class="form-control" name="name" required value="<?= cadd($rs['name']) ?>" placeholder="品名/货号">
						</div>
					</div>

					<div class="input_b">

						<div class="text-input uinput">
							
							<input type="number" placeholder="自动补款限额" name="autoAddPay" value="<?=spr($_POST['autoAddPay'].$rs['autoAddPay'])?>">
						</div>
					</div>





					<!--<div class="input_b">

						<div class="text-input uinput">
							<input value="" type="text" id="tel" placeholder="代购商品（个/件）">
						</div>

					</div>-->
					<div style="font-size: .8rem;margin-top: 0.7rem">尺码、长度、形状、数量</div>
					<div class="input_b" style="height: 6em;">

						<div class="text-input uinput">
							<textarea  name="memberContent" placeholder="请详细描述尺码、长度、形状等"></textarea>
						</div>

					</div>

					<div style="font-size: .8rem;margin-top: 0.7rem">备注信息</div>
					<div class="input_b" style="height: 6em;">

						<div class="text-input uinput">
							<textarea placeholder="" name="content"></textarea>
						</div>

					</div>

					<div style="text-align: center">
						<button class="btn-yuan" type="submit" style="margin-top: 2em;" id="add_btn">
							完成添加
						</button>
					</div>     
				</form>
			</div>
		</div>
		<div class="yindao" id="tips">
			<div class="div-2" style="margin-left: 10%">
				<div>
					<center><i class="fa fa-info fa-2x" style="color: #f1565a"></i> 禁运物品知多少？</center>
				</div>
				<div class="div-2-con">
					亲~邮寄物品分国际管制和国内管制！<font color="#f1565a">禁运物品</font>寄到Jbuy中转仓也没办法帮您寄出去，为了给您更好的转运体验，请跟随小buy一起了解<font color="#f1565a">禁运物品</font>有哪些吧！
				</div>
				<div class="div-2-b">
					<div class="c1" onclick="ylapp.window.open('im', '/xamember/im.php', 2, 128);">咨询客服禁运物品</div>
					<div class="c2">|</div>
					<div class="c3" onclick="ylapp.window.open('faq', '/xamember/faq.php', 2, 128);">查看运转常见问题</div>
				</div>
			</div>
			<div style="clear:both;"></div>
			<div style="margin-top:1em;">
				<div class="fa fa-close" onclick="$('#tips').hide();" style="color: #ffffff"></div>
			</div>
		</div>
	</div>





</div>


<script>
//代购表单参数--------------------------------------------------------------
function daigouPar()
{
	var groupid=document.getElementsByName('groupid')[0].value;
	var source=document.getElementsByName('source')[0].value;
	var brand=0;	if(Number(source)==2){brand=document.getElementsByName('brand')[0].value;}
	var priceCurrency=document.getElementsByName('priceCurrency')[0].value;
	var groupid=document.getElementsByName('groupid')[0].value;
	var freightFee=document.getElementsByName('freightFee')[0].value;

	var tmp='';		if($('[name="tmp"]').length>0){	tmp=document.getElementsByName('tmp')[0].value;	}
	
	ylapp.ajax({
		url:'/public/ajax.php?n='+Math.random(),
		type:'post',
		data: 'lx=daigouPar&groupid='+groupid+'&brand='+brand+'&priceCurrency='+priceCurrency+'&tmp='+tmp+'&groupid='+groupid+'&freightFee='+freightFee+'&source='+source+'',
		datatype:'json',
		success:function(data){
			arr=unescape(data);
			arr =arr.split(",");
			/*
				字符串转数组
				arr[0] 折扣
				arr[1] 运费
			*/

			if(arr[0]==-1){msg='不支持该品牌';} 
			else if(arr[0]==10){msg='0';}
			document.getElementById('brandDiscount_msg').innerHTML=arr[0]; 
			document.getElementsByName('brandDiscount')[0].value=arr[0]; 

			if(!freightFee&&Number(arr[1])>0){document.getElementsByName('freightFee')[0].value=arr[1]; }
			if($('[id="priceCurrency_msg"]').length>0){document.getElementById('priceCurrency_msg').innerHTML=priceCurrency; }
			if($('[id="priceCurrency_msg3"]').length>0){document.getElementById('priceCurrency_msg3').innerHTML=priceCurrency; }
		},
	});
}


ylapp.ready(function() {
    
	daigouPar();
	get_source();
	
});

</script>

<script>
//货源类型处理--------------------------------------------------------------
function get_source()
{
	if(!document.getElementsByName("source")){return;}//判断元素是否存在
	var source=document.getElementsByName("source")[0].value;
	if(Number(source)==1){
		//线上网站==========================

		//品牌和折扣
		document.getElementById("brandShow").style.display ='none';
		document.getElementsByName("brand")[0].removeAttribute("required");
		
		//地址框
		document.getElementById("address_name").innerHTML='电商网址';
		document.getElementsByName("address")[0].setAttribute("required",true);
		document.getElementsByName("address")[0].setAttribute("class", "form-control input_txt_red");
	}else if(Number(source)==2){
		//线下专柜==========================
		
		//品牌和折扣
		document.getElementById("brandShow").style.display ='block';
		document.getElementsByName("brand")[0].setAttribute("required",true);
		
		//地址框
		document.getElementById("address_name").innerHTML='专柜地址';
		document.getElementsByName("address")[0].removeAttribute("required");
		document.getElementsByName("address")[0].setAttribute("class", "form-control");
	}
}
</script>