<div id="accordion1" class="panel-group">
<?php 
$i=0;
$query_wh="select whid,name{$LT},address{$LT} from warehouse where checked='1' order by myorder desc,whid desc";
$sql_wh=$xingao->query($query_wh);
while($wh=$sql_wh->fetch_array())
{
	if($member_warehouse[$Mgroupid][$wh['whid']]['checked'])
	{
		$i+=1;
?>
	<div class="panel panel-default">
	   <div class="panel-heading">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_<?=$i?>">
			<h4 class="panel-title">
			<?=cadd($wh['name'.$LT])?>
			</h4>
		</a>
	   </div>
	   
	   <div id="accordion1_<?=$i?>" class="panel-collapse collapse <?=$i==1?'in':''?>">
		  <div class="panel-body">
			 <?=Label(TextareaToBr($wh['address'.$LT],1))?>
		  </div>
	   </div>
	</div>
<?php
    }
}
?>			
</div>