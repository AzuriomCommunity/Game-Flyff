@extends('layouts.app')

@section('title', 'Players')

@section('content')
<div class="container content">
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Guild</th>
                <th scope="col">Level</th>
                <th scope="col">Job</th>
                <th scope="col">Play time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($characters as $character)
                <tr>
                    @php
                        $character_rank = $loop->iteration + ($characters->currentPage()-1) * $characters->perPage()
                    @endphp
                    @if ($character_rank < 4)
                        <th scope="row"><img style="width: 64px;height:64px" src="{{$character->getAvatarUrl()}}" alt=""></th>
                    @else
                        <th scope="row">{{$character_rank}}</th>
                    @endif
                    
                    <td>{{$character->m_szName}}</td>
                    <td>{{$character->guild->m_szGuild ?? '-'}}</td>
                    <td>{{$character->m_nLevel}}</td>
                    <td><img src="{{$character->getJobIcon()}}" alt="{{$character->getJobName()}}"> {{$character->getJobName()}}</td>
                    <td>{{$character->TotalTimePlayed}}</td>
                </tr>
            @endforeach
            
        </tbody>
    </table>
    {{$characters->links()}}
</div>
@endsection
