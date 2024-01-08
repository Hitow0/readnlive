<x-layout :titre="$titre">

    @auth()

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <div>
        <form action="{{route('histoire.store')}}" method="POST" enctype="multipart/form-data" id="publier-histoire">
        {!! csrf_field() !!}

        <div>
            <h2>Création d'une nouvelle histoire</h2>
        </div>

            <div>
                {{--Titre de l'histoire--}}
                <label for="title"><strong>Titre de l'histoire : </strong></label>
                <input type="text" name="title" id="title" value="{{old('titre')}}" placeholder="Titre">

            </div>

            <div>
                {{--Picth de l'histoire--}}
                <label for="pitch"><strong>Pitch de l'histoire : </strong></label>
                <textarea name="pitch" id="pitch" rows="3" placeholder="Votre pitch">{{old("pitch")}}</textarea>
            </div>


                <div>
                    {{--La photo de l'histoire--}}

                    <label for="photo">Choisir une image :</label>
                    <input type="file" name="document" id="photo" accept="image/*">
                </div>


            <div>
                {{--Le genre de l'histoire--}}
                <label for="genre"><strong>Genre de l'histoire : </strong></label>
                <select name="genre" id="genre">
                    @foreach($genres as $genre)
                        <option value="{{$genre["label"]}}">{{$genre["label"]}}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" id="genre">Créer</button>
            </div>

        </form>
    </div>
    @else
        <div>
            Pas connecté
        </div>
    @endauth


</x-layout>