<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedBookView extends Model
{
    use HasFactory;

    protected $fillable = [
        'received_book_id', 'name_verifier', 'date_view', 'view_status',
    ];

    public function receivedBook()
    {
        return $this->belongsTo(ReceivedBook::class);
    }
}
