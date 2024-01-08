<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use App\Models\Histoire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use function PHPUnit\Framework\isEmpty;

class ChapitreController extends Controller
{
    public function premierChapitre($id) {
        if(Auth::check()) {
            Session::forget('en_cours');
            Session::put("en_cours", array());
        }
        $chapitre = Chapitre::select("chapitres.id")
            ->leftJoin("suites", "suites.chapitre_source_id", "=", "chapitres.id")
            ->where("chapitres.histoire_id", "=", intVal($id))
            ->where("chapitres.premier", "=", 1)->get();
        if($chapitre ==null){
            return view('errors.404');
        }
        return $this->afficherChapitre($chapitre[0]->id);
    }

    public function afficherChapitre($id) {
        $chapitre=Chapitre::select("chapitres.*", "histoires.*")
            ->leftJoin("histoires", "histoires.id", "=", "chapitres.histoire_id")
            ->where("chapitres.id", "=", intval($id))->get();
        $reponses=Chapitre::select("chapitre_destination_id", "reponse")
            ->leftJoin("suites", "suites.chapitre_source_id", "=", "chapitres.id")
            ->where("chapitres.id", "=", intVal($id))
            ->get();
        if($chapitre ==null){
            return view('errors.404');
        }
        if($reponses == null){
            return view('errors.404');
        }

        if(Chapitre::find($id) == null){
            return view('errors.404');
        }
        if(count(Chapitre::find($id)->suivants)==0){
            $has_suite = false;
            if (Auth::check()) {
                if (User::select("*")
                        ->leftJoin("terminees", "id", "=", "user_id")
                        ->where("histoire_id", "=", $chapitre[0]->id)->get()!=null) {
                    DB::table('terminees')->insert([
                        'user_id' => Auth::id(),
                        'histoire_id' => $chapitre[0]->histoire_id,
                        'nombre' => 1
                        ]);
                }
                else {
                    DB::table('terminees')->updateOrInsert(
                        ['user_id' => Auth::id(), 'histoire_id' => $chapitre[0]->histoire_id],
                        ['nombre' => DB::raw('nombre + 1')]
                    );
                }
            }
        }
        else{
            $has_suite=true;
        }
        if(Auth::check()) {
            $tab = Session::get("en_cours", []);
            $tab[] = $chapitre[0]->titrecourt;
            Session::put("en_cours", $tab);
        }
        $en_cours=Session::get("en_cours");
        return view("chapitre.show", ["titre"=>"Affichage d'un chapitre", "chapitre"=>$chapitre[0],"has_suite"=>$has_suite ,"reponses"=>$reponses, "en_cours"=>$en_cours]);
    }

    public function edit($id){
        $chap = Chapitre::find($id);
        if($chap ==null){
            return view('errors.404');
        }
        $histoire = Histoire::find($chap->histoire_id);
        return view("chapitre.edit", ["titre"=>"Edition d'un chapitre", "chapitre"=>$chap, "histoire"=>$histoire]);
    }

    public function update(Request $request, $id){
        $this->validate(
            $request,
            [
                'titre'=>'required',
                'titrecourt'=>'required',
                'text'=>'required',
            ]
        );
        $chapitre = Chapitre::find($id);
        if($chapitre ==null){
            return view('errors.404');
        }

        $chapitre->titre = $request->titre;
        $chapitre->titrecourt = $request->titrecourt;
        $chapitre->media = $request->media;
        $chapitre->question = $request->question;
        $chapitre->texte = $request->text;

        $chapitre->save();
        return redirect()->route('histoire.edit', ['histoire'=>$chapitre->histoire_id]);
    }

    public function deleteLink(Request $request, $source_id, $destination_id){
        $deleted = DB::table('suites')->where('chapitre_source_id', $source_id)->where('chapitre_destination_id', $destination_id)->delete();
        return back();
    }
}
