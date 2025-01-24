<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentPdf extends Model
{
    use HasFactory;

    protected $fillable = [
        'received_book_id', 'pdf_files', 'pdf_status',
    ];

    public function receivedBook()
    {
        return $this->belongsTo(ReceivedBook::class, 'received_book_id');
    }
}
