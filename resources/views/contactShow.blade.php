<x-layout>

    <div class="contact-form">
        <div class="form-header text-center">
            <h2>Contact :</h2>
        </div>

        <div class="form-group">
            <label for="email"><strong>Email :</strong></label>
            <input type="email" name="email" id="email" value="{{$email}}" disabled>
        </div>

        <div class="form-group">
            <label for="identity"><strong>Nom.Prénom :</strong></label>
            <input type="text" name="identity" id="identity" value="{{$identity}}" disabled>
        </div>

        <div class="form-group">
            <label for="description"><strong>Message :</strong></label>
            <textarea name="description" id="description" placeholder="Message" disabled>{{$description}}</textarea>
        </div>
        <div class="form-group">
            <button class="btn btn-success"><a href="{{route('histoires.index')}}">Retour</a></button>
        </div>

    </div>

</x-layout>
