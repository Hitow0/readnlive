<x-layout>

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

<form action="{{route("register")}}" method="post">
    @csrf
    <input type="text" name="name" required placeholder="Name" />
    <input type="email" name="email" required placeholder="Email" />
    <input type="password" name="password" required placeholder="password" />
    <input type="password" name="password_confirmation" required placeholder="password" />
    <input type="submit" />
</form>
Déjà un compte ? <a href="{{route("login")}}">Connectez vous</a>
</x-layout>
