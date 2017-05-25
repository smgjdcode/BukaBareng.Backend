<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class BackendController extends Controller
{

    public function getUser(Request $request){
        try {
            $client = new Client();
            $res = $client->request('POST', 'https://api.bukalapak.com/v2/authenticate.json', [
                'auth' => [$request['email'], $request['password']]
            ]);

            $response = json_decode($res->getBody(), true);
            if ($response['status'] == 'OK') {
                $result = array("id" => $response['user_id'], "user_name" => $response['user_name'],
                    "email" => $response['email'], "token" => $response['token']);
                return json_encode($result);
            } else {
                return $response;
            }
        } catch (\HttpException $e){
            return $e->getMessage();
        } catch (\Exception $e){
            return $e->getMessage();
        }

    }

    public function getProducts(Request $request){
        try {
            $client = new Client();
            $parameters = [
                'keywords' => $request['keyword'],
                'page' => '1',
                'per_page' => '50'
            ];
            $formattedparam = http_build_query($parameters);

            $res = $client->request('GET', "https://api.bukalapak.com/v2/products.json?{$formattedparam}", [
                'auth' => ['67287', $request['token']]
            ]);

            $arr = json_decode($res->getBody(), true);
            $products = $arr['products'];
            $result = array();
            foreach ($products as $product){
                if(isset($product['wholesale'])){
                    $lenght = sizeof($product['wholesale'])-1;
                    $prod = array("price" => $product['price'], "weight" => $product['weight'], "city" => $product["city"],
                        "image" => $product['images'][0], "desc" => $product['desc'] , "seller_name" => $product['seller_name'],
                        "product_id" => $product['id'],"lower_price" => $product['wholesale'][$lenght]['price'],
                        "lower_bound" => $product['wholesale'][$lenght]['lower_bound']);


//                    foreach ($wholesales as $wholesale){
//                        $arr = array("lower_bound" => $wholesale['lower_bound'],
//                            "price" => $wholesale['price']);
//                        array_push($prod, $arr);
//                    }
                    array_push($result, $prod);
                }

            }
            $result = array("results" => $result);
            $result = json_encode($result);
            return $result;

        } catch (\HttpException $e){
            return $e->getMessage();
        } catch (\Exception $e){

            return $e->getMessage();
        }
    }


}
