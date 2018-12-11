{{ mb_strtoupper('Nouvel utilisateur confirmé') }}


Un nouveau client viens de confirmer son compte le {{ $user->fr_updated_date }} à {{ $user->fr_updated_time }}.
Voici les informations de base ce client:

Prénom: {{ $user->format_first_name }}
Nom: {{ $user->format_last_name }}
Email: {{ $user->email }}

<a href="#" target="_blank">Souhaitez lui la bienvenue</a>

Si ce bouton ne fonctionne pas, essayez de copier et coller
cet URL dans votre navigateur web. Si le problème perssiste,
s'il vous plais sentez vous libre de contacter l'équipe
de developpement.
    .
@lang('general.admin_thanks', ['app' => config('app.name')])
&copy; 2018 {{ config('app.name') }}, @lang('general.right').