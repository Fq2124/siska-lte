<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Degrees extends Model
{
    protected $table = 'degrees';

    protected $guarded = ['id'];

    public function getEducation()
    {
        return $this->hasMany(Education::class, 'degree_id');
    }

    public function getVacancy()
    {
        return $this->hasMany(Vacancies::class, 'degree_id');
    }
}
