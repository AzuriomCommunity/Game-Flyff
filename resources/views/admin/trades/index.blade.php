@extends('admin.layouts.admin')

@section('title', trans('admin.users.title'))

@section('content')

<div class="alert alert-info" role="alert">
    You can search for: Trade ID, Character name, Penyas, Item ID
</div>

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
                        <td><a data-toggle="collapse" href="#collapse-{{$trade->TradeID}}" role="button" aria-expanded="false" aria-controls="collapse-{{$trade->TradeID}}" class="mx-1"><i class="fas fa-eye"></i></a></td>
                    </tr>
                    <tr class="collapse" id="collapse-{{$trade->TradeID}}">
                        <td colspan="5">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h2 class="text-center">{{$trade->firstTradeDetail->character->m_szName}}</h2>
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="text-center">SENT TO <small>{{$trade->secondTradeDetail->character->m_szName}}</small></h5>
                                                    Penyas : {{$trade->firstTradeDetail->TradeGold}}
                                                    <ul>
                                                        @forelse ($trade->firstTradeDetail->sentItems as $item)
                                                            <li>{{$item->ItemIndex}} x {{$item->ItemCnt}}</li>
                                                        @empty
                                                            <h6 class="text-center">NO ITEMS</h4>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h2 class="text-center">{{$trade->secondTradeDetail->character->m_szName}}</h2>
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="text-center">SENT TO <small>{{$trade->firstTradeDetail->character->m_szName}}</small></h5>
                                                        Penyas : {{$trade->secondTradeDetail->TradeGold}}
                                                        <ul>
                                                            @forelse ($trade->secondTradeDetail->sentItems as $item)
                                                                <li>{{$item->ItemIndex}} x {{$item->ItemCnt}}</li>
                                                            @empty
                                                                <h6 class="text-center">NO ITEMS</h4>
                                                            @endforelse
                                                        </ul>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$trades->appends(request()->all())}}
        </div>
    </div>
</div>
@endsection