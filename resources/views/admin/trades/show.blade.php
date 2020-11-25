@extends('admin.layouts.admin')

@section('title', trans('admin.users.title'))

@section('content')
<div class="card shadow mb-4">
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
@endsection