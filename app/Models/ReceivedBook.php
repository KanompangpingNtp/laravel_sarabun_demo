<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id', 'register_type','number_receive', 'book_number', 'book_year', 'book_receipt_number',
        'urgency_level', 'received_date', 'date_receipt', 'registered_date', 'subject',
        'to_person', 'reference', 'content', 'note', 'from_person',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function views()
    {
        return $this->hasMany(ReceivedBookView::class);
    }

    public function documentPdf()
    {
        return $this->hasOne(DocumentPdf::class, 'received_book_id');
    }
}
