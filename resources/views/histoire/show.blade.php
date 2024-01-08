<x-layout :titre="$titre">
    <div id="details-histoire">
        @if(session('info'))
        <div class="popup">
            {{ session('info') }}
        </div>
        @endif

        @if(($histoire->active == 0 && (Auth::user() == null) ) || ($histoire->active == 0 && (Auth::user() != null)) && ($histoire->active == 0 && (Auth::user()->id != $histoire->user_id)))
        <div>
            <h3>Vous ne pouvez pas accéder à cette histoire</h3>
        </div>
        @else
        <h1>{{$histoire->titre}}</h1>
        <div>
            <strong>Pitch de l'histoire :</strong>
            <article style="margin-block: 1rem;">
                "{{$histoire->pitch}}"
            </article>
        </div>

        <br>
        <div>
            @if(str_contains($histoire->photo, "http"))
            <img class="photo" src="{{$histoire->photo}}" alt="photo" id="cover-image">
            @else
            <img class="photo" src="{{url('storage/images/'.$histoire->photo)}}" alt="photo" id="cover-image">
            @endif
        </div>

        <div id="nav-histoire">
            @if($has_chapitre)
            <div>
                <a href="{{route('histoire.start', ['id'=>$histoire->id])}}"><button>Lire l'histoire</button></a>
            </div>
            @endif

            @auth()
            @if($histoire->user_id==Auth::user()->id)
            <div><a href="{{route("histoire.edit",["histoire"=>$histoire->id])}}"><button>Modifier les chapitres</button></a></div>
            <div><a href="{{route("histoire.editHistory",["id"=>$histoire->id])}}"><button>Modifier l'histoire</button></a></div>
            @endif
            @endauth
        </div>
        <div>
            <strong>Auteur :</strong>
            <a href="{{route("user.profil",['id'=>$auteur->id])}}">{{$auteur->name}}</a>
        </div>

        <div>
            <strong>Genre :</strong>
            {{$genre}}
        </div>

        <div>
            <strong>Nombre d'avis : </strong> {{$nb_avis}}
        </div>

        <div>
            <strong>Nombre de lectures terminées : </strong> {{$nb_lectures}}
        </div>

        @if($histoire->active)
        <div><strong>En ligne : </strong>✅</div>
        @else
        <div><strong>En ligne</strong>❌</div>
        @endif
        <div id="commentaires">
            <h2>Commentaires:</h2>
            @auth()
            <form id="avis" action="{{ route('avis.store',['id'=>$histoire->id])}}" method="POST">
                @csrf
                <div class="text-center">
                    <h3>Commenter</h3>
                </div>
                <div class="form-group">
                    <input type="text" name="contenu" class="form-input" placeholder="Avis">
                </div>
                <input type="submit" value="Publier">
            </form>
            @endauth
            @foreach($avis as $avi)
            <div class="commentaire">
                <div id="left">
                    <img class="avataravi" src="{{url("/storage/images/".$avi->avatar)}}" alt="Avatar">
                </div>
                <div id="right">
                    <p>"{{$avi->contenu}}"</p>
                    <span>Publié par {{ $avi->name }}</span>
                    <p>
                        <i>
                            {{$avi->created_at}}
                        </i>
                    </p>
                </div>
                @auth()
                @if(Auth::user()->id== $avi->user_id)
                <div id="edit-commentaire">
                    <form action="{{route("avis.delete",["id"=>$avi->id])}}" method="post">
                        @csrf
                        <div><button class="action-button delete-button-button" type="submit">Supprimer</button></div>
                    </form>
                    <form action="{{route("avis.edit",["id"=>$avi->id])}}" method="get">
                        @csrf
                        <div><button class="action-button delete-button-button" type="submit">Éditer</button></div>
                    </form>
                </div>
                @endif
                @endauth
            </div>

            @endforeach
        </div>
        @endif
    </div>

</x-layout>