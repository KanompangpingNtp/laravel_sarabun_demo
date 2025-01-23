<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReceivedBook;
use App\Models\DocumentPdf;

class BookFilesController extends Controller
{
    public function BookFiles()
    {
        $ReceivedBook = ReceivedBook::with('documentPdf')->get();

        return view('pages.home2', compact('ReceivedBook'));
    }
}
