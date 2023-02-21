<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eps extends Model
{
    protected $connection = 'tenant';
    protected $fillable = ['nombre', 'nit', 'cuenta_contable', 'editable'];
    protected $table = 'eps';
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ['editable' => 'boolean'];

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }
}
