@extends('layouts.app')


@section('breadcrumb')
	<div class="row wrapper border-bottom white-bg page-heading">
	    <div class="col-lg-10">
	        <!-- <h2></h2> -->
	        <ol class="breadcrumb">
	        	<li>
	                <a href="{{ route('home') }}">控制面板</a>
	            </li>

	            <li>
	                <a href="javascript:;">用户管理</a>
	            </li>

	            <li class="active">
	                <strong>组织机构管理</strong>
	            </li>
	        </ol>
	    </div>
	    <div class="col-lg-2">
	    </div>
	</div>
@endsection

@section('content')
<div class="fh-breadcrumb">
	<div class="fh-column fh-column-w">
	    <div class="full-height-scroll">
	    	<div class="full-height-wrapper">
	    		<div id="jstree1">
                <ul>
                    <li class="jstree-open">Admin theme
                        <ul>
                            <li>css
                                <ul>
                                    <li data-jstree='"type":"css"}'>animate.css</li>
                                    <li data-jstree='"type":"css"}'>bootstrap.css</li>
                                    <li data-jstree='"type":"css"}'>style.css</li>
                                </ul>
                            </li>
                            <li>email-templates
                                <ul>
                                    <li data-jstree='"type":"html"}'>action.html</li>
                                    <li data-jstree='"type":"html"}'>alert.html</li>
                                    <li data-jstree='"type":"html"}'>billing.html</li>
                                </ul>
                            </li>
                            <li>fonts
                                <ul>
                                    <li data-jstree='"type":"svg"}'>glyphicons-halflings-regular.eot</li>
                                    <li data-jstree='"type":"svg"}'>glyphicons-halflings-regular.svg</li>
                                    <li data-jstree='"type":"svg"}'>glyphicons-halflings-regular.ttf</li>
                                    <li data-jstree='"type":"svg"}'>glyphicons-halflings-regular.woff</li>
                                </ul>
                            </li>
                            <li class="jstree-open">img
                                <ul>
                                    <li data-jstree='"type":"img"}'>profile_small.jpg</li>
                                    <li data-jstree='"type":"img"}'>angular_logo.png</li>
                                    <li class="text-navy" data-jstree='"type":"img"}'>html_logo.png</li>
                                    <li class="text-navy" data-jstree='"type":"img"}'>mvc_logo.png</li>
                                </ul>
                            </li>
                            <li class="jstree-open">js
                                <ul>
                                    <li data-jstree='"type":"js"}'>inspinia.js</li>
                                    <li data-jstree='"type":"js"}'>bootstrap.js</li>
                                    <li data-jstree='"type":"js"}'>jquery-2.1.1.js</li>
                                    <li data-jstree='"type":"js"}'>jquery-ui.custom.min.js</li>
                                    <li  class="text-navy" data-jstree='"type":"js"}'>jquery-ui-1.10.4.min.js</li>
                                </ul>
                            </li>
                            <li data-jstree='"type":"html"}'> affix.html</li>
                            <li data-jstree='"type":"html"}'> dashboard.html</li>
                            <li data-jstree='"type":"html"}'> buttons.html</li>
                            <li data-jstree='"type":"html"}'> calendar.html</li>
                            <li data-jstree='"type":"html"}'> contacts.html</li>
                            <li data-jstree='"type":"html"}'> css_animation.html</li>
                            <li  class="text-navy" data-jstree='"type":"html"}'> flot_chart.html</li>
                            <li  class="text-navy" data-jstree='"type":"html"}'> google_maps.html</li>
                            <li data-jstree='"type":"html"}'> icons.html</li>
                            <li data-jstree='"type":"html"}'> invoice.html</li>
                            <li data-jstree='"type":"html"}'> login.html</li>
                            <li data-jstree='"type":"html"}'> mailbox.html</li>
                            <li data-jstree='"type":"html"}'> profile.html</li>
                            <li  class="text-navy" data-jstree='"type":"html"}'> register.html</li>
                            <li data-jstree='"type":"html"}'> timeline.html</li>
                            <li data-jstree='"type":"html"}'> video.html</li>
                            <li data-jstree='"type":"html"}'> widgets.html</li>
                        </ul>
                    </li>
                </ul>
            </div>
	    	</div>
	    </div>
    </div>
    <div class="full-height">
        <div class="full-height-scroll">
            <div class="full-height-wrapper white-bg border-left full-height">
                <div class="row full-height">
                	<div class="col-lg-12 full-height">
		                <div class="ibox float-e-margins full-height-ibox">
		                    <div class="ibox-title">
		                        <h5>部门添加</h5>
		                        <div class="ibox-tools pull-right">
		                            <button class="btn btn-xs btn-success">保存</button>
		                            <button class="btn btn-xs btn-default">取消</button>
		                        </div>
		                    </div>
		                    <div class="ibox-content">
								 full-ibox-content
		                    </div>
		                </div>
            		</div>
                </div>	
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
$(document).ready(function() {
	$('body').addClass('full-height-layout');
	
	$('#jstree1').jstree({
        'core' : {
            'check_callback' : true
        },
        'plugins' : [ 'types', 'dnd' ],
        'types' : {
            'default' : {
                'icon' : 'fa fa-folder'
            },
            'html' : {
                'icon' : 'fa fa-file-code-o'
            },
            'svg' : {
                'icon' : 'fa fa-file-picture-o'
            },
            'css' : {
                'icon' : 'fa fa-file-code-o'
            },
            'img' : {
                'icon' : 'fa fa-file-image-o'
            },
            'js' : {
                'icon' : 'fa fa-file-text-o'
            }
        }
    });

} );
</script>
@endsection