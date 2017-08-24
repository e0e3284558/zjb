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
	    		<div id="departments-tree">
                    
                </div>
	    	</div>
	    </div>
    </div>
    <div class="full-height">
        <div class="full-height-scroll white-bg border-left ">
            <div class="full-height-wrapper full-height">
                <div class="row full-height">
                	<div class="col-lg-12 full-height" id="dep-form-wrapper">
		                
            		</div>
                </div>	
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
$(document).ready(function() {
	$('body').addClass('full-height-layout');
    
	$('#departments-tree').jstree({
        'core' : {
            'force_text' : true,
            "check_callback" : true, 
            'data' : {
                'url' : '{!! url("users/departments?tree=1") !!}',
                "dataType" : "json"
            }
        },
        'plugins' : [ 'types', 'dnd' ,'changed'],
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
    $('#departments-tree').on('load_node.jstree',function (e, data) {
      $('#departments-tree').jstree('open_all');
    });
    $('#departments-tree').on('changed.jstree',function (e,data) {
      if(data.node != undefined){
        var link = data.node.a_attr.href;
        $.get(link, {}, function(data){
            $('#dep-form-wrapper').html(data);
          });
      }
    });
    $.get('{{ url("users/departments/create") }}', {}, function(data){
        $('#dep-form-wrapper').html(data);
    });
} );
</script>
@endsection