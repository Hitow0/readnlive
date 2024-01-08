<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipeController extends Controller
{
    public function index(){
        $equipe= [
            'nomEquipe'=>"L'equipe de l'année !",
            'logo'=>"referenceDuFichier",
            'slogan'=>"....",
            'localisation'=>"numero de la salle",
            'membres'=> [
                [ 'nom'=>"DUPUIS",'prenom'=>"Mathéo", 'image'=>"avatar_matheo.png", 'fonctions'=>["validateur","développer", "concepteur"] ],
                [ 'nom'=>"DENIS",'prenom'=>"Léo", 'image'=>"avatar_leo.png", 'fonctions'=>["développer", "concepteur"] ],
                [ 'nom'=>"NOURRY",'prenom'=>"Nicolas", 'image'=>"avatar_nicoN.png", 'fonctions'=>["développer", "concepteur"] ],
                [ 'nom'=>"BLART",'prenom'=>"Nicolas", 'image'=>"avatar_nicoB.png", 'fonctions'=>["développer", "concepteur"] ],
                [ 'nom'=>"BALCEREK",'prenom'=>"Corto", 'image'=>"no_avatar.png", 'fonctions'=>["développer", "concepteur"] ],
                [ 'nom'=>"ROUSSEAU",'prenom'=>"Luc", 'image'=>"no_avatar.png", 'fonctions'=>["développer", "concepteur"] ],
                [ 'nom'=>"DRIDI",'prenom'=>"Iskander", 'image'=>"no_avatar.png", 'fonctions'=>["développer", "concepteur"] ],
                [ 'nom'=>"JOLY",'prenom'=>"Thomas", 'image'=>"no_avatar.png", 'fonctions'=>["développer", "concepteur"] ],
            ],
            'autres'=>"Autre chose",
        ];
        return view('equipes.index', ['equipe' => $equipe]);
    }
    public function contact(){
        return view('contact');
    }
    public function contactShow(Request $request){
        $email = $request->email;
        $identity = $request->identity;
        $description = $request->description;

        return view('contactShow',['email'=>$email, 'identity' => $identity, 'description' => $description]);
    }
}