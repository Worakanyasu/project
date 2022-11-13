<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index')->with('productsView', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = Storage::disk('public')->put('images', $request->image);
        $prepareProduct = [
            'name' => $request->name,
            'price' => $request->price,
            'user_id' => Auth::id(),
            'image' => $file
        ];

        $product = Product::create($prepareProduct);

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)//Product $product)
    {
          $prepareProduct = [
            'name' => $request->name,
            'price' => $request->price,
            'user_id' => Auth::id(),
    
        ];

        if ($request->image) {
        $file = Storage::disk('public')->put('images', $request->image);
        $prepareProduct['image'] = $file;
        }
        $product = Product::find($id);
        $productInst = $product;//Product::find($product->id);

        //////////////////*****/////////////////////

        $this->authorize('update', $productInst);
        
        if ($productInst->image && $request->image) {
            unlink('storage/' . $productInst->image);
        }
        $productInst->update($prepareProduct);

        //return redirect()->route('products.index');
        return redirect()->route('products.index');
        // $product = Storage::find($id);

        // $image = $request->image;

        // if($image)
        // {  
        //     $imagename = time() . '.' . $image->getClientOriginalExtension();
        //     $request->img->move('/storage/images/', $imagename);

        //     $product->image = $imagename;
        // } 

        // $product->name = $request->name;
        // $product->price = $request->price;

        // $post->update();

        // return redirect()->route('')

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $productInst = Product::find($product->id);

        if($productInst->image){
            unlink('storage/' . $productInst->image);
        }
        
        $productInst->delete();

        return redirect()->route('products.index');
    }
}
