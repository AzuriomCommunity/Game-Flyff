@extends('layouts.app')

@section('title', 'Guild Siege')

@section('content')
<div class="container content">
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">{{trans('flyff::messages.guild')}}</th>
                <th scope="col">MVP<th></th>
                <th scope="col">{{ trans('messages.fields.action') }}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($guildSieges as $guildSiege)
                <tr>
                    <td>
                        {{ format_date($guildSiege->happened_at, true) }}
                    </td>
                    @php
                        $guild = array_key_first($guildSiege->data['guild_ranking']);
                        $mvp = array_key_first($guildSiege->data['player_ranking']);
                    @endphp
                    <td>
                        {{"$guild : {$guildSiege->data['guild_ranking'][$guild]['totalScore']}"}}
                    </td>
                    <td>
                        {{"$mvp - {$guildSiege->data['player_ranking'][$mvp]['guild']} : {$guildSiege->data['player_ranking'][$mvp]['score']}"}}
                    </td>
                    <td>
                        <a class="mx-1" target="_blank" href="{{ route('flyff.guild-siege.show', $guildSiege->id)}}" role="button"><i class="bi bi-eye"></i></a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

    {{ $guildSieges->links() }}
</div>
@endsection