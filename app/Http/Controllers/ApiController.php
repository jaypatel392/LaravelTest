<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Providers;
use App\Products;
use App\ProductVariations;

class ApiController extends Controller
{
    public function getBroadbandMonthlyPrice(Request $request) {
        try {
            if(!$request->get('provider_name')){
                return response(json_encode(['status' => false, 'msg' => 'Provider name is required*']), 404);
            }

            if(!$request->get('product')){
                return response(json_encode(['status' => false, 'msg' => 'Product name is required*']), 404);
            }
            $providers = Providers::with(["products" => function ($query){
                $query->where('products.name', \Request::get('product'));
            }])
            ->where('name', \Request::get('provider_name'))
            ->where('provider_type', 'broadband')
            ->get()
            ->first();
            if(!$providers){
                return response(json_encode(['status' => false, 'msg' => 'Record not found']), 404);
            }
            return response(json_encode($providers), 200);

        } catch (ModelNotFoundException $exception) {
            return response('Internal server error', 500);
        }
    }

    public function getEnergyMonthlyPrice(Request $request) {
        
        if(!$request->get('provider_name')){
            return response(json_encode(['status' => false, 'msg' => 'Provider name is required*']), 404);
        }

        if(!$request->get('product')){
            return response(json_encode(['status' => false, 'msg' => 'Product name is required*']), 404);
        }
        $providers = Providers::with(["products" => function ($query){
            $query->where('products.name', \Request::get('product'));
        }])
        ->with(["productVariations" => function ($query1){
            $query1->where('name', \Request::get('product_variation'));
        }])
        ->where('name', \Request::get('provider_name'))
        ->where('provider_type', 'energy')
        ->get()
        ->first();
        if($providers && $providers->productVariations && count($providers->productVariations) > 0){
            return response(json_encode(['price' => $providers->productVariations[0]->price]), 200);
        }
        return response(json_encode(['status' => false, 'msg' => 'Record not found']), 404);

    }

    public function UpdateEnergyPrice(Request $request) {
        $reqData = $request->all();
        if(!isset($reqData['provider_name'])){
            return response(json_encode(['status' => false, 'msg' => 'Provider name is required*']), 404);
        }

        if(!isset($reqData['product'])){
            return response(json_encode(['status' => false, 'msg' => 'Product name is required*']), 404);
        }

        if(!isset($reqData['product_variation'])){
            return response(json_encode(['status' => false, 'msg' => 'Product variation is required*']), 404);
        }

        if(!isset($reqData['new_price'])){
            return response(json_encode(['status' => false, 'msg' => 'New price is required*']), 404);
        }

        $providers = Providers::with(["products" => function ($query){
            $query->where('products.name', \Request::get('product'));
        }])
        ->with(["productVariations" => function ($query1){
            $query1->where('name', \Request::get('product_variation'));
        }])
        ->where('name', \Request::get('provider_name'))
        ->where('provider_type', 'energy')
        ->get()
        ->first();

        if($providers && $providers->productVariations && count($providers->productVariations) > 0){
            $affected = ProductVariations::where('id', $providers->productVariations[0]->id)->update(['price' => \Request::get('new_price')]);
            return response(json_encode(['success' => true, 'msg' => 'Data updated successfully.']), 200);
        }

    }
    
}
