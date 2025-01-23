<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetBookController extends Controller
{
    public function getbookIndex()
    {
        if (!session()->has('submit_count')) {
            session(['submit_count' => 1]); // เริ่มจาก 1
        }

        if (request()->isMethod('post')) {
            // เพิ่มค่าเฉพาะเมื่อเป็น POST
            $submitCount = session('submit_count') + 1;
            session(['submit_count' => $submitCount]); // อัปเดตค่า submit_count
        }

        $numberReceive = session('submit_count');


        return view('pages.home', compact('numberReceive'));
    }

    public function getbookCreate(Request $request)
    {
        $request->validate([
            'register_type' => 'nullable|string',
            'number_receive' => 'nullable|string',
            'book_number' => 'nullable|string',
            'book_year' => 'nullable|string',
            'book_receipt_number' => 'nullable|string',
            'urgency_level' => 'nullable|string',
            'received_date' => 'nullable|date',
            'date_receipt' => 'nullable|date',
            'registered_date' => 'nullable|date',
            'subject' => 'nullable|string',
            'to_person' => 'nullable|string',
            'reference' => 'nullable|string',
            'content' => 'nullable|string',
            'note' => 'nullable|string',
            'from_person' => 'nullable|string',
        ]);

        dd($request);

        return redirect()->back()->with('success', 'หนังสือถูกส่งเรียบร้อย');
    }
}
