var indexval = 0;
$(document).ready(function() {

	//Sidebar Accordion Menu:

	$("#main-nav li ul").hide(); // Hide all sub menus
	$("#main-nav li a.current").parent().find("ul").slideToggle("slow"); // Slide down the current menu item's sub menu

	$("#main-nav li a.nav-top-item").click( // When a top menu item is clicked...
		function() {
			$(this).parent().siblings().find("ul").slideUp("normal"); // Slide up all sub menus except the one clicked
			$(this).next().slideToggle("normal"); // Slide down the clicked sub menu
			return false;
		}
	);

	$("#main-nav li a.no-submenu").click( // When a menu item with no sub menu is clicked...
		function() {
			window.location.href = (this.href); // Just open the link instead of a sub menu
			return false;
		}
	);

	// Sidebar Accordion Menu Hover Effect:

	$("#main-nav li .nav-top-item").hover(
		function() {
			$(this).stop().animate({
				paddingRight: "25px"
			}, 200);
		},
		function() {
			$(this).stop().animate({
				paddingRight: "15px"
			});
		}
	);

	//Minimize Content Box

//	$(".content-box-header h3").css({
//		"cursor": "s-resize"
//	}); // Give the h3 in Content Box Header a different cursor
//	$(".closed-box .content-box-content").hide(); // Hide the content of the header if it has the class "closed"
//	$(".closed-box .content-box-tabs").hide(); // Hide the tabs in the header if it has the class "closed"
//
//	$(".content-box-header h3").click( // When the h3 is clicked...
//		function() {
//			$(this).parent().next().toggle(); // Toggle the Content Box
//			$(this).parent().parent().toggleClass("closed-box"); // Toggle the class "closed-box" on the content box
//			$(this).parent().find(".content-box-tabs").toggle(); // Toggle the tabs
//		}
//	);

	// Content box tabs:

	
	$('ul.content-box-tabs li a.default-tab').addClass('current'); // Add the class "current" to the default tab
	$('.content-box-content div.default-tab').show(); // Show the div with class "default-tab"

	$('.content-box ul.content-box-tabs li a').click( // When a tab is clicked...
		function() {
			$(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
			$(this).addClass('current'); // Add class "current" to clicked tab
			var currentTab = $(this).attr('href'); // Set variable "currentTab" to the value of href of clicked tab
			$(currentTab).siblings().hide(); // Hide all content divs
			$(currentTab).show(); // Show the content div with the id equal to the id of clicked tab
			return false;
		}
	);

	//Close button:

	$(".close").click(
		function() {
			$(this).parent().fadeTo(400, 0, function() { // Links with the class "close" will close parent
				$(this).slideUp(400);
			});
			return false;
		}
	);


	// Alternating table rows:

	$('tbody tr:even').addClass("alt-row"); // Add class "alt-row" to even table rows

	// Check all checkboxes when the one in a table head is checked:

	$('.check-all').click(
		function() {
			$(this).parent().parent().parent().parent().find("input[type='checkbox']").attr('checked', $(this).is(':checked'));
		}
	);

	// Initialise Facebox Modal window:

	$('a[rel*=modal]').windowbox(); // Applies modal window to any link with attribute rel="modal"
	$('a[name*=edit]').click(function() {//采购页面表格中的修改操作
		indexval = $(this).parent().parent().index() + 1;
	})
	$('a[name*=edit]').windowbox()
		// Initialise jQuery WYSIWYG:

	$(".wysiwyg").wysiwyg(); // Applies WYSIWYG editor to any textarea with the class "wysiwyg"

	$(".cinemaList").find("input[type='checkbox']").click(
		function() {
			$(this).attr('checked', $(this).is(':checked'));
		}
	);

});
function onlyNum() {
    if(!(event.keyCode==46)&&!(event.keyCode==8)&&!(event.keyCode==37)&&!(event.keyCode==39))
    if(!((event.keyCode>=48&&event.keyCode<=57)||(event.keyCode>=96&&event.keyCode<=105)))
    event.returnValue=false; }


function editmessagesshow() {
	$('#facebox').find('.editmessages').fadeIn(200);
}

function editmessageshide() {
	$('#facebox').find('.editmessages').hide();
}

function editmessages(obj) {
	var w = $('#facebox table').width();
	if (w > 741) {
		$(obj).parent().parent().parent().parent().parent().animate({
			'width': '369px'
		}, 400, function() {
			$('#facebox').animate({
				'left': $(window).width() / 2 - ($('#facebox table').width()/2)
			}, 400);
		})
		editmessageshide();
	} else {
		$(obj).parent().parent().parent().parent().parent().animate({
			'width': '741px'
		}, 400, function() {
			editmessagesshow();
		})
		$('#facebox').animate({
			'left': $(window).width() / 2 - ($('#facebox table').width())
		}, 400);
		var gys_name = $(obj).parent().parent().prev().find('select').val();
		alert('修改供应商  ' + gys_name + '  的数据，此处应使用ajax')
	}
}

function cinemaListadd() {
	var app = new Array();
	$(".content .editmessages .cinemaList input[type='checkbox']").each(function(key, obj) {
		if ($(this).is(':checked')) {
			app.push($(this).parent());
		}
	})
	$('.eidt').append(app);
}

function cinema_del(obj) {
	var r = onclick = confirm("确定要删除吗？注：当前仅删除院线信息，影院不会被删除  ")
	if (r) {
		var cinema_name = $(obj).siblings('label').text();
		$(obj).parent().remove()

		$.ajax({
			type: "post",
			url: "",
			async: true,
			data: cinema_name
		});
	} else {
		alert('b')
	}
}

function cinema_edit(obj) {
	var w = $('#facebox table').width();
	if (w > 741) {
		$(obj).parent().parent().parent().parent().animate({
			'width': '369px'
		}, 400, function() {
			$('#facebox').animate({
				'left': $(window).width() / 2 - ($('#facebox table').width() / 2)
			}, 400);

		})
	} else {
		$(obj).parent().parent().parent().parent().animate({
			'width': '739px'
		}, 400, function() {})
		var text = $(obj).siblings('label').text();
		$(obj).parent().parent().parent().siblings('.middle').find('h3').text(text);
		$('#facebox').animate({
			'left': $(window).width() / 2 - ($('#facebox table').width())
		}, 400);
	}
}

function cinema_addnew(obj) {
	var w = $('#facebox table').width();
	if (w > 841) {
		$(obj).parent().parent().parent().animate({
			'width': '739px'
		}, 400, function() {
			$('#facebox').animate({
				'left': $(window).width() / 2 - ($('#facebox table').width() / 2)
			}, 400);

		})
	} else {
		$(obj).parent().parent().parent().animate({
			'width': '1110px'
		}, 400, function() {})
		var text = $(obj).siblings('label').text();
		$(obj).parent().parent().siblings('.middle').find('h3').text(text);
		$('#facebox').animate({
			'left': ($(window).width() - 1110)/2
		}, 400);
	}
}

function editoperations(){//采购页面的保存按钮
	var new_data = new Array();
	//获取修改后的各个数值
	 new_data.push($('#facebox .content form p:eq(0) select').val())
	 new_data.push($('#facebox .content form p:eq(1) input').val())
	 new_data.push($('#facebox .content form p:eq(2) input').val())
	 new_data.push($('#facebox .content form p:eq(3) input').val())
	 new_data.push($('#profile-links a:eq(1)').text())
	//开始定位并修改
	var indexnum = indexval - 1;
	var text_input = new Array();
	var trval = $('#tab1 tbody tr:eq(' + indexnum + ')');
	trval.find('td:eq(1)').text(new_data[0]);
	trval.find('td:eq(2)').text(parseInt(new_data[1]))
	trval.find('td:eq(3)').text(parseInt(new_data[2]))
	trval.find('td:eq(4)').text(new_data[3])
	trval.find('td:eq(7)').text(new_data[4])
	
	$('#facebox .content form p:eq(4) input[type=checkbox]').each(function(key,obj){
		if($(this).is(':checked')){
			text_input.push($(this).val());
		}
	})
	if(text_input!=null){
	trval.find('td:eq(5)').text(text_input)
	}
	
}