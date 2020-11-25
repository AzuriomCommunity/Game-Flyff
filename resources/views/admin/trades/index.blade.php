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
                        <th scope="col">Character 1</th>
                        <th scope="col">Character 2</th>
                        <th scope="col">Date</th>
                        <th scope="col">{{ trans('messages.fields.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trades as $trade)
                    <tr>
                        <td>{{$trade->TradeID}}</td>
                        <td>{{$trade->firstTradeDetail->character->m_szName}}</td>
                        <td>{{$trade->secondTradeDetail->character->m_szName}}</td>
                        <td>{{$trade->TradeDt}}</td>
                        <td><a href="{{ route('flyff.admin.trades.show', $trade) }}" class="mx-1" title="{{ trans('messages.actions.show') }}" data-toggle="tooltip"><i class="fas fa-eye"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$trades->links()}}
        </div>
    </div>
</div>
@endsection