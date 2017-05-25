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
}
