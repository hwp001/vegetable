<?php

namespace App\Http\Controllers\Api\V1\Wx;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function addComment(Request $request)
    {
        $data = $request->all();
        $bool = (new Comment())->addComment($data);
        return json_encode($bool);
        if ($bool) {
            return json_encode(['statu'=>1]);
        } else {
            return json_encode(['statu'=>0,'err'=>'新增评论失败']);
        }
    }

    //上传图片 并将图片存储再临时文件位置
    public function uploadImg(Request $request)
    {
        if (!empty($_FILES)) {
            $upload_dir = public_path('upload/goodImg/');
            $upload_name = $upload_dir.basename($_FILES['commentImg']['name']);
            if (move_uploaded_file($_FILES['commentImg']['tmp_name'], $upload_name)) {
                return 'goodImg/'.basename($_FILES['commentImg']['name']);
            } else {
                return 0;
            }
        }

    }
}
