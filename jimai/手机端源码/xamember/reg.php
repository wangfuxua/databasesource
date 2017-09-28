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
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/function.php');
$noper = 1;
require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/session.php');

//验证手机版
if (isMobile()) {
	$_SESSION['isMobile']	 = 1;
	$ism					 = 1;
	$m						 = '/m';
} else {
	$_SESSION['isMobile'] = 0;
}

if ($Muserid && $_COOKIE["member_cookie"]) {
	echo '<script language=javascript>';
	echo 'location.href="main.php";';
	echo '</script>';
	XAtsto('main.php');
}

//获取,处理
$lx		 = par($_GET['lx']);
$groupid = par($_GET['groupid']);
if (!$lx) {
	$lx = 'add';
}
$headtitle = $LG['reg.headtitle']; //会员注册

if (!$off_member_reg) {
	exit("<script>alert('{$LG['reg.CloseReg']}');goBack('uc');</script>");
}

//生成令牌密钥(为安全要放在所有验证的最后面)
$token		 = new Form_token_Core();
$tokenkey	 = $token->grante_token("memberreg");
?>
<link href="/bootstrap/css/pages/reg.css" rel="stylesheet" type="text/css"/>
<link href="/css/member.css" rel="stylesheet" type="text/css"/>
<link href="/bootstrap/css/themes/<?= $theme_member ?>" rel="stylesheet" type="text/css" id="style_color"/>
<?php
if ($ism) {
	require_once($_SERVER['DOCUMENT_ROOT'] . '/m/template/incluce/header.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/m/template/incluce/top.php');
	echo '<link href="/css/xingao_m.css" rel="stylesheet" type="text/css"/>';
} else {
	require_once($_SERVER['DOCUMENT_ROOT'] . '/template/incluce/header.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/template/incluce/nav.php');
	echo '<style>.gb_member {background-image: url(/images/gb_member_reg_' . rand(1, 3) . '.jpg);}</style>';
}
?>

<?php
if (!$ism) {
	?>

	<!--内容开始-->
	<div class="gb_member">
		<div class="reg">
			<div class="content"> 
				<!-- BEGIN LOGIN FORM -->
				<form class="form-horizontal form-bordered" name="xingao" action="reg_save.php" method="post">
					<input name="lx" type="hidden" value="<?= $lx ?>">
					<input name="tokenkey" type="hidden" value="<?= $tokenkey ?>">
					<h3 class="form-title">
						<?= $headtitle ?>
						<?= $tobind ? ' (' . $LG['reg.BindingAccounts'] . ')' : '' ?>
					</h3>

					<?php
					$group	 = '';
					$query2	 = "select groupid,groupname{$LT} from member_group where checked=1 and regchecked=1 order by myorder desc, groupname{$LT} asc,groupid desc";
					$sql2	 = $xingao->query($query2);
					while ($rs2	 = $sql2->fetch_array()) {
						$group		 .= '<option value="' . $rs2['groupid'] . '" ' . ($rs2['groupid'] == $groupid ? ' selected ' : '') . ' >' . cadd($rs2['groupname' . $LT]) . '</option>';
						$rsgroupid	 = $rs2['groupid'];
					}
					$rc = mysqli_affected_rows($xingao);
					if (!$group) {
						exit("<script>alert('{$LG['reg.CloseGroup']}');goBack('uc');</script>");
					}
					?>


					<?php if ($rc > 1) { ?>
						<div class="form-group">
							<label class="control-label col-md-3"><?= $LG['reg.groupid']; //注册类型        ?></label>
							<div class="col-md-9 has-error">
								<select  class="form-control input-medium" data-placeholder="Select..." name="groupid">
									<?= $group ?>
								</select>
							</div>
						</div>
					<?php } else { ?>
						<input name="groupid" type="hidden" value="<?= $rsgroupid ?>">     
					<?php } ?>



					<?php if (arrcount($me_openCurrency) > 1) { ?>
						<div class="form-group">
							<label class="control-label col-md-3"><?= $LG['currency']; //币种        ?></label>
							<div class="col-md-9 has-error">
								<select name="currency" class="form-control input-small select2me" required data-placeholder="币种">
									<?= openCurrency('', 4) ?>
								</select>
								<span class="help-block"><?= $LG['reg.currency']//请注意选择，注册后不可更改        ?></span>
							</div>
						</div>
					<?php } else { ?> 
						<input name="currency" type="hidden" value="<?= $me_openCurrency ?>">     
					<?php } ?>



					<div class="form-group">
						<label class="control-label col-md-3"><?= $LG['reg.username']; //注册账号         ?></label>
						<div class="col-md-9 has-error">
							<input type="text" class="form-control input-medium" name="username" autocomplete="off" id="username" required 
								   maxlength="50" onBlur="check_username();"
								   placeholder="<?php
								   if ($member_reg_lx == 1) {
									   echo $LG['reg.EmailAccounts'];
								   } elseif ($member_reg_lx == 2) {
									   echo $LG['reg.EmailLimit'];
								   } elseif ($member_reg_lx == 3) {
									   echo $LG['reg.LetterLimit'];
								   }
								   ?>">
							<span class="help-block red" id="msg_username"></span> </div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-3">
							<?php
							if ($member_reg_lx == 1) {
								echo $LG['reg.EmailConfirm'];
							} else {
								echo $LG['reg.EmailUsed'];
							}
							?>
						</label>
						<div class="col-md-9 has-error">
							<input type="text" class="form-control input-medium" name="email" id="email" required 
								   maxlength="50" onBlur="check_email();"
								   onselectstart="return false" oncopy="return false" onpaste="return false"
								   placeholder="<?php
								   if ($member_reg_lx == 1) {
									   echo $LG['reg.EmailRepeat'];
								   } else {
									   echo $LG['reg.EmailUsedIn'];
								   }
								   ?>">
							<span class="help-block red" id="msg_email"></span> </div>
					</div>


					<?php if ($off_reg_email) { ?>
						<div class="form-group">
							<label class="control-label col-md-3"><?= $LG['reg.email_yz']; //邮箱验证        ?></label>
							<div class="col-md-9 has-error">
								<input type="text" class="form-control input-small" name="email_yz"  required  maxlength="10" placeholder="<?= $LG['reg.ResultCode'] ?>">
								<button type="button" class="btn btn-warning" onClick="SendEmail_yz();"><i class="icon-rss"></i> <?= $LG['reg.GetCode'] ?> </button>
								<span class="help-block" id="msg_email_yz"></span>
							</div>
						</div>
					<?php } ?>

					<?php if ($ON_nickname) { ?>
						<div class="form-group">
							<label class="control-label col-md-3"><?= $LG['data.nickname']; //昵称         ?></label>
							<div class="col-md-9 <?= $ON_nickname ? 'has-error' : '' ?>">
								<input type="text" class="form-control input-medium" maxlength="50" <?= $ON_nickname ? 'required' : '' ?>  name="nickname">
								<span class="help-block"><?= $LG['data.save_35'] ?></span>
							</div>
						</div>
					<?php } ?>


					<div class="form-group">
						<label class="control-label col-md-3"><?= $LG['reg.password']; //登录密码         ?></label>
						<div class="col-md-9 has-error">
							<input type="password" class="form-control input-medium" name="password" autocomplete="off"  id="password" required 
								   maxlength="50" onKeyUp="check_password('{$LG['reg.LimitWord']}');" placeholder="<?= $LG['reg.LimitPassword']; //请输入复杂的密码        ?>">
							<span class="help-block" id="msg_password"></span>
						</div>
					</div>


					<div class="form-group">
						<label class="control-label col-md-3"><?= $LG['reg.password2']; //确认密码         ?></label>
						<div class="col-md-9 has-error">
							<input type="password" class="form-control input-medium" name="password2" id="password2" required 
								   maxlength="50" onBlur="check_password2();"
								   placeholder="<?= $LG['reg.RepeatPassword']; //再次输入密码        ?>">
							<span class="help-block red" id="msg_password2"></span>
						</div>
					</div>


					<?php if ($off_reg_mobile && $off_sms) { ?>
						<div class="form-group">
							<label class="control-label col-md-3"><?= $LG['reg.mobile_code']; //手机国家         ?></label>
							<div class="col-md-9">
								<select  class="form-control input-medium" data-placeholder="Select..." name="mobile_code" id="mobile_code">
									<?php mobileCountry(86, 1) ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3"><?= $LG['reg.mobile']; //手机号码         ?></label>
							<div class="col-md-9 has-error">
								<input type="text" class="form-control input-medium" name="mobile" id="mobile" required maxlength="20" placeholder="<?= $LG['reg.RealMobileIn']; //请填写真实手机号码         ?>">
								<span class="help-block" id="msg_sj"></span> </div>
						</div>
						<!--不能在此限制发送时间，当手机写错就不能再发送-->

						<div class="form-group">
							<label class="control-label col-md-3"><?= $LG['reg.mobile_yz']; //手机验证        ?></label>
							<div class="col-md-9 has-error">
								<input type="text" class="form-control input-small" name="mobile_yz"  required  maxlength="10"  placeholder="<?= $LG['reg.ResultCode']; //收到校验码         ?>">
								<button type="button" class="btn btn-warning" onClick="SendMobile_yz();" ><i class="icon-rss"></i> <?= $LG['reg.GetCode']; //获取校验码        ?> </button>
							</div>
						</div>
					<?php } ?>



					<?php if ($CustomerService) { ?>
						<div class="form-group">
							<label class="control-label col-md-3"><?= $LG['CustomerService'] ?></label>
							<div class="col-md-9">
								<select  class="form-control input-medium select2me" data-placeholder="Select..." name="CustomerService">
									<?= CustomerService($rs['CustomerService'], 1) ?>
								</select>
								<span class="help-block"><?= $LG['member.10']//提交后将不可更改         ?></span>
							</div>
						</div>
					<?php } ?>



					<?php if ($off_tuiguang) { ?>
						<div class="form-group">
							<label class="control-label col-md-3"><?= $LG['reg.tuiguang_userid']; //邀请号码        ?></label>
							<div class="col-md-9">
								<input type="text" class="form-control input-small" name="tuiguang_userid"  maxlength="15" title="<?= $LG['reg.InvitationNumber'] ?><?= $tuiguang_xhy ?><?= $LG['integral'] ?>" value="<?= cadd($_GET["tg"]) ?>" placeholder="<?= $LG['reg.blank']; //没有可留空         ?>" />
							</div>
						</div>
					<?php } ?>
					<?php if ($off_code_reg) { ?>
						<div class="form-group">
							<label class="control-label col-md-3"><?= $LG['code']; //验 证 码        ?></label>
							<div class="col-md-9 has-error">
								<input name="code" id="code" type="text" class="form-control placeholder-no-fix input-small pull-left" placeholder="<?= $LG['code']; //验 证 码         ?>" style="margin-right:10px;" autocomplete="off"  maxlength="10" required onkeyup="checkcode('reg');"  title="<?= $LG['codePpt1']; //不分大小写         ?>"/>
								<span align="left"><span id="msg_code"></span> <img src="/images/code.gif" onclick="codeimg.src = '/public/code/?v=reg&rm=' + Math.random()" id="codeimg" title="<?= $LG['codePpt2']; //看不清，点击换一张(不分大小写)         ?>"  width="100" height="35"/></span> 
							</div>
						</div>
					<?php } ?>
					<div class="form-actions" style="margin-top:10px;" align="center">
						<input type="checkbox"  onClick='document.getElementById("agreed").disabled = !this.checked;' autocomplete="off"/>
						<font class="red2"><a href="<?php
						$xacd = ClassData($reg_classid);
						echo pathLT($xacd['path']);
						?>" target="_blank"><?= $LG['reg.agree']; //我已看过并同意   ?>《<strong><?= cadd($xacd['name']) ?></strong>》</a></font>
						<br><br>

						<button type="submit" id="agreed" disabled class="btn btn-info input-medium"><i class="icon-user"></i> <?= $LG['reg.submit']; //提 交 注 册         ?> </button>
					</div>
					<div class="forget-password" align="right">
					 <!-- <p> <font class="red2">以上需要填写完整才能注册</font><br><br>-->
						<a href="/xamember/"><span class="btn btn-xs btn-danger"><i class="icon-key"></i> <?= $LG['reg.login']; //我已经有账号，点击登录        ?> </span></a> </p>
					</div>

					<!--[if lt IE 9]><br>
				  <font style="color:#F00">
					<?= $LG['pptBrowserHTML'] ?><br>
				  </font>
				  <![endif]-->

				</form>
				<!-- END LOGIN FORM --> 
			</div>
		</div>
	</div>
	<div class="clear"></div>

	<?php require_once($_SERVER['DOCUMENT_ROOT'] . $m . '/template/incluce/footer.php'); ?>
	<!--内容结束-->

<?php } else { ?>
	<div class="bc-bg" tabindex="0" data-control="PAGE" id="Page" style="background:#eeeeee">
		<div class="uh cc-head  ubb bc-border" data-control="HEADER" id="Header">
			<div class="ub">
				<div class="nav-btn" id="nav-left">
					<div class="fa fa-1g fa-chevron-left ub-img1" onclick="window.history.go( - 1)">
					</div>
				</div>
				<h1 class="ut ub-f1 ulev-3 ut-s tx-c" tabindex="0">用户注册</h1>
				<div class="nav-btn" id="nav-right">

				</div>
			</div>


		</div>

		<form class="form-horizontal form-bordered" name="xingao" action="reg_save.php" method="post" style="width:70%;margin:0 auto;">
			<input name="lx" type="hidden" value="<?= $lx ?>">
			<input name="ism" type="hidden" value="<?= $ism ?>">
			<input name="tokenkey" type="hidden" value="<?= $tokenkey ?>">
			<input name="reg_type" type="hidden" value="mobile" id="reg_type">
			<!--content开始-->
			<div class="uf bc-border" id="content1" style="top:4rem;">
				<style>
					.control-label{
						font-size:.8rem;

					}
				</style>

				<script>
					function step1_1() {
						if ($('#mobile').val() == "" || $("#yzm_1").val() == "") {
							alret('手机和验证码没填写');
							return;
						}
						
						var type = $("#reg_type").val();
						if (type == "email") {
							$("#mobile").removeAttr("required");
							$("#yzm_1").removeAttr("required");
							
							$("#username").attr("required","required");
							$("#email").attr("required",'required');
							$("#yzm_2").attr("required",'required');
							
						} else {
							$("#mobile").attr("required","required");
							$("#yzm_1").attr("required",'required');
							
							$("#username").removeAttr("required");
							$("#email").removeAttr("required");
							$("#yzm_2").removeAttr("required");
						}
						
						$("#step1_1").hide();
						$("#step1_2").show();
						
					}
					function step1_1_step() {
						if ($('#email').val() == "" || $("#yzm_2").val() == "") {
							alret('邮箱和验证码没填写');
							return;
						}
						var type = $("#reg_type").val();
						if (type == "email") {
							$("#mobile").removeAttr("required");
							$("#yzm_1").removeAttr("required");
							
							$("#username").attr("required","required");
							$("#email").attr("required",'required');
							$("#yzm_2").attr("required",'required');
						} else {
							$("#mobile").attr("required","required");
							$("#yzm_1").attr("required",'required');
							
							$("#username").removeAttr("required");
							$("#email").removeAttr("required");
							$("#yzm_2").removeAttr("required");
						}
						
						$("#step1_1_email").hide();
						$("#step1_2").show();
					}
					function step1_2() {
						
						var type = $("#reg_type").val();
						if (type == "email") {
							$("#mobile").removeAttr("required");
							$("#yzm_1").removeAttr("required");
							
							$("#username").attr("required","required");
							$("#email").attr("required",'required');
							$("#yzm_2").attr("required",'required');
							
							
							$("#step1_1_email").show();
						} else {
							$("#mobile").attr("required","required");
							$("#yzm_1").attr("required",'required');
							
							$("#username").removeAttr("required");
							$("#email").removeAttr("required");
							$("#yzm_2").removeAttr("required");
							
							$("#step1_1").show();
						}

						$("#step1_2").hide();
					}
					function qiehuanType(type) {
						$("#reg_type").val(type);
						if (type == "email") {
							$("#step1_1").hide();
							$("#step1_1_email").show();
						} else {
							$("#step1_1").show();
							$("#step1_1_email").hide();
						}
					}
					//setTimeout('$("#step1_1_email").hide();', 10000);
				</script>
				<!-------------------------------------------第一步---------------------------------------------------->

				<div id="step1_1">

					<?php if ($off_reg_mobile && $off_sms) { ?>
						<div class="form-group">
							<label class="control-label col-md-4"><?= $LG['reg.mobile_code']; //手机国家         ?></label>
							<div class="col-md-8">
								<select  class="form-control input-medium" data-placeholder="Select..." name="mobile_code" id="mobile_code">
									<?php mobileCountry(86, 1) ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4"><?= $LG['reg.mobile']; //手机号码         ?></label>
							<div class="col-md-8 has-error">
								<input type="text" class="form-control input-medium" name="mobile" id="mobile" required maxlength="20" placeholder="<?= $LG['reg.RealMobileIn']; //请填写真实手机号码         ?>">
								<span class="help-block" id="msg_sj"></span> </div>
						</div>
						<!--不能在此限制发送时间，当手机写错就不能再发送-->

						<div class="form-group">

							<div class="col-md-12 has-error">
								<input type="text" id="yzm_1" class="form-control input-small" name="mobile_yz"  required  maxlength="10"  placeholder="<?= $LG['reg.ResultCode']; //收到校验码         ?>" style="width:50%;">
								<button type="button" class="btn btn-warning" onClick="SendMobile_yz();" ><i class="icon-rss"></i> <?= $LG['reg.GetCode']; //获取校验码        ?> </button>
							</div>
						</div>

						<div class="form-actions">
							<button type="button" class="btn-block btn btn-danger pull-right input-small" onclick="step1_1();">下一步</button>


						</div>

					<?php } ?>
					<div style="padding-bottom:20rem;font-size:.8rem;width:100%;clear:both;">
						<br/>

						<div style="text-align:center;">
							没有手机，<a href="javascript:qiehuanType('email');"> 使用邮箱注册！</a>
						</div>

					</div>

				</div>
				<div id="step1_1_email" style="display:none">

					<div class="form-group">
						<label class="control-label col-md-4"><?= $LG['reg.username']; //注册账号         ?></label>
						<div class="col-md-8 has-error">
							<input type="text" class="form-control input-medium" name="username" autocomplete="off" id="username" required 
								   maxlength="50" onBlur="check_username();"
								   placeholder="<?php
								   if ($member_reg_lx == 1) {
									   echo $LG['reg.EmailAccounts'];
								   } elseif ($member_reg_lx == 2) {
									   echo $LG['reg.EmailLimit'];
								   } elseif ($member_reg_lx == 3) {
									   echo $LG['reg.LetterLimit'];
								   }
								   ?>">
							<span class="help-block red" id="msg_username"></span> 
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4">
							<?php
							if ($member_reg_lx == 1) {
								echo $LG['reg.EmailConfirm'];
							} else {
								echo $LG['reg.EmailUsed'];
							}
							?>
						</label>
						<div class="col-md-8 has-error">
							<input type="text" class="form-control input-medium" name="email" id="email" required 
								   maxlength="50" onBlur="check_email();"
								   onselectstart="return false" oncopy="return false" onpaste="return false"
								   placeholder="<?php
								   if ($member_reg_lx == 1) {
									   echo $LG['reg.EmailRepeat'];
								   } else {
									   echo $LG['reg.EmailUsedIn'];
								   }
								   ?>">
							<span class="help-block red" id="msg_email"></span> </div>
					</div>


					<?php if ($off_reg_email) { ?>
						<div class="form-group">
							<label class="control-label col-md-4"><?= $LG['reg.email_yz']; //邮箱验证        ?></label>
							<div class="col-md-8 has-error">
								<input type="text" id="yzm_2" class="form-control input-small" name="email_yz"  required  maxlength="10" placeholder="<?= $LG['reg.ResultCode'] ?>">
								<button type="button" class="btn btn-warning" onClick="SendEmail_yz();"><i class="icon-rss"></i> <?= $LG['reg.GetCode'] ?> </button>
								<span class="help-block" id="msg_email_yz"></span>
							</div>
						</div>
					<?php } ?>

					<div class="form-actions">
						<button type="button" class="btn-block btn btn-danger pull-right input-small" onclick="step1_1_step();">下一步</button>


					</div>


					<div style="padding-bottom:20rem;font-size:.8rem;width:100%;clear:both;">
						<br/>

						<div style="text-align:center;">
							没有email，<a href="javascript:qiehuanType('mobile');"> 使用手机注册！</a>
						</div>

					</div>

				</div>
				<div id="step1_2" style="display:none">

					<div class="form-group">
						<label class="control-label col-md-4"><?= $LG['reg.password']; //登录密码         ?></label>
						<div class="col-md-8 has-error">
							<input type="password" class="form-control input-medium" name="password" autocomplete="off"  id="password" required 
								   maxlength="50" onKeyUp="check_password('{$LG['reg.LimitWord']}');" placeholder="<?= $LG['reg.LimitPassword']; //请输入复杂的密码        ?>">
							<span class="help-block" id="msg_password"></span>
						</div>
					</div>


					<div class="form-group">
						<label class="control-label col-md-4"><?= $LG['reg.password2']; //确认密码         ?></label>
						<div class="col-md-8 has-error">
							<input type="password" class="form-control input-medium" name="password2" id="password2" required 
								   maxlength="50" onBlur="check_password2();"
								   placeholder="<?= $LG['reg.RepeatPassword']; //再次输入密码        ?>">
							<span class="help-block red" id="msg_password2"></span>
						</div>
					</div>

					<?php
					$group	 = '';
					$query2	 = "select groupid,groupname{$LT} from member_group where checked=1 and regchecked=1 order by myorder desc, groupname{$LT} asc,groupid desc";
					$sql2	 = $xingao->query($query2);
					while ($rs2	 = $sql2->fetch_array()) {
						$group		 .= '<option value="' . $rs2['groupid'] . '" ' . ($rs2['groupid'] == $groupid ? ' selected ' : '') . ' >' . cadd($rs2['groupname' . $LT]) . '</option>';
						$rsgroupid	 = $rs2['groupid'];
					}
					$rc = mysqli_affected_rows($xingao);
					if (!$group) {
						exit("<script>alert('{$LG['reg.CloseGroup']}');goBack('uc');</script>");
					}
					?>


					<?php if ($rc > 1) { ?>
						<div class="form-group">
							<label class="control-label col-md-4"><?= $LG['reg.groupid']; //注册类型        ?></label>
							<div class="col-md-8 has-error">
								<select  class="form-control input-medium" data-placeholder="Select..." name="groupid">
									<?= $group ?>
								</select>
							</div>
						</div>
					<?php } else { ?>
						<input name="groupid" type="hidden" value="<?= $rsgroupid ?>">     
					<?php } ?>



					<?php if (arrcount($me_openCurrency) > 1) { ?>
						<div class="form-group">
							<label class="control-label col-md-4"><?= $LG['currency']; //币种        ?></label>
							<div class="col-md-8 has-error">
								<select name="currency" class="form-control input-small select2me" required data-placeholder="币种">
									<?= openCurrency('', 4) ?>
								</select>
								<span class="help-block"><?= $LG['reg.currency']//请注意选择，注册后不可更改        ?></span>
							</div>
						</div>
					<?php } else { ?> 
						<input name="currency" type="hidden" value="<?= $me_openCurrency ?>">     
					<?php } ?>



					
					<?php if ($ON_nickname) { ?>
						<div class="form-group">
							<label class="control-label col-md-4"><?= $LG['data.nickname']; //昵称        ?></label>
							<div class="col-md-8 <?= $ON_nickname ? 'has-error' : '' ?>">
								<input type="text" class="form-control input-medium" maxlength="50" <?= $ON_nickname ? 'required' : '' ?>  name="nickname">
								<span class="help-block"><?= $LG['data.save_35'] ?></span>
							</div>
						</div>
					<?php } ?>

					<?php if ($CustomerService) { ?>
						<div class="form-group">
							<label class="control-label col-md-4"><?= $LG['CustomerService'] ?></label>
							<div class="col-md-8">
								<select  class="form-control input-medium select2me" data-placeholder="Select..." name="CustomerService">
									<?= CustomerService($rs['CustomerService'], 1) ?>
								</select>
								<span class="help-block"><?= $LG['member.10']//提交后将不可更改         ?></span>
							</div>
						</div>
					<?php } ?>



					<?php if ($off_tuiguang) { ?>
						<div class="form-group">
							<label class="control-label col-md-4"><?= $LG['reg.tuiguang_userid']; //邀请号码 ?></label>
							<div class="col-md-8">
								<input type="text" class="form-control input-small" name="tuiguang_userid"  maxlength="15" title="<?= $LG['reg.InvitationNumber'] ?><?= $tuiguang_xhy ?><?= $LG['integral'] ?>" value="<?= cadd($_GET["tg"]) ?>" placeholder="<?= $LG['reg.blank']; //没有可留空         ?>" />
							</div>
						</div>
					<?php } ?>

					<div class="form-actions">
						<button type="submit" class="btn-block btn btn-danger pull-right input-small">确认注册</button>

						<a type="button" href="JavaScript:void(0);" style="color:#fff;margin-top.5rem;" class="btn-block btn btn-info pull-right input-small" onclick="step1_2();">上一步</a>


								<!--<a href="/api/login/qq/" target="_blank"><img src="/images/login_qq.gif" style="margin-bottom:5px; margin-top:5px;"></a>-->



					</div>

						<div style="height: 2rem;clear:both;"></div>


				</div>
			</div>
		</form>
	</div>
<?php } ?>


<!-------------------------------------------账号验证-------------------------------------------->
<script language="javascript" type="text/javascript">
<?php if ($member_reg_lx == 1) { ?>
		function check_username()
		{
		var temp = document.getElementById("username");
		//对电子邮件的验证
		var myreg = /^([a-zA-Z0-9]+[_|\-|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if (temp.value != "")
		{
		if (!myreg.test(temp.value))
		{
		document.getElementById('msg_username').innerHTML = "<?= $LG['reg.EmailError']; //请输入有效的E_mail         ?>";
		username.focus();
		return false;
		} else
		{
		document.getElementById('msg_username').innerHTML = "";
		}

		}
		}

		function check_email()
		{
		var temp = document.getElementById("username");
		var temp2 = document.getElementById("email");
		//对电子邮件的验证
		if (temp.value != temp2.value)
		{
		document.getElementById('msg_email').innerHTML = "<?= $LG['reg.EmailRepeatError']; //2次输入的邮箱不一样         ?>"; //  alert('提示\n\n请输入有效的E_mail！');
		//email.focus();//不能强制焦点
		return false;
		} else
		{
		document.getElementById('msg_email').innerHTML = "";
		}
		}
	<?php
} else {
	?>
		function check_username()
		{
		var temp = document.getElementById("username");
		//对电子邮件的验证
	<?php if ($member_reg_lx == 2) { ?>
			var myreg = /^[A-Za-z]+$/;
		<?php
	} else {
		?>
			var myreg = /^[a-zA-Z]/;
	<?php } ?>


		if (temp.value != "")
		{
		if (!myreg.test(temp.value) || temp.value.length < 4 || temp.value.length > 15)
		{
	<?php if ($member_reg_lx == 2) { ?>
			document.getElementById('msg_username').innerHTML = "<?= $LG['reg.AllLetters']; //必须全是字母(4至15个字)         ?>"; //  alert('提示nn请输入有效的E_mail！');
		<?php
	} else {
		?>
			document.getElementById('msg_username').innerHTML = "<?= $LG['reg.FirstLetter']; //必须以字母开头(4至15个字)         ?>"; //  alert('提示nn请输入有效的E_mail！');
	<?php } ?>

		username.focus();
		return false;
		} else
		{
		document.getElementById('msg_username').innerHTML = "";
		}

		}
		}


		function check_email()
		{
		var temp = document.getElementById("email");
		//对电子邮件的验证
		var myreg = /^([a-zA-Z0-9]+[_|\-|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if (temp.value != "")
		{
		if (!myreg.test(temp.value))
		{
		document.getElementById('msg_email').innerHTML = "<?= $LG['reg.EmailError']; //请输入有效的E_mail         ?>"; //  alert('提示\n\n请输入有效的E_mail！');
		email.focus();
		return false;
		} else
		{
		document.getElementById('msg_email').innerHTML = "";
		}

		}
		}
<?php } ?>
</script>



<!-------------------------------------------手机验证-------------------------------------------->
<?php if ($off_reg_mobile && $off_sms) { ?>
	<SCRIPT type=text/javascript>
		function SendMobile_yz() {
		var mobile = document.getElementById("mobile").value;
		var mobile_code = document.getElementById("mobile_code").value;
		var xmlhttp_sj = createAjax();
		if (xmlhttp_sj) {
		var span = document.getElementById('msg_sj');
		xmlhttp_sj.open('POST', '/xamember/reg_yz.php?n=' + Math.random(), true);
		xmlhttp_sj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp_sj.send('lx=mobile&mobile=' + mobile + '&mobile_code=' + mobile_code + '');
		xmlhttp_sj.onreadystatechange = function () {
		if (xmlhttp_sj.readyState == 4 && xmlhttp_sj.status == 200)
		{
		span.innerHTML = unescape(xmlhttp_sj.responseText);
		}
		}
		}
		}
	</SCRIPT>
<?php } ?>

<!-------------------------------------------邮箱验证-------------------------------------------->
<?php if ($off_reg_email) { ?>
	<SCRIPT type=text/javascript>
		function SendEmail_yz() {
		var email = document.getElementById("email").value;
		var xmlhttp_em = createAjax();
		if (xmlhttp_em) {
		var span = document.getElementById('msg_email_yz');
		xmlhttp_em.open('POST', '/xamember/reg_yz.php?n=' + Math.random(), true);
		xmlhttp_em.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp_em.send('lx=email&email=' + email + '');
		xmlhttp_em.onreadystatechange = function () {
		if (xmlhttp_em.readyState == 4 && xmlhttp_em.status == 200)
		{
		span.innerHTML = unescape(xmlhttp_em.responseText);
		}
		}
		}
		}
	</SCRIPT>
<?php } ?>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/js/checkJS.php'); //通用验证
?>

