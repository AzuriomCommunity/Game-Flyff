@extends('layouts.app')

@section('title', 'Guilds')

@section('content')
<div class="container content">
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Wins</th>
                <th scope="col">Leader</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guilds as $guild)
                <tr>
                    <th scope="row">{{$loop->iteration + ($guilds->currentPage()-1) * $guilds->perPage()}}</th>
                    <td>{{$guild->m_szGuild}}</td>
                    <td>{{$guild->m_nWin}}</td>
                    <td>{{$guild->leader->m_szName}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
