<?php

namespace App\Http\Controllers;

use App\Models\GiftCard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GiftCardController extends Controller
{
    public function create()
    {
        return view('giftcards.create');
    }

    public function cardsByRoute()
    {
        $cards = Auth::user()->giftCards()->byRoute(request('route'))->get();
        return view('giftcards.by_route', compact('cards'));
    }
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

        // Increment view count for all cards in this route
        GiftCard::query()->where('route', $route)->increment('view_count');

        return view('giftcards.name_input', compact('images'));
    }

    public function trackDownload(Request $request)
    {
        $card = GiftCard::findOrFail($request->card_id);
        $card->increment('download_count');
        return response()->json(['ok' => true]);
    }

    public function updateRoute(Request $request)
    {
        $request->validate([
            'old_route' => 'required',
            'new_route' => ['required', 'regex:/^[a-zA-Z0-9]+$/'],
        ]);

        $oldRoute = $request->old_route;
        $newRoute = $request->new_route;

        // Check the user owns these cards
        $cards = Auth::user()->giftCards()->where('route', $oldRoute)->get();
        if ($cards->isEmpty()) abort(403);

        // Check new route isn't taken by another user
        $taken = GiftCard::where('route', $newRoute)->where('user_id', '!=', Auth::id())->exists();
        if ($taken) {
            return back()->with('error', 'هذا الرابط مستخدم من شخص آخر');
        }

        Auth::user()->giftCards()->where('route', $oldRoute)->update(['route' => $newRoute]);

        return back()->with('success', 'تم تحديث الرابط بنجاح');
    }

    public function admin()
    {
        if (Auth::user()->email !== 'yazoid1421@gmail.com') {
            abort(403);
        }

        $cards = GiftCard::all();
        $routes = $cards->groupBy('route');

        $totalCards = $cards->count();
        $totalDownloads = $cards->sum('download_count');
        $totalViews = $cards->sum('view_count');
        $totalRoutes = $routes->count();

        // Most downloaded card
        $topCard = $cards->sortByDesc('download_count')->first();

        // Route stats
        $routeStats = $routes->map(function ($group) {
            return [
                'route' => $group->first()->route,
                'cards_count' => $group->count(),
                'downloads' => $group->sum('download_count'),
                'views' => $group->sum('view_count'),
                'user' => $group->first()->user,
            ];
        })->sortByDesc('downloads')->values();

        // All cards sorted by downloads
        $cardsByDownloads = $cards->sortByDesc('download_count')->values();

        return view('admin.dashboard', compact(
            'totalCards', 'totalDownloads', 'totalViews', 'totalRoutes',
            'topCard', 'routeStats', 'cardsByDownloads'
        ));
    }

    public function showRoutes()
    {
        $routes = Auth::user()->giftcards()->pluck('route')->map(function ($route) {
            return GiftCard::byRoute($route)->get();
        });

        return view('routes.index', compact('routes')); // 'domains.index' is the path to your new view file
    }

    public function destroy(GiftCard $card)
    {
        $card->delete();
        return redirect()->route('giftcards.cards', ['route' => $card->route]);
    }

}
