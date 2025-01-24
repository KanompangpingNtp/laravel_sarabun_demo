<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReceivedBook;
use App\Models\DocumentPdf;
use App\Models\ReceivedBookView;

class FilesonTableController extends Controller
{
    public function BookFiles()
    {
        $ReceivedBook = ReceivedBook::with('documentPdf')->get();

        return view('pages.home2', compact('ReceivedBook'));
    }

    public function viewFile($id)
    {
        $receivedbook = ReceivedBook::with('documentPdf')->findOrFail($id);

        return view('pages.view_file', compact('receivedbook'));
    }
}
