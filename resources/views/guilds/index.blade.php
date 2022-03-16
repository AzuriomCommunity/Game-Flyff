@extends('layouts.app')

@section('title', 'Guilds')

@section('content')
<div class="container content">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Wins</th>
                <th scope="col">Leader</th>
                <th scope="col">{{ trans('messages.fields.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guilds as $guild)
                <tr>
                    <th scope="row"><img src="{{$guild->Icon}}" alt=""> {{$loop->iteration + ($guilds->currentPage()-1) * $guilds->perPage()}}</th>
                    <td>{{$guild->m_szGuild}}</td>
                    <td>{{$guild->m_nWin}}</td>
                    <td>{{$guild->leader->m_szName}}</td>
                    <td>
                        <a href="{{route('flyff.guilds.show', $guild->m_szGuild)}}" class="mx-1" title="{{ trans('messages.actions.show') }}" data-toggle="tooltip"><i class="bi bi-eye"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{$guilds->links()}}
</div>
@endsection
