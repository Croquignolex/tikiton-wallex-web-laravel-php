{{ mb_strtoupper('Formulaire de contact') }}


Ce méssage vous à été envoyé dépuis le formulaire de contact le {{ $contact->fr_created_date }} à {{ $contact->fr_created_time }}.
Voici les détails de ce méssage:

Nom: {{ $contact->format_name }}
Email: {{ $contact->email }}
Tel: {{ $contact->phone }}
Sujet: {{ $contact->subject }}

{{ $contact->message }}

<a href="#" target="_blank">Répondre au méssage</a>

Si ce bouton ne fonctionne pas, essayez de copier et coller
cet URL dans votre navigateur web. Si le problème perssiste,
s'il vous plais sentez vous libre de contacter l'équipe
de developpement.

@lang('general.admin_thanks', ['app' => config('app.name')])
&copy; 2018 {{ config('app.name') }}, @lang('general.right').