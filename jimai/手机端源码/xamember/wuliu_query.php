<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/function.php');
$noper = 1;
require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/session.php');


$_SESSION['isMobile']	 = 1;
$ism					 = 1;
$m						 = '/m';

$headtitle = "客服咨询";

require_once($_SERVER['DOCUMENT_ROOT'] . '/m/template/incluce/header.php');
?>
	<div class="bc-bg" tabindex="0" data-control="PAGE" id="Page" style="background:#eeeeee">
		<div class="uh cc-head  ubb bc-border" data-control="HEADER" id="Header">
			<div class="ub">
				<div class="nav-btn" id="nav-left">
					<div class="fa fa-1g fa-chevron-left ub-img1" onclick="window.history.go( - 1)">
					</div>
				</div>
				<h2 class="ut ub-f1 ulev-3 ut-s tx-c" tabindex="0">物流查询</h2>
				<div class="nav-btn" id="nav-right">

				</div>
			</div>


		</div>

		<!--content开始-->
		<div id="content" class="ub-f1 tx-l t-bla c-gra1" style="margin-top: 1em;">

		</div>
		<!--content结束-->
	</div>

	<script>
		ylapp.ready(function() {
			var tempH = $('#Header').offset().height;
			ylapp.frame.open("content", "http://m.kuaidi100.com/", 0, tempH);
		});
	</script>