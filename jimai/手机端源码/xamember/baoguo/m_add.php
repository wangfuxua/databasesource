<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/function.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/session.php');

$headtitle = "添加包裹";

$ism = 1;

$lx='add';
$bg_zxyd=1;

$headtitle=$LG['name.nav_14'];//包裹预报
$submit_name=$LG['submit'];
if($bg_zxyd){$headtitle=$LG['baoguo.add_form_1'];$submit_name=$LG['baoguo.add_form_23'];}

require_once($_SERVER['DOCUMENT_ROOT'] . '/m/template/incluce/header.php');

if(!$off_baoguo||!$member_per[$Mgroupid]['ON_Mbaoguo']){exit ("<script>alert('{$LG['baoguo.add_form_2']}');goBack();</script>");}
if($bg_zxyd&&!$off_baoguo_zxyd){exit ("<script>alert('{$LG['baoguo.add_form_3']}');goBack();</script>");}
elseif(!$off_baoguo_zxyd&&!$off_baoguo_yubao){exit ("<script>alert('{$LG['baoguo.add_form_4']}');goBack();</script>");}

//生成令牌密钥(为安全要放在所有验证的最后面)
$token=new Form_token_Core();
$tokenkey= $token->grante_token("baoguo");

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
		padding-top: 1rem;
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
		padding-left: 1rem;
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
		margin-top:.66rem;
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


<div class="bc-bg" tabindex="0" data-control="PAGE" id="Page">
	<div class="uh cc-head ubb bc-border" data-control="HEADER" id="Header">
		<div class="ub">
			<div class="nav-btn" id="nav-left">
				<div class="fa fa-1g fa-chevron-left ub-img1" onclick="window.location.href='/m/'">
				</div>
			</div>
			<h1 class="ut ub-f1 ulev-3 ut-s tx-c" tabindex="0">添加包裹</h1>
			<div class="nav-btn" id="nav-right">

			</div>
		</div>
		<div class="ub ub-ver ub-fv main-1">
			<div class="main-1-top">
				<img src="/m/css/images/ad_1.png" onclick="ylapp.window.open('price', '/xamember/other/m_tab.php', 2, 128);"/>
			</div>
		</div>
	</div>

	<div class="uf sc-bg  bc-border" id="form" style="top: 8rem;">
		<div class="div-1">
			<div class="div-1-top">
				<i class="fa fa-edit fa-2x"></i> 填写寄往Jbuy的国内包裹<!--<span>(物流信息首页显示更新)</span>-->
			</div>
			<div class="div-1-con">
				<form action="/xamember/baoguo/m_add_save.php" method="post" class="form-horizontal form-bordered" name="xingao" id="form33">
		<input name="bg_zxyd" type="hidden" value="<?=add($bg_zxyd)?>">
		<input name="lx" type="hidden" value="<?=add($lx)?>">
		<input name="tokenkey" type="hidden" value="<?=$tokenkey?>">
		
		<div style="display:none;">
			<select name="warehouse[]"  class="form-control"  data-placeholder="<?=$LG['baoguo.add_form_12'];//选择?>" required style="width:150px;">
              <!--不能加select2me 复制行会失效并且不可点击--> 
              <?php warehouse('',1,1);?>
            </select>
		</div>
					<div class="input_b">
						<div class="text-b">物流单号</div>
						<div class="text-input uinput">
							<input name="bgydh[]"  type="text"   class="form-control" style="width:150px;" required id=""  title="<?=$LG['baoguo.add_form_11'];//如果没有运单号可填写购物的订单号?>" placeholder="包裹物流单号"/>	
					</div>
						<div class="uinn fa sc-text fa-qrcode" style="font-size: 1.2rem;" onclick="scanNo();">
						</div>
					</div>

					<div class="input_b">
						<div class="text-b">物流公司</div>
						<div class="text-input uinput select">
							<select required name="kuaidi[]"  id="" class="form-control"  data-placeholder="<?=$LG['baoguo.add_form_12'];//选择?>"  style="width:120px;">
              <!--不能加select2me 复制行会失效并且不可点击--> 
              <!--ID空时就不复制数据--> 
              <?php baoguo_kuaidi('');?>
            </select>
						</div>

					</div>

		<div class="input_b" style="height:5rem;">
						<div class="text-b" style="line-height:5rem;">包裹内容</div>
						<div class="text-input uinput" style="height:5rem;">
							<textarea required name="content[]" class="form-control" placeholder="<?=$LG['baoguo.add_form_14'];//请在此写入您的要求或者任何有利于区分货物、查询货物的信息，比如包装的重量长宽高等?>" style="border:0px;"></textarea>
						</div>
					</div>
					<center style="clear:both;">
						<button type="button" class="btn-yuan" style="margin-top: 2rem;" onclick="$('#form33').submit();">
							添加国内物流单
						</button>
					</center>     
				</form>
			</div>
		</div>
	</div>

	<div class="uf sc-bg  bc-border" style="top: 9rem;">
		<div class="div-1">
			<div class="div-1-top">
				<i class="fa fa-plane fa-2x"></i> 填不填单号，包裹已寄往Jbuy
			</div>
			<div class="div-2-con">
				<div class="img">
					<img src="/m/css/images/ad_2.png" />
				</div>
				<!--<div class="b-btn" onclick="ylapp.window.open('warehouse', 'warehouse.html', 2, 128);">查看包裹是否已经到达</div>-->
				<div class="b-btn" onclick="ylapp.window.open('im', '/xamember/im.php', 2, 128);">咨询客服</div>
			</div>
			<br/>
			<br/>
		</div>
	</div>
</div>




<script>
	ylapp.ready(function () {
		if (navigator.platform == "Win32") {
			$("#form").css("top", "9rem");
		}
	});

	function scanNo() {
		if (typeof uexScanner == "undefined") {
			alert("没有可调用的扫码程序");
		} else {
			uexScanner.open(function (error, data) {
				if (!error) {
					var code = data.code;
					$("#no").val(code);
					//alert("data:" + JSON.stringify(data));
				} else {
					alert("failed!");
				}
			});
		}
	}
</script>