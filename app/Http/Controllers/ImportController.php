<?php

namespace App\Http\Controllers;
use App\Models\Import;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index() {
        return view('auth.import');
    }
    ///test
    public function test()
    {
        $i=new Import();
        $a=$i->importDonne($note);
        return $a;
    }
    
    public function importData(Request $request) {
        $request->validate([
            'note'=>['required'],
            'config_note' => ['required']
            
        ]);
        $note =$request->file('note');
        $conf = $request->file('config_note');
  
        

        try {
            $filename1 = "CSV1_".time().".".$note->getClientOriginalExtension();
            $filename2 = "CSV2_".time().".".$conf->getClientOriginalExtension();
         
            
            $path1 = 'data/'. $filename1;
            $path2 = 'data/'. $filename2;
        
            $note->move(storage_path('data/'), $filename1);
            $conf->move(storage_path('data/'), $filename2);
            

            $import = new Import();

            $error = $import->importDonne($path1,$path2);
             
            if (count($error) > 0){
                return back()->with([
                    'errtm'=> $error
                ]);
            }
            return back()->with([
                'message'=> ['Import termine']
            ]);
        } catch (\Exception $e) {
            $err[] = $e->getMessage();
            return back()->with('cath',$err);
        }
    }

}
