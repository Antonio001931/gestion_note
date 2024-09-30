<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Etudiant;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Semestre;
use App\Models\Promotion;
use App\Models\Configuration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AuthController extends Controller
{

    public function login() {
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }

    public function doLogin(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->intended('/insertNote');
            } 
        }

        return back()->withErrors([
            'email' => 'Verifier',
            'password' => 'Verifier'
        ])->onlyInput('email');
    }

    
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function insertAd()
    {
        $user = User::create([
            'nom' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'is_admin' => true,
           
        ]);

        Auth::login($user);

        return redirect('/');
    }

   public function insertNote()
   {
    $etudiant=new Etudiant();
    $matiere=new Matiere();
    //$e=$etudiant->getAllEtudiant();
    $m=$matiere->getAllMatiere();
    return view('auth.insert_note',[
    
           
      //  'e'=> $e,
        'm'=>$m,
        
       
    ]);

   }

   public function doInsertNote(Request $request)
   {
    $validatedData = $request->validate(
        [
            
            'etudiant' => 'required',
            'matiere' => 'required',
            'note'=>'nullable|numeric|min:0',
          

        ]
    );
    $etu=$request->input('etudiant');
    $etudiant=Etudiant::where('numetu', $etu)->first();
    try {
      
        
        DB::beginTransaction();
        if($etudiant)
        {
            
        $val= Note::create([
           
          
            'id_etudiant' =>$etudiant->id_etudiant,
            'id_matiere'=>$validatedData['matiere'],
            'note' =>$validatedData['note'],
            'session'=>Carbon::Now(),
            
          

          ]);
          DB::commit();
          return redirect('/insertNote')->with('success','Insertion note avec succes');
        }
       
            return redirect('/insertNote')->with('error','Insertion note error');
        
      
      
       
          


           
            
        
    } catch (\Exception $e) {
        DB::rollBack();
        dd($e->getMessage());

        return back()->with('errors',$e->getMessage());
        dd($e->getMessage());
    }

   }
   
//filtre

// public function index()
//     {
//         $rep=new Etudiant();
//         $val=$rep->getAllEtudiant();
//         return view('auth.liste_etudiant',[
    
           
//             'prom'=> $val,
//             'result'=>null,
            
           
//         ]);
//     }
public function filtre(Request $request)
{
    
   $prom=Promotion::all();
   
   $data=$request->input();
   
   if(empty($data))
   {
   
    $etudiants=Etudiant::all();

   }else{
    $promotion=intval($data['promotion']);
    if($data['nom']==null)
    {
        $nom="";
        
    }else{
        $nom=strtolower($data['nom']);
        
    }
    
    $query_prom="";
    if($promotion!=0)
    {
        $query_prom="and id_promotion =".$promotion;
    }
    $query="select * from v_etudiant_promotion where lower(CONCAT(nom, ' ',prenom)) LIKE '%".$nom."%'".$query_prom;
    $etudiants=DB::select($query);
}
    return view('auth.liste_etudiant',[
       "promotion"=>$prom,
       "etudiants"=>$etudiants,
    ]);


  
}
public function listeSemestre($numetu)
{
    
  
  $semestre=Semestre::all();

  for($i=0;$i<count($semestre);$i++)
  {
    $n= new Note();
    $note=$n->getNoteSemestre($semestre[$i]->id_semestre,$numetu);
    $semestre[$i]['moyenne']=$note['moyenne'];
  
  }
 
  
  return view('auth.liste_semestre',[
    "semestre"=>$semestre,
   "num"=>$numetu,

 ]);



}

public function noteSemestre($ids,$etu)
{
// $co=new Configuration();
// $conf1=$co->getConfById(1);

// $conf2=$co->getConfById(2);

  $n= new Note();
  $note=$n->getNoteSemestre($ids,$etu);
 
  return view('auth.note_etudiant',[
    "nom"=>$note["nom"],
    "prenom"=>$note["prenom"],
    "dtn"=>$note["dtn"],
    "num"=>$note["num"],
    "note"=>$note,
    "moyenne"=>$note["moyenne"],
    "credit"=>$note["credit"],
    "credit_obtenu"=>$note["crd_o"],
    "mention"=>$note["mention"],
    
 ]);
    }
// $res["crd_o"]=$credit_obtenu;
public function getNombreEtudiant()
{
    $etudiant=Etudiant::all();
    $nbr_etudiant=count($etudiant);
    return view('auth.tableau_bord',[
        "nombre"=>$nbr_etudiant,
       
        
     ]);
}
public function getAdmis()
{
    //getSommeCreditEtudiant($num)
    $etudiant=Etudiant::all();
    $nbr_etudiant=count($etudiant);
    $n=new Note();
    $res=$n->getListCreditEtudiant();

    return view('auth.tableau_bord',[
        "nombre"=>$nbr_etudiant,
        "admis"=>$res['admis'],
        "non_admis"=>$res['non_admis'],
        "n_admis"=>$res['nadmis'],
        "n_padmis"=>$res['nonadmis'],
      
       
        
     ]);
}
    

public function getEtuAdmis()
{
    //getSommeCreditEtudiant($num)
    $etudiant=Etudiant::all();
    $nbr_etudiant=count($etudiant);
    $n=new Note();
    $res=$n->getListCreditEtudiant();
    return view('auth.listeAdmis',[
       
        "n_admis"=>$res['nadmis'],
        "moyenne"=>$res['moyenne_licence'],
      
       
        
     ]);
}
   
public function getEtuNonAdmis()
{
    //getSommeCreditEtudiant($num)
    $etudiant=Etudiant::all();
    $nbr_etudiant=count($etudiant);
    $n=new Note();
    $res=$n->getListCreditEtudiant();
    return view('auth.listeNonAdmis',[
       
        "nonadmis"=>$res['nonadmis'],
        "moyenne"=>$res['moyenne_licence'],
       
        
     ]);
}
//nuety
public function ListeLicence($ids)
{
    $anne =[];
    for($i=0;$i<3;$i++)
    {
       $anne[$i]['anne']=$i+1;
       $total_credit=Note::getCreditLicence($ids,$i+1);
       $res='';
       if($total_credit==60)
       {
        $res='admis';
       }
       else{
        $res='ajournee';
       }
       $anne[$i]['resultat']=$res;
       
       
    }
    return view('auth.listeanne',[
       
        "anne"=>$anne,
        "id"=>$ids,
        
       
        
     ]);
}

public static function ListeRelever($an,$etu)
{
    $semestre =null;
    if($an==1)
    {
        $semestre=Semestre::where('id_semestre',1)->orwhere('id_semestre',2)->get();
    }
    if($an==2)
    {
        $semestre=Semestre::where('id_semestre',3)->orwhere('id_semestre',4)->get();
    }
    if($an==3)
    {
        $semestre=Semestre::where('id_semestre',5)->orwhere('id_semestre',6)->get();
    }
    $relever=[];
    $resultat_general=[];
    $i=0;
    $moyenne_annee=0;
    $moyenne_general=0;
    $credit=0;
   
    foreach($semestre as $sem){
  
        $relever[$i]["resultats"]=Note::getNoteSemestre($semestre[$i]->id_semestre,$etu);
       $moyenne_annee+=$relever[$i]["resultats"]["moyenne"];
       $credit+=$relever[$i]["resultats"]["crd_o"];
        $i++;
       
    }
    $moyenne_general= $moyenne_annee/2;
    $mention='';
    if($credit==60)
    {    $mention='Admis';
    }else $mention='Ajournee';
    $resulat_general["moyenne"]=$moyenne_general;
    $resulat_general["mention"]=$mention;
   //$resultat=Note::getResultatAnnee($etu,$an);
   
    return view('auth.releverAnnee',[
       
        "relever"=>$relever,
        "moyenne_general"=> $resulat_general["moyenne"],
        "creditanne"=>$credit,
        "mention"=>$resulat_general["mention"],
        
     ]);
}
    
} 


