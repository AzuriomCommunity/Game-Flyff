@extends('admin.layouts.admin')

@section('title', trans('admin.users.title'))

@section('content')
<form class="form-inline mb-3" action="{{ route('flyff.admin.trades.index') }}" method="GET">
    <div class="form-group mb-2">
        <label for="searchInput" class="sr-only">{{ trans('messages.actions.search') }}</label>

        <div class="input-group">
            <input type="text" class="form-control" id="searchInput" name="search" value="{{ $search ?? '' }}" placeholder="{{ trans('messages.actions.search') }}">

            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search fa-sm"></i>
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
            {{$trades->appends(request()->all())}}
        </div>
    </div>
</div>
@endsection