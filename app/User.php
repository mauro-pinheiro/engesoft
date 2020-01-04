<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'email',
        'institution_id',
        'theme',
        'endereco',
        'senha',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function setInstitutionIdAttribute($instituicao)
    {
        if ($instituicao != null) {
            $this->attributes['institution_id'] = Institution::firstOrCreate([
                'nome' => $instituicao
            ])->id;
        }
    }

    /** Relationships */

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
