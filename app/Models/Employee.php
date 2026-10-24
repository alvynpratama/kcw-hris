<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'full_name',
        'phone',
        'birth_place',
        'birth_date',
        'nik',
        'address',
        'placement_company',
        'department',
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
        'contract_start',
        'contract_end',
        'status',
        'face_photo_path',
        'ktp_file_path',
        'kk_file_path',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'contract_start' => 'date',
            'contract_end' => 'date',
        ];
    }
}