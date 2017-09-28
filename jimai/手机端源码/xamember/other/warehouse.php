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
require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/session.php');
$headtitle = $LG['warehouse'];

//验证手机版
if (isMobile()) {
	$ism = 1;
}
if ($ism) {
	require_once($_SERVER['DOCUMENT_ROOT'] . '/m/template/incluce/header.php');
} else {
	require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/head.php');
}
?>
<?php if (!$ism) { ?>
	<div class="page_ny"> 
		<!-- BEGIN PAGE HEADER-->
		<div class="row"><!--单页时去掉 class="row",不然会有横滚动条,并且form 加 style="margin:20px;"-->
			<div class="col-md-12"> 
				<h3 class="page-title"> <a href="javascript:void(0)" onClick="javascript:window.location.href = window.location.href;" title="<?= $LG['refresh'] ?>" class="gray">
						<?= $headtitle ?>
					</a>  </h3>
			</div>
		</div>
		<!-- END PAGE HEADER-->

		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">
				<div class="form">
					<div ><!--class="form-body"-->
						<div ><!--class="portlet"-->
							<div > <!--class="portlet-body article_ny"-->
								<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/other/call/warehouse.php'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/foot.php');
	?>

<?php } else { ?>

	<style>
		.main-1{
			background: #ededed;
		}
		.main-1-top{
			width: 100%;
			text-align: center;
			background: #fff6e1;
			color: #e87e57;
			padding: .7em;
			font-size: .8rem;
		}

		.div-1{
			margin: 0 auto;
			width: 100%;
			background: #FFFFFF;
			border-bottom: 3px solid #f1565a;
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
			font-size: .8rem;
			height: 3em;
			margin-top: 1em;
		}
		.text-b {
			border-right:1px solid #ccc; 
			padding-left: 1em;
			padding-right: 1em;
			float: left;
			width: 25%;
			text-align: center;
		}
		.input_b .text-input{
			width:60%;
			float: left;
		}
		.input_b .text-input input[type='text']{
			width: 98%;
			padding-left: 1em;
			height: 100%;
			border:0px;
			background-color:transparent;
			padding-top:.9em;
		}
		.input_b .text-input textarea{
			width: 90%;
			padding: .2em;
			border:0px;
			background-color:transparent;
			font-size:1rem;
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
			font-size: .9rem;
		}
		.copy{
			color:#F1565A;
			margin-top: -.4em;
		}

		.div-2{
			width: 100%;
			background: #FFFFFF;
			border-bottom: 1px solid #ccc;
			float: left;
			padding-top: 1em;
			font-size: .8rem;
		}
		.div-2-con{
			width: 90%;
			margin: 0 auto;
			margin-top: 1.5em;
			margin-bottom: 1.5em;
			font-size: .85rem;
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

	<div class="bc-bg" tabindex="0" data-control="PAGE" id="Page">
		<div class="uh cc-head ubb bc-border" data-control="HEADER" id="Header">
			<div class="ub">
				<div class="nav-btn" id="nav-left">
					<div class="fa fa-1g fa-chevron-left ub-img1" onclick="window.history.go( - 1)">
					</div>
				</div>
				<h1 class="ut ub-f1 ulev-3 ut-s tx-c" tabindex="0">我的中转地址</h1>
				<div class="nav-btn" id="nav-right">

				</div>
			</div>
			<div class="ub ub-ver ub-fv main-1">
				<div class="main-1-top">
					转运包裹先寄到jbuy中转仓，我们代您拆包验货哦！
				</div>
			</div>
		</div>

		<div class="uf sc-bg  bc-border" style="top: 4em;">
			<div class="div-1">
				<div class="div-1-con">
					<form>
						<div class="input_b">
							<div class="text-b">收货人</div>
							<div class="text-input uinput">
								<input value="张三" type="text" id="name" readonly="">
							</div>
							<div class="uinn sc-text copy" id="name_btn">
								复制
							</div>
						</div>

						<div class="input_b">
							<div class="text-b">联系电话</div>
							<div class="text-input uinput">
								<input value="15921688717" type="text" id="tel" readonly="">
							</div>
							<div class="uinn sc-text copy" id="tel_btn">
								复制
							</div>
						</div>

						<div class="input_b" style="height: 6em;">
							<div class="text-b" style="height: 6em;">仓库地址</div>
							<div class="text-input uinput">
								<textarea id="addr" readonly="">江苏省南通市海门市高新区海能路299号#10034室
								</textarea>
							</div>
							<div class="uinn sc-text copy" id="addr_btn">
								复制
							</div>
						</div>

						<div class="input_b">
							<div class="text-b">邮编</div>
							<div class="text-input uinput">
								<input value="226100" type="text" id="code" readonly="">
							</div>
							<div class="uinn sc-text copy" id="code_btn">
								复制
							</div>
						</div>

						<div style="text-align: center">
							<button class="btn-yuan" type="button" style="margin-top: 2em;" id="all_btn">
								复制全部信息
							</button>
						</div>     
					</form>
				</div>
			</div>
			<div class="div-2">
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
		</div>

		
	</div>


	


	<script>
		ylapp.ready(function () {
			var name_clipboard = new Clipboard('#name_btn', {
				text: function () {
					return $("#name").val();
				}
			});
			name_clipboard.on('success', function (e) {
				alert("已复制到粘贴板");
			});

			name_clipboard.on('error', function (e) {
				alert("复制失败，您的系统不支持");
			});

			var tel_clipboard = new Clipboard('#tel_btn', {
				text: function () {
					return $("#tel").val();
				}
			});
			tel_clipboard.on('success', function (e) {
				alert("已复制到粘贴板");
			});

			tel_clipboard.on('error', function (e) {
				alert("复制失败，您的系统不支持");
			});

			var addr_clipboard = new Clipboard('#addr_btn', {
				text: function () {
					return $("#addr").val();
				}
			});
			addr_clipboard.on('success', function (e) {
				alert("已复制到粘贴板");
			});

			addr_clipboard.on('error', function (e) {
				alert("复制失败，您的系统不支持");
			});
			var code_clipboard = new Clipboard('#code_btn', {
				text: function () {
					return $("#code").val();
				}
			});
			code_clipboard.on('success', function (e) {
				alert("已复制到粘贴板");
			});

			code_clipboard.on('error', function (e) {
				alert("复制失败，您的系统不支持");
			});

			var all_clipboard = new Clipboard('#all_btn', {
				text: function () {
					var str = $("#name").val() + " ";
					str += $("#tel").val() + " ";
					str += $("#addr").val() + " ";
					str += $("#code").val() + " ";
					return str;
				}
			});
			all_clipboard.on('success', function (e) {
				alert("已复制到粘贴板");
			});

			all_clipboard.on('error', function (e) {
				alert("复制失败，您的系统不支持");
			});
		});

	</script>

	<?php
}
?>
