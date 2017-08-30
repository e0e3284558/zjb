var zjb = function(){
    // Handles Bootstrap switches
    var handleBootstrapSwitch = function() {
        if (!$().bootstrapSwitch) {
            return;
        }
        $('.make-switch').bootstrapSwitch();
    };

    // Handles Bootstrap confirmations
    var handleBootstrapConfirmation = function() {
        if (!$().confirmation) {
            return;
        }
        $('[data-toggle=confirmation]').confirmation({ btnOkClass: 'btn btn-sm btn-success', btnCancelClass: 'btn btn-sm btn-danger'});
    }
    var handleTooltips = function() {
        // global tooltips
        $('.tooltips').tooltip();
    };
    var handleiCheck = function() {
        if (!$().iCheck) {
            return;
        }

        $('.icheck').each(function() {
            var checkboxClass = $(this).attr('data-checkbox') ? $(this).attr('data-checkbox') : 'icheckbox_minimal-blue';
            var radioClass = $(this).attr('data-radio') ? $(this).attr('data-radio') : 'iradio_minimal-blue';

            if (checkboxClass.indexOf('_line') > -1 || radioClass.indexOf('_line') > -1) {
                $(this).iCheck({
                    checkboxClass: checkboxClass,
                    radioClass: radioClass,
                    insert: '<div class="icheck_line-icon"></div>' + $(this).attr("data-label")
                });
            } else {
                $(this).iCheck({
                    checkboxClass: checkboxClass,
                    radioClass: radioClass
                });
            }
        });
    };
    // Handle Select2 Dropdowns
    var handleSelect2 = function() {
        if ($().select2) {
            $.fn.select2.defaults.set("theme", "bootstrap");
            $('.select2').select2({
                width: 'auto' 
            });
        }
    };
    // Handles scrollable contents using jQuery SlimScroll plugin.
    var handleScrollers = function() {
        zjb.initSlimScroll('.scroller');
        zjb.initSlimScroll('.full-height-scroll');
    };
    var lastPopedPopover;

    var handlePopovers = function() {
        $('.popovers').popover();

        // close last displayed popover

        $(document).on('click.bs.popover.data-api', function(e) {
            if (lastPopedPopover) {
                lastPopedPopover.popover('hide');
            }
        });
    };
    var handleReloadHtml = function(){
        $('body').on('click', 'a[data-toggle="relaodHtml"],button[data-toggle="relaodHtml"]', function(e) {
            e.preventDefault();
            var el = $(this).data('target');
            var url = $(this).attr('href') ? $(this).attr('href') : $(this).data('href');
            var query = $(this).data('query');
            var loading = $(this).data('loading') ? true : false;
            if(url){
                zjb.ajaxGetHtml($(el),url,query,loading);
            }
        });
    };
    var handleFullHeight = function(){
        if($(".full-height-layout-on").length > 0){
            $('body').addClass('full-height-layout');
        }
    }
    
	return {
        //main function to initiate core javascript
        init:function (){
            handleScrollers();
            handleBootstrapSwitch();
            handleBootstrapConfirmation();
            handleiCheck();
            handleSelect2();
            handleTooltips();
            handlePopovers();
            handleReloadHtml();
            handleFullHeight();
        },
        //main function to initiate core javascript after ajax complete
        initAjax:function (){
            handleBootstrapSwitch();
            handleBootstrapConfirmation();
            handleiCheck();
            handleSelect2();
            handleTooltips();
            handlePopovers();
            handleScrollers();
        },
		//返回某个url页面
	    backUrl: function (url,time) {
	        if (time) {
	            window.setTimeout(function () {
	               window.location.href = url;
	            }, time);
	        }else{
	            window.location.href = url;
	        }
	    },
	    blockUI:function(element){
            var loadingMes = '<div class="sk-spinner sk-spinner-cube-grid">'+
                                    '<div class="sk-cube"></div>'+
                                    '<div class="sk-cube"></div>'+
                                    '<div class="sk-cube"></div>'+
                                    '<div class="sk-cube"></div>'+
                                    '<div class="sk-cube"></div>'+
                                    '<div class="sk-cube"></div>'+
                                    '<div class="sk-cube"></div>'+
                                    '<div class="sk-cube"></div>'+
                                    '<div class="sk-cube"></div>'+
                                '</div>';
	        var ele = $;
	        if(element){
	        	ele = $(element);
	        	var loadingMes = '<div class="sk-spinner sk-spinner-three-bounce">'+
                                    '<div class="sk-bounce1"></div>'+
                                    '<div class="sk-bounce2"></div>'+
                                    '<div class="sk-bounce3"></div>'+
                                '</div>';
                var centerY = false;
                if (ele.height() <= ($(window).height())) {
                    centerY = true;
                }
                ele.block({
		        	baseZ:9000,
		        	message:loadingMes,
		        	cenrerX:true,
		        	centerY:centerY ? centerY : false,
		        	css: {
		        		top: '20%',
		        		left: '35%', 
                        border: '0',
                        padding: '0',
                        backgroundColor: 'none'
                    },
                    overlayCSS: {
                        cursor: 'wait'
                    }
		        });
	        }else{
	        	ele.blockUI({
		        	baseZ:9000,
		        	message:loadingMes,
		        	css: {
                        border: '0',
                        padding: '0',
                        backgroundColor: 'none'
                    },
                    overlayCSS: {
                        cursor: 'wait'
                    }
		        });
	        }
	    },
	    unblockUI: function(target) {
            if (target) {
                $(target).unblock({
                    onUnblock: function() {
                        $(target).css('position', '');
                        $(target).css('zoom', '');
                    }
                });
            } else {
                $.unblockUI();
            }
        },
        /*基于jquery基础的ajax POST,PUT,DELETE请求,默认数据类型JSON*/
        ajaxPostData: function (el, url, query, callback, errorCallback, dataType, type) {
            jQuery.ajax({
                url: url,
                type: type ? type : 'POST',
                dataType: dataType ? dataType : 'JSON',
                data: query,
                beforeSend: function () {
                    zjb.blockUI(el?el:'');
                },
                complete: function (xhr, textStatus) {
                    //called when complete
                    zjb.unblockUI(el?el:'');
                },
                success: function (data, textStatus, xhr) {
                    //called when successful
                    if (callback instanceof Function) {
                        callback(data, textStatus, xhr);
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    //called when there is an error
                    if (errorCallback instanceof Function) {
                        callback(xhr, textStatus, errorThrown);
                    }else{
                        toastr.error('请求错误，请重试', '警告');
                    }
                }
            });
        },
        /*ajax加载页面*/
        ajaxGetHtml: function(el, url, query, isLoading, callback, errorCallback){
            var loading = isLoading ? true : false;
            jQuery.ajax({
                url: url,
                type: 'GET',
                dataType: 'HTML',
                cache:false,
                data: query,
                beforeSend: function () {
                    if(loading){
                        zjb.blockUI(el?el:'');
                    }
                },
                complete: function (xhr, textStatus) {
                    //called when complete
                    if(loading){ zjb.unblockUI(el?el:''); }
                    zjb.initAjax();
                },
                success: function (data, textStatus, xhr) {
                    //called when successful
                    $(el).html(data);
                    if (callback instanceof Function) {
                        callback();
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    //called when there is an error
                    if (errorCallback instanceof Function) {
                        callback(xhr, textStatus, errorThrown);
                    }else{
                        toastr.error('请求错误，请重试', '警告');
                    }
                }
            });
        },
        initSlimScroll: function(el) {
            if (!$().slimScroll) {
                return;
            }

            $(el).each(function() {
                if ($(this).attr("data-initialized")) {
                    return; // exit
                }

                var height = '100%';

                if ($(this).attr("data-height")) {
                    height = $(this).attr("data-height");
                }

                $(this).slimScroll({
                    allowPageScroll: true, // allow page scroll when the element scroll is ended
                    size: '7px',
                    color: ($(this).attr("data-handle-color") ? $(this).attr("data-handle-color") : 'rgb(0, 0, 0)'),
                    wrapperClass: ($(this).attr("data-wrapper-class") ? $(this).attr("data-wrapper-class") : 'slimScrollDiv'),
                    railColor: ($(this).attr("data-rail-color") ? $(this).attr("data-rail-color") : '#eaeaea'),
                    position: 'right',
                    height: height,
                    alwaysVisible: ($(this).attr("data-always-visible") == "1" ? true : false),
                    railVisible: ($(this).attr("data-rail-visible") == "1" ? true : false),
                    disableFadeOut: true
                });

                $(this).attr("data-initialized", "1");
            });
        },

        destroySlimScroll: function(el) {
            if (!$().slimScroll) {
                return;
            }

            $(el).each(function() {
                if ($(this).attr("data-initialized") === "1") { // destroy existing instance before updating the height
                    $(this).removeAttr("data-initialized");
                    $(this).removeAttr("style");

                    var attrList = {};

                    // store the custom attribures so later we will reassign.
                    if ($(this).attr("data-handle-color")) {
                        attrList["data-handle-color"] = $(this).attr("data-handle-color");
                    }
                    if ($(this).attr("data-wrapper-class")) {
                        attrList["data-wrapper-class"] = $(this).attr("data-wrapper-class");
                    }
                    if ($(this).attr("data-rail-color")) {
                        attrList["data-rail-color"] = $(this).attr("data-rail-color");
                    }
                    if ($(this).attr("data-always-visible")) {
                        attrList["data-always-visible"] = $(this).attr("data-always-visible");
                    }
                    if ($(this).attr("data-rail-visible")) {
                        attrList["data-rail-visible"] = $(this).attr("data-rail-visible");
                    }

                    $(this).slimScroll({
                        wrapperClass: ($(this).attr("data-wrapper-class") ? $(this).attr("data-wrapper-class") : 'slimScrollDiv'),
                        destroy: true
                    });

                    var the = $(this);

                    // reassign custom attributes
                    $.each(attrList, function(key, value) {
                        the.attr(key, value);
                    });

                }
            });
        },
        imageUpload: function(){
            
        }
	}
}();
jQuery(document).ready(function() {    
   zjb.init(); // init custom core componets
});