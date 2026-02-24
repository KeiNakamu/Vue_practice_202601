<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class MeController extends Controller
{
    public function __invoke(Request $request)
    {
        return new UserResource($request->user());
    }
}
