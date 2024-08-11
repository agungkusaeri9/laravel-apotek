<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(TransasctionDetails::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeGetByAdminBarang($val)
    {
        return $val->where('user_id', auth()->user()->id);
    }

    public static function getNewCode()
    {

        $user_id = auth()->id();
        $kode_terakhir = self::getByAdminBarang($user_id)->latest()->first();
        if ($kode_terakhir) {
            $inv_userid = 'INV' . $user_id;
            $lastInvoiceNumber = substr($kode_terakhir->invoice, strlen($inv_userid));
            $nextInvoiceNumber = str_pad((int) $lastInvoiceNumber + 1, 5, '0', STR_PAD_LEFT);
            $invoice = 'INV' . $user_id . $nextInvoiceNumber;
            return $invoice;
        } else {
            $invoice =  'INV' . $user_id . '00001';
            return $invoice;
        }
    }
}
