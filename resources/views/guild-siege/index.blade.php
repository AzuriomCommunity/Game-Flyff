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
                    @endphp
                    <td>
                        {{"$guild : {$guildSiege->data['guild_ranking'][$guild]['totalScore']}"}}
                    </td>
                    <td>
                        <a class="mx-1" target="_blank" href="{{ route('flyff.guild-siege.show', $guildSiege->id)}}" role="button"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

    {{ $guildSieges->links() }}
</div>
@endsection