/*
 * Facebox (for jQuery)
 * version: 1.2 (05/05/2008)
 * @requires jQuery v1.2 or later
 *
 * Examples at http://famspam.com/facebox/
 *
 * Licensed under the MIT:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2007, 2008 Chris Wanstrath [ chris@ozmm.org ]
 *
 * Usage:
 *  
 *  jQuery(document).ready(function() {
 *    jQuery('a[rel*=facebox]').facebox() 
 *  })
 *
 *  <a href="#terms" rel="facebox">Terms</a>
 *    Loads the #terms div in the box
 *
 *  <a href="terms.html" rel="facebox">Terms</a>
 *    Loads the terms.html page in the box
 *
 *  <a href="terms.png" rel="facebox">Terms</a>
 *    Loads the terms.png image in the box
 *
 *
 *  You can also use it programmatically:
 * 
 *    jQuery.facebox('some html')
 *
 *  The above will open a facebox with "some html" as the content.
 *    
 *    jQuery.facebox(function($) { 
 *      $.get('blah.html', function(data) { $.facebox(data) })
 *    })
 *
 *  The above will show a loading screen before the passed function is called,
 *  allowing for a better ajaxy experience.
 *
 *  The facebox function can also display an ajax page or image:
 *  
 *    jQuery.facebox({ ajax: 'remote.html' })
 *    jQuery.facebox({ image: 'dude.jpg' })
 *
 *  Want to close the facebox?  Trigger the 'close.facebox' document event:
 *
 *    jQuery(document).trigger('close.facebox')
 *
 *  Facebox also has a bunch of other hooks:
 *
 *    loading.facebox
 *    beforeReveal.facebox
 *    reveal.facebox (aliased as 'afterReveal.facebox')
 *    init.facebox
 *
 *  Simply bind a function to any of these hooks:
 *
 *   $(document).bind('reveal.facebox', function() { ...stuff to do after the facebox and contents are revealed... })
 *
 */


(function($) {
  $.windowbox = function(data, klass) {
    $.windowbox.loading()
    if (data.ajax) fillFaceboxFromAjax(data.ajax)
    else if (data.image) fillFaceboxFromImage(data.image)
    else if (data.div) fillFaceboxFromHref(data.div)
    else if ($.isFunction(data)) data.call($)
    else $.windowbox.reveal(data, klass)
  }

  /*
   * Public, $.facebox methods
   */

  $.extend($.windowbox, {
    settings: {
      opacity      : 0,
      overlay      : true,
      loadingImage : 'images/loading.gif',
      closeImage   : 'images/icons/close_ico.png',
      imageTypes   : [ 'png', 'jpg', 'jpeg', 'gif' ],
      faceboxHtml  : '\
	    <div id="facebox" style="display:none;"> \
	      <div class="popup"> \
	        <table> \
	          <tbody> \
	            <tr> \
	              <td class="tl"/><td class="b"/><td class="tr"/> \
	            </tr> \
	            <tr> \
	              <td class="b"/> \
	              <td class="body"> \
	                <div class="content"> \
	                </div> \
	                <div class="footer"> \
	                  <a href="#" class="close"> \
	                    <img src="images/icons/close_ico.png" title="close" class="close_image" /> \
	                  </a> \
	                </div> \
	              </td> \
	              <td class="b"/> \
	            </tr> \
	            <tr> \
	              <td class="bl"/><td class="b"/><td class="br"/> \
	            </tr> \
	          </tbody> \
	        </table> \
	      </div> \
	    </div>'
    },
    
    loading: function(obj) {
      init()
      if ($('#facebox .loading').length == 1) return true
      showOverlay()

      $('#facebox .content').empty()
      $('#facebox .body').children().hide().end().
        append('<div class="loading"><img src="'+$.windowbox.settings.loadingImage+'"/></div>')

      $('#facebox').css({
        top:	getPageScroll()[1] + (getPageHeight() / 10),
        left:	385.5
      }).show()

      $(document).bind('keydown.facebox', function(e) {
        if (e.keyCode == 27) $.windowbox.close()
        return true
      })
      $(document).trigger('loading.facebox')
    },

    reveal: function(data, klass) {
      $(document).trigger('beforeReveal.facebox')
      if (klass) $('#facebox .content').addClass(klass)
      $('#facebox .content').append(data);
      addData();
      $('#facebox .loading').remove();
      $('#facebox .body').children().fadeIn('normal');
      $('#facebox').css('left', $(window).width() / 2 - ($('#facebox table').width() / 2))
      $(document).trigger('reveal.facebox').trigger('afterReveal.facebox')
    },

    close: function() {
      $(document).trigger('close.facebox')
      return false
    }
  })

  
  /*
   * Public, $.fn methods
   */

  $.fn.windowbox = function(settings) {
    init(settings)
    function clickHandler() {
      $.windowbox.loading(true)
      // support for rel="facebox.inline_popup" syntax, to add a class
      // also supports deprecated "facebox[.inline_popup]" syntax
      var klass = this.rel.match(/facebox\[?\.(\w+)\]?/)
      if (klass) klass = klass[1]
      fillFaceboxFromHref(this.href, klass)
      return false
    }

    return this.click(clickHandler)
  }

  /*
   * Private methods
   */

  // called one time to setup facebox on this page
  function init(settings) {
    if ($.windowbox.settings.inited) return true
    else $.windowbox.settings.inited = true

    $(document).trigger('init.facebox')
    makeCompatible()

    var imageTypes = $.windowbox.settings.imageTypes.join('|')
    $.windowbox.settings.imageTypesRegexp = new RegExp('\.' + imageTypes + '$', 'i')

    if (settings) $.extend($.windowbox.settings, settings)
    $('body').append($.windowbox.settings.faceboxHtml)

    var preload = [ new Image(), new Image() ]
    preload[0].src = $.windowbox.settings.closeImage
    preload[1].src = $.windowbox.settings.loadingImage

    $('#facebox').find('.b:first, .bl, .br, .tl, .tr').each(function() {
      preload.push(new Image())
      preload.slice(-1).src = $(this).css('background-image').replace(/url\((.+)\)/, '$1')
    })

    $('#facebox .close').click($.windowbox.close)
    $('#facebox .close_image').attr('src', $.windowbox.settings.closeImage)
  }
  
  // getPageScroll() by quirksmode.com
  function getPageScroll() {
    var xScroll, yScroll;
    if (self.pageYOffset) {
      yScroll = self.pageYOffset;
      xScroll = self.pageXOffset;
    } else if (document.documentElement && document.documentElement.scrollTop) {	 // Explorer 6 Strict
      yScroll = document.documentElement.scrollTop;
      xScroll = document.documentElement.scrollLeft;
    } else if (document.body) {// all other Explorers
      yScroll = document.body.scrollTop;
      xScroll = document.body.scrollLeft;	
    }
    return new Array(xScroll,yScroll) 
  }

  // Adapted from getPageSize() by quirksmode.com
  function getPageHeight() {
    var windowHeight
    if (self.innerHeight) {	// all except Explorer
      windowHeight = self.innerHeight;
    } else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
      windowHeight = document.documentElement.clientHeight;
    } else if (document.body) { // other Explorers
      windowHeight = document.body.clientHeight;
    }	
    return windowHeight
  }

  // Backwards compatibility
  function makeCompatible() {
    var $s = $.windowbox.settings

    $s.loadingImage = $s.loading_image || $s.loadingImage
    $s.closeImage = $s.close_image || $s.closeImage
    $s.imageTypes = $s.image_types || $s.imageTypes
    $s.faceboxHtml = $s.facebox_html || $s.faceboxHtml
  }

  // Figures out what you want to display and displays it
  // formats are:
  //     div: #id
  //   image: blah.extension
  //    ajax: anything else
  function fillFaceboxFromHref(href, klass) {
    // div
    if (href.match(/#/)) {
      var url    = window.location.href.split('#')[0]
      var target = href.replace(url,'')
      $.windowbox.reveal($(target).clone().show(), klass)

    // image
    } else if (href.match($.windowbox.settings.imageTypesRegexp)) {
      fillFaceboxFromImage(href, klass)
    // ajax
    } else {
      fillFaceboxFromAjax(href, klass)
    }
  }
  
  function skipOverlay() {
    return $.windowbox.settings.overlay == false || $.windowbox.settings.opacity === null 
  }

  function showOverlay() {
    if ($('facebox_overlay').length == 0) 
      $("body").append('<div id="facebox_overlay" class="facebox_hide"></div>')

    $('#facebox_overlay').hide().addClass("facebox_overlayBG")
      .css('opacity', $.windowbox.settings.opacity)
      .click(function() { $(document).trigger('close.facebox') })
      .fadeIn(200)
    return false
  }
  
  function hideOverlay() {
    if (skipOverlay()) return
      $('#facebox .content').css('width','369px')
      $('#facebox_overlay').fadeOut(200, function(){
      $("#facebox_overlay").removeClass("facebox_overlayBG")
      $("#facebox_overlay").addClass("facebox_hide") 
      $("#facebox_overlay").remove()
    })
    
    return false
  }
  
  function addData(){
  	if(indexval){
  		var indexnum = indexval-1;
  		var trval = $('#tab1 tbody tr:eq('+indexnum+')');
  		var option_val = trval.find('td:eq(1)').text();
  		$('#facebox .content form p:eq(0) select option').each(function(key,obj){
  			var a =$(this).val();
  			if(a==option_val){
  				$(this).attr('selected','selected');
  				}
  		})
  		$('#facebox .content form p:eq(1) input').val(parseInt(trval.find('td:eq(2)').text()))
  		$('#facebox .content form p:eq(2) input').val(parseInt(trval.find('td:eq(3)').text()))
  		$('#facebox .content form p:eq(3) input').val(trval.find('td:eq(4)').text())
  		var obj_array = trval.find('td:eq(5)').text().split(',');
  		$('#facebox .content form p:eq(4) input[type=checkbox]').each(function(key,obj){
  			for (i=0;i<obj_array.length;i++){
  				if (obj_array[i]==$(this).val()){
  					$(this).attr('checked','checked')
  				}
  			}
  			
  		})
  	}
  }
 
   
  
  /*
   * Bindings
   */

  $(document).bind('close.facebox', function() {
    $(document).unbind('keydown.facebox')
    $('#facebox').fadeOut(function() {
      
      $('#facebox .content').removeClass().addClass('content')
      hideOverlay()
      $('#facebox .loading').remove()
    })
  })

})(jQuery);
