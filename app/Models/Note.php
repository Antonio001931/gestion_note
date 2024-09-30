<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use App\Models\Configuration;
use Illuminate\Database\Eloquent\Model;


class Note extends Model
{
    use HasFactory;
    protected $table = 'note';
    public $timestamps = false;
    protected $primaryKey = 'id_note';
    protected $fillable = [
         
        'id_etudiant',
        'id_matiere',
        'note',
        'coeff',
        'session',
       
       
       
       
    ];
    public static function getNoteSemestre($idS,$num)
    {
        $resu=DB::select('SELECT * FROM v_resultat WHERE id_semestre  = ? and numetu  = ? ', [$idS,$num]);

        $c=new Configuration();
        $conf1=$c->getConfById(1);
       
        $conf2=$c->getConfById(2);
    
        $moyenne=0;
        $note=0;
        $total=0;
        $credit=0;
        $credit_obtenu=0;
        $nbQ=0;
        $nbW=0;
        $result='';
        $nom='';
        $prenom='';
        $dtn='';
        $num='';
        $i=0;
        $session=null;
        for($i=0;$i<count($resu);$i++)
        {
          
           if($resu[$i]->note<10)
           {
               $nbQ++;
           }
           if($resu[$i]->note<$conf1[0]->valeur)
           {
               $nbW++;
           }
         
          
        }
   
        foreach($resu as $r)
        {
           
            $note=$r->total_note;
            $total=$total+$note;
            $c=$r->credit;
            $credit=$credit+$c;
            $crd_o=$r->credit_obtenu ;
            $semestre=$r->id_semestre;
           
            $moyenne=$total/$credit;
            $nom=$r->nom_etudiant;
            $prenom=$r->prenom;
            $dtn=$r->dtn;
            $num=$r->numetu;
            //$session=$r->session;
            $i++;         
        }   
    
       
       
            if($nbW==0 && $nbQ<=$conf2[0]->valeur && $moyenne>=10)
            {
              
              
               for($i=0;$i<count($resu);$i++)
               {
                   if($resu[$i]->resultat=='AJ')
                   {
                       $resu[$i]->resultat='Com';
                       $resu[$i]->credit_obtenu=$resu[$i]->credit;            
                     
                   }            
               }
                   
            }   
            
            
            $mention='';
            $credit_obtenu=0;
           
            for($i=0;$i<count($resu);$i++)
            {
                
                $credit_obtenu= $credit_obtenu+$resu[$i]->credit_obtenu;
                
             
                if($credit_obtenu==30)
                {
                    $mention='Admis';
                }
                else{
                    $mention='Ajournee';
                }
              
            }    
           
          
      
        $res= [];
        $res["nom"]=$nom;
        $res["prenom"]=$prenom;
        $res["dtn"]=$dtn;
        $res["num"]=$num;
        $res["moyenne"]=round($moyenne,2);
        $res["credit"]=$credit;
        $res["crd_o"]=$credit_obtenu;
        $res["session"]=$session;
        $res["notes"]=$resu;
        $res["semestre"]=$semestre;
        $res["mention"]=$mention;
       // dd($res["crd_o"]);
      // dd($session);
       return $res;
    }

 public function getSommeCreditEtudiant($num)
{
   $total=0;
   $nom='';
   $semestre=Semestre::all();
   for($i=0;$i<count($semestre);$i++)
  {
   
    $credit=self::getNoteSemestre($semestre[$i]->id_semestre,$num);
    $semestre[$i]['crd_o']=$credit['crd_o'];
    if (is_array($credit['crd_o'])) {
        $total += array_sum($credit['crd_o']);
    } else {
        $total += $credit['crd_o'];
    }
  }
  $res=[];
  $res['crd']=$total;
  $res['nom']=$credit['nom'];
  

return $res;
}
//tableau de bord
public function getListCreditEtudiant()
{
    $admis=0;
    $non_admis=0;
    $moyenne=[];
    $ad_name=[];
    $pd_name=[];
   $etudiant=Etudiant::all();
    for($j=0;$j<count($etudiant);$j++)
    {
        $credit=self::getSommeCreditEtudiant($etudiant[$j]->numetu);
        $moy=self::getResultatAnnee($etudiant[$j]->numetu,3);
        //$moyenne[$j]['moyenne_general']=$moy['moyenne_general'];
        $etudiant[$j]['crd']=$credit['crd'];
        $etudiant[$j]['moyenne']=$moy['moyenne_general'];
        if($etudiant[$j]['crd']<180)
        {
             $non_admis++;
             $pd_name[$j]=$etudiant[$j];
             $moyenne[$j]=$etudiant[$j];
         }else
        {
            $admis++;
           $ad_name[$j]=$etudiant[$j];
           $moyenne[$j]=$etudiant[$j];

         }
        
    }
 
   $res=[];
   $res['admis']=$admis;
   $res['non_admis']=$non_admis;
   $res['nadmis']=$ad_name;
   $res['nonadmis']=$pd_name;
   $res['moyenne_licence']=$moyenne;
 

   return $res;
   
    
  }
  //total_credit
public static function getCreditLicence($etu,$anne)
{
    $semestre =null;
    if($anne==1)
    {
        $semestre=Semestre::where('id_semestre',1)->orwhere('id_semestre',2)->get();
    }
    if($anne==2)
    {
        $semestre=Semestre::where('id_semestre',3)->orwhere('id_semestre',4)->get();
    }
    if($anne==3)
    {
        $semestre=Semestre::where('id_semestre',5)->orwhere('id_semestre',6)->get();
    }
    $total_credit=0;

    foreach($semestre as $sem){
  
        $relever=Note::getNoteSemestre($semestre[0]->id_semestre,$etu);
        foreach($relever["notes"] as $rel)
        {
            $total_credit+=$rel->credit_obtenu;
           
        }
    }
    return $total_credit;

}

public static function getResultatAnnee($etu,$anne)
{
    $semestre =null;
    if($anne==1)
    {
        $semestre=Semestre::where('id_semestre',1)->orwhere('id_semestre',2)->get();
    }
    if($anne==2)
    {
        $semestre=Semestre::where('id_semestre',3)->orwhere('id_semestre',4)->get();
    }
    if($anne==3)
    {
        $semestre=Semestre::where('id_semestre',5)->orwhere('id_semestre',6)->get();
    }
    $total_note=0;
    $total_credit=0;
    $moyenne_gen=0;
    $resultat='';
    $i=0;
    foreach($semestre as $sem){
  
        $relever=Note::getNoteSemestre($semestre[$i]->id_semestre,$etu);
        $i++;
        foreach($relever["notes"] as $rel)
        {
            
            $total_note+=$rel->total_note;
            $total_credit+=$rel->credit_obtenu;
           
            $moyenne_gen=round($total_note/60,2);
            if($total_credit==60)
            {
                $resultat='Admis';
            }else {
                $resultat='Ajournee';
            }

        }
        
        $res= [];
        $res["moyenne_general"]=$moyenne_gen;
        $res["resultat"]=$resultat;
    }
  
   //dd($res);
   return $res;

}





  
}