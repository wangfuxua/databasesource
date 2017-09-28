<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/function.php');
$pervar='daigou';
require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/session.php');

$_SESSION['isMobile']	 = 1;
$ism					 = 1;
$m						 = '/m';

$headtitle="代购";//代购

$callFrom='member';//member 会员中心

require_once($_SERVER['DOCUMENT_ROOT'] . '/m/template/incluce/header.php');

?>

<script src="/m/js/p-pull-refresh.js"></script>
        <style>
            .c_list{
                margin-top: 2.5rem;
                font-size: 1rem;
                margin-bottom: 3.5rem;
            }
            .c_list .btn-yuan{
                width: 60%;
                margin: 0 auto;
                background: #fe8361;
                color:#ffffff;
                height: 2.5rem;
                line-height: 2.5rem;
                border-radius:1rem;
                margin-top: 1rem;
            }
            
            .c_list li{
                background: #FFFFFF;
                margin-bottom: .5rem;
                text-align: left;
                line-height: 1.2rem;
            }
            .l-1{
                padding: .5rem;
                font-size: .8rem;
            }
            .c_list li .l-1 .status{
                float: right;
                color: #E31114;
                font-size: .8rem;
            }
            .l-2 li{
                background: #f2f2f2;
                margin-bottom: .1rem;
                padding: .5rem;
                text-align: left;
                line-height: 1.2rem;
                font-size: 0.8rem;
            }
            .l-2 .l_left{
                float: left;
                width: 16%;
            }
            .l-2 .l_left img{
                width: 100%;
            }
            .l-2 .l_right{
                float: right;
                width: 70%;
                text-align: left;
            }
            .l-2 .l_status{
                float: right;
                width: 12%;
                color:red;
                text-align:right;
                
            }
            .l-3{
                line-height: 2.5rem;
                font-size: .9rem;
                text-indent: 1rem;
            }
            .l-3-right{
               float: right;
               margin-right: 1rem;
           }
           .l-3-right .tj_btn{
               border-radius: .3rem;
               background: #F1565A;
               color: #FFFFFF;
               border: 0px;
               padding:.2rem;
               padding-left: 1rem;
               padding-right: 1rem;
               font-size: .8rem;
	     line-height: 1.3rem;
           }
           .l-3-left{
               float: left;
           }
            .t1{
                text-overflow:ellipsis;
                overflow: hidden;
                height: 2.4rem;
                line-height:1.2rem;
               word-break:break-all;
               margin-bottom: .3rem;
               color: #333333;
            }
            
            .t2{
               color: #c0bfbf;
               margin-bottom: .3rem;
               text-overflow:ellipsis;
               overflow: hidden;
               line-height: 1rem;
            }
            
            .main-1-top{
               width: 100%;
               background: #fff6e1;
               color: #e87e57;
               padding: .7rem;
               font-size: .8rem;
               text-indent: 2rem;
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
                font-size: .9em;
            }
           
           
            .loading-warp{ display: table; width: 100%; margin-top: -5.8rem; z-index: 888}
.loading-warp .box{ width: 100%; padding-top: 1rem; padding-bottom: 1rem;
 display: table-cell; text-align: center; vertical-align: middle; }
.loading-warp .box img{ display: block; width: 2rem; height: 2rem; margin: 0 auto; }
.loading-warp .box .text{ display: block; text-align: center; font-size: 0.7rem; 
    line-height: 0.5rem; opacity: 0.7; margin-top: 1.4rem; }
            
            
        </style>
    
        <div class="bc-bg" tabindex="0" data-control="PAGE" id="Page">
            <div class="uh cc-head  ubb bc-border" data-control="HEADER" id="Header">
                <div class="ub">
                    <div class="nav-btn" id="nav-left">
                        
                    </div>
                    <h1 class="ut ub-f1 ulev-3 ut-s tx-c" tabindex="0">代购</h1>
                    <div class="nav-btn" id="nav-right">
                        <div class="fa fa-1g ub-img1 fa-plus" style="margin-right: 1em;" onclick="ylapp.window.open('daigouadd', '/xamember/daigou/m_add.php', 2, 128);">
		    </div>
		    <div class="fa fa-headphones ub-img1" onclick="ylapp.window.open('im', '/xamember/im.php', 2, 128);">
		    </div>
                    </div>
                </div>
            </div>
            
            
            
            <div class="" data-control="CONTENT" id="ScrollContent" style="top:13em;">
                
                <div class="scrollbox">
                    <div class="box_bounce ub ub-ver ub-pc">
                        <div class="ub-f1">
                            <div id="tabview2" class="uf sc-bg ubb bc-border" style="background: #FFFFFF;z-index: 999;position: fixed;top:2.4rem;">
                            </div>
                            <input id="list_index" value="0" type="hidden"/>
                            
                            <div class="loading-warp">
                                <div class="box">
                                    <div>
                                        <img src="/m/css/images/reload.gif" />
                                        <span class="text">下拉开始刷新</span>
                                    </div>
                                </div>
                            </div>
    
                            <div class="c_list" id="list1">
                                <!--
                                <center>
                                    <img src="./css/images/i_1.png" />
                                    <div>暂无代购单需要处理</div>
                                    <div class="btn-yuan" style="margin-top: 2em;" onclick="ylapp.window.open('daigouadd', 'daigouadd.html', 2, 128);">
                                        立即添加
                                    </div>
                                    
                                </center>
                                -->
                                <ul>
                                    <li onclick="open_detail(1)">
                                        <div class="l-1">
                                            <div>代购订单：4436546443423434</div>
                                            <div>2017-2-7 12:12:12<span class="status">待算价</span></div>
                                        </div>
                                        <div class="l-2">
                                            <ul>
                                                <li>
                                                    <div class="l_left">
                                                        <img src="css/images/ico_2.png" />
                                                    </div>
                                                    
                                                    <div class="l_status">
                                                        待算价
                                                    </div>
                                                    
                                                    <div class="l_right">
                                                        <div class="t1">
                                                            
                                                                http://www.divcss5.com/rumen/r/r532.shtml?http://w532.shtml?http://www.divcss5.com/rumen/r532.shtml
                                                            
                                                        </div>
                                                        <div class="t2">
                                                            <b>数量：</b>111。<b>规格：</b>设置或检索是否使用一个省略号标记（...）标示对象内文本文字的溢出.
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div style="clear:both"></div>
                                                </li>
                                                
                                                <li>
                                                    <div class="l_left">
                                                        <img src="css/images/ico_2.png" />
                                                    </div>
                                                    
                                                    <div class="l_status">
                                                        待算价
                                                    </div>
                                                    
                                                    <div class="l_right">
                                                        <div class="t1">
                                                            
                                                                http://www.divcss5.com/rumen/r/r532.shtml?http://w532.shtml?http://www.divcss5.com/rumen/r532.shtml
                                                            
                                                        </div>
                                                        <div class="t2">
                                                            <b>数量：</b>111。<b>规格：</b>设置或检索是否使用一个省略号标记（...）标示对象内文本文字的溢出.
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div style="clear:both"></div>
                                                </li>
                                                
                                            </ul>
                                        </div>
                                        <div class="l-3">
                                            共1件
                                        </div>
                                    </li>
                                    
                                    <li onclick="open_detail(1)">
                                        <div class="l-1">
                                            <div>代购订单：4436546443423434</div>
                                            <div>2017-2-7 12:12:12<span class="status">待算价</span></div>
                                        </div>
                                        <div class="l-2">
                                            <ul>
                                                <li>
                                                    <div class="l_left">
                                                        <img src="css/images/ico_2.png" />
                                                    </div>
                                                    <div class="l_right">
                                                        <div class="t1">
                                                            
                                                                http://www.divcss5.com/rumen/r/r532.shtml?http://w532.shtml?http://www.divcss5.com/rumen/r532.shtml
                                                            
                                                        </div>
                                                        <div class="t2">
                                                            <b>数量：</b>111。<b>规格：</b>设置或检索是否使用一个省略号标记（...）标示对象内文本文字的溢出.
                                                        </div>
                                                        
                                                    </div>
                                                    <div style="clear:both"></div>
                                                </li>
                                                
                                                <li>
                                                    <div class="l_left">
                                                        <img src="css/images/ico_2.png" />
                                                    </div>
                                                    <div class="l_right">
                                                        <div class="t1">
                                                            
                                                                http://www.divcss5.com/rumen/r/r532.shtml?http://w532.shtml?http://www.divcss5.com/rumen/r532.shtml
                                                            
                                                        </div>
                                                        <div class="t2">
                                                            <b>数量：</b>111。<b>规格：</b>设置或检索是否使用一个省略号标记（...）标示对象内文本文字的溢出.
                                                        </div>
                                                        
                                                    </div>
                                                    <div style="clear:both"></div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="l-3">
                                            <div class="l-3-left">共2件</div>
                                            <div class="l-3-right">
                                                <button class="tj_btn">提交订单</button>
                                            </div>
                                            <div style="clear: both"></div>
                                        </div>
                                    </li>
                                    
                                </ul>
                            </div>
                            <div class="c_list" id="list2" style="display: none;">
								<div class="main-1-top">
                                    代付账号：15921688717<div style="float: right;padding-right: 2em;margin-bottom: .5rem;" id="copy_btn" data="15921688717">复制</div>
                                </div>
								<div style="margin-top:1rem;width:90%;margin:0 auto;">
									
									<form action="m_daifu_save.php" method="post" class="form-horizontal form-bordered" name="xingao" enctype ="multipart/form-data">
									<input name="lx" type="hidden" value="<?=add($lx)?>">
									<input name="tokenkey" type="hidden" value="<?=$tokenkey?>">
									<input name="status" type="hidden" value="12">
									<input name="title"  type="hidden" class="form-control placeholder-no-fix" placeholder="<?=$LG['msg.form_2'];//标题?>" required  title="<?=$LG['msg.form_2'];//标题?>" value="我要代付"/>
									
									<textarea  class="form-control" rows="4" name="content" placeholder="<?=$LG['msg.form_3'];//内容?>..."  title="<?=$LG['msg.form_3'];//内容?>"  required ></textarea>
									
									<input id="file" accept="image/*;capture=camera" type="file" name="file" style="font-size:.8rem;margin-top:1rem;">
									
									<div style="text-align: center">
                                <button class="btn-yuan" type="submit" style="margin-top: 2em;" id="add_btn">
                                        提   交
                                    </button>
                            </div>   
								</form>
								</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uf sc-bg ubt sc-border-tab" data-control="FOOTER" id="footer">
            
        </div>
		
	<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/m/template/incluce/footer.php');
	?>
        
        <script>
        
        //打开代购详情
        function open_detail(id){
            ylapp.window.open('orderdetail', 'orderdetail.html', 2, 128);
        }
        //打开代付详情
        function open_daifu_detail(id){
            ylapp.window.open('daifuorderdetail', 'daifuorderdetail.html', 2, 128);
        }
        
        //提交代付订单
        function daifu_submit(id){
            ylapp.window.open('daifuordersubmit', 'daifuordersubmit.html', 2, 128);
        }
        
        //初始化下拉状态
        var $statu = $('.loading-warp .text');
    //代购单下拉刷新
    var pullRefresh = $('#list1').pPullRefresh({
        $el: $('#list1'),
        $loadingEl: $('.loading-warp'),
        sendData: null,
        url: 'test.php',
        callbacks: {
            pullStart: function(){
                $statu.text('松开开始刷新');
            },
            start: function(){
                $statu.text('数据刷新中···');
            },
            success: function(response){
                $statu.text('数据刷新成功！');
            },
            end: function(){
                $statu.text('下拉刷新结束');
            },
            error: function(){
                $statu.text('找不到请求地址,数据刷新失败');
            }
        }
    });

ylapp.ready(function() {
    ylapp.window.on('resume',function(){
        /* 窗口到前台执行 */
        //初始化导航hover
        tabview.moveTo(1);
    });
    tabview.moveTo(1);
    //alert(navigator.platform);
    //var tempH = $('#Header').offset().height;
    if (navigator.platform=="Win32"){
        $("#ScrollContent").css("top","12.5em");
    }
});

 /*tab切换*/
           var tabview2 = ylapp.tab({
                selector : "#tabview2",
                hasIcon : false,
                hasAnim : true,
                hasLabel : true,
                hasBadge : false,
                data : [{
                label : "代购单",
                    }, {
                label : "代付单",
                    }]
            });
			
			var clipboard = new Clipboard('#copy_btn', {
                    text: function() {
                        return $("#copy_btn").attr("data");
                    }
                });
                clipboard.on('success', function(e) {
                    alert("已复制到粘贴板");
                });
				
            tabview2.on("click",function(obj, index){ /*TAB变更时切换多浮动窗口*/
                if (index==1){
                    $("#list2").show();
                    $("#list1").hide();
                } else {
                    $("#list2").hide();
                    $("#list1").show();
                }
            });
        </script>
    </body>

</html>