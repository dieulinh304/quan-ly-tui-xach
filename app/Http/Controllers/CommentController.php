<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Lấy danh sách comment (ví dụ theo sản phẩm)
    public function index($sanpham_id)
    {
        $comments = Comment::where('sanpham_id', $sanpham_id)->with('user')->get();
        return response()->json($comments);
    }

    // Hàm kiểm tra từ ngữ thô tục
    private function containsBadWords($content)
    {
        $badwords = file(storage_path('app/dstucam.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($badwords as $word) {
            if (stripos($content, $word) !== false) {  // không phân biệt hoa thường
                return true;
            }
        }
        return false;
    }

    // Thêm mới comment
    public function store(Request $request)
    {
        $request->validate([
            'sanpham_id' => 'required|exists:sanpham,id_sanpham',
            'content' => 'required|string|max:1000',
        ]);

        // Kiểm tra từ ngữ thô tục
        if ($this->containsBadWords($request->content)) {
            return response()->json(['success' => false, 'message' => 'Vi phạm ngôn ngữ cộng đồng'], 422);
        }

        $comment = Comment::create([
            'user_id' => Auth::user()->id_nd,
            'sanpham_id' => $request->sanpham_id,
            'content' => $request->content,
        ]);

        $comment->load('user');

        return response()->json(['success' => true, 'comment' => $comment]);
    }

    // Sửa comment
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::findOrFail($id);

        if ($comment->user_id != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Không có quyền sửa bình luận này.'], 403);
        }

        // Kiểm tra từ ngữ thô tục
        if ($this->containsBadWords($request->content)) {
            return response()->json(['success' => false, 'message' => 'Vi phạm ngôn ngữ cộng đồng'], 422);
        }

        $comment->content = $request->content;
        $comment->save();

        return response()->json(['success' => true, 'comment' => $comment]);
    }

    // Xóa comment
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Không có quyền xóa bình luận này.'], 403);
        }

        $comment->delete();

        return response()->json(['success' => true]);
    }
}
