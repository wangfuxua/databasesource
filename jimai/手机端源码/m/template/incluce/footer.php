<script>
	/* 底部导航ICOS */
	var tabview = ylapp.tab({
		selector: "#footer",
		hasIcon: true,
		hasAnim: false,
		hasLabel: true,
		hasBadge: true,
		data: [{
				label: "主页",
				icon: "fa-cube"
			}, {
				label: "代购",
				icon: "fa-credit-card",
			}, {
				label: "服务",
				icon: "fa-th-large",
			}, {
				label: "我的",
				icon: "fa-user",
				badge: '',
			}]
	});
	/* footer菜单点击事件 */
	tabview.on("click", function (obj, index) { /*TAB变更时切换多浮动窗口*/
		if (index == 0) {//首页
			//ylapp.window.open("index", "index.html", 0, 0);
			window.location.href = WEB_URL;
		} else if (index == 1) {//代购
			//ylapp.window.open("daigou", "daigou.html", 0, 0);
			window.location.href = "/xamember/daigou/m_list.php";
		} else if (index == 2) {//服务
			//ylapp.window.open("service", "service.html", 0, 0);
			window.location.href = "/xamember/service.php";
		} else if (index == 3) {//我的
			//ylapp.window.open("user", "user.html", 0, 0);
			window.location.href = "/xamember/user/index.php";
		}
		//tabview.moveTo(index);
		$("#footer").find(".item").removeClass("sc-text-active");
		//alert($("#footer").find("div[data-index='"+index+"']").length);
		$("#footer").find("div[data-index='" + index + "']").find(".item").addClass("sc-text-active");
	});
</script>