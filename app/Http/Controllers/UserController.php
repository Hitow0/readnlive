<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Commentaire;
use App\Models\Histoire;
use App\Models\Scene;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function profil($id){
        $user = User::find(intval($id));
        if($user ==null){
            return view('errors.404');
        }

        $histoiresTermineesIds = $user->terminees;
        info($histoiresTermineesIds->pluck('id'));

        if (empty($histoiresTermineesIds)) {
            $histoire_untermined = Histoire::all();
        } else {
            $histoire_untermined = Histoire::whereNotIn('id', $histoiresTermineesIds->pluck('id'))->get();
        }

        $histoire_creating = $user->mesHistoires->where('active', false);

        $histoire_published = $user->mesHistoires->where('active', true);

        $histoires_terminees =  count($user->terminees);

        $commentaires = Avis::select('avis.*', DB::raw('histoires.titre AS titre_histoire'))
            ->leftJoin('histoires', 'histoires.id', '=', 'avis.histoire_id')
            ->where('avis.user_id', intval($id))
            ->get();


        return view('user.profil', ['title'=>'Profil', 'user'=>$user, 'histoires' => $histoire_untermined, 'histoires_creating' => $histoire_creating, 'commentaires'=> $commentaires, 'histoires_published'=> $histoire_published, 'nb_histoires_terminees' => $histoires_terminees]);
    }

    public function changeAvatar(Request $request, $id)
    {
        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $file = $request->file('document');
            $nom = 'image';
            $now = time();
            $nom = sprintf("%s_%d.%s", $nom, $now, $file->extension());
            $file->storeAs('images', $nom);

            $user = User::find($id);
            if($user ==null){
                return view('errors.404');
            }
            $user->avatar = $nom;

            $user->save();
        }

        return redirect()->route('user.profil', ['id'=>$id]);
    }
}
