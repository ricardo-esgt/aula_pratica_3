<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Rules\Password;
use Laravel\Fortify\TwoFactorAuthenticationProvider;

class Create extends Controller
{
    public function __invoke(EnableTwoFactorAuthentication $enable)
    {
        $input = request()->all();

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => ['required', 'string', new Password, 'confirmed']
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => \Hash::make($input['password']),
        ]);

        $enable($user);

        return response()->json([
            "qrcode" => $user->twoFactorQrCodeSvg()
        ]);
    }
}
