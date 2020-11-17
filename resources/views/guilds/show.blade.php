@extends('layouts.app')

@section('title', trans('flyff::messages.guilds').' - '. $guild->m_szGuild )

@section('content')
<div class="container content">
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Rank</th>
                <th scope="col">Level</th>
                <th scope="col">Job</th>
                <th scope="col">Play time</th>
                <th scope="col">{{ trans('messages.fields.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guild->members as $member)
                <tr>
                    <th scope="row"><img style="width: 64px;height:64px" src="{{$member->character->AvatarUrl}}" alt=""></th>
                    <td><img src="{{$member->character->SexIcon}}" alt=""> {{$member->character->m_szName}}</td>
                    <td><img src="{{$member->RankIcon}}" alt=""> {{$member->RankTitle}}</td>
                    <td>{{$member->character->m_nLevel}}</td>
                    <td><img src="{{$member->character->JobIcon}}" alt="{{$member->character->JobName}}"> {{$member->character->JobName}}</td>
                    <td>{{$member->character->TotalTimePlayed}}</td>
                    <td>
                        <a href="{{route('flyff.characters.show', $member->character->m_szName)}}" class="mx-1" title="{{ trans('messages.actions.show') }}" data-toggle="tooltip"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
            @endforeach
            
        </tbody>
    </table>
</div>
@endsection