@extends('layouts.app.mail')

@section('head', mb_strtoupper('Formulaire de contact'))

@section('body')
    <tr>
        <td>
            <p style="text-align: justify;">
                Ce méssage vous à été envoyé dépuis le formulaire de
                contact le <span style="color: #1a8cff;">{{ $contact->fr_created_date }} à {{ $contact->fr_created_time }}</span>.
                Voici les détails de ce méssage:
            </p>
            <p style="text-align: justify;">
                <strong style="color: #1a8cff;">Nom:</strong> {{ $contact->format_name }}<br />
                <strong style="color: #1a8cff;">Email:</strong> {{ $contact->email }}<br />
                <strong style="color: #1a8cff;">Tel:</strong> {{ $contact->phone }}<br />
                <strong style="color: #1a8cff;">Sujet:</strong> {{ $contact->subject }}
            </p>
            <p style="text-align: justify; border: 1px solid #1a8cff; padding: 10px">
                {{ $contact->message }}
            </p>
            <div style="text-align: center;">
                <a href="#" style="display: inline-block; padding: 11px 30px; margin: 20px 0 30px; font-size: 15px; color: #fff; background: #1a8cff; text-decoration:none;" target="_blank">
                    Répondre au méssage
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
