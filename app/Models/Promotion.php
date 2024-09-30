<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $table = 'promotion';
    public $timestamps = false;
    protected $primaryKey = 'id_promotion';
    protected $fillable = [
         
        
        'nom',
        'annee',
        
       
       
       
       
    ];
}
