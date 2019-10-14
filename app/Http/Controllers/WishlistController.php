<?php

namespace App\Http\Controllers;

use App\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
        // $this->middleware('guest', ['only' => ['show']]);
        // $this->middleware('owner', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        if (Auth::id() != $userId){
            return view('/');
        }
        $wishlists = Wishlist::where('user_id', $userId)
                              ->orderBy('id', 'desc')
                              ->paginate(5);
        return view('wishlist.index', compact('wishlists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('wishlist.create');
    }

    private function storeCore(Request $request)
    {
        $request->request->add(['user_id' => Auth::id()]);
        Wishlist::create($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->storeCore($request);

        return response()->redirectToAction('WishlistController@index', Auth::id())
                         ->with('info', 'New wishlist has created.');
    }

    /**
     * Store a newly created resource in storage via ajax
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAjax(Request $request)
    {
        if ($request->ajax()){

            $this->storeCore($request);

            return response()->json(['status' => '200', 'info' => 'New wishlist has created.']);
        }

        abort(400, 'Not is ajax request.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $wishlistId
     * @return \Illuminate\Http\Response
     */
    public function show($wishlistId)
    {
        // dd($wishlistId);
        $wishlist = Wishlist::findOrFail($wishlistId);
        return view('wishlist.show', compact('wishlist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $wishlistId
     * @return \Illuminate\Http\Response
     */
    public function edit($wishlistId)
    {
        $wishlist = Wishlist::findOrFail($wishlistId);

        if (Auth::id() != $wishlist->user_id){
            return back()->with('info', 'you don\'t have permissions to update.');
        }

        return view('wishlist.edit', compact('wishlist'));
    }

    private function updateCore(Request $request, $wishlistId)
    {
        $wishlist = Wishlist::findOrFail($wishlistId);
        $userId = Auth::id();
        if ($userId != $wishlist->user_id){
            return back()->with('info', 'you don\'t have permissions to update.');
        }

        $wishlist->fill($request->all());
        $wishlist->user_id = $userId;
        $wishlist->save();
        $wishlist->products()->attach($request->product_id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $wishlistId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $wishlistId)
    {
        $this->updateCore($request, $wishlistId);

        return response()->redirectToAction('WishlistController@index', Auth::id());
    }

    public function detachProduct($wishlistId, $productId)
    {
        // dd($productId);
        // $productId = 1;
        $wishlist = Wishlist::findOrFail($wishlistId);
        $userId = Auth::id();
        if ($userId != $wishlist->user_id){
            return back()->with('info', 'you don\'t have permissions to update.');
        }
        $wishlist->products()->detach($productId);
    }

    /**
     * Update the specified resource in storage via ajax.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $wishlistId
     * @return \Illuminate\Http\Response
     */
    public function updateAjax(Request $request, $wishlistId)
    {
        if ($request->ajax()){

            $this->updateCore($request, $wishlistId);

            return response()->json(['status' => '200', 'info' => 'Product add to wishlist.']);
        }
        abort(400, 'Not is ajax request.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $wishlistId
     * @return \Illuminate\Http\Response
     */
    public function destroy($wishlistId)
    {
        $wishlist = Wishlist::findOrFail($wishlistId);

        if (Auth::id() != $wishlist->user_id){
            return back()->with('info', 'you don\'t have permissions to delete.');
        }

        $wishlist->delete();
        return back()->with('info', 'Wishlist deleted.');
    }
}
