<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Get all existing Products
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllProducts()
    {
        $products = Product::get()->toJson(JSON_PRETTY_PRINT);
        return response($products, 200);
    }

    /**
     * Get Product by ID
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function getProduct($id)
    {
        if (Product::where('id', $id)->exists()) {
            $product = Product::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($product, 200);
        } else {
            return response()->json([
                "message" => "Product not found"
            ], 404);
        }
    }

    /**
     * Create new Product
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function createProduct(Request $request)
    {

        $product = new Product;
        $product->name = $request->name;
        $product->detail = $request->detail;
        $product->save();

        return response()->json([
            "message" => "Product record created"
        ], 201);
    }

    /**
     * Update existing Product
     *
     * @param Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProduct(Request $request, $id)
    {
        if (Product::where('id', $id)->exists()) {
            $product = Product::find($id);

            $product->name = is_null($request->name) ? $product->name : $product->name;
            $product->detail = is_null($request->detail) ? $product->detail : $product->detail;
            $product->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "Product not found"
            ], 404);
        }
    }

    /**
     * Delete existing Product
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */

    public function deleteProduct($id)
    {
        if (Product::where('id', $id)->exists()) {
            $product = Product::find($id);
            $product->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Product not found"
            ], 404);
        }
    }
}
