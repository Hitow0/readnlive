{{--Il faudra peut-être changer la disposition plus tard --}}
<x-layout>

    @if (isset($anchor))
        <input type="hidden" name="anchor" value="{{ $anchor }}">
    @endif
    <div id="home" class="container">
        <div>
            <div id="left">
                <h1 class="home-title">Bienvenue</br>sur <span>Read'nLive</span></h1>
            </div>
            <div id="right">    
                <img src="{{url('/images/logo.svg')}}" alt="Logo"/>
            </div>
        </div>
        <a href="#filter"><button class="home-cta">Accèder aux histoires</button></a>
    </div>
    <h2 id="filter">Filtrage par genre</h2>
    <form action="{{route('histoire.index')}}" method="get" id="select-genre">
        <select name="gen">
            <option value="All" @if($gen == 'All') selected @endif>-- Tous genres --</option>
            @foreach($genres as $genre)
                <option value="{{$genre["label"]}}" @if($gen == $genre['label']) selected @endif>{{$genre["label"]}}</option>
            @endforeach
        </select>
        <input type="submit" value="OK">
    </form>

        @auth()
            <div><a href="{{route('histoire.create')}}"  class="home-cta"><button>Créer une histoire</button> </a></div>
        @endauth

    <section id="accueil-histoires" class="container">

        @if(!@empty($histoires))
        <!-- <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Résumé</th>
                    <th>Photo</th>
                    <th>Auteur</th>
                    <th>Genre</th>
                </tr>
            </thead>
            <tbody> -->
            @foreach($histoires as $histoire)
                @auth()
                    @if(($histoire->active == 1)||(Auth::user()->id == $histoire->user_id))
                    <div class="histoire-card">
                        <div id="left">
                            <h2>{{$histoire->titre}}</h2>
                            <p>"{{$histoire->pitch}}"</p>
                            <p>Publié par {{$histoire->name}}</p>
                            <p>Genre: {{$histoire->label}}</p>
                            <a href="{{route('histoire.show', ['histoire'=>$histoire->id])}}"><button>Accéder à l'histoire</button></a>
                        </div>
                        <div id="right">
                        @if(str_contains($histoire->photo, "http"))
                                <img class="photo" src="{{$histoire->photo}}" alt="photo">
                            @else
                                <img class="photo" src="{{url('storage/images/'.$histoire->photo)}}" alt="photo">
                            @endif
                            <p>Nombre de lectures : {{$histoire->nb_lectures}}</p>
                        </div>

                    </div>
                    @endif
                @else
                    @if(($histoire->active == 1))
                        <div class="histoire-card">
                            <div id="left">
                                <h2>{{$histoire->titre}}</h2>
                                <p>"{{$histoire->pitch}}"</p>
                                <p>Publié par {{$histoire->name}}</p>
                                <p>Genre: {{$histoire->label}}</p>
                                <a href="{{route('histoire.show', ['histoire'=>$histoire->id])}}"><button>Accéder à l'histoire</button></a>
                            </div>
                            <div id="right">
                                @if(str_contains($histoire->photo, "http"))
                                    <img class="photo" src="{{$histoire->photo}}" alt="photo">
                                @else
                                    <img class="photo" src="{{url('storage/images/'.$histoire->photo)}}" alt="photo">
                                @endif
                                <p>Nombre de lectures : {{$histoire->nb_lectures}}</p>

                            </div>
                        </div>
                    @endif
                @endauth
            @endforeach
        @else
            <p>Aucune histoire à afficher</p>
        @endif
    </section>
    <script>
        $(function () {
            if ( $( "[name='anchor']" ).length ) {
                window.location = '#' + $( "[name='anchor']" ).val();
            }
        });
    </script>
</x-layout>