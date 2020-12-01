<?php

namespace Azuriom\Plugin\Flyff\Games;

use RuntimeException;
use Azuriom\Models\User;
use Azuriom\Games\ServerBridge;
use Illuminate\Support\Facades\DB;
use Azuriom\Plugin\Shop\Models\User as ShopUser;

/**
 * CHARACTER_01_DBF
 * LOGGING_01_DBF
 * ACCOUNT_DBF.
 */
class FlyffServerBridge extends ServerBridge
{
    protected const DEFAULT_PORT = 29000;

    /**
     * Here the $maxPlayerConnected represents the record of users connected simultaneously.
     */
    public function getServerData()
    {
 
        if(@fsockopen($this->server->address, $this->server->port,$errorno, $errorstr, 0.1)) {
            $connected = DB::connection('sqlsrv')->table('CHARACTER_01_DBF.dbo.CHARACTER_TBL')->where('MultiServer', '1')->count();
            $maxPlayerConnected = (int) DB::connection('sqlsrv')->table('LOGGING_01_DBF.dbo.LOG_USER_CNT_TBL')->select('number')->orderByDesc('number')->first()->number;
    
            return [
                'players' => $connected,
                'max_players' => $maxPlayerConnected,
            ];
        }

        return null;
    }

    public function verifyLink()
    {
        return !! @fsockopen($this->server->address, $this->server->port, $errorno, $errorstr, 0.1);
    }

    /**
     * $m_idPlayer and $m_nServer are set if the user open the shop in-game
     * using session vars set in the default theme.
     *
     * $playerNameIfNavigator is set with the theme when the user buy in the shop
     * outside of the game, from his phone for example.
     */
    public function sendCommands(array $commands, User $user = null, bool $needConnected = false)
    {
        if ($user === null) {
            throw new RuntimeException('User is required to send commands.');
        }

        $idPlayer = session('m_idPlayer');
        $idServer = session('m_nServer');
        $playerNameIfNavigator = request()->flyff_player_name;

        if (empty($idPlayer) || empty($idServer)) {
            $this->getPlayerFallback($user, $idPlayer, $idServer);
        } else {
            $idPlayer = str_pad($idPlayer, 7, '0', STR_PAD_LEFT); //formating nothing important
            $idServer = str_pad($idServer, 2, '0', STR_PAD_LEFT);
        }

        if ($this->playerIsConnected($idPlayer, $idServer)) {
            $this->sendItemsWithSocket($idPlayer, $idServer, $commands);
        } else {
            $this->sendItemsWithDatabase($idPlayer, $idServer, $commands);
        }
    }

    public function canExecuteCommand()
    {
        return true;
    }

    public function getDefaultPort()
    {
        return self::DEFAULT_PORT;
    }

    private function getPlayerFallback($user, &$idPlayer, &$idServer)
    {
            //this is the fallback, it gets the first character, not deleted of the Azuriom connected user.
            $account = DB::connection('sqlsrv')->table('ACCOUNT_DBF.dbo.ACCOUNT_TBL')
                ->select('account')->where('Azuriom_user_id', $user->id)->first();

            $character = DB::connection('sqlsrv')->table('CHARACTER_01_DBF.dbo.CHARACTER_TBL')
                ->select('m_idPlayer', 'serverindex', 'MultiServer')
                ->where(
                    [
                        ['account', $account->account],
                        ['isblock', 'F'],
                    ])->first();

            $idPlayer = $character->m_idPlayer;
            $idServer = $character->serverindex;
        
    }

    private function playerIsConnected($idPlayer, $idServer)
    {
        $character = DB::connection('sqlsrv')->table('CHARACTER_01_DBF.dbo.CHARACTER_TBL')
            ->select('MultiServer')
            ->where([ //get first not deleted character
                ['m_idPlayer', $idPlayer],
                ['serverindex', $idServer],
            ])->first();

        return $character->MultiServer === '1';
    }

    /**
     * $command should look like : 26228,Elixir of Stone,1
     * which is : id,name,quantity.
     */
    private function sendItemsWithDatabase($idPlayer, $idServer, $commands)
    {
        foreach ($commands as $command) {
            $id_name_quantity = explode(',', $command);
            DB::connection('sqlsrv')->table('CHARACTER_01_DBF.dbo.ITEM_SEND_TBL')
                ->insert([
                    'm_idPlayer' => $idPlayer,
                    'serverindex' => $idServer,
                    'Item_Name' => trim($id_name_quantity[1]),
                    'Item_count' => trim($id_name_quantity[2]),
                    'idSender' => '0000000',
                    'adwItemId0' => trim($id_name_quantity[0]),
                ]);
        }
    }

    private function sendItemsWithSocket($idPlayer, $idServer, $commands)
    {
        $fp = fsockopen($this->server->address, $this->server->port, $errno, $errstr);
        if (! $fp) {
            throw new RuntimeException("$errstr ($errno)");
        }

        foreach ($commands as $command) {
            $id_name_quantity = explode(',', $command);
            $packet = pack('VVVVV', $idServer, $idPlayer, 0, trim($id_name_quantity[0]), trim($id_name_quantity[2])).str_pad(env('FLYFF_WEBSHOP_KEY', '8b8d0c753894b018ce454b2e'), 21, ' ').pack('V', 1);
            fwrite($fp, $packet);
        }

        if ($fp) {
            fclose($fp);
        }
    }
}
