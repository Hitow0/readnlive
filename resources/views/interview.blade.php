<x-layout :titre="$titre">

    <div>
    <h1>Notre Interview</h1>
    </div>

    <div><video width="720" height="fit-content" controls>
            <source src="{{url('storage/images/Interview.mp4')}}" type=video/mp4>
            Votre navigateur ne prend pas en charge la balise vidéo.
        </video>
    <div>
        Vous pouvez retrouver des informations sur <a href="{{route("equipe_index")}}">notre équipe</a>
    </div>
</x-layout>