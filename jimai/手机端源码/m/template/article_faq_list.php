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

//http://zy/m/template/article_faq_list.php?classid=36
//获取,处理
$url=$_SERVER['REQUEST_URI'];

//获取,处理

$lx=par($_GET['lx']);

$classid=(int)$_GET['classid'];

//验证,查询
if(!$_SESSION['manage']['userid']&&$lx!='html'){XAts('temp');}
if(!$classid)
{
	echo ("<script>alert('classid{$LG['pptError']}');goBack('uc');</script>");  goto checked;
}

$cr=ClassData($classid);
$headtitle=$cr['seotitle'.$LT]?cadd($cr['seotitle'.$LT]):cadd($cr['name'.$LT]);
$search.="&classid={$classid}";

require_once($_SERVER['DOCUMENT_ROOT'].'/m/template/incluce/header.php');//放查询的后面
require_once($_SERVER['DOCUMENT_ROOT'].'/m/template/incluce/top.php');
?>

<!--内容开始-->
<div class="article_ny">
	<span class="title"><?=cadd($cr['name'.$LT])?> </span>
	<div id="accordion1" class="panel-group">
	 <?php 
	$order=' order by istop desc,isgood desc,ishead desc,edittime desc,addtime desc';//默认排序
	$allclassid=$classid.SmallClassID($classid);
	$query="select title{$LT},content{$LT},titlecolor,isgood from article where checked=1 and classid in ({$allclassid}) {$order}";
	$line=10;$page_line=3;//分页处理,不设置则默认
	include($_SERVER['DOCUMENT_ROOT'].'/public/page.php');
	$i=0;
	while($rs=$sql->fetch_array())
	{
		$i+=1;
		if(!$rs['isgood']){$panel='default';}
		elseif($rs['isgood']==1){$panel='success';}
		elseif($rs['isgood']==2){$panel='warning';}
		elseif($rs['isgood']==3){$panel='danger';}
	?>
		<div class="panel panel-<?=$panel?>">
		   <div class="panel-heading">
			   <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_<?=$i?>">
			   <h4 class="panel-title"><?=$i?>. <?=cadd($rs['title'.$LT])?></h4>
			  </a>
		   </div>
		   
		   <div id="accordion1_<?=$i?>" class="panel-collapse collapse <?=$i==1?'in':''?>">
			  <div class="panel-body">
				 <?=caddhtml($rs['content'.$LT])?>
			  </div>
		   </div>
		</div>
	<?php 
	}
	if (!mysqli_num_rows($sql)){ echo $LG['pptNot'];} 
	?>
	</div>
	
	<div class="row">
	<?=$listpage?>
	</div>
</div>
<!--内容结束-->
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/m/template/incluce/footer.php');  checked: ?>