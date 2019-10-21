<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Resources\ProductCollection as ProductCollectionResouce;
use App\Http\Resources\Product as ProductResource;
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
        $products = ProductResource::collection(Product::all());
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
        $product = Product::create([
            'type' => $request->input('data.type'),
            'name' => $request->input('data.attributes.name'),
            'price' => $request->input('data.attributes.price')
        ]);
        $product = new ProductResource($product);


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
        $product = Product::find($id);
        if (!is_null($product)){
            return (new ProductResource($product))->response()->setStatusCode(200);
        }
        else{
            $error = ['errors' => ['code' => 'ERROR-2', 'title' => 'Not Found']];
            return response()->json($error,404);
        }
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
        $codeHTTP = 500;
        $response = '';
        $product = Product::find($id);
        if (!is_null($product)){
            $product->update([
                'name' => $request->input('data.attributes.name'),
                'price' => $request->input('data.attributes.price'),
            ]);
            $response = $product;
            $codeHTTP = 200;
            return (new ProductResource($product))->response()->setStatusCode(200);
        }
        else{
            $response = ['errors' => ['code' => 'ERROR-2', 'title' => 'Not Found']];
            $codeHTTP = 404;
        }

        return response()->json($response, $codeHTTP);
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

        try {
            $product = Product::find($id);
            if ($product != null) {
                $status = 204;
                Product::destroy($id);
            } else {
                $response = ['errors' => ['code' => 'ERROR-2', 'title' => 'Not Found']];
                $status = 404;
            }
        } catch (\Throwable $th) {
            $response = ['errors' => ['code' => 'ERROR-2', 'title' => 'Not Found']];
            $status = 404;
        }

        return response()->json($response, $status);
    }
}
