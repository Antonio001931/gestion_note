<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Etudiant;
use App\Models\Note;
use App\Models\User;
use App\Models\Semestre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class CliController extends Controller
{

    public function loginCli() {
        return view('client.login');
    }

   
    public function doLoginCli(ClientRequest $request)
    {
        $credentials = $request->validated();


        $etudiant = Etudiant::where('numetu', strtoupper($credentials['etu']))->first();
       
        if ($etudiant) {
             
            Auth::guard('etudiant')->login($etudiant);
            $id=self::getAuthenticatedEtudiantId();
            $e=new Etudiant();
            $etude=$e->getEtuById($id);
            $semestre=Semestre::all();
            for($i=0;$i<count($semestre);$i++)
         {
              $n= new Note();
              $note=$n->getNoteSemestre($semestre[$i]->id_semestre,$credentials['etu']);
              
              $semestre[$i]['moyenne']=$note['moyenne'];
    
       }
            return view('client.liste_semestre',[
                "semestre"=>$semestre,
               "num"=>$etude[0],
             ]);
        } else
    {
        return redirect('/cli/login')->with('error','ETU incorrecte');
    }
       
    }
//getEtuById($id)
    public function getAuthenticatedEtudiantId()
    {
        return Auth::guard('etudiant')->id();
    }
    
    
    public function noteSemestre($ids,$etu)
    {
      $n= new Note();
      $note=$n->getNoteSemestre($ids,$etu);
     
      return view('client.note_etudiant',[
        "nom"=>$note["nom"],
        "prenom"=>$note["prenom"],
        "dtn"=>$note["dtn"],
        "num"=>$note["num"],
        "note"=>$note,
        "moyenne"=>$note["moyenne"],
        "credit"=>$note["credit"],
        "credit_obtenu"=>$note["crd_o"],
        // "session"=>$note["session"],
     ]);
        }
    
    
}
