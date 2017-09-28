<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/function.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/session.php');

$_SESSION['isMobile']	 = 1;
$ism					 = 1;
$m						 = '/m';

$headtitle="我的";//代购

require_once($_SERVER['DOCUMENT_ROOT'] . '/m/template/incluce/header.php');

$mr=FeData('member','*',"userid='{$Muserid}'");

?>


<style>
            .banImg{
                background-image:url('/m/css/images/u_bg.jpg');
            }
            .userImg{
                background-image:url('/m/css/images/user.png');
            }
            /*
 * 头部
 * */
.uh-per1{
    height:6em;
}
.uwh-per2{
    height:2.875em;
    width:2.875em;
}
.uwh-per3{
    height:2.25em;
    width:2.25em;
}
.umar-per1{
    margin:0.125em;
}
.umar-per2{
    margin:-0.625em 0.625em 0.5625em 0;
}
.umar-b-per3{
    margin-bottom:-0.5em;
}
.t-gra-per{
    color:#8b8b8b;
}

.b-gra-per1{
    border-color:#d1d1d1;
}
.uinn-per1{
    padding:0.40625em 0 0.5em 0;
}
.triangle2 {
    width: 0px;
    border-top: 0.46875em solid #a0a0a0;
    border-right: 0.46875em solid #f1f1f1;
    border-bottom: 0;
    border-left: 0.46875em solid #f1f1f1;
}
.c-gra-per1{
    background-color:#a0a0a0;
}
.uinn-a7{
    padding:0 0.625em;
}
.uinn-a1{
    padding:0.625em;
}
.mar-ar1{
    margin-right:0.625em;
}
.umar-at1{
    margin-top:0.625em;
}
.c-wh{
    background-color: white;
}
.ulev-app2{
    font-size:0.9375em;
}
.ufm1{
    font-family:Arial;
}
/*
 * 中部
 * */
.umar-FP1{
    margin:0 1.25em;
}
.umar-r-FP1{
    margin-right:1.25em;
}
.umar-r-FP2{
    margin-right:0.75em;
}
.uinn-FP1{
    padding:0.625em 0;
}
.uwh-FP1{
    width:1.3125em;
    height:1.3125em;
}
.uwh-FP2{
    width:3.6em;
    height:1.8em;
}
.t-gra-FP1{
    color:#c2c2c2;
}
.uc-a-FP1 {
    -webkit-border-radius: 0.9em;
    border-radius: 0.9em;
}
.uinn3
{
    padding:0.2em;
}
.t-gra6{
    color:#c2c2c2;
}
.umar-ar3{
    margin-right:0.5em;
}
.umar-at1{
    margin-top:0.625em;
}
.c-wh{
    background-color: white;
}
.uinn-a11{
    padding:0.625em 0;
}
.uinn-a7{
    padding:0 0.625em;
}
.ufm1{
    font-family:Arial;
}

.open_ico{
    width: 1rem;
    height: 1rem;text-align: center;
    margin-right: .2rem;
    background: #A0A0A0;
}

.hong{
            border-radius: 50%;
            width: .6rem;
            height: .6rem;
            background: #F1565A;
            text-align: center;
            position: absolute;
            margin-top: -1.8rem;
            font-size: .5rem;
            margin-left: 1rem;
            color: #FFFFFF
        }
        </style>
    
        <div class="bc-bg" tabindex="0" data-control="PAGE" id="Page">
            
            <div class="uh cc-head  ubb bc-border" data-control="HEADER" id="Header">
                <div class="ub">
                    <div class="nav-btn" id="nav-left">
                        
                    </div>
                    <h1 class="ut ub-f1 ulev-3 ut-s tx-c" tabindex="0">我的</h1>
                    <div class="nav-btn" id="nav-right">
                        
                    </div>
                </div>
            </div>
            
            <div id="content" class="ub-f1 tx-l t-bla c-gra1" style="top:2.5rem;z-index:99999">
                <div class="ub ub-ver">
                    <!--<div class="ub-img1 ub-fh uh-per1 banImg"></div>-->
                    <div class="ub sc-bg uinn-a7" onclick="">
                        <div class="uba bc-border c-wh umar-per2">
                            <div class="ub-img uwh-per2 userImg umar-per1" id="face"></div>
                        </div>
                        <div class="ub ub-ver ub-f1">
                            <div class="ulev-app2 umar-t" onclick="ylapp.window.open('open', '/xamember/open/index.php', 2, 128);">
                                <div class="ufl uinn1" id="truename">国民小斌</div>
                                <div class="ufl sc-bg-alert uc-a1 uinn3 ulev-2 bc-text-head open_ico" style="background: #E87E57;">
                                    <i class="fa fa-mobile"></i>
                                </div>
                                <div class="ufl sc-bg-alert uc-a1 uinn3 ulev-2 bc-text-head open_ico" style="background:green">
                                    <i class="fa fa-comments"></i>
                                </div>
                                <div class="ufl sc-bg-alert uc-a1 uinn3 ulev-2 bc-text-head open_ico" style="background: #007DB8">
                                    <i class="fa fa-envelope"></i>
                                </div>
                            </div>
                            
                            <div class="ut-s t-gra-per ulev-4 umar-t">
                                
                            </div>
                            
                        </div>
                    </div>
                    <div class="ub sc-bg-active">
                        <div class="ub-f1 ub ub-ver ub-ac  b-gra-per1 ubt ubb ubr">
                            <div class="ub ub-ver ub-ac uinn-per1">
                                <div class="t-gra-per ulev-4">
                                    余额
                                </div>
                                <div class="sc-text-warn ulev-app2 ufm1 umar-at1" id="service">
                                    ￥<?php $r_money=spr_sepa($mr['money']);echo $r_money[0];?>
                                </div>
                            </div>
                        </div>
                        <div class="ub-f1 ub ub-ver ub-ac  b-gra-per1 ubt ubb">
                            <div class="ub ub-ver ub-ac uinn-per1" onclick="ylapp.window.open('youhuiquan', '/xamember/coupons/m_list.php', 2, 128);">
                                <div class="t-gra-per ulev-4">
                                    优惠券
                                </div>
                                <div class="sc-text-warn ulev-app2 ufm1 umar-at1" id="youhuiquan">
                                    <?php
							$cp=FeData('coupons',' count(*) as total,sum(`number`) as number',"status=0 {$Mmy}");
							echo $cp['number'];
						 ?>
                                </div>
                            </div>
                        </div>
                       <div class="ubl ub-f1 ub ub-ver ub-ac  b-gra-per1 ubt ubb">
                            <div class="ub ub-ver ub-ac uinn-per1" onclick="ylapp.window.open('im', '/xamember/im.php', 2, 128);">
                                <div class="t-gra-per ulev-4">
                                     在线客服
                                </div>
                                <div class="sc-text-warn ulev-app2 ufm1 umar-at1">
                                     <div class="fa fa-headphones"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="line-height: 2rem;padding-left: .5rem;">我的运单</div>
                    <div class="ub sc-bg-active" style="background: #FFFFFF;font-size: .8rem;">
                        <div class="ub-f1 ub ub-ver ub-ac  b-gra-per1 ubt ubb ubr">
                            <div class="ub ub-ver ub-ac uinn-per1" onclick="ylapp.window.open('yundan', '/xamember/yundan/m_list.php?status=-1', 2, 128);">
                                <div class="t-gra-per ulev-4">
                                    <div class="fa fa-barcode fa-2x"></div>
                                    <?=CountNum($CN_table='yundan',$CN_field='status',$CN_zhi=-1,$CN_where="",$CN_userid=$Muserid,$CN_color='warning');?>
                                </div>
                                <div class="ulev-app2 ufm1 umar-at1">
                                    待入库
                                </div>
                            </div>
                        </div>
                        <div class="ub-f1 ub ub-ver ub-ac  b-gra-per1 ubt ubb ubr" onclick="ylapp.window.open('yundan', '/xamember/yundan/m_list.php?status=0', 2, 128);">
                            <div class="ub ub-ver ub-ac uinn-per1" onclick="">
                                <div class="t-gra-per ulev-4">
                                    <div class="fa fa-filter fa-2x"></div>
				<?=$ydnum_status_0=CountNum($CN_table='yundan',$CN_field='status',$CN_zhi=0,$CN_where="",$CN_userid=$Muserid,$CN_color='warning');?>
                                </div>
                                <div class="ulev-app2 ufm1 umar-at1" id="service">
                                    待审核
                                </div>
                            </div>
                        </div>
                        <div class="ub-f1 ub ub-ver ub-ac  b-gra-per1 ubt ubb" onclick="ylapp.window.open('yundan', '/xamember/yundan/m_list.php?status=2', 2, 128);">
                            <div class="ub ub-ver ub-ac uinn-per1">
                                <div class="t-gra-per ulev-4">
                                    <div class="fa fa-question fa-2x"></div>
									<?=$ydnum_status_2=CountNum($CN_table='yundan',$CN_field='status',$CN_zhi=2,$CN_where="",$CN_userid=$Muserid,$CN_color='warning');?>
                                </div>
                                <div class="ulev-app2 ufm1 umar-at1" id="abilityrating">          
                                    待打包
                                </div>
                            </div>
                        </div>
                       <div class="ubl ub-f1 ub ub-ver ub-ac  b-gra-per1 ubt ubb" onclick="ylapp.window.open('yundan', '/xamember/yundan/m_list.php?status=3', 2, 128);">
                            <div class="ub ub-ver ub-ac uinn-per1">
                                <div class="t-gra-per ulev-4">
                                     <div class="fa fa-credit-card fa-2x"></div>
									 <?=$ydnum_status_3=CountNum2($CN_table='yundan',$CN_field='status',$CN_zhi=3,$CN_where="",$CN_userid=$Muserid,$CN_color='warning');?>
                                </div>
                                <div class="ulev-app2 ufm1 umar-at1">
                                     待付款
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
               
            </div>
            
            <div id="listview1" class="ubt bc-border sc-bg c-wh umar-at1" style="background: #fff;font-size: .8rem;margin-top:3rem;">
                
                </div>
			
			<div class="uf sc-bg ubt sc-border-tab" data-control="FOOTER" id="footer">
            
        </div>
		
	<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/m/template/incluce/footer.php');
	?>
        
        <script>
        ylapp.ready(function() {
                ylapp.window.on('resume',function(){
                    /* 窗口到前台执行 */
                    //初始化导航hover
                    tabview.moveTo(3);
                });
                tabview.moveTo(3);
                
               
            });
            
            var lv1 = ylapp.listview({
            selector : "#listview1",
            type : "thinLine",
            hasIcon : true,
            hasAngle : false,
            hasSubTitle : true,
            multiLine : 1
        });
        lv1.set([/*{
            id : "1",
            icon : '/m/css/images/u1.png',
            title : '查看历史记录',
            subTitle : '',
        }, */{
            id : "2",
            icon : '/m/css/images/u2.png',
            title : '我的地址簿',
            subTitle : '我的收货地址'
        },{
            id : "3",
            icon : '/m/css/images/u3.png',
            title : '我的中转地址',
            subTitle : '我的国内私人专属小仓库'
        },{
            id : "5",
            icon : '/m/css/images/u5.png',
            title : '安全中心',
            subTitle : ''
        },{
            id : "6",
            icon : '/m/css/images/u6.png',
            title : '在线客服',
            subTitle : ''
        }]);
        lv1.on('click', function(ele, context, obj, subobj) {
            var id = context.id;
            switch(id){
                case '1':
                    ylapp.window.open('history', 'history.html', 2, 128);
                break;
                case '2':
                    ylapp.window.open('address', '/xamember/address/m_list.php', 2, 128);
                break;
                case '3':
                    ylapp.window.open('aaaaaa', '/xamember/other/warehouse.php', 2, 128);
                break;
                case '5':
                    ylapp.window.open('open', '/xamember/open/index.php', 2, 128);
                break;
                case '6':
                    ylapp.window.open('im', '/xamember/im.php', 2, 128);
                break;
            }
        });
		
		
		
        </script>
    </body>

</html>