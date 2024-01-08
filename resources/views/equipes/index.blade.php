<x-layout>
<div id="membres">
    @foreach($equipe['membres'] as $membre)
        <div class="membre">
            <h2>{{$membre['nom']}} {{$membre['prenom']}}</h2>
            <img src="{{url("storage/images/".$membre['image'])}}">
            <p>
                @foreach($membre['fonctions'] as $fonction)
                    <strong style="text-transform: capitalize;">{{$fonction}}</strong>
                @endforeach
            </p>
        </div>
    @endforeach
</div>
</x-layout>