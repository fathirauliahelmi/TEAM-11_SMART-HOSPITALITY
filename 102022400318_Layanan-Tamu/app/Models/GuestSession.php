<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestSession extends Model
{
    // Kasih tahu Laravel kalau model ini berpasangan dengan tabel guest_sessions
    protected $table = 'guest_sessions';

    // Daftarkan kolom yang boleh diisi secara massal (Mass Assignment)
    protected $fillable = [
    'room_number',
    'guest_name',
    'session_token',
    'check_in_at',
    'check_out_at',
    'status',
    'receipt_number'
    ];
}