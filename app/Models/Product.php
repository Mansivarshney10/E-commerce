<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Response;

class Product extends Model
{
    /**
     * It is a trait that links a Eloquent model to a model factory
     */
    use HasFactory; 

    protected $fillable = [
        'name', 'price', 'description', 'image'
    ];

    /**
     * Get all product data from the table
     */
    public function getProductList(){

        $product = $this->all();

        $returnData = $this->arrangeData($product);
        return $returnData;
    }

    /**
     * Foreach loop for storing data in an array
     */
    public function arrangeData($data){

        $returnData = array();

        foreach($data as $key=>$value){
            $returnData[] = $value->attributes;
        }

        return $returnData;
    }

    /**
     * Find Product By ID
     */
    public function getCartList($id){

        $product = Product::find($id);
        return $product;

    }

    /**
     * Joining Product, ProductDetails, ProductDescription, ProductImages to return values on Product-Display
     */
    public function getProductData($id){

        $product = Product::find($id)->toArray();
        $product['productDetails'] = ProductDetails::where('id', '=', $id)->get()->toArray();
        $product['productDescription'] = ProductDescription::where('id', '=', $id)->get()->toArray();
        $product['productImages'] = ProductImages::where('id', '=', $id)->get()->toArray();

        return $product;
    }

    /**
     * Displaying results for products other than what the user selected
     */
    public function productNotIn($id){
        
        $product = Product::select("*")->whereNotIn('id', [$id])->get();
        return $product; 
    }

}
