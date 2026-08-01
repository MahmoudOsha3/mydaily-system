<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoMailer
{
    public function sendOtp(string $toEmail, string $code): bool
    {
        $response = Http::withHeaders([
            'api-key' => config('services.brevo.api_key'),
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name' => config('services.brevo.sender_name'),
                'email' => config('services.brevo.sender_email'),
            ],
            'to' => [
                ['email' => $toEmail],
            ],
            'subject' => 'كود إعادة تعيين كلمة المرور - يومياتي',
            'htmlContent' => $this->otpTemplate($code),
        ]);

        if ($response->failed()) {
            Log::error('فشل إرسال إيميل الـ OTP عن طريق Brevo', [
                'email' => $toEmail,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

        return $response->successful();
    }

    protected function otpTemplate(string $code): string
    {
        return <<<HTML
        <div dir="rtl" style="font-family: sans-serif; background:#0f172a; padding:32px; color:#f1f5f9;">
            <div style="max-width:420px; margin:auto; background:#1e293b; border-radius:16px; padding:32px; text-align:center;">
                <h2 style="color:#34d399; margin-bottom:8px;">كود إعادة تعيين كلمة المرور</h2>
                <p style="color:#94a3b8; margin-bottom:24px;">استخدم الكود ده عشان تكمل عملية تغيير كلمة المرور. الكود صالح لمدة 10 دقايق.</p>
                <div style="font-size:32px; font-weight:bold; letter-spacing:8px; background:#0f172a; padding:16px; border-radius:12px; color:#34d399;">
                    {$code}
                </div>
                <p style="color:#64748b; margin-top:24px; font-size:12px;">لو ما طلبتش الكود ده، تجاهل الرسالة دي.</p>
            </div>
        </div>
        HTML;
    }
}
