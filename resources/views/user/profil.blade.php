<x-layout :title="$title">
    <div id="profil">
        <h1 class="profile-title">Profil de {{ $user->name }}</h1>

        <div class="button-container">
            <button id="btn-info">Infos</button>
            <button id="btn-histoires">Histoires publiées</button>
            @auth
            @if($user->id == Auth::user()->id)
            <button id="btn-histoires-unterminated">Histoires non terminées</button>
            <button id="btn-histoires-creating">Histoires en création</button>
            <button id="btn-commentaires">Commentaires</button>
            @else
            <button class="hidden" id="btn-histoires-unterminated">Histoires non terminées</button>
            <button class="hidden" id="btn-histoires-creating">Histoires en création</button>
            <button class="hidden" id="btn-commentaires">Commentaires</button>
            @endif
            @else
            <button class="hidden" id="btn-histoires-unterminated">Histoires non terminées</button>
            <button class="hidden" id="btn-histoires-creating">Histoires en création</button>
            <button class="hidden" id="btn-commentaires">Commentaires</button>
            @endauth
        </div>

        <div class="profile-container" id="user-info">
            <div class="avatar-container">
                <img src="{{ url('storage/images/'.$user->avatar) }}" alt="Avatar de {{ $user->name }}" class="avatar"><br>
                @auth
                @if($user->id == Auth::user()->id)
                <button id="changeAvatarBtn" class="action-button view-button">Changer d'avatar</button>
                @endif
                @endauth
            </div>
            <div id="fullscreen"><button>X</button></div>
            <div class="profile-info">
                <p><strong>Nom : </strong>{{ $user->name }}</p>
                <p><strong>Email : </strong>{{ $user->email }}</p>
                <p><strong>Nombre d'histoire lues : </strong>{{$nb_histoires_terminees}}</p>
                <p><strong>Nombre d'avis : </strong>{{count($commentaires)}}</p>

            </div>
        </div>

        @auth
        <div id="avatarModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeModal">&times;</span>
                <form id="avatarForm" action="{{route('user.avatarUpdate', ['id'=>Auth::user()->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="avatarInput">Choisir une image :</label>
                    <input type="file" name="document" id="avatarInput" accept="image/*">
                    <button type="submit" id="confirmBtn">Confirmer</button>
                </form>
            </div>
        </div>
        @endauth
    </div>

    <section id="histoires-unterminated" class="hidden">
        <div>
            <h2>Histoires non terminées</h2>
            @if($histoires->count() === 0)
            <p>Il n'y a pas d'histoire publiée</p>
            @else
            @foreach($histoires as $histoire)
            <li>
                <a href="{{route('histoire.show', ['histoire'=>$histoire->id])}}"><button>{{ $histoire->titre }}</button></a>
            </li>
            @endforeach
            @endif
        </div>
    </section>

    <section id="histoires-creating" class="hidden">
        <div>
            <h2>Histoires en cours de création</h2>
            @if($histoires_creating->count() === 0)
            <p>Il n'y a pas d'histoire en création</p>
            @else
            @foreach($histoires_creating as $histoire)
            <li>
                <a href="{{route('histoire.show', ['histoire'=>$histoire->id])}}"><button>{{ $histoire->titre }}</button></a>
            </li>
            @endforeach
            @endif
        </div>
    </section>
    
    <section id="histoires" class="hidden">
        <div>
            <h2>Histoires publiées</h2>
            @if($histoires_published->count() === 0)
            <p>Il n'y a pas d'histoire publiée</p>
            @else
            @foreach($histoires_published as $histoire)
            <li>
                <a href="{{ route('histoire.show', ['histoire' => $histoire->id]) }}"><button>{{ $histoire->titre }}</button></a>
            </li>
            @endforeach
            @endif

        </div>
    </section>
    
    <section id="commentaires-all" class="hidden">
        <div id="commentaires">
            <h2>Commentaires</h2>
            @if($commentaires->count() === 0)
            <p>Il n'y a pas de commentaire</p>
            @else
            <div id="liste-commentaires">
            @foreach($commentaires as $commentaire)
                    <div class="commentaire" id="commentaires-profil">
                        <p class="contenu">"{{ $commentaire->contenu }}"</p>
                        <div>
                            <p>Ajouté le {{ $commentaire->created_at }}</p>
                            <p>Dernière mise à jour le {{ $commentaire->updated_at }}</p>
                            <p>A l'histoire <a href="{{ route('histoire.show', ['histoire'=>$commentaire->histoire_id]) }}" class="nom-histoire">{{$commentaire->titre_histoire}}</a></p>
                        </div>
                    </div>
            @endforeach
            </div>
            @endif
        </div>
    </section>

    <script>
        document.getElementById('btn-info').addEventListener('click', function() {
            document.getElementById('user-info').classList.remove('hidden');
            document.getElementById('histoires-unterminated').classList.add('hidden');
            document.getElementById('commentaires-all').classList.add('hidden')
            document.getElementById('histoires-creating').classList.add('hidden');
            document.getElementById('histoires').classList.add('hidden');
            document.getElementById('histoires').classList.add('hidden')

            document.getElementById('btn-info').classList.add('active');
            document.getElementById('btn-histoires-unterminated').classList.remove('active');
            document.getElementById('btn-commentaires').classList.remove('active');
            document.getElementById('btn-histoires-creating').classList.remove('active');
            document.getElementById('btn-histoires').classList.remove('active');

        });

        document.getElementById('btn-histoires-unterminated').addEventListener('click', function() {
            document.getElementById('user-info').classList.add('hidden');
            document.getElementById('histoires-unterminated').classList.remove('hidden');
            document.getElementById('commentaires-all').classList.add('hidden')
            document.getElementById('histoires-creating').classList.add('hidden');
            document.getElementById('histoires').classList.add('hidden')

            document.getElementById('btn-info').classList.remove('active');
            document.getElementById('btn-histoires-unterminated').classList.add('active');
            document.getElementById('btn-commentaires').classList.remove('active')
            document.getElementById('btn-histoires-creating').classList.remove('active');
            document.getElementById('btn-histoires').classList.remove('active');
        });

        document.getElementById('btn-commentaires').addEventListener('click', function() {
            document.getElementById('user-info').classList.add('hidden');
            document.getElementById('histoires-unterminated').classList.add('hidden');
            document.getElementById('commentaires-all').classList.remove('hidden')
            document.getElementById('histoires-creating').classList.add('hidden');
            document.getElementById('histoires').classList.add('hidden')

            document.getElementById('btn-info').classList.remove('active');
            document.getElementById('btn-histoires-unterminated').classList.remove('active');
            document.getElementById('btn-commentaires').classList.add('active')
            document.getElementById('btn-histoires-creating').classList.remove('active');
            document.getElementById('btn-histoires').classList.remove('active');

        });

        document.getElementById('btn-histoires-creating').addEventListener('click', function() {
            document.getElementById('user-info').classList.add('hidden');
            document.getElementById('histoires-unterminated').classList.add('hidden');
            document.getElementById('commentaires-all').classList.add('hidden')
            document.getElementById('histoires-creating').classList.remove('hidden');
            document.getElementById('histoires').classList.add('hidden')


            document.getElementById('btn-info').classList.remove('active');
            document.getElementById('btn-histoires-unterminated').classList.remove('active');
            document.getElementById('btn-commentaires').classList.remove('active')
            document.getElementById('btn-histoires-creating').classList.add('active');
            document.getElementById('btn-histoires').classList.remove('active');
        });

        document.getElementById('btn-histoires').addEventListener('click', function() {
            document.getElementById('user-info').classList.add('hidden');
            document.getElementById('histoires-unterminated').classList.add('hidden');
            document.getElementById('commentaires-all').classList.add('hidden')
            document.getElementById('histoires-creating').classList.add('hidden');
            document.getElementById('histoires').classList.remove('hidden');


            document.getElementById('btn-info').classList.remove('active');
            document.getElementById('btn-histoires-unterminated').classList.remove('active');
            document.getElementById('btn-commentaires').classList.remove('active')
            document.getElementById('btn-histoires-creating').classList.remove('active');
            document.getElementById('btn-histoires').classList.add('active');
        });

        document.getElementById('changeAvatarBtn').addEventListener('click', function() {
            document.getElementById('avatarModal').style.display = 'block';
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('avatarModal').style.display = 'none';
        });

        document.getElementById('confirmBtn').addEventListener('click', function() {
            document.getElementById('avatarModal').style.display = 'none';
        });
    </script>

</x-layout>