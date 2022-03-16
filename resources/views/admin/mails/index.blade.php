@extends('admin.layouts.admin')

@section('title', trans('admin.users.title'))

@section('content')

<div class="alert alert-info" role="alert">
    You can search for: Mail ID, Sender, Receiver, Title, Penyas, Item ID
</div>

<form class="form-inline mb-3" action="{{ route('flyff.admin.mails') }}" method="GET">
    <div class="form-group mb-2">
        <label for="searchInput" class="sr-only">{{ trans('messages.actions.search') }}</label>

        <div class="input-group">
            <input type="text" class="form-control" id="searchInput" name="search" value="{{ $search ?? '' }}" placeholder="{{ trans('messages.actions.search') }}">

            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </div>
</form>

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
                        <td>{{$mail->sender ? $mail->sender->m_szName : 'FLYFF'}}</td>
                        <td>{{$mail->receiver ? $mail->receiver->m_szName : 'FLYFF'  }}</td>
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
            {{$mails->appends(request()->all())}}
        </div>
    </div>
</div>
@endsection