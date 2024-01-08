<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Chapitre;
use App\Models\Genre;
use App\Models\Histoire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class HistoiresController extends Controller
{
    public function index(Request $request) {
        $gen = $request->input('gen', null);
        $value = $request->cookie('gen', null);

        $histoires = Histoire::select(
            "histoires.*",
            "label",
            "name",
            DB::raw("(SELECT SUM(nombre) FROM terminees WHERE terminees.histoire_id = histoires.id) as nb_lectures")
        )
            ->leftJoin("genres", "histoires.genre_id", "=", "genres.id")
            ->leftJoin("users", "histoires.user_id", "=", "users.id")
            ->orderBy("nb_lectures","desc")
            ->get();
        if (!isset($gen)) {
            if (!isset($value)) {
                $histoires = Histoire::select(
                    "histoires.*",
                    "label",
                    "name",
                    DB::raw("(SELECT SUM(nombre) FROM terminees WHERE terminees.histoire_id = histoires.id) as nb_lectures")
                )
                    ->leftJoin("genres", "histoires.genre_id", "=", "genres.id")
                    ->leftJoin("users", "histoires.user_id", "=", "users.id")
                    ->orderBy("nb_lectures","desc")
                    ->get();
                $gen = 'All';
                Cookie::expire('gen');
            } else {
                info($gen);
                $histoires = $histoires
                    ->where('label', $gen);
                $gen = $value;
                Cookie::queue('gen', $gen, 10);            }
        } else {
            if ($gen == 'All') {
                $histoires = Histoire::select(
                    "histoires.*",
                    "label",
                    "name",
                    DB::raw("(SELECT SUM(nombre) FROM terminees WHERE terminees.histoire_id = histoires.id) as nb_lectures")
                )
                    ->leftJoin("genres", "histoires.genre_id", "=", "genres.id")
                    ->leftJoin("users", "histoires.user_id", "=", "users.id")
                    ->orderBy("nb_lectures","desc")
                    ->get();

                Cookie::expire('gen');
            } else {
                $histoires = $histoires
                    ->where('label', $gen);
                Cookie::queue('gen', $gen, 10);
            }
        }
        $genres = Genre::select("label")->get();

        if ($request->has('gen') && !($request->has('anchor'))) {
            return redirect()->route('histoires.index', ['anchor' =>'#accueil_histoire', 'gen'=>$gen]);
        }
        $anchor = "filter";
        $title = "Liste des histoires";
        if ($request->has('anchor')) {
            return view("histoire.index", compact('title', 'histoires', 'gen', 'genres', 'anchor'));
        }
        return view("histoire.index", compact('title', 'histoires', 'gen', 'genres'));
    }

    public function show($id){
        $histoire = Histoire::find($id);
        if($histoire ==null){
            return view('errors.404');
        }

        $auteur  = User::select("users.*")
            ->join("histoires",'users.id',"=",'histoires.user_id')
            ->where("users.id","=",$histoire->user_id)
            ->get();
        $auteur = $auteur[0];


        $genre = Genre::select(DB::raw("DISTINCT(label)"))
            ->join("histoires","genres.id","=","histoires.genre_id")
            ->where("genres.id","=",$histoire->genre_id)
            ->get();
        $genre = $genre[0]['label'];

        $avis=Avis::select("avis.*","users.avatar", "users.name")
            ->leftJoin('users', 'avis.user_id', '=', 'users.id')
            ->where("avis.histoire_id","=","$id")
            ->get();


        $nb_avis = Avis::select(DB::raw("COUNT(*)"))
            ->join("histoires","avis.histoire_id","=","histoires.id")
            ->where("avis.histoire_id","=",$histoire->id)
            ->get();
        $nb_avis = $nb_avis[0]["COUNT(*)"];

        $nb_lectures = Histoire::select(DB::raw("SUM(nombre)"))
            ->join("terminees","histoires.id", "=","terminees.histoire_id")
            ->where("terminees.histoire_id","=",$histoire->id)
            ->get();
        $nb_lectures = $nb_lectures[0]["SUM(nombre)"];

        $nb_chapitre = Chapitre::select(DB::raw("COUNT(*) as nb_chapitre"))
            ->where("histoire_id","=",$histoire->id)
            ->get();
        $nb_chapitre = $nb_chapitre[0]["nb_chapitre"];
        if ($nb_chapitre>0){
            $has_chapitre = true;
        }
        else{
            $has_chapitre = false;
        }
        return view('histoire.show',['titre'=>"Histoire n°".$id,"auteur"=>$auteur, "genre"=>$genre ,"nb_avis"=>$nb_avis,"nb_lectures"=>$nb_lectures,'has_chapitre'=>$has_chapitre,'histoire'=>$histoire,'avis'=>$avis]);
    }


    public function create(){
        $genres = Genre::all();
        if($genres ==null){
            return view('errors.404');
        }

        return view('histoire.create',['titre'=>"Création d'histoire", "genres"=>$genres]);
    }

    public function store(Request $request){

        $this->validate(
            $request,
            [
                'title'=>'required',
                'pitch'=>'required',
                'genre'=>'required'
            ]
        );

        $histoire = new Histoire();

        $histoire->titre = $request->title;
        $histoire->pitch = $request->pitch;

        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $file = $request->file('document');
            $nom = 'image';
            $now = time();
            $nom = sprintf("%s_%d.%s", $nom, $now, $file->extension());
            $file->storeAs('images', $nom);
        } else{
            $nom = "no_name.png";
        }
        $histoire->photo = $nom;


        $histoire->active = 0;
        $histoire->user_id = Auth::user()->id;

        $genre_id = Genre::select("id")
            ->where("label","=",$request->genre)
            ->get();
        $genre_id = $genre_id[0]["id"];
        $histoire->genre_id = $genre_id;
        $histoire->save();

        return redirect()->route('histoire.index')->with("info", "Histoire publiée avec succès");
    }


    public function edit($id){
        $histoire =Histoire::find($id);
        if($histoire ==null){
            return view('errors.404');
        }
        $chapitres = $histoire->chapitres;

        return view("histoire.edit", ["titre"=>"Histoire en cours", "histoire"=>$histoire,"chapitres"=>$chapitres]);
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

        $chapitre = new Chapitre();

        $chapitre->titre = $request->titre;
        $chapitre->titrecourt = $request->titrecourt;
        $chapitre->media = $request->media;
        $chapitre->question = $request->question;
        if ($request->premier == null){
            $chapitre->premier = false;
        }
        else {
            $chapitre->premier = true;
        }
        $chapitre->texte = $request->text;
        $chapitre->histoire_id = $id;

        $chapitre->save();
        return redirect()->route('histoire.edit', ['histoire'=>$id]);
    }

    public function link(Request $request, $id){
        $this->validate(
            $request,
            [
                'source'=>'required',
                'destination'=>'required',
                'reponse'=>'required',
            ]
        );

        DB::table('suites')->insert([
            'chapitre_source_id' => $request->source,
            'chapitre_destination_id'=> $request->destination,
            'reponse'=>$request->reponse,
        ]);

        return redirect()->route('histoire.edit', ['histoire'=>$id]);
    }

    public function setPublic($id){

        Histoire::where("id","=",$id)
            ->update(['active'=>1]);

        return redirect()->route('histoire.edit',['histoire'=>$id]);

    }

    public function setPrivate($id){
        Histoire::where("id","=",$id)
            ->update(['active'=>0]);

        return redirect()->route('histoire.edit',['histoire'=>$id]);
    }

    public function editHistory($id){
        $histoire =Histoire::find($id);
        if($histoire ==null){
            return view('errors.404');
        }
        $genres = Genre::all();


        return view("histoire.editHistory", ["titre"=>"Edition de l'histoire", "histoire"=>$histoire, "genres"=>$genres]);
    }

    public function updateHistory(Request $request, $id){
        $this->validate(
            $request,
            [
                'titre'=>'required',
                'pitch'=>'required',
                'genre'=>'required'
            ]
        );

        $histoire = Histoire::find($id);

        $histoire->titre = $request->titre;
        $histoire->pitch = $request->pitch;

        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $file = $request->file('document');
            $nom = 'image';
            $now = time();
            $nom = sprintf("%s_%d.%s", $nom, $now, $file->extension());
            $file->storeAs('images', $nom);
        } else{
            $nom = "no_name.png";
        }
        $histoire->photo = $nom;

        $genre_id = Genre::select("id")
            ->where("label","=",$request->genre)
            ->get();
        $genre_id = $genre_id[0]["id"];
        $histoire->genre_id = $genre_id;
        $histoire->save();

        return redirect()->route('histoire.show', ['histoire'=>$id]);
    }
}
