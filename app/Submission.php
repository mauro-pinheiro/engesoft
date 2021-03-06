<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = ['number', 'status'];

    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function contact()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute()
    {
        switch ($this->attributes['status']) {
            case 'I':
                return "Incompleto";
            case 'P':
                return "Pendente";
            case 'A':
                return "Avaliado";
            case 'S':
                return "Selecionado";
        }
    }
}
