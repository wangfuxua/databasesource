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
$noper=1;require_once($_SERVER['DOCUMENT_ROOT'].'/xamember/incluce/session.php');

//验证手机版
if(isMobile()){
	$_SESSION['isMobile']=1;$ism=1;$m='/m';
}else{
	$_SESSION['isMobile']=0;
}

if($Muserid&&$_COOKIE["member_cookie"])
{
	echo '<script language=javascript>';
	echo 'location.href="main.php";';
	echo '</script>';
	XAtsto('main.php');
}

//获取,处理
$lx=par($_GET['lx']);
$groupid=par($_GET['groupid']);
if(!$lx){$lx='add';}
$headtitle=$LG['reg.headtitle'];//会员注册

if(!$off_member_reg)
{
	exit("<script>alert('{$LG['reg.CloseReg']}');goBack('uc');</script>");
}

//生成令牌密钥(为安全要放在所有验证的最后面)
$token=new Form_token_Core();
$tokenkey= $token->grante_token("memberreg");
?>
<link href="/bootstrap/css/pages/reg.css" rel="stylesheet" type="text/css"/>
<link href="/css/member.css" rel="stylesheet" type="text/css"/>
<link href="/bootstrap/css/themes/<?=$theme_member?>" rel="stylesheet" type="text/css" id="style_color"/>
<?php 
if($ism)
{
	require_once($_SERVER['DOCUMENT_ROOT'].'/m/template/incluce/header.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/m/template/incluce/top.php');
	echo '<link href="/css/xingao_m.css" rel="stylesheet" type="text/css"/>';
}else{
	require_once($_SERVER['DOCUMENT_ROOT'].'/template/incluce/header.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/template/incluce/nav.php');
	echo '<style>.gb_member {background-image: url(/images/gb_member_reg_'.rand(1,3).'.jpg);}</style>';
}
?>


<!--内容开始-->
<div class="gb_member">
    <div class="reg">
      <div class="content"> 
        <!-- BEGIN LOGIN FORM -->
            <form class="form-horizontal form-bordered" name="xingao" action="http://www.jbuy.com.au/xamember/reg_save.php" method="post">
          <input name="lx" type="hidden" value="add">
          <input name="tokenkey" type="hidden" value="912c91a5ac8f0e13f726e1a8abab95fd">
          <h3 class="form-title">
            会员注册                      </h3>
      <!--静态开始--> 
      <style>
      .form-bordered .form-group > div{border-left:0px solid #efefef;}
      </style>   
      <ul id="myTab" class="nav nav-tabs">
      <li class="active">
        <a href="#home" data-toggle="tab">手机注册</a>
      </li>
      <li><a href="#ios" data-toggle="tab">邮箱注册</a></li>
    </ul>
<div id="myTabContent" class="tab-content">
  <div class="tab-pane fade in active" id="home">


      <div class="form-group">
        <label class="control-label col-md-3">手机国家</label>
        <div class="col-md-9">
          <select class="form-control input-medium select2me" data-placeholder="Select..." name="CustomerService">
            <option value="1" selected="">中国</option>
            <option value="2" selected="">美国</option>
            <option value="3" selected="">俄罗斯</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3">手机号码</label>
        <div class="col-md-9 has-error">
          <input type="text" class="form-control input-medium" name="mobile" id="mobile" required maxlength="20">
          <span class="help-block" id="msg_sj"></span> </div>
      </div>
      <!--不能在此限制发送时间，当手机写错就不能再发送-->
      
      <div class="form-group">
        <label class="control-label col-md-3">手机验证</label>
        <div class="col-md-9 has-error">
          <input type="text" class="form-control input-small" name="mobile_yz"  required  maxlength="10"  placeholder="收到校验码">
          <button type="button" class="btn btn-warning" onClick="SendMobile_yz();" ><i class="icon-rss"></i> 获取校验码 </button>
        </div>
      </div>
          
      <div class="form-group">
          <label class="control-label col-md-3">昵称</label>
          <div class="col-md-9 has-error">
              <input type="text" class="form-control input-medium" maxlength="50" required="" name="nickname" id="nickname" placeholder="请输入您的昵称">
              <span class="help-block">为提高入库精度,此昵称必须与站外(群里)所用昵称保持一致</span>
          </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3">登录密码</label>
        <div class="col-md-9 has-error">
          <input type="password" class="form-control input-medium" name="password" autocomplete="off" id="password" required="" maxlength="50" onkeyup="check_password(&#39;{$LG[&#39;reg.LimitWord&#39;]}&#39;);" placeholder="请输入复杂的密码">
          <span class="help-block" id="msg_password"></span>
        </div>
      </div>
      <div class="form-group">
          <label class="control-label col-md-3">专属客服</label>
          <div class="col-md-9">
              <select class="form-control input-medium select2me" data-placeholder="Select..." name="CustomerService" >
              <option value="" selected="" ></option><option value="01">01(小言)</option><option value="02">02(星星)</option><option value="03">03(晓晓)</option><option value="05">05(芊芊)</option><option value="06">06(玥玥)</option><option value="07">07(小琪)</option><option value="08">08(小雨)</option><option value="09">09(小佳)</option><option value="10">10(小艺)</option><option value="11">11(小鱼)</option><option value="12">12(小新)</option><option value="15">15(小李)</option><option value="16">16(乐乐)</option><option value="17">17(小球)</option><option value="18">18(小璐)</option><option value="20">20(小吉)</option><option value="21">21(萱萱)</option><option value="22">22(圆圆)</option><option value="24">24(小莉)</option><option value="26">26(依依)</option><option value="29">29(冬冬)</option>        </select>
              <span class="help-block">请认真选择,提交后将不可再更改</span>
          </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3">邀请号码</label>
        <div class="col-md-9">
          <input type="text" class="form-control input-small" name="tuiguang_userid" maxlength="15" title="填写邀请号码，即可获得100积分" value="" placeholder="没有可留空">
        </div>
      </div>
      <div class="form-actions" style="margin-top:10px;" align="center">
          <input type="checkbox" onclick="document.getElementById(&quot;agreed&quot;).disabled=!this.checked;" autocomplete="off">
          <font class="red2"><a href="http://www.jbuy.com.au/html/bzzx/yonghuxuzhi/zhucexieyi/indexCN.html" target="_blank">我已看过并同意《<strong>注册协议</strong>》</a></font>
          <br><br>
        
          <button type="submit" id="agreed" class="btn btn-info input-medium"><i class="icon-user"></i> 提 交 注 册 </button>
      </div>
      <div class="forget-password" align="right">
       <!-- <p> <font class="red2">以上需要填写完整才能注册</font><br><br>-->
        <a href="http://www.jbuy.com.au/xamember/"><span class="btn btn-xs btn-danger"><i class="icon-key"></i> 我已经有账号，点击登录 </span></a> <p></p>
      </div>
  </div>
  <div class="tab-pane fade" id="ios">
      <div class="form-group">
          <label class="control-label col-md-3">邮箱</label>
          <div class="col-md-9 has-error">
              <input type="text" class="form-control input-medium" maxlength="50" required="" name="nickname" placeholder="请输入您的邮箱">
          </div>
      </div>
      <div class="form-group">
          <label class="control-label col-md-3">昵称</label>
          <div class="col-md-9 has-error">
              <input type="text" class="form-control input-medium" maxlength="50" required="" name="nickname" id="nickname2" placeholder="请输入您的昵称">
              <span class="help-block">为提高入库精度,此昵称必须与站外(群里)所用昵称保持一致</span>
          </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3">登录密码</label>
        <div class="col-md-9 has-error">
          <input type="password" class="form-control input-medium" name="password" autocomplete="off" id="password" required="" maxlength="50" onkeyup="check_password(&#39;{$LG[&#39;reg.LimitWord&#39;]}&#39;);" placeholder="请输入复杂的密码">
          <span class="help-block" id="msg_password"></span>
        </div>
      </div>
      <div class="form-group">
          <label class="control-label col-md-3">专属客服</label>
          <div class="col-md-9">
              <select class="form-control input-medium select2me" data-placeholder="Select..." name="CustomerService" >
              <option value="" selected="" ></option><option value="01">01(小言)</option><option value="02">02(星星)</option><option value="03">03(晓晓)</option><option value="05">05(芊芊)</option><option value="06">06(玥玥)</option><option value="07">07(小琪)</option><option value="08">08(小雨)</option><option value="09">09(小佳)</option><option value="10">10(小艺)</option><option value="11">11(小鱼)</option><option value="12">12(小新)</option><option value="15">15(小李)</option><option value="16">16(乐乐)</option><option value="17">17(小球)</option><option value="18">18(小璐)</option><option value="20">20(小吉)</option><option value="21">21(萱萱)</option><option value="22">22(圆圆)</option><option value="24">24(小莉)</option><option value="26">26(依依)</option><option value="29">29(冬冬)</option>        </select>
              <span class="help-block">请认真选择,提交后将不可再更改</span>
          </div>
      </div>
      <div class="form-group">
        <label class="control-label col-md-3">邀请号码</label>
        <div class="col-md-9">
          <input type="text" class="form-control input-small" name="tuiguang_userid" maxlength="15" title="填写邀请号码，即可获得100积分" value="" placeholder="没有可留空">
        </div>
      </div>
      <div class="form-actions" style="margin-top:10px;" align="center">
          <input type="checkbox" onclick="document.getElementById(&quot;agreed&quot;).disabled=!this.checked;" autocomplete="off">
          <font class="red2"><a href="http://www.jbuy.com.au/html/bzzx/yonghuxuzhi/zhucexieyi/indexCN.html" target="_blank">我已看过并同意《<strong>注册协议</strong>》</a></font>
          <br><br>
        
          <button type="submit" id="agreed2" class="btn btn-info input-medium"><i class="icon-user"></i> 提 交 注 册 </button>
      </div>
      <div class="forget-password" align="right">
       <!-- <p> <font class="red2">以上需要填写完整才能注册</font><br><br>-->
        <a href="http://www.jbuy.com.au/xamember/"><span class="btn btn-xs btn-danger"><i class="icon-key"></i> 我已经有账号，点击登录 </span></a> <p></p>
      </div>
  </div>
</div>  
<script>
$("#agreed").click(function(){
  var nickname = $("#nickname").val();
  checkName(nickname);
})
$("#agreed2").click(function(){
  var nickname = $("#nickname2").val();
  checkName(nickname);
})
function checkName(obj) {
    if(obj.length != 0) {
        if(!obj.match(/^[\u4e00-\u9fa5]+$/)){
            alert('请输入中文');
            return false;
        }   
    }
}
</script>
<!--静态完毕-->          
  
          
        </form>  
        <!-- END LOGIN FORM --> 
      </div>
    </div>
</div>
<div class="clear"></div>

<!--内容结束-->

<!-------------------------------------------账号验证-------------------------------------------->
<script language="javascript" type="text/javascript"> 
<?php if($member_reg_lx==1){?>
function check_username()
{
   var temp = document.getElementById("username");
  //对电子邮件的验证
  var myreg = /^([a-zA-Z0-9]+[_|\-|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
  if(temp.value!="")
  {
   if(!myreg.test(temp.value))
    {
      document.getElementById('msg_username').innerHTML="<?=$LG['reg.EmailError'];//请输入有效的E_mail?>";
      username.focus();
      return false;
    }
	else
	{     
	 document.getElementById('msg_username').innerHTML="";
	}
	
   }
}

function check_email()
{
   var temp = document.getElementById("username");
   var temp2 = document.getElementById("email");
  //对电子邮件的验证
  if(temp.value!=temp2.value)
    {
      document.getElementById('msg_email').innerHTML="<?=$LG['reg.EmailRepeatError'];//2次输入的邮箱不一样?>";//  alert('提示\n\n请输入有效的E_mail！');
      //email.focus();//不能强制焦点
      return false;
    }
	else
	{     
	 document.getElementById('msg_email').innerHTML="";
	}
}
<?php
}else{
?>
function check_username()
{
   var temp = document.getElementById("username");
  //对电子邮件的验证
	<?php if($member_reg_lx==2){?>
		var myreg =  /^[A-Za-z]+$/;
	<?php
	}else{
	?>
		var myreg = /^[a-zA-Z]/;
	<?php }?>


  if(temp.value!="")
  {
   if(!myreg.test(temp.value)||temp.value.length<4||temp.value.length>15)
    {
		<?php if($member_reg_lx==2){?>
   		   document.getElementById('msg_username').innerHTML="<?=$LG['reg.AllLetters'];//必须全是字母(4至15个字)?>";//  alert('提示nn请输入有效的E_mail！');
		<?php
		}else{
		?>
   		   document.getElementById('msg_username').innerHTML="<?=$LG['reg.FirstLetter'];//必须以字母开头(4至15个字)?>";//  alert('提示nn请输入有效的E_mail！');
		<?php }?>

       username.focus();
      return false;
    }
	else
	{     
	 document.getElementById('msg_username').innerHTML="";
	}
	
   }
}


function check_email()
{
   var temp = document.getElementById("email");
  //对电子邮件的验证
  var myreg = /^([a-zA-Z0-9]+[_|\-|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
  if(temp.value!="")
  {
   if(!myreg.test(temp.value))
    {
      document.getElementById('msg_email').innerHTML="<?=$LG['reg.EmailError'];//请输入有效的E_mail?>";//  alert('提示\n\n请输入有效的E_mail！');
       email.focus();
      return false;
    }
	else
	{     
	 document.getElementById('msg_email').innerHTML="";
	}
	
   }
}
<?php }?>
</script>



<!-------------------------------------------手机验证-------------------------------------------->
<?php if($off_reg_mobile&&$off_sms){?>
<SCRIPT type=text/javascript>
function SendMobile_yz() {
  var mobile = document.getElementById("mobile").value;
  var mobile_code = document.getElementById("mobile_code").value;

 var xmlhttp_sj=createAjax(); 
 if (xmlhttp_sj) {  
  var span=document.getElementById('msg_sj');
  xmlhttp_sj.open('POST','/xamember/reg_yz.php?n='+Math.random(),true);
  xmlhttp_sj.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  xmlhttp_sj.send('lx=mobile&mobile='+mobile+'&mobile_code='+mobile_code+'');
  xmlhttp_sj.onreadystatechange=function() {  
   if (xmlhttp_sj.readyState==4 && xmlhttp_sj.status==200) 
   { 
    span.innerHTML=unescape(xmlhttp_sj.responseText); 
   }
  }
 }
}
</SCRIPT>
<?php }?>

<!-------------------------------------------邮箱验证-------------------------------------------->
<?php if($off_reg_email){?>
<SCRIPT type=text/javascript>
function SendEmail_yz() {
  var email = document.getElementById("email").value;

 var xmlhttp_em=createAjax(); 
 if (xmlhttp_em) {  
  var span=document.getElementById('msg_email_yz');
  xmlhttp_em.open('POST','/xamember/reg_yz.php?n='+Math.random(),true);
  xmlhttp_em.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  xmlhttp_em.send('lx=email&email='+email+'');
  xmlhttp_em.onreadystatechange=function() {  
   if (xmlhttp_em.readyState==4 && xmlhttp_em.status==200) 
   { 
   		span.innerHTML=unescape(xmlhttp_em.responseText); 
   }
  }
 }
}
</SCRIPT>
<?php }?>


<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/js/checkJS.php');//通用验证
require_once($_SERVER['DOCUMENT_ROOT'].$m.'/template/incluce/footer.php');?>