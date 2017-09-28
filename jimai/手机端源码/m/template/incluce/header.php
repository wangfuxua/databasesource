<?php
if ($rs['seokey']) {
	$seokey = striptags($rs['seokey']);
} elseif ($rs['seokey' . $LT]) {
	$seokey = striptags($rs['seokey' . $LT]);
} elseif ($cr['seokey']) {
	$seokey = striptags($cr['seokey']);
} elseif ($cr['seokey' . $LT]) {
	$seokey = striptags($cr['seokey' . $LT]);
} else {
	$seokey = striptags($sitekey);
}

if ($rs['intro' . $LT]) {
	$seointro = striptags($rs['intro' . $LT]);
} elseif ($rs['intro' . $LT]) {
	$seointro = striptags($rs['intro' . $LT]);
} elseif ($cr['intro' . $LT]) {
	$seointro = striptags($cr['intro' . $LT]);
} elseif ($cr['intro' . $LT]) {
	$seointro = striptags($cr['intro' . $LT]);
} else {
	$seointro = striptags($sitetext);
}
?>

<meta name="keywords" content="<?= $seokey ?>" />
<meta name="description" content="<?= $seointro ?>" />
<title><?= $headtitle ?>-<?= cadd($sitename) ?>|<?= cadd($sitetitle) ?></title>

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="/bootstrap/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="/bootstrap/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="/bootstrap/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" href="/m/css/fonts/font-awesome.min.css">
<link rel="stylesheet" href="/m/css/ui-box.css">
<link rel="stylesheet" href="/m/css/ui-base.css">
<link rel="stylesheet" href="/m/css/ui-color.css">
<link rel="stylesheet" href="/m/css/ylapp.icon.css">
<link rel="stylesheet" href="/m/css/ylapp.control.css">
<link rel="stylesheet" href="/m/css/index.css">
<style>
	#Header{
		font-size:1.05rem;
		padding-top:.2rem;
	}
</style>

<!-- END GLOBAL MANDATORY STYLES -->

<!--各类特效JS:必须有,放在footer.php无效-->

<script src="/m/js/ylapp.js"></script>
<script src="/m/js/ylapp.control.js"></script>
<script src="/m/js/ylapp.scrollbox.js"></script>
<script src="/m/js/ylapp.tab.js"></script>
<script src="/m/js/template.import.js"></script>
<script src="/m/js/clipboard.min.js"></script>
<script src="/m/js/ylapp.listview.js"></script>

<script>
	/**
	 +----------------------------------------------------------
	 * 获取当前URL相关
	 +----------------------------------------------------------
	 */
	var WEB_URL = window.location.protocol + "//" + window.location.host + "/m/";
</script>


</head>

<body class="" ontouchstart>
