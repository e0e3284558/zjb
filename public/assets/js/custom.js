var zjb = function(){

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

	return {
        init:function (){
            handleReloadHtml();
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
            var loading = isLoading == false ? false : true;
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
                },
                success: function (data, textStatus, xhr) {
                    //called when successful
                    el.html(data);
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
        }
	}
}();
jQuery(document).ready(function() {    
   zjb.init(); // init custom core componets
});