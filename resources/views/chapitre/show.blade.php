<x-layout :titre="$titre">
    @if(($chapitre->active == 0 && (Auth::user() == null) ) || ($chapitre->active == 0 && (Auth::user() != null)) && ($chapitre->active == 0 && (Auth::user()->id != $chapitre->user_id)))
        <div><h3>Vous ne pouvez pas accéder à cette histoire</h3></div>
    @else
    <div>
        <h1>{{$chapitre->t}}</h1>
        <h2>{{$chapitre->titrecourt}}</h2>
    </div>
    @if($chapitre->media!=null)
        @switch(substr($chapitre->media, -4))
            @case(".jpg" or ".png" or "jpeg" or ".gif" or ".svg")
            <img src="{{$chapitre->media}}" alt="Image" class="image-chapitre">
            @break
            @case(".mp3" or ".ogg" or "mpeg" or "wave")
            <audio src="{{$chapitre->media}}" controls>
                Votre navigateur ne semble pas supporter ce fichier.
            </audio>
            @break
            @case(".mp4")
                <video autoplay>
                    <source src="{{$chapitre->media}}" type="video/mp4">
                </video>
            @break
            @case("webm")
                <video autoplay>
                    <source src="{{$chapitre->media}}" type="video/webm">
                </video>
        @endswitch
    @endif
    <div>
        <p>{{$chapitre->texte}}</p>
        @if($has_suite)
            <p><strong>{{$chapitre->question}}</strong></p>
            <div>
                @foreach($reponses as $rep)
                    <a href="{{route('chapitre.show', ['id'=>$rep->chapitre_destination_id])}}"><button>{{$rep->reponse}}</button></a>
                @endforeach
            </div>
        @else
            <p><strong>Fin de cette histoire</strong></p>
            <a href="{{route('histoire.start', ['id'=>$chapitre->histoire_id])}}"><button>Recommencer l'histoire</button></a>
            <a href="{{route('histoires.index')}}"><button>Retourner à l'accueil</button></a>
        @endif
        @auth()
            <p><strong>Route de votre histoire : </strong></p>
                <ul>
                    @foreach($en_cours as $a)
                        <li>{{$a}}</li>
                    @endforeach
                </ul>
            <form id="avis" action="{{ route('avis.store',['id'=>$chapitre->histoire_id])}}" method="POST">
                @csrf
                <div class="text-center" style="margin-top: 2rem">
                    <h3>Ajouter un commentaire</h3>
                    <hr class="mt-2 mb-2">
                </div>
                <div class="form-group">
                    <input type="text" name="contenu" class="form-input" placeholder="Avis">
                </div>
                <input type="submit" value="valider">
            </form>
        @endauth
    </div>
    @endif
</x-layout>