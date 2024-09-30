<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class Import extends Model
{
    use HasFactory;

    public function importDonne($note,$conf): array
    {
    
        $dataNote=Excel::toArray(new \App\Imports\Import(),storage_path($note))[0];
        //dd($dataNote);
        $dataConf =Excel::toArray(new \App\Imports\Import(),storage_path($conf))[0];
      // dd($dataConf);
    

        $message = [];
        $i = 0;
        DB::table('import_note')->truncate();
        foreach ($dataNote as $d) {
            try {
                $validation = Validator::make([
                    // numetu | nom | prenom | genre | datenaissance | promotion | codematiere | semestre | note
                    'numetu' =>$d['numetu'],
                    'nom' => $d['nom'],
                    'prenom' => $d['prenom'],
                    'genre' => $d['genre'],
                    'datenaissance' =>$d['datenaissance'],
                    'promotion' =>$d['promotion'],
                    'codematiere' => $d['codematiere'],
                    'semestre' => $d['semestre'],
                    'note' => $d['note']
                   
                ], [
                    'numetu' => ['required'],
                    'nom' => ['required'],
                    'prenom' => ['required'],
                    'genre' => ['required'],
                    'datenaissance' => ['required'],
                    'promotion'=> ['required'],
                    'codematiere' => ['required'],
                    'semestre' => ['required'],
                    'note' => ['required']
                ]);

                $validation->validated();
                 $note = str_replace(',', '.',$d['note']);
                // $comm = str_replace('%', '',$comm);
                DB::table('import_note')->insert([
                    'numetu' =>$d['numetu'],
                    'nom' => $d['nom'],
                    'prenom' => $d['prenom'],
                    'genre' => $d['genre'],
                    'datenaissance' =>$d['datenaissance'],
                    'promotion' =>$d['promotion'],
                    'codematiere' => $d['codematiere'],
                    'semestre' => $d['semestre'],
                    'note' => $note
                ]);
            } catch (\Exception $e) {
                $message[] = $e->getMessage() . ' || ligne : ' . $i;
            }
        }



        foreach ($dataConf as $d) {
            try {
                $validation = Validator::make([
                    'code' => $d['code'],
                    'config' => $d['config'],
                    'valeur' => $d['valeur']
                    
                ], [
                    'code' => ['required'],
                    'config' => ['required'],
                    'valeur' => ['required']
                    
                    
                ]);

                $validation->validated();
                

                DB::table('import_conf')->insert([
                    'code' => $d['code'],
                    'config' => $d['config'],
                    'valeur' => $d['valeur']
                ]);
               
            } catch (\Exception $e) {
                $message[] = $e->getMessage() . ' || ligne : ' . $i;
            }
        }

     
        $err =[];
        try {
            DB::insert('insert into promotion(nom)
                                select n.promotion
                                from import_note n group by n.promotion
                               ');
        } catch (\Exception $e) {
            $message[] = $e->getMessage();
        }

// id_etudiant | numetu | nom | prenom | dtn | id_promotion | semestre

//  numetu   |  nom   | prenom |  genre   | datenaissance | promotion | codematiere | semestre | note
try {
    DB::insert('INSERT INTO etudiant(numetu,nom,prenom,genre,dtn,id_promotion,semestre)
    SELECT ib.numetu, ib.nom, ib.prenom, ib.genre, ib.datenaissance, p.id_promotion,null
    FROM import_note ib
    JOIN promotion p ON ib.promotion = p.nom
    GROUP BY ib.numetu,ib.nom,ib.prenom, ib.genre, ib.datenaissance, p.id_promotion
  
    ');
} catch (\Exception $e) {
    $message[] = $e->getMessage();
}
// id_matiere | code | nom | credit (matiere)
// id_note | id_etudiant | id_matiere | note | session (note)
  //numetu   |  nom   | prenom |  genre   | datenaissance | promotion | codematiere | semestre | note      

  //id_note | id_etudiant | id_matiere | note | session
    try {
        DB::insert('insert into note(id_etudiant,id_matiere,note,session)
                            select e.id_etudiant,m.id_matiere,n.note,now()
                            from import_note n join etudiant e 
                            on n.numetu=e.numetu join matiere m on
                            n.codematiere=m.code
                           ');
    } catch (\Exception $e) {
        $message[] = $e->getMessage();
    }
//     $location= DB::select('select* from import_location il join v_location l on l.date_debut=il.date_debut and l.reference=il.reference');
//     foreach($location as $loca){
//         Location::addDetailLocation($loca->id_location);
//     }
    





    return $message;
 }

}
