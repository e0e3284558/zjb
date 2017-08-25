<meta charset="UTF-8">
<div class="ibox">
    <div class="ibox-title">
        <h5>维修工列表</h5>
    </div>
    <div class="ibox-content  ">
        <p class="m-b-lg">
            {{$title}}
            <br>
        </p>

        <div class="dd " id="nestable2">
            <div class="row gray-bg">
                @foreach($data as $v)
                    <div class="col-lg-4">
                        <div class="contact-box center-version">

                            <a href="profile.html">

                                @if($v->upload_id)
                                    <img alt="image" class="img-circle m-t-xs img-responsive" src="">
                                @else
                                    <button class="btn btn-circle btn-lg {{randomClass()}}"
                                            type="button">{{mb_substr($v->name,0,1)}}</button>
                                @endif

                                <h3 class="m-b-xs"><strong>{{$v-> name}}</strong></h3>

                                <address class="m-t-md">
                                    <strong><i class="fa fa-phone"></i> {{$v-> tel}}</strong><br>
                                    <p><i class="fa fa-map-marker"></i> 安徽省芜湖市弋江区</p>
                                </address>

                            </a>
                            <div class="contact-box-footer">
                                <div class="m-t-xs btn-group">
                                    <a class="btn btn-xs btn-white"><i class="fa fa-envelope"></i> 发送短信 </a>
                                    <a class="btn btn-xs btn-white" onclick="edit('{{url("repair/service_worker/$v->id/edit")}}')"><i class="fa fa-edit"></i> 编辑</a>
                                    <a class="btn btn-xs btn-white" onclick="del('{{$v->id}}')"><i class="fa fa-mail-forward"></i> 移除</a>
                                </div>
                            </div>
                        </div>
                    </div>

               @endforeach


            </div>
        </div>
    </div>
</div>

<script>
    function edit(url) {
        $.ajax({
            "url": url,
            "type": 'get',
            success: function (data) {
                $("#create").html(data);
            }
        })
    }

    /*删除*/
    function del(id) {
        layer.confirm('确认要删除吗？', function () {
            //发异步删除数据
            $.post("{{url('repair/service_worker/')}}/" + id, {
                '_method': 'delete',
                '_token': "{{csrf_token()}}"
            }, function (data) {
                if (data.status == 'success') {
                    layer.msg(data.message, {icon: 6});
                    window.location.reload();
                } else {
                    layer.msg('删除失败', {icon: 5});
                }
            });
        });
    }
</script>
</script>