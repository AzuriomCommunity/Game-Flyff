@extends('layouts.app')

@section('title', trans('flyff::messages.characters').' - '. $character->m_szName)

@section('content')
<div class="container content">

    <div class="media border border-primary rounded">
        <img src="{{$character->AvatarUrl}}" class="align-self-center mr-3" alt="...">
        <div class="media-body">
            <h5 class="mt-0"><img src="{{$character->JobIcon}}" alt=""> <img src="{{$character->SexIcon}}" alt=""> {{$character->m_szName}} : {{$character->m_nLevel}}</h5>
            <p>
                <div class="row">
                    <div class="col-4">
                        STR: {{$character->m_nStr}}<br>
                        END: {{$character->m_nSta}}
                        
                    </div>
                    <div class="col-4">
                        DEX: {{$character->m_nDex}}<br>
                        INT: {{$character->m_nInt}}
                    </div>
                    <div class="col-4">
                        PKValue: {{$character->PKValue}}<br>
                        TotalTimePlayed: {{$character->TotalTimePlayed}}
                    </div>
                </div>
            </p>
        </div>
    </div>
</div>
</div>
@endsection
