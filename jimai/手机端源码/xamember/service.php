<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/function.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/session.php');

$_SESSION['isMobile']	 = 1;
$ism					 = 1;
$m						 = '/m';

$headtitle="服务";//代购

require_once($_SERVER['DOCUMENT_ROOT'] . '/m/template/incluce/header.php');

?>

    
        <div class="bc-bg" tabindex="0" data-control="PAGE" id="Page">
            
            <div class="uh cc-head  ubb bc-border" data-control="HEADER" id="Header">
                <div class="ub">
                    <div class="nav-btn" id="nav-left">
                        
                    </div>
                    <h1 class="ut ub-f1 ulev-3 ut-s tx-c" tabindex="0">服务</h1>
                    <div class="nav-btn" id="nav-right">
                        
                    </div>
                </div>
            </div>
            
            <div id="listview1" class="ubt bc-border sc-bg c-wh umar-at1" style="margin-top: 3.5rem;background: #fff;font-size: .9rem;">
                
            </div>
            <div id="listview2" class="ubt bc-border sc-bg c-wh umar-at1" style="margin-top: 1rem;background: #fff;font-size: .9rem;">
                
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
                    tabview.moveTo(2);
                });
                tabview.moveTo(2);
                
            });


        var lv1 = ylapp.listview({
            selector : "#listview1",
            type : "thinLine",
            hasIcon : true,
            hasAngle : true,
            hasSubTitle : true,
            multiLine : 1
        });
        lv1.set([{
            id : "1",
            icon : '/m/css/images/s1.png',
            title : '常见问题',
            subTitle : '禁运物品/集运条款',
        }, {
            id : "2",
            icon : '/m/css/images/s2.png',
            title : '视频简介',
            subTitle : '观看Jbuy宣传视频'
        },{
            id : "3",
            icon : '/m/css/images/s3.png',
            title : '流程介绍',
            subTitle : '不知道怎么买？没关系，看这里'
        }]);
        lv1.on('click', function(ele, context, obj, subobj) {
            var id = context.id;
            switch(id){
                case '1':
                    ylapp.window.open('faq', '/xamember/faq.php', 2, 128);
                break;
                case '2':
                    ylapp.window.open('video', '/xamember/video.php', 2, 128);
                break;
                case '3':
                    ylapp.window.open('lcjs', 'http://h.eqxiu.com/s/sMfqDiCE?eqrcode=1&from=groupmessage&isappinstalled=0', 2, 128);
                break;
            }
        });
        var lv2 = ylapp.listview({
            selector : "#listview2",
            type : "thinLine",
            hasIcon : true,
            hasAngle : true,
            hasSubTitle : true,
            multiLine : 1
        });
        lv2.set([{
            id : "1",
            icon : '/m/css/images/s4.png',
            title : '运费估算',
            subTitle : '运费早知道，提前计划好',
        },/* {
            id : "2",
            icon : '/m/css/images/s5.png',
            title : '汇率牌价',
            subTitle : '了解今日汇率'
        },*/{
            id : "3",
            icon : '/m/css/images/s6.png', 
            title : '运费报价',
            subTitle : '查看最新的运费报表'
        }]);
        lv2.on('click', function(ele, context, obj, subobj) {
            var id = context.id;
            switch(id){
            case '1':
                ylapp.window.open('yunfei', '/xamember/yunfeigusuan.php', 2, 128);
            break;
            case '2':
                ylapp.window.open('huilv', 'huilv.html', 2, 128);
            break;
            case '3':
                ylapp.window.open('price', '/xamember/other/m_tab.php', 2, 128);
            break;
            }
        });


        </script>
    </body>

</html>