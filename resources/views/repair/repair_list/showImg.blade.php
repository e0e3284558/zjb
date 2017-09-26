<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="myModalLabel">图片详情</h4>
</div>
<div class="modal-body">

        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                @foreach($list as $k=>$img)
                    @if($k=="0")
                        <li data-target="#carousel-example-generic" data-slide-to="{{$k}}" class="active"></li>
                    @else
                        <li data-target="#carousel-example-generic" data-slide-to="{{$k}}"></li>
                    @endif
                @endforeach
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                @foreach($list as $k=>$img)
                    @if($k=="0")
                        <div class="item active">
                            <img src="{{url("$img->path")}}" class="img-show">
                        </div>
                    @else
                        <div class="item">
                            <img src="{{url("$img->path")}}" class="img-show">
                        </div>
                    @endif
                @endforeach

            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>




</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" data-dismiss="modal">确认</button>
</div>