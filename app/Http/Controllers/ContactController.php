<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'email'   => ['nullable', 'email', 'max:160'],
            'phone'   => ['required', 'string', 'max:30'],
            'subject' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        try {
            if ($clinic = site('contact_email')) {
                Mail::raw(
                    "Yeni iletişim mesajı:\n\nAd: {$data['name']}\nTelefon: {$data['phone']}\n"
                        ."E-posta: ".($data['email'] ?? '-')."\nKonu: ".($data['subject'] ?? '-')."\n\n{$data['message']}",
                    fn ($m) => $m->to($clinic)->subject('İletişim Formu: '.($data['subject'] ?? 'Yeni mesaj'))
                );
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return back()->with('contact_success', 'Mesajınız alındı. En kısa sürede sizinle iletişime geçeceğiz.');
    }
}
