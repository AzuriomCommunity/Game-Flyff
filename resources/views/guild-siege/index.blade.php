@extends('layouts.app')

@section('title', 'Guild Siege')

@section('content')
<div class="container content">
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">{{ trans('messages.fields.action') }}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($guildSieges as $guildSiege)
                <tr>
                    <th scope="row">
                        {{ $guildSiege->id }}
                    </th>
                    <td>
                        {{ format_date($guildSiege->happened_at) }}
                    </td>
                    <td>
                        <a class="mx-1" href="" role="button"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

    {{ $guildSieges->links() }}
</div>
@endsection