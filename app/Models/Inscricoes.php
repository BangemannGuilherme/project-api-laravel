<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscricoes extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'inscricoes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'users_id',
        'eventos_id',
        'checkin',
    ];

    public function eventos()
    {
        return $this->belongsTo(Eventos::class, 'eventos_id', 'id');
    }

    public function usuarios()
    {
        return $this->belongsTo(User::class);
    }
}
