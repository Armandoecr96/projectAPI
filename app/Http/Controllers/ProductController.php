<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\CrearProductRequest;
use App\Http\Requests\EditProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::get();
        return response()->json($products, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CrearProductRequest $request)
    {
        // Create a new product
        $product = Product::create($request->all());
        

        // Return a response with a product json
        // representation and a 201 status code   
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = '';
        $status = 500;
        $product = Product::find($id);
        if($product != null) {
            $response = $product;
            $status = 200;
        } else {
            $response = ['errors' => ['code' => 'ERROR-2', 'title' => 'Not Found']];
            $status = 404;
        }
        return response()->json($response, $status);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(EditProductRequest $request, $id)
    {
        $response = '';
        $status = 500;
        $product = Product::find($id);
        if($product != null) {
            $product->fill($request->all());
            $product->save();
            $status = 200;
            $response = $product;

        } else {
            $response = ['errors' => ['code' => 'ERROR-2', 'title' => 'Not Found']];
            $status = 404;
        }
        return response()->json($response, $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = '';
        $status = 500;
        $product = Product::find($id);
        if($product != null) {
            $status = 204;
            Product::destroy($id);
        } else {
            $response = ['errors' => ['code' => 'ERROR-2', 'title' => 'Not Found']];
            $status = 404;
        }        
        return response()->json($response, $status);

    }
}
