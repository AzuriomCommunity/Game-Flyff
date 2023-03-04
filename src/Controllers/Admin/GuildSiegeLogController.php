<?php

namespace Azuriom\Plugin\Flyff\Controllers\Admin;

use Carbon\Carbon;
use Azuriom\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Flyff\Models\GuildSiegeLog;

class GuildSiegeLogController extends Controller
{
    public function index()
    {
        return view('flyff::admin.guild-siege.index', ['guildSieges' => GuildSiegeLog::orderBy('happened_at', 'desc')->paginate()]);
    }

    public function addSiege(Request $request)
    {
        try {
            $last_guild_attacker = null;
            $last_char_attacker = null;

            $last_guild_defenser = null;
            $last_char_defenser = null;

            $result = [];
            $request->validate([
                'siege_log' => 'required|file|mimes:txt',
            ]);

            $contents = explode("\n", file_get_contents($request->file('siege_log')->getRealPath()));

            foreach ($contents as $line) {
                if (empty(trim($line))) {
                    continue;
                }

                if (Str::startsWith($line, '[')) {
                    $attacker_defenser = explode('→', $line);
                    if (count($attacker_defenser) < 2) {
                        $attacker_defenser = explode('â†’', $line);
                    }
                    if (count($attacker_defenser) < 2) {
                        $attacker_defenser = explode('??', $line);
                    }
                    $last_guild_attacker = Str::between($attacker_defenser[0], '[', ']');
                    $last_char_attacker = Str::afterLast(Str::beforeLast(Str::ascii($attacker_defenser[0]), '('), ' ');

                    $last_guild_defenser = Str::between($attacker_defenser[1], '[', ']');
                    $last_char_defenser = trim(Str::afterLast($attacker_defenser[1], ' '));


                    $result[$last_guild_attacker][$last_char_attacker]
                        ['kills']
                            [(string)($result[$last_guild_attacker][$last_char_attacker]['life'] ?? 1)] // kills during current life
                                ["$last_char_defenser - $last_guild_defenser"] = (
                                    $result[$last_guild_attacker][$last_char_attacker]
                                        ['kills']
                                            [(string)($result[$last_guild_attacker][$last_char_attacker]['life'] ?? 1)]
                                                ["$last_char_defenser - $last_guild_defenser"] ?? 0 // the number that a $last_char_defenser has been killed during current life
                                ) + 1;

                    $result[$last_guild_defenser][$last_char_defenser]
                        ['deaths']
                            [(string)($result[$last_guild_defenser][$last_char_defenser]['life'] ?? 1)] = "$last_char_attacker - $last_guild_attacker"; // who killed $last_char_defenser

                    $result[$last_guild_defenser][$last_char_defenser]['life'] = ($result[$last_guild_defenser][$last_char_defenser]['life'] ?? 0) + 1; //increase the number of current life for the defenser
                } else {
                    $points_str = explode(',', $line);
                    $points = 0;
                    foreach ($points_str as $point_str) {
                        $points += intval(Str::after($point_str, '+')); // counts the point
                    }

                    $result[$last_guild_attacker][$last_char_attacker]['score'] = ($result[$last_guild_attacker][$last_char_attacker]['score'] ?? 0) + $points;
                }
            }
            $playerRanking = [];

            foreach ($result as $keyGuild => $valueGuild) {
                uasort($result[$keyGuild], function ($a, $b) {
                    return ($b['score'] ?? 0) <=> ($a['score'] ?? 0); // sort the players of a guild
                });

                foreach ($result[$keyGuild] as $keyPlayer => $valuePlayer) {
                    $result[$keyGuild][$keyPlayer]['score'] = $result[$keyGuild][$keyPlayer]['score'] ?? 0;
                    $result[$keyGuild][$keyPlayer]['kills'] = $result[$keyGuild][$keyPlayer]['kills'] ?? [];
                    $result[$keyGuild][$keyPlayer]['deaths'] = $result[$keyGuild][$keyPlayer]['deaths'] ?? [];
                    $playerRanking[$keyPlayer] = $result[$keyGuild][$keyPlayer];
                    $playerRanking[$keyPlayer]['guild'] = $keyGuild;
                    $result[$keyGuild]['totalScore'] = ($result[$keyGuild]['totalScore'] ?? 0) + $result[$keyGuild][$keyPlayer]['score'];
                    $result[$keyGuild]['members'][$keyPlayer] = $result[$keyGuild][$keyPlayer]['score'];
                    unset($result[$keyGuild][$keyPlayer]);
                }
            }
            uasort($result, function ($a, $b) {
                return $b['totalScore'] <=> $a['totalScore']; // sort guilds
            });

            uasort($playerRanking, function ($a, $b) {
                return $b['score'] <=> $a['score']; // sort all players of all guilds
            });

            $ranking = [
                'guild_ranking' => $result,
                'player_ranking' => $playerRanking
            ];

            GuildSiegeLog::create([
                'data' => $ranking,
                'happened_at' => $request->input('happened_at')
            ]);

            return redirect()->route('flyff.admin.siege')->with('succes', 'Log created');
        } catch (\Throwable $th) {
            return redirect()->route('flyff.admin.siege')->with('error', $th->getMessage());
        }
    }
}
