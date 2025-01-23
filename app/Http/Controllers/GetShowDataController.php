<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReceivedBook;
use App\Models\DocumentPdf;
use App\Models\ReceivedBookView;

class GetShowDataController extends Controller
{
    public function getbookIndex()
    {
        $lastReceivedBookId = ReceivedBook::max('id') + 1;

        $ReceivedBook = ReceivedBook::with('documentPdf')->get();

        return view('pages.index', compact('lastReceivedBookId','ReceivedBook'));
    }
}
