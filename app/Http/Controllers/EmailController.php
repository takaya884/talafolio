<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function showForm()
    {
        return view('emails.send-form');
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            Mail::raw($request->message, function ($message) use ($request) {
                $message->to($request->to)
                        ->subject($request->subject);
            });

            return back()->with('success', 'メールが正常に送信されました。');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'メールの送信に失敗しました。' . $e->getMessage()]);
        }
    }
}