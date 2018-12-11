@extends('layouts.mail')

@section('head', mb_strtoupper('Nouvel utilisateur confirmé'))

@section('body')
    <tr>
        <td>
            <p style="text-align: justify;">
                Un nouvel utilisateur viens de confirmer son compte
                le <span style="color: #1a8cff;">{{ $user->fr_updated_date }} à {{ $user->fr_updated_time }}</span>.
                Voici les informations de base ce client:
            </p>
            <p style="text-align: justify;">
                <strong style="color: #1a8cff;">Prénom:</strong> {{ $user->format_first_name }}<br />
                <strong style="color: #1a8cff;">Nom:</strong> {{ $user->format_last_name }}<br />
                <strong style="color: #1a8cff;">Email:</strong> {{ $user->email }}
            </p>
            <div style="text-align: center;">
                <a href="#" style="display: inline-block; padding: 11px 30px; margin: 20px 0 30px; font-size: 15px; color: #fff; background: #1a8cff; text-decoration:none;" target="_blank">
                    Souhaitez lui la bienvenue
                </a>
            </div>
            <p style="text-align: justify;">
                Si ce bouton ne fonctionne pas, essayez de copier et coller
                cet URL dans votre navigateur web. Si le problème perssiste,
                s'il vous plais sentez vous libre de contacter l'équipe
                de developpement.
            </p>
        </td>
    </tr>
@endsection
