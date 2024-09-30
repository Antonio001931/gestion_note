<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Configuration extends Model
{
    use HasFactory;
    protected $table = 'import_conf';
    public $timestamps = false;
    protected $primaryKey = 'id_conf';
    protected $fillable = [

        'code',
        'config',
        'config',
       
       
       
       
    ];

    public static function getAllConf()
    {
        return DB::table('import_conf')->get();
    }
    public static function getConfById($id)
    {
        return DB::select('select valeur from import_conf where id_conf='.$id);
    }



}

  


