<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/function.php');
$noper = 1;
require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/session.php');


$_SESSION['isMobile']	 = 1;
$ism					 = 1;
$m						 = '/m';
$addid=par($_GET['addid']);
if ($addid) {
	$headtitle = "编辑/查看地址";
	
	$rs=FeData('member_address','*',"addid='{$addid}' {$Mmy}");
	
} else {
	$headtitle = "新增地址";
}

//生成令牌密钥(为安全要放在所有验证的最后面)
$token=new Form_token_Core();
$tokenkey= $token->grante_token("address_add");

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
					<div class="fa fa-1g fa-chevron-left ub-img1" onclick="window.history.go( - 1)">
					</div>
				</div>
				<h1 class="ut ub-f1 ulev-3 ut-s tx-c" tabindex="0"><?php
				if ($addid) {
					echo "编辑地址";
				} else {
					echo "新增地址";
				}
				?></h1>
				<div class="nav-btn" id="nav-right">

				</div>
			</div>


		</div>

		<div class="uf sc-bg  bc-border" id="form" style="top: 3.3rem;padding-bottom: 5rem;">
		<div class="div-1">
			
			<div class="div-1-con">
				<form action="m_save.php" method="post"  id="form33">
		<input name="lx" type="hidden" value="add">
  <input name="addid" type="hidden" value="<?=$rs['addid']?>">
  <input name="addclass" type="hidden" value="2">
  <input name="checked" type="hidden" value="1">
  <input name="tokenkey" type="hidden" value="<?=$tokenkey?>">
		
		
					<div class="input_b">
						<div class="text-b">真实姓名</div>
						<div class="text-input uinput">
							<input name="truename" required value="<?=cadd($rs['truename'])?>"  type="text"   placeholder="姓名"/>	
						</div>
					</div>

					<div class="input_b">
						<div class="text-b">手机号码</div>
						<div class="text-input uinput select">
							<select data-placeholder="Select..." required name="mobile_code" style="width:40%;">
        <?php mobileCountry($rs['mobile_code'],1)?>
        </select>
								
							<input type="text" name="mobile" required value="<?=cadd($rs['mobile'])?>" placeholder="<?=$LG['address.pptForm1']?>" style="line-height: .8rem;width:50%;margin-left:5rem;margin-top:.2rem;">
							
						</div>
						
					</div>
  
  <div class="input_b">
						<div class="text-b">固定电话</div>
						<div class="text-input uinput">
							<input  name="tel"  value="<?=cadd($rs['tel'])?>" type="text"   placeholder=""/>	
						</div>
					</div>
  
					<div class="input_b">
						<div class="text-b">邮政编码</div>
						<div class="text-input uinput">
							<input  name="zip" value="<?=cadd($rs['zip'])?>" type="text"   placeholder=""/>	
						</div>
					</div>
  
  <div class="input_b">
						<div class="text-b">所在省份</div>
						<div class="text-input uinput">
							<input  name="add_shengfen" required value="<?=cadd($rs['add_shengfen'])?>" type="text"   placeholder=""/>	
						</div>
					</div>
  
  <div class="input_b">
						<div class="text-b">所在城市</div>
						<div class="text-input uinput">
							<input  name="add_chengshi" required value="<?=cadd($rs['add_chengshi'])?>" type="text"   placeholder=""/>	
						</div>
					</div>
  
  <div class="input_b">
						<div class="text-b">所在区镇</div>
						<div class="text-input uinput">
							<input  name="add_quzhen" required value="<?=cadd($rs['add_quzhen'])?>" type="text"   placeholder=""/>	
						</div>
					</div>
  <div class="input_b">
						<div class="text-b">详细地址</div>
						<div class="text-input uinput">
							<input  name="add_dizhi" required value="<?=cadd($rs['add_dizhi'])?>" type="text"   placeholder=""/>	
						</div>
					</div>
  
  
  
  

		<div class="input_b" style="height:5rem;">
						<div class="text-b" style="line-height:5rem;">地址备注</div>
						<div class="text-input uinput" style="height:5rem;">
							<textarea name="content" style="border:0px;"><?=cadd($rs['content'])?> </textarea>
						</div>
					</div>
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