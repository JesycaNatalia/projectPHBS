<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'bulan_id',
        'user_id',
        'ppemantauan_id',
        'kartu_keluarga_id',
        'total_skor',
        'skor_nol',
    ];

    public function bulan()
    {
        return $this->belongsTo('App\Models\Bulan');
    }

    public function kartu_keluarga()
    {
        return $this->belongsTo('App\Models\KartuKeluarga');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function ppemantauan()
    {
        return $this->belongsTo('App\Models\Ppemantauan');
    }
}
