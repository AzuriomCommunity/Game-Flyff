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
                    <th scope="row">{{$loop->iteration + ($characters->currentPage()-1) * $characters->perPage()}}</th>
                    <td>{{$character->m_szName}}</td>
                    <td>{{$character->guild->m_szGuild ?? '-'}}</td>
                    <td>{{$character->m_nLevel}}</td>
                    <td>{{$character->m_nJob}}</td>
                    <td>{{$character->TotalTimePlayed}}</td>
                </tr>
            @endforeach
            
        </tbody>
    </table>
    {{$characters->links()}}
</div>
@endsection
