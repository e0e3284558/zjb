<div class="ibox">
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-b-md">
                    <a href="#" class="btn btn-white btn-xs pull-right" onclick="edit({{$data->id}})">修改服务商信息</a>
                    <h2>{{$data->name}}</h2>
                </div>
                <dl class="dl-horizontal">
                    <dt>所属:</dt>
                    <dd>
                        <span class="label label-primary">
                            <?php
                            if ($data->org->toArray() !== []) {
                                foreach ($data->org as $v) {
                                    if ($v->pivot->status == 0) {
                                        echo '内部服务商';
                                    }
                                }
                            } else {
                                echo '外部服务商';
                            }
                            ?>
                        </span>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5">
                <dl class="dl-horizontal">

                    <dt>服务商负责人:</dt>
                    <dd>{{$data->user}}</dd>
                    <dt> &nbsp;</dt>
                    <dd> &nbsp;</dd>
                    <dt>服务商电话:</dt>
                    <dd>{{$data->tel}}</dd>
                    <dt> &nbsp;</dt>
                    <dd> &nbsp;</dd>
                    <dt>服务商传真:</dt>
                    <dd>{{$data->tel}}</dd>
                </dl>
            </div>
            <div class="col-lg-7" id="cluster_info">
                <dl class="dl-horizontal">
                    <dt>服务商成员:</dt>
                    <dd class="project-people">
                        @foreach($serviceWorker as $j)
                            @if($j['upload_id'])
                                {!! avatar_circle($j['upload_id']) !!}
                            @else
                                {!! avatar_circle(null,$j['name'] )!!}
                            @endif
                        @endforeach
                    </dd>
                </dl>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <dl class="dl-horizontal">
                    <dt>好评率:</dt>
                    <dd>
                        <div class="progress progress-striped active m-b-sm">
                            <div style="width: 97%;" class="progress-bar progress-bar-info"></div>
                        </div>
                        <small>综合好评率为 <strong>97%</strong></small>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="row m-t-sm">
            <div class="col-lg-12">
                <div class="panel blank-panel">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab-1" data-toggle="tab">客户评价</a></li>
                                <li class=""><a href="#tab-2" data-toggle="tab">维修记录</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-1">
                                <div class="feed-activity-list">
                                    <div class="feed-element">
                                        <a href="#" class="pull-left">
                                            <img alt="image" class="img-circle" src="/img/a2.jpg">
                                        </a>
                                        <div class="media-body ">
                                            <small class="pull-right">2h ago</small>
                                            <strong>Mark Johnson</strong> posted message on <strong>Monica
                                                Smith</strong> site. <br>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="tab-pane" id="tab-2">

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>当前状态</th>
                                        <th>标题</th>
                                        <th>开始时间</th>
                                        <th>结束时间</th>
                                        <th>备注</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <span class="label label-primary"><i
                                                        class="fa fa-check"></i> Completed</span>
                                        </td>
                                        <td>
                                            Create project in webapp
                                        </td>
                                        <td>
                                            12.07.2014 10:10:1
                                        </td>
                                        <td>
                                            14.07.2014 10:16:36
                                        </td>
                                        <td>
                                            <p class="small">
                                                Lorem Ipsum is that it has a more-or-less normal distribution of
                                                letters, as opposed to using 'Content here, content here', making it
                                                look like readable.
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    /*更新所选分类的维修工*/
    function edit(id) {
        url = '{{url('repair/service_provider')}}/' + id + '/edit';
        $.ajax({
            "url": url,
            "type": 'get',
            success: function (data) {
                $("#create").html(data);
            }
        })
    }
</script>