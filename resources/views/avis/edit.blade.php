<x-layout :titre="$title">
    @auth
        @if(Auth::user()->id == $avis->user_id)
        <h3>Edition du commentaire sur l'histoire {{$histoire->titre}}</h3>

    <form action="{{route('avis.update', ['id'=>$avis->id])}}" method="post">
        @csrf
        <textarea name="contenu" id="contenu" placeholder="Veuillez rentrer votre commentaire">{{$avis->contenu}}</textarea>
        <button type="submit">Confirmer</button>
    </form>
        @else
            <h3>Vous n'êtes pas le propriétaire du commentaire</h3>
        @endif
    @else
        <h3>Vous n'êtes pas connecté</h3>
    @endauth
</x-layout>