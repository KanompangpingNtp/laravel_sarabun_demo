<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReceivedBook;
use App\Models\DocumentPdf;
use App\Models\ReceivedBookView;

class GetBookController extends Controller
{
    //
    public function getbookIndex()
    {
        $lastReceivedBookId = ReceivedBook::max('id') + 1;

        return view('pages.home', compact('lastReceivedBookId'));
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
            'file_input' => 'file|max:10240',
        ]);

        // dd($request);

        $ReceivedBook = ReceivedBook::create([
            'users_id' => auth()->id(),
            'register_type' => $request->register_type,
            'number_receive' => $request->number_receive,
            'book_number' => $request->book_number,
            'book_year' => $request->book_year,
            'book_receipt_number' => $request->book_receipt_number,
            'urgency_level' => $request->urgency_level,
            'received_date' => $request->received_date,
            'date_receipt' => $request->date_receipt,
            'registered_date' => $request->registered_date,
            'subject' => $request->subject,
            'to_person' => $request->to_person,
            'reference' => $request->reference,
            'content' => $request->content,
            'note' => $request->note,
            'from_person' => $request->from_person,
        ]);

        if ($request->hasFile('file_input')) {
            $file = $request->file('file_input');
            if ($file->getClientOriginalExtension() !== 'pdf') {
                return redirect()->back()->with('error', 'รองรับเฉพาะไฟล์ PDF เท่านั้น!');
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('pdf', $filename, 'public');

            DocumentPdf::create([
                'received_book_id' => $ReceivedBook->id,
                'pdf_files' => $path,
                'pdf_status' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'หนังสือถูกส่งเรียบร้อย');
    }
}
