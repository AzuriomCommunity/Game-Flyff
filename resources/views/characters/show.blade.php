@extends('layouts.app')

@section('title', trans('flyff::messages.characters').' - '. $character->m_szName)

@section('content')
    <div class="d-flex align-items-center">
        <div class="flex-shrink-0">
            <img src="{{$character->AvatarUrl}}" class="align-self-center mr-3" alt="...">
        </div>
        <div class="flex-grow-1 ms-3">
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
@endsection
