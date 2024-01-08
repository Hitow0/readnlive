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
            <h3>Edition de l'histoire {{$histoire->titre}}</h3>

            <form action="{{route('histoire.updateHistory', ['id'=>$histoire->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" id="titre" name="titre" placeholder="Titre" value="{{$histoire->titre}}">
                <input type="text" id="pitch" name="pitch" placeholder="Pitch" value="{{$histoire->pitch}}">
                <label for="photo">Choisir une image :</label>
                <input type="file" name="document" id="photo" accept="image/*">
                <label for="genre"><strong>Genre de l'histoire : </strong></label>
                <select name="genre" id="genre">
                    @foreach($genres as $genre)
                        <option value="{{$genre["label"]}}">{{$genre["label"]}}</option>
                    @endforeach
                </select>
                <button type="submit">Confirmer</button>
            </form>
        @else
            <h3>Vous n'êtes pas le propriétaire de l'histoire</h3>
        @endif
    @else
        <h3>Vous n'êtes pas connecté</h3>
    @endauth
</x-layout>