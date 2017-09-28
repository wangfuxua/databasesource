<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/function.php');
$noper = 1;
require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/session.php');


$_SESSION['isMobile']	 = 1;
$ism					 = 1;
$m						 = '/m';

$headtitle=$LG['name.nav_17'];//运单管理


$where="1=1";
$status=par($_GET['status']);
//取出保存的ID
$id_name='ydid';
if($_SESSION["old_status"]==$status)
{
	$id_checked=ToArr(par($_SESSION[$id_name]));
}else{
	$_SESSION[$id_name]='';
}
$_SESSION["old_status"]=$status;



if(CheckEmpty($status))
{
	switch($status)
	{
		case 'chuku':
			$where.=" and status>4 and status<30";
		break;
		
		case 'all':
			$where.="";
		break;
		
		default:
			$where.=" and status='{$status}'";
	}
}
$search.="&status={$status}";


//搜索
$so=(int)$_GET['so'];

if($so==1)
{
	$key=par($_GET['key']);
	$warehouse=par($_GET['warehouse']);
	$country=par($_GET['country']);
	$channel=par($_GET['channel']);
	$addSource=par($_GET['addSource']);
	$tally=par($_GET['tally']);
	
	$stime_add=par($_GET['stime_add']);
	$etime_add=par($_GET['etime_add']);
	$stime_chuku=par($_GET['stime_chuku']);
	$etime_chuku=par($_GET['etime_chuku']);
	     
	     
	if($key)
	{
		//联表查询:查包裹表	
		$query_table="select bgid from baoguo where bgydh like '%{$key}%'";
		$sql_table=$xingao->query($query_table);
		while($r=$sql_table->fetch_array())
		{
			$where_table.=" or find_in_set('{$r['bgid']}',bgid)";
		}

		//联表查询:查代购表	
		$query_table="select goid from daigou_goods where godh like '%{$key}%'";
		$sql_table=$xingao->query($query_table);
		while($r=$sql_table->fetch_array())
		{
			$where_table.=" or find_in_set('{$r['goid']}',goid)";
		}

		$where.=" and (ydid='".CheckNumber($key,-0.1)."' or lotno='{$key}' or whPlace='{$key}' or hscode like '%{$key}%' or ydh like '%{$key}%' or gwkdydh like '%{$key}%' or gnkdydh like '%{$key}%' or dsfydh like '%{$key}%' or s_name like '%{$key}%' or s_mobile like '%{$key}%'  {$where_table}  )";
	}
		
	if(CheckEmpty($warehouse)){$where.=" and warehouse='{$warehouse}'";}
	if(CheckEmpty($country)){$where.=" and country='{$country}'";}
	if(CheckEmpty($channel)){$where.=" and channel='{$channel}'";}
	if(CheckEmpty($addSource)){$where.=" and addSource='{$addSource}'";}
	if(CheckEmpty($tally)){$where.=" and tally='{$tally}'";}
	if($stime_add){$where.=" and addtime>='".strtotime($stime_add." 00:00:00")."'";}
	if($etime_add){$where.=" and addtime<='".strtotime($etime_add." 23:59:59")."'";}
	if($stime_chuku){$where.=" and chukutime>='".strtotime($stime_chuku." 00:00:00")."'";}
	if($etime_chuku){$where.=" and chukutime<='".strtotime($etime_chuku." 23:59:59")."'";}
	
	//筛选菜单
	$field=par($_GET['field']);
	$zhi=par($_GET['zhi']);
	if(CheckEmpty($field)&&CheckEmpty($zhi)){$where.=" and {$field}='{$zhi}' ";}

	$search.="&so={$so}&key={$key}&warehouse={$warehouse}&country={$country}&channel={$channel}&addSource={$addSource}&stime_add={$stime_add}&etime_add={$etime_add}&stime_chuku={$stime_chuku}&etime_chuku={$etime_chuku}";
}

$order=' order by ydh desc,status asc';//默认排序
include($_SERVER['DOCUMENT_ROOT'].'/public/orderby.php');//排序处理页

$_SESSION['Mexport_yundan']=$where;
$query="select * from yundan where {$where}  {$Mmy} {$order}";

//分页处理
//$line=20;$page_line=15;//$line=-1则不分页(不设置则默认)
//include($_SERVER['DOCUMENT_ROOT'].'/public/page.php');

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
				<h1 class="ut ub-f1 ulev-3 ut-s tx-c" tabindex="0">
					<?php
					if ($status==-1) {
						echo "待入库运单";
					} elseif ($status==0) {
						echo "待审核运单";
					} elseif ($status==3) {
						echo "待支付运单";
					}elseif ($status==2) {
						echo "待打包运单";
					}
					?>
				</h1>
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
$tri=0;
while($rs=$sql->fetch_array())
{
	$tri+=1;
	$mr=FeData('member','groupid,CustomerService',"userid='{$rs['userid']}'");
	$groupid=$mr['groupid'];
	
	//是否勾选
	$checked=0; if(have($id_checked,$rs['ydid'])){$checked=1;}
?>
                                    <li onclick="window.location.href='m_form.php?lx=edit&ydid=<?=$rs['ydid']?>';">
                                        <div class="l_left">
											
                                            <!--<img src="/m/css/images/ico_3.png" />-->
                                        </div>
										<div class="l_right2">
											状态：<a href="/yundan/m_status.php?ydh=<?=$rs['ydh']?>" target="_blank"><?=status_name(spr($rs['status']),$rs['statustime'],$rs['statusauto'])?>
							</a>
											<br/>
											<?php echo date('Y-m-d H:i:s', $rs['addtime']);?>
							
										</div>
                                        <div class="l_right">
                                            <div class="t1">
                                                运单号：<?=$rs['ydid']?>
                                            </div>
                                            <div class="t2">
                                                寄往国家：<?=yundan_Country(spr($rs['country']))?>（渠道：<?=channel_name($groupid,$rs['warehouse'],$rs['country'],$rs['channel'])?>）
                                                </div>
											<div class="t2">
                                                收件人：<?=cadd($rs['s_name'])?>（<font class="gray2"><?=cadd($rs['s_mobile_code'])?>-<?=cadd($rs['s_mobile'])?></font>）
                                                </div>
                                            
                                        </div>
										
                                        <div style="clear:both"></div>
                                    </li>
                                    
                                  <?php }?>    
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	</div>
		
		<div style="background: #FFFFFF;padding-top: .5rem;padding-bottom:.5rem;text-align: center;position: fixed;bottom: 0;width: 100%;">
				<div class="btn-yuan" onclick="ylapp.window.open('daifuorderadd', 'm_form.php', 2, 128);">添加运单</div>
			</>