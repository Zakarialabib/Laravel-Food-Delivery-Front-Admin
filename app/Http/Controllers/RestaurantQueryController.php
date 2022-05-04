<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestaurantQueryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'postcode' => 'required|min:4|max:4',
        ]);

        return redirect()
            ->route('restaurants.filter', ['postcode' => $data['postcode']])
            ->withCookie(cookie()->forever('postcode', $data['postcode'])
        );
    }
}

