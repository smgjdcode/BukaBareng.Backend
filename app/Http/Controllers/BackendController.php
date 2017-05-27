<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use App\Http\Repository\MassdropRepositoryImpl;
use GuzzleHttp\Client;
use App\Http\Repository\TransactionRepositoryImpl;
use App\Http\Repository\UserRepositoryImplemented;
use Illuminate\Support\Facades\DB;

class BackendController extends Controller
{
    private $massdropRepositoryImpl;
    private $userRepositoryImpl;
    private $transactionRepositoryImpl;

    public function __construct(MassdropRepositoryImpl $massdropRepositoryImpl, UserRepositoryImplemented $userRepositoryImplemented
    ,TransactionRepositoryImpl $transactionRepositoryImpl ){
        $this->massdropRepositoryImpl = $massdropRepositoryImpl;
        $this->userRepositoryImpl = $userRepositoryImplemented;
        $this->transactionRepositoryImpl = $transactionRepositoryImpl;
    }
//    public function getUser(Request $request){
//        try {
//            $client = new Client();
//            $res = $client->request('POST', 'https://api.bukalapak.com/v2/authenticate.json', [
//                'auth' => [$request['email'], $request['password']]
//            ]);
////            print_r($request);
//            $response = json_decode($res->getBody(), true);
//            if ($response['status'] == 'OK') {
//                $result = array("id" => $response['user_id'], "user_name" => $response['user_name'],
//                    "email" => $response['email'], "token" => $response['token']);
//                return json_encode($result);
//            } else {
//                return json_encode($response);
//            }
//        } catch (\HttpException $e){
//            return $e->getMessage();
//        } catch (\Exception $e){
//            return $e->getMessage();
//        }
//
//    }

    public function getUser($id){
        try{
            $user = $this->userRepositoryImpl->getById($id);
            if(sizeof($user) > 0) {
                $result = array('user_id' => $user['id'], 'user_name' => $user['username'],
                    'balance' => $user['balance']);
            } else {
                $result = array('status' => "404");
            }
            return json_encode($result);
        } catch (\Exception $e){
           return  $e->getMessage();
        }
    }

    public function getUserTransaction($user_id){
//        $transactions = $this->transactionRepositoryImpl->getByUserId($user_id);
        try {
            $query = 'Select t.id, t.bought_time, m.deadline, m.lower_price, m.lower_bound, m.quantity, t.status from buys t inner join massdrops m on m.id = t.massdrop_id where t.user_id =  ?  ';
            $transactions = DB::select($query, [$user_id]);
            foreach ($transactions as $transaction) {
                if($transaction->status < 3) {
                    if ($transaction->bought_time <= $transaction->deadline) {
                        if ($transaction->quantity < $transaction->lower_bound) {
                            $res = $this->transactionRepositoryImpl->updateStatus($transaction->id, 2);
                        } elseif ($transaction->quantity >= $transaction->lower_bound) {
                            $res = $this->transactionRepositoryImpl->updateStatus($transaction->id, 1);
                        }
                    } else {
                        $res = $this->transactionRepositoryImpl->updateStatus($transaction->id, 0);
                    }
                }
            }
            $query = 'Select  t.id, t.bought_time, m.product_img, m.lower_price, m.product_name, t.jumlah, t.status from buys t inner join massdrops m on m.id = t.massdrop_id where t.user_id =  ?  ';
            $transacts = DB::select($query, [$user_id]);
            $result = array();
            foreach ($transacts as $transact){
                $hasil = array('id_transaksi' => $transact->id, 'nama_barang' => $transact->product_name, 'quantity' => $transact->jumlah,
                    'harga_barang' => $transact->lower_price, 'tanggal_pembelian' => $transact->bought_time,
                    'status' => $transact->status, "gambar" => $transact->product_img);
                array_push($result, $hasil);
            }
            $results = array("results" => $result);
            return json_encode($results);
        } catch (\Exception $e){
            return $e->getMessage();
        }


//        if($transactions > 0){
//            foreach ($transactions as $transaction){
//                $hasil = array($transaction['']);
//            }
//        }
    }

    public function createTransaction(Request $request){
        try{
            $attributes = array('user_id' => $request['user_id'], 'massdrop_id' => $request['massdrop_id'],
                'jumlah' => $request['jumlah'], 'product_id' => $request['product_id'], 'status' => 2 ,
                'bought_time' => date("Y-m-d"));
            $this->transactionRepositoryImpl->create($attributes);
            $massdrop = $this->massdropRepositoryImpl->getById($request['massdrop_id']);
            $qty = $massdrop['quantity'] + $request['jumlah'];
            $result = $this->massdropRepositoryImpl->updateQuantity($request['massdrop_id'], $qty);
            return json_encode(array('status' => "Succes"));
        } catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function createUser(Request $request){
        try {
            $users = $this->userRepositoryImpl->getById($request['id']);
            if(sizeof($users) < 1){
                $attributes = array('id' => $request['id'], 'balance' => $request['balance'],
                    'username' => $request['username']);
                $this->userRepositoryImpl->create($attributes);
                $status = array("results" => array("status" => "OK"));
                return json_encode($status);
            } else {
                $status = array("results" => array("status" => "User sudah ada"));
                return json_encode($status);
            }
        } catch (\HttpException $e){
            return $e->getMessage();
        } catch (\Exception $e){
            return $e->getMessage();
        }
    }


    public function createPayment(Request $request){
        try {
//            $query = 'Select  u.balance, t.jumlah, m.lower_price ';
//            $transacts = DB::select($query, [$user_id]);
            $transaction = $this->transactionRepositoryImpl->getById($request['transaction_id']);
            $total_payment = $request['total_payment'];
            if(sizeof($transaction) > 0){
                $user_id = $transaction['user_id'];
                $user = $this->userRepositoryImpl->getById($user_id);
                $remaining_balance = $user['balance'] - $total_payment;
                if($remaining_balance < 0){
                    $status = array("status" => "failed");
                } else {
                    $res = $this->userRepositoryImpl->updateBalance($user_id,$remaining_balance);
                    $status = array("status" => "succes");
                    $res = $this->transactionRepositoryImpl->updateStatus($transaction['id'], 3);
                }
                return json_encode($status);
            }
            $status = array("status" => "failed");
            return json_encode($status);
        } catch (\Exception $e){
           return $e->getMessage();
        }

    }

//    public function getMassdrop($id){
//        try{
//            $massdrop = $this->massdropRepositoryImpl->getById($id);
//
//            if(sizeof($massdrop) > 0){
//                $result = array('')
//            }
//
//        } catch (\Exception $e){
//            $e->getMessage();
//        }
//    }

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
                        $prod['massdrop_id'] = $massdrop[0]['id'];
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
