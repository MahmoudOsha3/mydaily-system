<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetOtp;
use App\Models\User;
use App\Services\BrevoMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showRequestForm()
    {
        return view('pages.auth.forgot-password');
    }

    public function sendOtp(Request $request, BrevoMailer $mailer)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $data['email'])->first();

        // ما بنفصحش إذا الإيميل ده موجود ولا لأ، عشان نحافظ على خصوصية الحساب
        if ($user) {
            $code = (string) random_int(100000, 999999);

            PasswordResetOtp::where('email', $user->email)
                ->whereNull('consumed_at')
                ->update(['consumed_at' => now()]);

            PasswordResetOtp::create([
                'email' => $user->email,
                'code' => Hash::make($code),
                'expires_at' => now()->addMinutes(10),
            ]);

            $mailer->sendOtp($user->email, $code);
        }

        return redirect()
            ->route('password.reset.form', ['email' => $data['email']])
            ->with('success', 'لو الإيميل ده متسجل عندنا، هيوصلك كود التحقق حالًا.');
    }

    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', [
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $record = PasswordResetOtp::where('email', $data['email'])
            ->whereNull('consumed_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (! $record || $record->attempts >= 5 || ! Hash::check($data['otp'], $record->code)) {
            if ($record) {
                $record->increment('attempts');
            }

            return back()->withErrors([
                'otp' => 'الكود غلط أو منتهي، اطلب كود جديد.',
            ])->onlyInput('email');
        }

        $user = User::where('email', $data['email'])->firstOrFail();
        $user->update(['password' => Hash::make($data['password'])]);

        $record->update(['consumed_at' => now()]);

        return redirect()->route('login')->with('success', 'تم تغيير كلمة المرور، سجل دخولك دلوقتي.');
    }
}
