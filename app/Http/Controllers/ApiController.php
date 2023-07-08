<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function test()
    {
        /** @var Parents $parent */
        $parent = Parents::query()->findOrFail(1);
        $token = $parent->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
