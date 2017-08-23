var zjb = function(){


	return {
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
	}
}();