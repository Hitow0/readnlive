<x-layout :titre="$titre">
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
    @auth()
    <div>
        <h1>Modification de l'histoire : {{$histoire->titre}}</h1></div>
        @if($histoire->user_id == Auth::user()->id)
        <div class="flexrow">
            @if($histoire->active == 0)
                <form action="{{route("histoire.public",["id"=>$histoire->id])}}" method="post">
                @csrf
                    <div><button type="submit">Activer</button></div>
                </form>
            @else
                <form action="{{route("histoire.private",["id"=>$histoire->id])}}" method="post">
                    @csrf
                    <div><button type="submit">Désactiver</button></div>
                </form>
            @endif


            <div><a href="{{route("histoire.show",["histoire"=>$histoire->id])}}"><button>Tester</button></a></div>
        </div>
    </div>
    

    {{--Ajouter des chapitres de l'histoire--}}
<div>
    <div class="infos-histoire">
        <h3>Chapitres de l'histoire</h3>

        <table>
            <thead>
            <tr>
                <th><strong>Id</strong></th>
                <th><strong>Titre court</strong></th>
                <th><strong>Question</strong></th>
                <th><strong>Action</strong></th>
            </tr>
            </thead>
            <tbody>
            @foreach($chapitres as $chapitre)
                <tr>
                    <td>{{$chapitre->id}}</td>
                    <td>{{$chapitre->titrecourt}}</td>
                    <td>{{$chapitre->question}}</td>
                    <td>
                        @auth()
                            @if(Auth::user()->id== $histoire->user_id)
                                <form action="{{route("chapitre.edit",["id"=>$chapitre->id])}}" method="get">
                                    @csrf
                                    <div><button class="action-button delete-button-button" type="submit">éditer</button></div>
                                </form>
                            @endif
                        @endauth
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="infos-histoire" id="milieu">
    <div>
    <h3>Ajouter un Chapitre</h3>

    <div>
        <form action="{{route('histoire.update', ['histoire'=>$histoire->id])}}" method="post">
            @csrf
            @method('PUT')
            <input type="text" id="titre" name="titre" placeholder="Titre">
        <input type="text" id="titrecourt" name="titrecourt" placeholder="Titre court">
        <input type="text" id="media" name="media" placeholder="Média">
        <input type="text" id="question" name="question" placeholder="Question">
            <label for="premier">Premier</label>
            <input type="checkbox" id="premier" name="premier">
            <label for="text">Texte :</label>
            <textarea id="text" name="text"></textarea>
            <button type="submit">Envoyer</button>
        </form>
    </div>
    </div>


    {{--Gérer les liens entre les chapitres--}}

        <div>
            <h3>Liaison des chapitres</h3>

            <form action="{{route('histoire.link', ['id'=>$histoire->id])}}" method="post">
                @csrf
                <label for="source">Source : </label>

                <select name="source" id="source">
                    @foreach($chapitres as $chapitre)
                        <option value="{{$chapitre["id"]}}">{{$chapitre["id"]}} : {{$chapitre["titrecourt"]}}</option>
                    @endforeach
                </select>


                <label for="destination">Destination :</label>
                <select name="destination" id="destination">
                    @foreach($chapitres as $chapitre)
                        <option value="{{$chapitre["id"]}}">{{$chapitre["id"]}} : {{$chapitre["titrecourt"]}}</option>
                    @endforeach
                </select>
                <input type="text" id="reponse" name="reponse" placeholder="Réponse">

                <button type="submit">Envoyer</button>
            </form>
        </div>

        </div>
        <div class="infos-histoire">
            <table>
                <thead>
                <tr>
                    <th><strong>Source</strong></th>
                    <th><strong>Réponse</strong></th>
                    <th><strong>Destination</strong></th>
                    <th><strong>Action</strong></th>
                </tr>
                </thead>
                <tbody>
                @foreach($chapitres as $chapitre)
                    @foreach($chapitre->suivants as $suivant)
                    <tr>
                        <td>{{$chapitre->id}} : {{$chapitre->titrecourt}}</td>
                        <td>{{$suivant->pivot->reponse}}</td>
                        <td>{{$suivant->id}} : {{$suivant->titrecourt}}</td>
                        <td>
                            @auth()
                                @if(Auth::user()->id== $histoire->user_id)
                                    <form action="{{route("link.delete",["source_id"=>$chapitre->id, "destination_id"=>$suivant->id])}}" method="post">
                                        @csrf
                                        <div><button class="action-button delete-button-button" type="submit">Supprimer</button></div>
                                    </form>
                                @endif
                            @endauth
                        </td>
                    </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
        @else
            <h3>Vous n'avez pas la permission d'éditer cette histoire</h3>
        @endif
    @else
        <h3>Vous n'êtes pas connecté</h3>
    @endauth
</x-layout>