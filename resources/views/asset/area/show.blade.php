<div class="modal-header">
    <a style="float: right;" href="javascript:;" onclick="dlt('{{$info->id}}')" >删除</a>
    <h4 class="modal-title" id="myModalLabel">编辑分类</h4>
</div>
<div class="modal-body">
    <label class="control-label">场地名称<span style="color:red;">*</span></label>
    <input type="text" value="{{$info->name}}" name="name" class="form-control" >

    <label class="control-label">场地编号</label>
    <input type="text" value="{{$info->address_code}}" name="address_code" class="form-control">

    <label class="control-label">备注</label>
    <textarea class="form-control" name="descr" rows="3" placeholder="添加备注" style="resize: none;"></textarea>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">确认</button>
</div>