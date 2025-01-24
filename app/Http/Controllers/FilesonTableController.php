<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReceivedBook;
use App\Models\DocumentPdf;
use App\Models\ReceivedBookView;

class FilesonTableController extends Controller
{
    //
    public function getbookIndex()
    {
        $ReceivedBook = ReceivedBook::with('documentPdf')->get();

        return view('pages.home2', compact('ReceivedBook'));
    }
}
