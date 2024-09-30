<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Matiere extends Model
{
    use HasFactory;
    protected $table = 'matiere';
    public $timestamps = false;
    protected $primaryKey = 'id_matiere';
    protected $fillable = [
        'credit',
       
       
       
       
    ];

    public static function getAllMatiere()
    {
        return DB::table('matiere')->get();
    }
    public static function getMatiereById($id)
    {
        return DB::select('select*from matiere where id_matiere='.$id);
    }
    

}
