@extends('admin.layouts.admin')

@section('title', trans('admin.users.title'))

@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Expéditeur</th>
                        <th scope="col">Destinataire</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Penya</th>
                        <th scope="col">Id de l'objet</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Date d'envoie</th>
                        <th scope="col">Date Penyas</th>
                        <th scope="col">Date Item</th>
                        <th scope="col">Date de Suppresion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mails as $mail)
                    <tr>
                        <td>{{$mail->nMail}}</td>
                        <td>{{$mail->sender ? $mail->sender->m_szName : '-'}}</td>
                        <td>{{$mail->receiver ? $mail->receiver->m_szName : '-'  }}</td>
                        <td>{{$mail->szTitle}}</td>
                        <td>{{$mail->nGold}}</td>
                        <td>{{$mail->dwItemId}}</td>
                        <td>{{$mail->nItemNum}}</td>
                        <td>{{$mail->SendDt}}</td>
                        <td>{{$mail->GetGoldDt ?? '-'}}</td>
                        <td>{{$mail->ItemReceiveDt ?? '-'}}</td>
                        <td>{{$mail->DeleteDt ?? '-'}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$mails->links()}}
        </div>
    </div>
</div>
@endsection