<?php

namespace Azuriom\Plugin\Flyff\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Flyff\Models\FlyffAccount;
use Azuriom\Plugin\Flyff\Models\FlyffAccountDetail;
use Azuriom\Plugin\Flyff\Requests\FlyffAccountRequest;

class FlyffAccountController extends Controller
{
    public function store(FlyffAccountRequest $request)
    {
        $validatedData = $request->validated();
        //FlyffAccount::create();
        $validatedData['password'] = flyff_hash_mdp($validatedData['password']);
        FlyffAccount::query()->create([
            'account' => $validatedData['account'],
            'password' => $validatedData['password'],
            'isuse' => 'T',
            'member' => 'A',
            'realname' => '',
            'Azuriom_user_id' => auth()->id(),
            'Azuriom_user_access_token' => Str::random(128)
        ]);

        FlyffAccountDetail::query()->create([
            'account' => $validatedData['account'],
            'gamecode' => 'A000',
            'tester' => '2',
            'm_chLoginAuthority' => 'F',
            'regdate' => Carbon::now(),
            'BlockTime' => '0',
            'EndTime' => '0',
            'WebTime' => '0',
            'isuse' => 'O',
            'email' => '',
        ]);

        return redirect()->route('flyff.accounts.index')->with('success', 'Account created');
    }

    public function link(Request $request)
    {
        $validated = $request->validate([
            'account' => 'required|string',
            'password' => 'required|string',
        ]);

        $account = FlyffAccount::firstWhere('account', $validated['account']);

        $hash = flyff_hash_mdp($validated['password']);

        if ($account !== null && $account->password === $hash) {
            $account->Azuriom_user_id = auth()->id();
            $account->Azuriom_user_access_token = Str::random(128);
            $account->save();

            return redirect()->route('flyff.accounts.index')->with('success', 'Account Linked');
        }

        return redirect()->route('flyff.accounts.index')->with('error', 'Wrong credentials');
    }

    public function edit(FlyffAccount $account)
    {
        abort_if($account->Azuriom_user_id != auth()->id(), 403);

        return view('flyff::change-password', ['account'=>$account]);
    }

    public function update(FlyffAccount $account)
    {
        abort_if($account->Azuriom_user_id != auth()->id(), 403);

        $validated = $this->validate(request(), [
            'password' => ['required', 'string', 'min:8','max:16', 'regex:/^[A-Za-z0-9]+$/u','confirmed']
        ]);

        $account->password = flyff_hash_mdp($validated['password']);
        $account->save();

        return redirect()->route('flyff.accounts.index')->with('success', 'Password changed');
    }
}
