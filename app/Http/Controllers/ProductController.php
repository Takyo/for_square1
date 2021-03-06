<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Form;


class ProductController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = ($request->sort === 'desc') ? 'desc': 'asc';
        $products = Product::orderBy('price', $sort)->paginate(5);

        return view('products.index', compact('products', 'sort'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage from scraping.
     * TODO:
     *      insertar masivamente productos
     *      se muestre bien la relacion muchos a muchos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function storeFromScraping(Request $request)
    {
        $category = new \App\Category();
        $property = new \App\Property();
        $image = new \App\Image();

        foreach ($request->all() as $req) {
            $category_id = $category->firstOrCreate(['name' => $req['category']])->id;

            $properties_id = [];
            foreach ( $req['properties']as $prop) {
                $id = $property->firstOrCreate(['name' => key($prop)])->id;
                $properties_id[$id] = ['content' => $prop[key($prop)]];
            }

            $images_id = [];
            foreach ( $req['imgs'] as $prop => $value) {
                $id = $image->firstOrCreate(['name' => $prop])->id;
                $images_id[$id] = ['filepath' => "$value"];
            }

            $data = array_merge($req, ['category_id' => $category_id]);
            $product = new Product();
            $product->fill($data);
            $product->save();
            $product->properties()->attach($properties_id);
            $product->images()->attach($images_id);
        }

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       Product::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
