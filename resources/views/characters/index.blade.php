@extends('layouts.app')

@section('title', 'Players')

@section('content')
<div class="container content">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ trans('messages.fields.name') }}</th>
                <th scope="col">{{trans('flyff::messages.guild')}}</th>
                <th scope="col">Level</th>
                <th scope="col">Job</th>
                <th scope="col">Play time</th>
                <th scope="col">{{ trans('messages.fields.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($characters as $character)
                <tr>
                    @php
                        $character_rank = $loop->iteration + ($characters->currentPage()-1) * $characters->perPage()
                    @endphp
                    @if ($character_rank < 4)
                        <th scope="row"><img style="width: 64px;height:64px" src="{{$character->AvatarUrl}}" alt=""></th>
                    @else
                        <th scope="row">{{$character_rank}}</th>
                    @endif
                    
                    <td><img src="{{$character->SexIcon}}" alt=""> {{$character->m_szName}}</td>
                    <td>{{$character->guild->m_szGuild ?? '-'}}</td>
                    <td>{{$character->m_nLevel}}</td>
                    <td><img src="{{$character->JobIcon}}" alt="{{$character->JobName}}"> {{$character->JobName}}</td>
                    <td>{{$character->TotalTimePlayed}}</td>
                    <td>
                        <a href="{{route('flyff.characters.show', $character->m_szName)}}" class="mx-1" title="{{ trans('messages.actions.show') }}" data-toggle="tooltip"><i class="bi bi-eye"></i></a>
                    </td>
                </tr>
            @endforeach
            
        </tbody>
    </table>
    {{$characters->links()}}
</div>
@endsection
