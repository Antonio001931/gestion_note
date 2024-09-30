<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class Etudiant extends Authenticatable
{
    use HasFactory;
    protected $table = 'v_etudiant_promotion';
    public $timestamps = false;
    protected $primaryKey = 'id_etudiant';
    protected $fillable = [
        'numetu',
       
       
       
       
    ];
    public static function getAllEtudiant()
    {
        return DB::table('v_etudiant_promotion')->get();
    }
    public static function getEtudiantByProm($id)
    {
        return DB::select('select*from v_etudiant_promotion where id_promotion='.$id);
    }

    public static function getEtuById($id)
    {
        return DB::select('select numetu from v_etudiant_promotion where id_etudiant='.$id);
    }
    public static function getIdByEtu($id)
    {
        return DB::select('select id_etudiant from v_etudiant_promotion where numetu = ?', [$id]);
    }
   

   
}
