<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Histoire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{

    public function store(Request $request, $id
    )
    {

        $this->validate(
            $request,
            [
                'contenu' => 'required',
            ]
        );
        $avi=new Avis();
        $avi->contenu=$request->input("contenu");
        $avi->user_id=Auth::id();
        $avi->histoire_id=$id;
        $avi->save();
        return redirect()->route('histoire.show',['histoire'=>$id])->with("info", "Commentaire publié avec succès");
    }

    public function delete(Request $request, $id){

        $avi=Avis::select("avis.*")->where("avis.id","=",intval($id))->get()[0];
        $idH=$avi->histoire_id;
        $avi->delete();
        return redirect()->route('histoire.show',['histoire'=>$idH])->with('info', 'Commentaire supprimé avec succès');

    }

    public function edit($id){
        $avi=Avis::select("avis.*")->where("avis.id","=",intval($id))->get()[0];
        $idH=$avi->histoire_id;
        $histoire = Histoire::find($idH);
        if($histoire ==null){
            return view('errors.404');
        }

        return view('avis.edit', ['title'=>"Edition du commentaire",'avis'=>$avi, 'histoire'=>$histoire]);
    }

    public function update(Request $request, $id){
        $this->validate(
            $request,
            [
                'contenu'=>'required',
            ]
        );

        $avis = Avis::find($id);
        if($avis ==null){
            return view('errors.404');
        }
        $avis->contenu = $request->contenu;
        $avis->save();
        return redirect()->route('histoire.show',['histoire'=>$avis->histoire_id])->with("info", "Commentaire modifié avec succès");
    }
}
