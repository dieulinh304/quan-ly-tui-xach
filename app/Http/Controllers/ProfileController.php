<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException; // Đảm bảo đã import để sử dụng

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user(); // Lấy thông tin người dùng đang đăng nhập
        return view('pages.profile', compact('user'));
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'hoten' => 'required|string|max:100',
            // Rule 'unique' đã được tùy chỉnh để bỏ qua email của chính người dùng hiện tại
            // 'nguoidung' là tên bảng, 'email' là cột email, $user->id_nd là ID của người dùng hiện tại, 'id_nd' là tên cột khóa chính của bảng nguoidung
            'email' => 'required|string|email|max:100|unique:nguoidung,email,' . $user->id_nd . ',id_nd',
            'diachi' => 'nullable|string|max:255',
            'sdt' => 'nullable|string|max:20', // Đảm bảo cột này trong DB là VARCHAR/STRING để không mất số 0 đầu tiên
        ], [
            'email.unique' => 'Email này đã được sử dụng bởi một tài khoản khác.',
            'hoten.required' => 'Họ tên không được để trống.',
            'hoten.max' => 'Họ tên không được vượt quá :max ký tự.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.max' => 'Email không được vượt quá :max ký tự.',
            'diachi.max' => 'Địa chỉ không được vượt quá :max ký tự.',
            'sdt.max' => 'Số điện thoại không được vượt quá :max ký tự.',
        ]);

        $user->hoten = $request->hoten;
        $user->email = $request->email;
        $user->diachi = $request->diachi;
        $user->sdt = $request->sdt;
        $user->save();

        return redirect()->back()->with('success', 'Thông tin cá nhân đã được cập nhật thành công!');
    }

    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed', // Mật khẩu mới yêu cầu ít nhất 6 ký tự và phải khớp với trường xác nhận
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất :min ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Mật khẩu hiện tại không đúng.'],
            ]);
        }

        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Mật khẩu đã được thay đổi thành công!');
    }
}