<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use App\Http\Repository\MassdropRepositoryImpl;
use GuzzleHttp\Client;

class BackendController extends Controller
{
    private $massdropRepositoryImpl;

    public function __construct(MassdropRepositoryImpl $massdropRepositoryImpl){
        $this->massdropRepositoryImpl = $massdropRepositoryImpl;
    }
    public function getUser(Request $request){
        try {
            $client = new Client();
            $res = $client->request('POST', 'https://api.bukalapak.com/v2/authenticate.json', [
                'auth' => [$request['email'], $request['password']]
            ]);
//            print_r($request);
            $response = json_decode($res->getBody(), true);
            if ($response['status'] == 'OK') {
                $result = array("id" => $response['user_id'], "user_name" => $response['user_name'],
                    "email" => $response['email'], "token" => $response['token']);
                return json_encode($result);
            } else {
                return json_encode($response);
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
            $results = array();
            foreach ($products as $product){
                if(isset($product['wholesale'])){
                    $lenght = sizeof($product['wholesale'])-1;

                    $prod = array("name" => $product['name'],"price" => $product['price'], "weight" => $product['weight'], "city" => $product["city"],
                        "image" => $product['images'][0], "desc" => $product['desc'], "seller_name" => $product['seller_name'],
                        "product_id" => $product['id'], "lower_price" => $product['wholesale'][$lenght]['price'],
                        "lower_bound" => $product['wholesale'][$lenght]['lower_bound'], 'is_mass_drop' => false);
                    $massdrop = $this->massdropRepositoryImpl->getByProductId($product['id']);
                    if(sizeof($massdrop) > 0){
                        $prod['is_mass_drop'] = true;
                        $prod['deadline'] =  $massdrop[0]['deadline'];
                        $prod['quantity'] = $massdrop[0]['quantity'];
                    }

                    array_push($results, $prod);
                }
            }

            $results = array("results" => $results);
            $result = json_encode($results);
            return $result;

        } catch (\HttpException $e){
            return $e->getMessage();
        } catch (\Exception $e){

            return $e->getMessage();
        }
    }


}
