<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Semestre extends Model
{
    use HasFactory;
    protected $table = 'semestre';
    public $timestamps = false;
    protected $primaryKey = 'id_semestre';
    protected $fillable = [
         
       'nom',
       
       
       
    ];
    public static function getAllSemestre()
    {
        return DB::table('semestre')->get();
    }
    public static function getMoyenneSemestre($num)
    {
        $resu=DB::select('SELECT * FROM v_resultat WHERE numetu  = ?', [$num]);

        return $resu;
        
    }
}
