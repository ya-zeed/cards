<?php

namespace App\Http\Controllers;

use App\Models\GiftCard;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GiftCardController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'route' => [
                'required',
                Rule::unique('gift_cards')->where(function ($query) use ($request) {
                    return $query->whereNot('user_id', \Auth::id());
                })
            ],
        ]);
        $imageName = $request->file('image')->store('images', 'public');
        $fontPath = $request->file('font')?->store('fonts', 'public');

        $giftCard = new GiftCard([
            'user_id' => \Auth::id(),
            'route' => $request->get('route'),
            'image_path' => $imageName,
            'font_path' => $fontPath,
            'text_x' => $request->get('text_x'),
            'text_y' => $request->get('text_y'),
            'font_size' => $request->get('font_size'),
            'font_color' => $request->get('font_color'),
        ]);


        $giftCard->save();

        return redirect()->route('giftcards.download', $request->get('route'));
    }

    public function downloadPage($route)
    {
        $images = GiftCard::query()->where('route', $route)->get();
        if ($images->isEmpty()) abort(404);
        return view('giftcards.name_input', compact('images'));
    }

}
