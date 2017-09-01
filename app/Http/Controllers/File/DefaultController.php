<?php

namespace App\Http\Controllers\File;

use App\Models\File\File as FileModel;
use App\Services\ResponseJsonMessageService;
use Intervention\Image\Facades\Image;
use Storage;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DefaultController extends Controller
{
    use ResponseJsonMessageService;
    private $upload_folder = 'uploads';

    //图片上传接口
    public function imageUpload(Request $request)
    {
        //上传验证
        $rule = [
            'file' => 'bail|image|max:2048'
        ];
        $message = [
            'file.image' => '上传文件必须是图片',
            'file.max' => '上传图片大小不能大于2M',
        ];
        $file = $request->file();
        $validator = Validator::make($file, $rule, $message);
        if ($validator->fails()) {
            self::setStatus(0);
            self::setMessage($validator->errors()->first('file'));
        } else {
            //上传图片
            $upload_file = $file['file'];
            if ($upload_file->isValid()) {
                //设置保存目录
                $save_path = $this->upload_folder . '/' . date("Ym", time())
                    . '/' . date("d", time());
                //文件的扩展名
                $ext = $upload_file->getClientOriginalExtension();
                $uniqid = uniqid();
                //设置保存文件名
                $save_name = $uniqid . '.' . $ext;
                //文件转存
                $upload_file->move(public_path() . '/'
                    . $save_path, $save_name);
                $path = $save_path . '/' . $save_name;
                //数据库保存上传文件信息
                $file_info = new FileModel();
                $file_info->type = $upload_file->getClientMimeType();
                $file_info->name = $save_name;
                $file_info->old_name = $upload_file->getClientOriginalName();
                $file_info->width = 0;
                $file_info->height = 0;
                $file_info->suffix = $ext;
                $file_info->file_path = public_path() . '/' . $path;
                $file_info->path = '/' . $path;
                $file_info->url = config('app.url') . '/' . $path;
                $file_info->size = $upload_file->getClientSize();
                $file_info->org_id = get_current_login_user_org_id();
                $file_info->ip = $request->ip();
                $file_info->user_id = get_current_login_user_info();
                $file_info->upload_mode = 'image';
                $file_info->uniqid = $uniqid;

                if ($file_info->save()) {
                    self::setStatus(1);
                    self::setData($file_info->toArray());
                    self::setMessage('上传成功');
                } else {
                    self::setStatus(0);
                    self::setMessage('上传失败，数据库保存出错');
                }
            } else {
                self::setStatus(0);
                self::setMessage($upload_file->getErrorMessage());
            }
        }
        return response()->json(self::getMessageResult());
    }

    //文件上传接口
    public function fileUpload(Request $request)
    {
        $disk = Storage::disk('file');
        //上传验证
        $rule = [
            'file' => 'bail|max:2048'
        ];
        $message = [
            'file.max' => '上传文件大小不能大于2M',
        ];
        $file = $request->file();
        $validator = Validator::make($file, $rule, $message);
        if ($validator->fails()) {
            self::setStatus(0);
            self::setMessage($validator->errors()->first('file'));
        } else {
            //上传图片
            $upload_file = $file['file'];
            if ($upload_file->isValid()) {
                //设置保存目录
                $save_path =  date("Ym", time()) . '/' . date("d", time());
                //文件的扩展名
                $ext = $upload_file->getClientOriginalExtension();
                $uniqid = uniqid();
                //设置保存文件名
                $save_name = $uniqid . '.' . $ext;
                $bool = $disk->putFile($save_path,$upload_file);
                dump($bool);

//
//                //文件转存
//                $upload_file->move(public_path() . '/'
//                    . $save_path, $save_name);
//                $path = $save_path . '/' . $save_name;
//                //数据库保存上传文件信息
//                $file_info = new FileModel();
//                $file_info->type = $upload_file->getClientMimeType();
//                $file_info->name = $save_name;
//                $file_info->old_name = $upload_file->getClientOriginalName();
//                $file_info->width = 0;
//                $file_info->height = 0;
//                $file_info->suffix = $ext;
//                $file_info->file_path = public_path() . '/' . $path;
//                $file_info->path = '/' . $path;
//                $file_info->url = config('app.url') . '/' . $path;
//                $file_info->size = $upload_file->getClientSize();
//                $file_info->org_id = get_current_login_user_org_id();
//                $file_info->ip = $request->ip();
//                $file_info->user_id = get_current_login_user_info();
//                $file_info->upload_mode = 'image';
//                $file_info->uniqid = $uniqid;
//
//                if ($file_info->save()) {
//                    self::setStatus(1);
//                    self::setData($file_info->toArray());
//                    self::setMessage('上传成功');
//                } else {
//                    self::setStatus(0);
//                    self::setMessage('上传失败，数据库保存出错');
//                }
            } else {
                self::setStatus(0);
                self::setMessage($upload_file->getErrorMessage());
            }
        }
        return response()->json(self::getMessageResult());
    }

    //视频上传接口
    public function videoUpload()
    {

    }

    //base64上传接口
    public function base64Upload()
    {

    }
}
