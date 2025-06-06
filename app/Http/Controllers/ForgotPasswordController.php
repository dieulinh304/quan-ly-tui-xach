<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\NguoiDung;

class ForgotPasswordController extends Controller
{
    public function showForgotForm() {
        return view('pages.forgot-password');
    }

    public function sendResetLink(Request $request) {
        $request->validate(['email' => 'required|email']);
        $user = NguoiDung::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email không tồn tại!');
        }

        $token = Str::random(64);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::send('emails.reset-password', ['token' => $token], function($message) use ($request){
            $message->to($request->email);
            $message->subject('Lấy lại mật khẩu');
        });

        return back()->with('success', 'Đã gửi email lấy lại mật khẩu!');
    }

    public function showResetForm($token) {
        return view('pages.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $reset = DB::table('password_resets')
                    ->where('email', $request->email)
                    ->where('token', $request->token)
                    ->first();

        if (!$reset) {
            return back()->with('error', 'Token không hợp lệ hoặc đã hết hạn!');
        }

        $user = NguoiDung::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Đặt lại mật khẩu thành công!');
    }
}
?>
