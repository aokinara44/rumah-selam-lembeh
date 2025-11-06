<?php
// app/Models/Transaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'description',
        'amount',
        'type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime', // Otomatis format kolom 'date' sebagai objek Tanggal (Carbon)
        'amount' => 'decimal:2', // Otomatis format kolom 'amount' sebagai desimal dengan 2 angka di belakang koma
    ];
}