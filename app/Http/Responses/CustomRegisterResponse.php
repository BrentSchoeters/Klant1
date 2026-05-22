<?php

namespace App\Http\Responses;

use App\Models\ClothingSize;
use App\Models\Size;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use Illuminate\Contracts\Support\Responsable;
use App\Models\Gender;

class CustomRegisterResponse implements RegisterViewResponse
{
    public function toResponse($request)
    {
        $sizes = Size::all();
        $clothingSizes = ClothingSize::all();
        $genders = Gender::all();
        return view('auth.register', compact('genders', 'clothingSizes', 'sizes')); // Pass them to the view
    }
}
