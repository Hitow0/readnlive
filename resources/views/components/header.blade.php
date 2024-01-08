<nav class="container">
    <a href="{{route('histoires.index')}}" id="left">
        <h2>Read'nLive</h2>
    </a>
    <div id="right">
    <a href="{{route('histoires.index')}}">Accueil</a>
    <a href="{{route('contact')}}">Contact</a>
    <a href="{{route('equipe_index')}}">Equipe</a>
    <a href="{{route('interview')}}">Interview</a>
    </div>


    <div class="auth-buttons">
        @guest()
            <a href="{{route('login')}}"><button class="nav-btn">Se connecter</button></a>
            <a href="{{route("register")}}">Register</a>
        @else
            <div class="user-menu">
                <button class="nav-btn" id="user-btn">
                    <img src="{{ url('storage/images/'.Auth::user()->avatar)}}" alt="Avatar">
                    <span>{{ Auth::user()->name }}</span>
                </button>
                <div class="user-dropdown" id="user-dropdown">
                    <a href="{{route('user.profil', ['id' => Auth::user()->id])}}}"><button class="nav-btn" id="profil-btn">Profil</button></a>
                    <a href="#"><button class="nav-btn" id="logout-btn">Se déconnecter</button></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        @endguest
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Toggle user dropdown menu
            $("#user-btn").click(function () {
                $("#user-dropdown").toggle();
            });

            // Logout action
            $("#logout-btn").click(function () {
                $("#logout-form").submit();
            });

            // Hide dropdown on click outside
            $(document).click(function (e) {
                if (!$(e.target).closest('.user-menu').length) {
                    $("#user-dropdown").hide();
                }
            });
        });
    </script>

    </div>
</nav>