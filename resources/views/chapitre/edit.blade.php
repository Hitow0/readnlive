<x-layout :titre="$titre">
    @auth
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(Auth::user()->id == $histoire->user_id)
            <h3>Edition du chapitre {{$histoire->id}} sur l'histoire {{$histoire->titre}}</h3>

            <form action="{{route('chapitre.update', ['id'=>$chapitre->id])}}" method="post">
                @csrf
                <input type="text" id="titre" name="titre" placeholder="Titre" value="{{$chapitre->titre}}">
                <input type="text" id="titrecourt" name="titrecourt" placeholder="Titre court" value="{{$chapitre->titrecourt}}">
                <input type="text" id="media" name="media" placeholder="Média" value="{{$chapitre->media}}" maxlength="200">
                <input type="text" id="question" name="question" placeholder="Question" value="{{$chapitre->question}}">
                <label for="text">Texte :</label>
                <textarea id="text" name="text">{{$chapitre->texte}}</textarea>
                <button type="submit">Confirmer</button>
            </form>
        @else
            <h3>Vous n'êtes pas le propriétaire de l'histoire</h3>
        @endif
    @else
        <h3>Vous n'êtes pas connecté</h3>
    @endauth
</x-layout>