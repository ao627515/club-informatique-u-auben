<x-mail::message>
    # Candidature reçue

    Bonjour {{ $candidate->user->prenom }} {{ $candidate->user->nom }},

    Nous avons bien reçu votre candidature. Elle est actuellement en attente de validation par un administrateur. Vous
    recevrez un email dès qu'une décision sera prise.

    ## Récapitulatif de vos informations
    - Matricule : **{{ $candidate->user->matricule }}**
    - Nom : **{{ $candidate->user->nom }}**
    - Prénom : **{{ $candidate->user->prenom }}**
    - Email : **{{ $candidate->user->email }}**
    - Téléphone : **{{ $candidate->user->telephone }}**
    - Vision :

    > {{ $candidate->vision }}

    Si vous n'êtes pas à l'origine de cette demande, ignorez cet email.

    Merci,
    {{ config('app.name') }}
</x-mail::message>
