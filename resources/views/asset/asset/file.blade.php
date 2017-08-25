@extends("layouts.main")
@section("main")
    <div class="box box-primary">
        @if (!empty(session('success')))
            <input type="hidden" id="success" value="{{session('success')}}">
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif
    <!-- form start -->

        <style>
            .form-group{
                overflow: auto;
            }
        </style>

        <form action="{{url('/asset/import')}}" method="post" enctype="multipart/form-data"  >
            {{csrf_field()}}
            <div class="box-body">
                <div class="col-sm-12" >
                    <div class="form-group">
                        <label for="Comment" class="col-sm-4 control-label">照片</label>
                        <div class="col-sm-8">
                            <input type="file" name="excel" class="webuploader-element-invisible" multiple="multiple" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default " data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary pull-right" data-bind="click:saveAdd" id="saveAdd" data-loading-text="保存中...">保存</button>
            </div>
        </form>
    </div>

    <script>
        layui.use(['form','layer','laydate'], function(){
            $ = layui.jquery;
            var form = layui.form();
            var laydate = layui.laydate;
            layer = layui.layer;

            if($("#success").val()=="OK"){
                layer.alert("增加成功", {icon: 6},function () {
                    // 获得frame索引
                    var index = parent.layer.getFrameIndex(window.name);
                    //关闭当前frame
                    parent.layer.close(index);
                    parent.location.reload();
                });
            };


        });

        //查看是否还有子公司
        function finds(id) {
            $.ajax({
                "url":'{{url('asset/finds')}}'+"/"+id,
                "type":"get",
                'data':{id:id},
                success:function (data) {
                    if(data=="还有子类"){
                        $("#type_sel option:first").prop("selected","selected");
                        alert("只能选择子分类....");
                    }
                }
            })
        }

        //查找部门
        function seldep(id) {
            $.ajax({
                "url":'{{url('asset/sel')}}'+"/"+id,
                "type":"get",
                'data':{id:id},
                'dataType':"json",
                success:function (data) {
                    var select = $("#use_department_id");
                    if(data.length>0){
                        select.append("<option value=''>请选择</option>");
                        //遍历
                        for (var i = 0; i < data.length; i++) {
                            //把遍历出来数据添加到option
                            info = '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                            //把当前info数据添加到创建的select
                            select.append(info);
                        }
                        //把带有数据的select 追加
                        o.after(select);
                    }
                }
            })
        }




    </script>

@endsection