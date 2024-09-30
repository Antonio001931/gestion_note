<?php

namespace App\Http\Controllers;
use App\Models\ResetDatabase;
use Illuminate\Http\Request;

class ResetController extends Controller
{
    public function reset_database() {
       

      $reset=new ResetDatabase();
      $re=$reset->resetDatabase();
      
      return redirect()->intended('/admin/import/data');
           
    }
}
