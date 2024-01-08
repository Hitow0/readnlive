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

    <form action="{{route("login")}}" method="post">
        @csrf
        <input type="email" name="email" required placeholder="Email" />
        <input type="password" name="password" required placeholder="password" />
        <div id="remember-me">Remember me<input type="checkbox" name="remember"/></div>
        <input type="submit" />
    </form>
</x-layout>