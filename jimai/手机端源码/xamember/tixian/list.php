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
require_once($_SERVER['DOCUMENT_ROOT'].'/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/public/function.php');
$pervar='off_tixian';//权限验证
require_once($_SERVER['DOCUMENT_ROOT'].'/xamember/incluce/session.php');
$headtitle=$LG['tixian.list_1'];//提现管理
require_once($_SERVER['DOCUMENT_ROOT'].'/xamember/incluce/head.php');


//搜索
$where="1=1";
$so=(int)$_GET['so'];
if($so==1)
{
	$key=par($_GET['key']);
	$stime=par($_GET['stime']);
	$etime=par($_GET['etime']);
	$status=par($_GET['status']);
	
	if($key){$where.=" and (bank like '%{$key}%' or name like '%{$key}%')";}
	if($stime){$where.=" and addtime>='".strtotime($stime.' 00:00:00')."'";}
	if($etime){$where.=" and addtime<='".strtotime($etime.' 23:59:59')."'";}
	if(CheckEmpty($status)){$where.=" and status='{$status}'";}

	$search.="&so={$so}&key={$key}&stime={$stime}&etime={$etime}&status={$status}";
}

$order=' order by status asc,txid desc';//默认排序
include($_SERVER['DOCUMENT_ROOT'].'/public/orderby.php');//排序处理页


//echo $search;exit();
$query="select * from tixian where {$where}  {$Mmy} {$order}";

//分页处理
//$line=20;$page_line=15;//$line=-1则不分页(不设置则默认)
include($_SERVER['DOCUMENT_ROOT'].'/public/page.php');
?>

<div class="page_ny"> 
  <!-- BEGIN PAGE HEADER-->
	<div class="row"><!--单页时去掉 class="row",不然会有横滚动条,并且form 加 style="margin:20px;"-->
		<div class="col-md-12"> 
<!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3 class="page-title"> <a href="javascript:void(0)" onClick="javascript:window.location.href=window.location.href;" title="<?=$LG['refresh']?>" class="gray">
        <?=$headtitle?>
        </a> </h3>
      <ul class="page-breadcrumb breadcrumb">
        <button type="button" class="btn btn-info" onClick="location.href='form.php';"><i class="icon-plus"></i> <?=$LG['name.nav_48'];//申请提现?> </button>
      </ul>
      <!-- END PAGE TITLE & BREADCRUMB--> 
    </div>
  </div>
  <!-- END PAGE HEADER--> 
  
  <!-- BEGIN PAGE CONTENT-->
  <div class="tabbable tabbable-custom boxless">
    <div class="tab-content" style="padding:10px;"> 
      <!--搜索-->
      <div class="navbar navbar-default" role="navigation">
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <form class="navbar-form navbar-left"  method="get" action="?">
            <input name="so" type="hidden" value="1">
            <input name="my" type="hidden" value="<?=$my?>">
            <div class="form-group">
              <input type="text" name="key" class="form-control input-msmall popovers" data-trigger="hover" data-placement="right"  data-content="<?=$LG['tixian.list_2'];//银行/姓名 (可留空)?>" value="<?=$key?>">
            </div>
            <div class="form-group">
              <div class="col-md-0">
                <div class="input-group input-xmedium date-picker input-daterange" data-date-format="yyyy-mm-dd">
                  <input type="text" class="form-control input-small" name="stime" value="<?=$stime?>" title="<?=$LG['tixian.list_3'];//申请时间?>">
                  <span class="input-group-addon">-</span>
                  <input type="text" class="form-control input-small" name="etime" value="<?=$etime?>"  title="<?=$LG['tixian.list_3'];//申请时间?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-0">
                <select  class="form-control input-small select2me" name="status" data-placeholder="<?=$LG['status'];//状态?>">
                  <option></option>
                  <?=tixian_Status($status,1)?>
                </select>
              </div>
            </div>
            <button type="submit"  class="btn btn-info"><i class="icon-search"></i> <?=$LG['search'];//搜索?></button>
          </form>
        </div>
      </div>
      
      
      <form action="save.php" method="post" name="XingAoForm">
        <input name="lx" type="hidden">
       
        <table class="table table-striped table-bordered table-hover" >
          <thead>
            <tr>
              <th align="center" class="table-checkbox"> <input type="checkbox"  id="aAll" onClick="chkAll(this)"  title="<?=$LG['checkAll'];//全选/取消?>"/>
              </th>
              <th align="center"><a href="?<?=$search?>&orderby=addtime&orderlx=" class="<?=orac('addtime')?>"><?=$LG['tixian.list_3'];//申请时间?></a></th>
              <th align="center"><a href="?<?=$search?>&orderby=money&orderlx=" class="<?=orac('money')?>"><?=$LG['tixian.list_6'];//金额?></a></th>
              <th align="center"><a href="?<?=$search?>&orderby=bank&orderlx=" class="<?=orac('bank')?>"><?=$LG['tixian.list_7'];//银行?></a></th>
              
              <th align="center"><a href="?<?=$search?>&orderby=account&orderlx=" class="<?=orac('account')?>"><?=$LG['tixian.list_8'];//账号?></a></th>
              
              <th align="center"><a href="?<?=$search?>&orderby=status&orderlx=" class="<?=orac('status')?>"><?=$LG['status'];//状态?></a></th>
              <th align="center"><a href="?<?=$search?>&orderby=withtime&orderlx=" class="<?=orac('withtime')?>"><?=$LG['tixian.list_9'];//处理时间?></a></th>
              <th align="center"><?=$LG['op'];//操作?></th>
            </tr>
          </thead>
          <tbody>
            <?php
while($rs=$sql->fetch_array())
{
?>
            <tr class="odd gradeX <?=spr($rs['status'])==2?'gray2':''?>">
              <td align="center" valign="middle"><?php if(spr($rs['status'])==3){?>
                <input type="checkbox" id="a" onClick="chkColor(this);"  name="txid[]" value="<?=$rs['txid']?>" />
                <?php }?></td>
              <td align="center" valign="middle"><?=DateYmd($rs['addtime'])?></td>
              <td align="center" valign="middle"><?=spr($rs['money'])?> <?=cadd($rs['currency'])?></td>
              <td align="center" valign="middle"><?=cadd($rs['bank'])?><br>
                <font class="gray2">
                <?=cadd($rs['address'])?>
                </font></td>
              <td align="center" valign="middle"><?=cadd($rs['name'])?><br>
                <font class="gray2">
                <?=cadd($rs['account'])?>
                </font></td>
              <td align="center" valign="middle"><?=tixian_Status(spr($rs['status']))?></td>
              <td align="center" valign="middle"><?=DateYmd($rs['withtime'])?></td>
              <td align="center" valign="middle"><?php if(spr($rs['status'])==3){?>
                <a href="save.php?lx=del&txid=<?=$rs['txid']?>" class="btn btn-xs btn-danger"  onClick="return confirm('<?=$LG['pptDelConfirm'];//确认要删除所选吗?此操作不可恢复!?>');"><i class="icon-remove"></i> <?=$LG['del']?></a>
                <?php
					}
				?></td>
            </tr>
            <tr>
              <td colspan="8" align="left"><?php
         $zhi=cadd($rs['content']);
         if($zhi){
		 ?>
                <div class="gray modal_border"> <strong><?=$LG['tixian.list_11'];//备注?>：</strong>
                  <?php 
			echo leng($zhi,100,"...");
			Modals($zhi,$title=$LG['tixian.list_11'],$time=$rs['addtime'],$nameid='content'.$rs['txid'],$count=100);
			?>
                </div>
                <?php }?>
                
                <!---->
                
                <?php
         $zhi=cadd($rs['reply']);
         if($zhi){
		 ?>
                <div class="gray modal_border"> <strong><?=$LG['tixian.list_13'];//回复?>：</strong>
                  <?php 
			echo leng($zhi,100,"...");
			Modals($zhi,$title=$LG['tixian.list_13'],$time=$rs['replytime'],$nameid='reply'.$rs['txid'],$count=100);
			?>
                </div>
                <?php }?>
                
                <!----></td>
            </tr>
            <?php
}
?>
          </tbody>
        </table>			
            
            
<!--底部操作按钮固定--> 
<script>/*$(function(){ Autohidden(); });*/</script> <!--拉到底时自动隐藏-->
<style>body{margin-bottom:40px !important;}</style><!--不用隐藏,增高底部高度-->
 
<div align="right" class="fixed_btn" id="Autohidden">



<?php if(!$off_delbak||$off_delbak&&$status==0){?>
<!--btn-danger--><button type="submit"  class="btn btn-grey" onClick="
document.XingAoForm.lx.value='del';
return confirm('<?=$LG['pptDelConfirm'];//确认要删除所选吗?此操作不可恢复!?>');
"><i class="icon-signin"></i> <?=$LG['delSelect'];//删除所选?></button>
<?php }?>
       </div>
        <div class="row">
          <?=$listpage?>
        </div>
      </form>
    </div>
    <!--表格内容结束--> 
    
  </div>
</div>
<?php
$sql->free(); //释放资源
require_once($_SERVER['DOCUMENT_ROOT'].'/xamember/incluce/foot.php');
?>
