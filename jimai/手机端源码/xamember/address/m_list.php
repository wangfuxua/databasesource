<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/function.php');
$noper = 1;
require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/session.php');


$_SESSION['isMobile']	 = 1;
$ism					 = 1;
$m						 = '/m';

$headtitle = "地址";


//搜索
$where="addclass=2";

$order=' order by addid desc';//默认排序

include($_SERVER['DOCUMENT_ROOT'].'/public/orderby.php');//排序处理页
$query="select * from member_address where {$where}  {$Mmy} {$order}";
$sql=$xingao->query($query);



require_once($_SERVER['DOCUMENT_ROOT'] . '/m/template/incluce/header.php');

?>

<style>
            .c_list{
                margin-top: 1em;
                font-size: .8em;
            }
            
            .c_list li{
                background: #FFFFFF;
                margin-bottom: .5rem;
                padding: .5rem;
				border-bottom:1px solid #ccc;
            }
            .c_list .l_left{
                float: left;
                width: 0%;
	
            }
            .c_list .l_left img{
                width: 100%;
            }
            .c_list .l_right{
                float: right;
                width: 68%;
                text-align: left;
            }
	.c_list .l_right2{
                float: right;
                width: 28%;
                text-align: left;
            }
            .t1{
                /*text-overflow:ellipsis;
                overflow: hidden;
                height: 6rem;*/
               word-break:break-all;
               margin-bottom: .3rem;
			   font-size:0.9rem;
            }
            
            .t2,.t3{
               color: #6A6A6A;
               margin-bottom: .3rem;
            }
            
            .btn-yuan{
                width: 90%;
                margin: 0 auto;
                background:#F1565A;
                color:#ffffff;
                height: 2.5em;
                line-height: 2.5em;
                border-radius:.5rem;
                text-align: center;
            }
            
            
        </style>
	
	<div class="bc-bg" tabindex="0" data-control="PAGE" id="Page" style="background:#eeeeee">
		<div class="uh cc-head  ubb bc-border" data-control="HEADER" id="Header">
			<div class="ub">
				<div class="nav-btn" id="nav-left">
					<div class="fa fa-1g fa-chevron-left ub-img1" onclick="window.location.href = '/xamember/user/index.php'">
					</div>
				</div>
				<h1 class="ut ub-f1 ulev-3 ut-s tx-c" tabindex="0">我的地址薄</h1>
				<div class="nav-btn" id="nav-right">

				</div>
			</div>


		</div>

		<div class="" data-control="CONTENT" id="ScrollContent" style="top:12em;">
                
                <div class="scrollbox">
                    <div class="box_bounce ub ub-ver ub-pc">
                        <div class="ub-f1">
                            
                            <div class="c_list" id="list1">
                                <!--<center>
                                    <img src="./css/images/i_1.png" />
                                    <div>暂无代购单需要处理</div>
                                    <div class="btn-yuan" style="margin-top: 2em;" onclick="ylapp.window.open('daifuadd', 'daifuadd.html', 2, 128);">
                                        立即添加
                                    </div>
                                    
                                </center>-->
                                
                                <ul style="padding-bottom: 4rem">
									<?php
while($rs=$sql->fetch_array())
{
?>
                                    <li onclick="window.location.href='m_form.php?lx=edit&addid=<?=$rs['addid']?>';">
                                        <div class="l_left">
											
                                            <!--<img src="/m/css/images/ico_3.png" />-->
                                        </div>
										<div class="l_right2">
											<?php if($rs['mrs']!=1){?>
                <a href="m_save.php?lx=mr&mrs=1&addid=<?=$rs['addid']?>" class="btn btn-xs btn-default"><?=$LG['address.btn_mrs_1']//设为默认收货?></a>
                <?php }else{ ?>
                <a href="m_save.php?lx=mr&mrs=2&addid=<?=$rs['addid']?>"  class="btn btn-xs btn-success"><?=$LG['address.btn_mrs_2']//取消默认收货?></a>
                <?php }?>

                
				<?php if($rs['mrf']!=1){?>
                <a href="m_save.php?lx=mr&mrf=1&addid=<?=$rs['addid']?>" class="btn btn-xs btn-default"><?=$LG['address.btn_mrf_1']//设为默认发货?></a>
                <?php }else{ ?>
                <a href="m_save.php?lx=mr&mrf=2&addid=<?=$rs['addid']?>"  class="btn btn-xs btn-success"><?=$LG['address.btn_mrf_2']//取消默认发货?></a>
                <?php }?>
										</div>
                                        <div class="l_right">
                                            <div class="t1">
                                                <?=cadd($rs['truename'])?>（<?=AddClass($rs['addclass'])?>）
                                            </div>
                                            <div class="t2">
                                                <?=$rs['tel']?>
                                                </div>
											<div class="t2">
                                                <?=$rs['add_shengfen'].' '.$rs['add_chengshi'].' '.$rs['add_quzhen'].' '.$rs['add_dizhi']?>
                                                </div>
                                            
                                        </div>
										
                                        <div style="clear:both"></div>
                                    </li>
                                    
                                    <?php
}
?>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	</div>
		
		<div style="background: #FFFFFF;padding-top: .5rem;padding-bottom:.5rem;text-align: center;position: fixed;bottom: 0;width: 100%;">
            <div class="btn-yuan" onclick="ylapp.window.open('daifuorderadd', 'm_form.php', 2, 128);">添加新地址</div>
        </div>