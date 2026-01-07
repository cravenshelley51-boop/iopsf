<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequiredDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'file_path',
        'status',
        'admin_notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getDocumentTypes()
    {
        return [
            'identity_document' => 'Identity Document',
            'contract' => 'IOPSF Contract',
            'insurance_receipt' => 'Insurance Payment Receipt'
        ];
    }
} 