<?php
$config = array (
		//应用ID,您的APPID。
		'app_id' => "",

		//商户私钥，您的原始格式私钥,一行字符串
		'merchant_private_key' => "",



		//商户应用公钥,一行字符串
		'merchant_public_key' => "",



		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "",


		//编码格式只支持GBK。
		'charset' => "GBK",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//签名方式
		'sign_type'=>"RSA2"
);