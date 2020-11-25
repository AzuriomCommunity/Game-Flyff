<?php

namespace Azuriom\Plugin\Flyff\Controllers\Admin;

use Illuminate\Http\Request;
use Azuriom\Plugin\Flyff\Models\Bank;
use Azuriom\Plugin\Flyff\Models\Mail;
use Azuriom\Plugin\Flyff\Models\User;
use Azuriom\Plugin\Flyff\Models\Pocket;
use Azuriom\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Azuriom\Plugin\Flyff\Models\GuildBank;
use Azuriom\Plugin\Flyff\Models\Inventory;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $itemID = $request->input('itemID');
        $min = $request->input('min');
        $result = [
            'characters' => [],
            'guilds' => []
        ];
        
        if($itemID && $min) {
            $inventories = Inventory::where('m_Inventory', 'like', "%$itemID%")->get();
            $this->checkInventory($result, $inventories, 'm_Inventory', 'character', 'm_szName', $itemID, $min);

            $inventories = Bank::where('m_Bank', 'like', "%$itemID%")->get();
            $this->checkInventory($result, $inventories, 'm_Bank', 'character', 'm_szName', $itemID, $min);

            $inventories = Pocket::where('szItem', 'like', "%$itemID%")->get();
            $this->checkInventory($result, $inventories, 'szItem', 'character', 'm_szName', $itemID, $min);

            $inventories = Mail::where([['dwItemId', $itemID], ['ItemReceiveDt', null]])->get();
            $this->checkInventory($result, $inventories, 'nItemNum', 'sender', 'm_szName', $itemID, $min);


            $inventories = GuildBank::where('m_GuildBank', 'like', "%$itemID%")->get();
            $this->checkInventory($result, $inventories, 'm_GuildBank', 'guild', 'm_szGuild', $itemID, $min);
        }
        

        return view('flyff::admin.items.lookup', ['result' => $result, 'itemID' => $itemID, 'min' => $min]);
    }

    private function checkInventory(&$result, $inventories, $inventory_key, $relationship, $owner_key, $itemID, $min)
    {

        foreach ($inventories as $inventory) {
            $objects = explode('/', $inventory->{$inventory_key});
            foreach ($objects as  $object) {
                $props = explode(',', $object);
                if(count($props) > 6) {
                    if ( $props[1] == $itemID && $props[5] >= $min )
                    {
                        if($relationship == 'guild') {
                            $result['guilds'][$inventory->{$relationship}->{$owner_key}] = $props[5];
                        } else {
                             $result['characters'][$inventory->{$relationship}->{$owner_key}][$inventory_key] = $props[5];
                        }
                        
                    }
                }
            }
        }
    }
}