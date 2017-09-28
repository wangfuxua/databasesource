<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/function.php');
$noper = 1;
require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/session.php');


$_SESSION['isMobile']	 = 1;
$ism					 = 1;
$m						 = '/m';

$headtitle = "优惠券";
//过期更新
require_once($_SERVER['DOCUMENT_ROOT'].'/xingao/coupons/call/update.php');

//搜索
$where="1=1";
$so=(int)$_GET['so'];

$status=par($_GET['status']);
if(CheckEmpty($status)){$where.=" and status='{$status}'";}
$search.="&status={$status}";


$order=' order by addtime desc,status asc';//默认排序
include($_SERVER['DOCUMENT_ROOT'].'/public/orderby.php');//排序处理页
$query="select * from coupons where {$where} {$Mmy} {$order}";
$sql=$xingao->query($query);



require_once($_SERVER['DOCUMENT_ROOT'] . '/m/template/incluce/header.php');

?>
<style>
           .list1{
               margin: 0 auto;
               width: 90%;
               font-size: .8rem;
           }
           .list1 li{
               background: #93cfe7;
               color: #FFFFFF;
               padding: .5rem;
               margin-bottom: .8rem;
               border: 1px dashed #106D84
           }
           .l-1{
               
           }
           .l-3{
               line-height: 2rem;
               clear: both;
               text-align: right
           }
           .l-1-left{
               float: left;
               font-size: 3rem;
           }
           .l-1-right{
               float: right;
               color: #21853b
           }
           .l-2{
               background: #106d84;
               clear: both;
               padding: .2rem;
               padding-left: .5rem;
               padding-right: .5rem;
           }
           .l-2-left{
               float: left;
           }
           .l-2-right{
               float: right;
           }
        </style>
	
	<div class="bc-bg" tabindex="0" data-control="PAGE" id="Page" style="background:#eeeeee">
		<div class="uh cc-head  ubb bc-border" data-control="HEADER" id="Header">
			<div class="ub">
				<div class="nav-btn" id="nav-left">
					<div class="fa fa-1g fa-chevron-left ub-img1" onclick="window.history.go( - 1)">
					</div>
				</div>
				<h1 class="ut ub-f1 ulev-3 ut-s tx-c" tabindex="0">优惠券</h1>
				<div class="nav-btn" id="nav-right">

				</div>
			</div>


		</div>

		<div class="uf sc-bg  bc-border" style="background: #FFFFFF;top: 3em;">
                    <!--///-->
                    <div class="list1">
                        <ul>
							
							<?php
while($rs=$sql->fetch_array())
{
?>
							
                            <li>
                                <div class="l-1">
                                    <div class="l-1-left"><?=spr($rs['value'])?><?=$rs['types']==1?$XAmc:'折'?></div>
                                    <div class="l-1-right"><?=Coupons_Status(spr($rs['status']))?></div>
                                </div>
                                <div class="l-3">有效期：<?=$rs['duetime']?DateYmd($rs['duetime']):'不限'?></div>
                                <div class="l-2">
                                    <div class="l-2-left">满<?=spr($rs['limitmoney']).$XAmc?>该券可用</div>
                                    <div class="l-2-right"><?=Coupons_getSource($rs['getSource'])?></div>
                                    <div style="clear: both"></div>
                                </div>
                                <div style="clear: both"></div>
                            </li>
							
							<?php
}
?>
                            
                        </ul>
                    </div>
                    
                </div>
	</div>