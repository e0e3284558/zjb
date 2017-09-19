<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">个人信息</h4>
</div>
<div class="modal-body">
    <form action="{{url('users/default/'.$data->id)}}" id="AddUserForm" class="form-horizontal " method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label class="control-label col-md-3">用户名<span class="required">*</span></label>
            <div class="col-md-8">
            <input type="text" value="{{ $data->username }}" disabled class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">姓名<span class="required">*</span></label>
            <div class="col-md-8">
                <input type="text" value="{{ $data->name }}" disabled class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">邮箱<span class="required">*</span></label>
            <div class="col-md-8">
            <input type="email" value="{{ $data->email }}" disabled class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">手机号<span class="required">*</span></label>
            <div class="col-md-8">
            <input type="text" value="{{ $data->tel }}" disabled class="form-control">
            </div>
        </div>

    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-success" data-dismiss="modal">确定</button>
    {{--<button type="button" class="btn btn-success blue" id="submitUserForm">保存</button>--}}
</div>