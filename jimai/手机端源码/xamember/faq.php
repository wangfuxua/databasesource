<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/function.php');
$noper = 1;
require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/session.php');


$_SESSION['isMobile']	 = 1;
$ism					 = 1;
$m						 = '/m';

$headtitle = "常见问题";

$classid=120;
$cr=ClassData($classid);

$order=' order by istop desc,isgood desc,ishead desc,edittime desc,addtime desc';//默认排序
$where.=" classid='{$classid}'";
$query="select * from article where {$where} {$order}";
$sql=$xingao->query($query);

require_once($_SERVER['DOCUMENT_ROOT'] . '/m/template/incluce/header.php');


?>

<style>
           .div-1{
               width: 100%;
               background: #FFFFFF;
           }
           .div-1-title {
               width: 90%;
               margin: 0 auto;
               font-size: .8rem;
               margin-top: 1rem;
           }
           .div-1-con{
               border-radius: .6rem;
               border: 1px solid #CCCCCC;
               width: 90%;
               margin: 0 auto;
               margin-top: .5rem;
           }
           .div-1-con ul li{
               border-bottom: 1px solid #CCCCCC;
               line-height: 2rem;
               text-indent: .5rem;
               color: #80807F;
               font-size: .9rem;
           }
           .ul-con{
               color: #000000;
               padding: .8rem;
               font-size: .85rem;
               line-height: 1.5rem;
               display: none;
           }
           .ul-con p{
               padding: 0;
               margin: 0;
           }
        </style>
		
	<div class="bc-bg" tabindex="0" data-control="PAGE" id="Page" style="background:#FFFFFF">
		<div class="uh cc-head  ubb bc-border" data-control="HEADER" id="Header">
			<div class="ub">
				<div class="nav-btn" id="nav-left">
					<div class="fa fa-1g fa-chevron-left ub-img1" onclick="window.history.go( - 1)">
					</div>
				</div>
				<h1 class="ut ub-f1 ulev-3 ut-s tx-c" tabindex="0">常见问题</h1>
				<div class="nav-btn" id="nav-right">

				</div>
			</div>


		</div>

		<div class="uf sc-bg  bc-border" style="background: #FFFFFF;top: 3em;">
                <div class="div-1">
                    <!--<div class="div-1-title">
                        <p>邮寄物品分类</p>
                        <p><b>所有的常见问题仅供参考！</b></p>
                    </div>-->
                    <div class="div-1-con">
                        <ul>
							<?php
while($rs=$sql->fetch_array())
{
?>
                            <li>
                                <div class="ul-title"><i class="fa fa-caret-right"></i> <?=cadd($rs['titleCN'])?></div>
                                <div class="ul-con">
                                    <?= htmlspecialchars_decode($rs['contentCN'])?>
                                </div>
                                
                            </li>
                            <?php
}
?>
                        </ul>
                    </div>
                    
                    
                    <!--<div class="div-1-title">
                        <p>邮寄物品分类</p>
                        <p>所有的常见问题仅供参考！</p>
                    </div>
                    <div class="div-1-con">
                        <ul>
                            <li>
                                <div class="ul-title"><i class="fa fa-caret-right"></i> 测试1</div>
                                <div class="ul-con">
                                    <p>所有的常见问题仅供参考</p>
                                    <p>所有的常见问题仅供参考所有的常见问题仅供参考所有的常见问题仅供参考所有的常见问题仅供参考所有的常见问题仅供参考</p>
                                </div>
                                
                            </li>
                            <li>
                                <div class="ul-title"><i class="fa fa-caret-right"></i> 测试2</div>
                                <div class="ul-con">
                                    <p>222222222所有的常见问题仅供参考</p>
                                    <p>所有的常见问题仅供参考所有的常见问题仅供参考所有的常见问题仅供参考所有的常见问题仅供参考所有的常见问题仅供参考</p>
                                </div>
                            </li>
                            <li>
                                <div class="ul-title"><i class="fa fa-caret-right"></i> 测试3</div>
                                <div class="ul-con">
                                    <p>所有的常见问题仅供参考3333333</p>
                                    <p>所有的常见问题仅供参考所有的常见问题仅供参考所有的常见问题仅供参考所有的常见问题仅供参考所有的常见问题仅供参考</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                
                    <!--///-->
                    
                </div>
            </div>
		
	</div>

	<script>
		ylapp.ready(function() {
			$(".div-1-con li").click(function(){
				if ($(this).find(".ul-con").css("display") != "none"){
					return;
				}
				var obj = $(this).parent();
				obj.find(".ul-con").hide();
				obj.find(".ul-title").find("i").addClass("fa-caret-right").removeClass("fa-caret-down");
				obj.find(".ul-title").css("color","#80807F");
				$(this).find(".ul-con").show();
				$(this).find(".ul-title").css("color","#000000");
				$(this).find(".ul-title").find("i").addClass("fa-caret-down").removeClass("fa-caret-right");
				//alert(obj.length);
			});
		});
	</script>