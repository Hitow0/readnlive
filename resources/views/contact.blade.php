<x-layout>
    <!-- HTML structure with added classes -->
    <form class="contact-form" action="{{ route('contactShow') }}" method="POST">
        @csrf
        <div class="form-header text-center">
            <h2>Contact :</h2>
            <hr class="mt-2 mb-2">
        </div>

        <div class="form-group">
            <label for="email"><strong>Email :</strong></label>
            <input type="email" name="email" id="email" placeholder="Adresse email">
        </div>

        <div class="form-group">
            <label for="identity"><strong>Nom.Prénom :</strong></label>
            <input type="text" name="identity" id="identity" placeholder="Nom et prénom du contact">
        </div>

        <div class="form-group">
            <label for="description"><strong>Message :</strong></label>
            <textarea name="description" id="description" placeholder="Message"></textarea>
        </div>

        <div class="form-group">
            <button class="btn btn-success" type="submit">Valider</button>
        </div>
    </form>

</x-layout>
