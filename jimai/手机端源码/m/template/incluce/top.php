<div class="navi_header"> 
    <img class="logo" src="/images/logo_m.png">
    <ul>
    <li class="border"><a href="<?=pathLT('/m/html/allnav.html')?>"><?=$LG['front.67'];//导航?></a></li>
    <li class="border"><a href="/m/search/article.php"><?=$LG['search'];//搜索?></a></li>
    <li class="border"><a href="/xamember/"><?=$LG['member'];//会员?></a></li>
    
<?php if($ON_LG){?>
    <li class="yuyan"><a href="javascript:void(0)"><?=$LG['language'];//语言?></a>
    <span>
	<?php 
    $languageList=languageType('',6);
    if($languageList)
    {
        foreach($languageList as $arrkey=>$value)
        {
            ?>
            <a href="/Language/?LGType=1&language=<?=$value?>" class="<?=$value==$LT?'hover':''?>"><?=languageType($value)?></a>
            <?php 
        }
    }
    ?>
    </span>
    </li>
<?php }?>

    </ul>
</div>
<script type="text/javascript">
$(document).ready(function(e)
{
	$(".yuyan").hover(
		function(){
			$(this).find("span").show();
			},
		function(){
			$(this).find("span").hide();
			}
	);
});
</script>
