<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\MercadoLivre;
use App\Models\MercadoLivreData;
use App\Models\ProductML;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;


class MercadoLivreController extends Controller
{
    public function index()
    {
        $contasML = MercadoLivreData::get();
        return view('Backend.ml.index', compact('contasML'));
    
    }
    public function handleAuth()
    {
        $auth = new MercadoLivre();
        $authUrl = $auth->getAuthUrl();

        return redirect($authUrl);
    }

    public function getMLData(Request $request)
    {

        $dadosMercadoLivre = MercadoLivreData::where('id', $request->mlId)->first();

        return response()->json($dadosMercadoLivre);
    }
    public function handleMercadoLibreCallback(Request $request)
    {

        $code = $request->query('code');
        $userID = session('userData')->id;
        $auth = new MercadoLivre();
        $data = $auth->handleCallback($code);
        $userML = $auth->getUserDataML($data['access_token']);

        $verify = MercadoLivreData::firstOrNew(['id_ml' => $userML['id']]);



        if ($verify->exists) {

            flash('Conta já Vinculada')->error();
        } else {
            $mercadoLivreData = new MercadoLivreData();
            $mercadoLivreData->user_id = $userID;
            $mercadoLivreData->nickname = $userML['nickname'];
            $mercadoLivreData->id_ml = $userML['id'];
            $mercadoLivreData->first_name = $userML['first_name'];
            $mercadoLivreData->last_name = $userML['last_name'];
            $mercadoLivreData->email = $userML['email'];
            $mercadoLivreData->address = $userML['address']['address'];
            $mercadoLivreData->city = $userML['address']['city'];
            $mercadoLivreData->state = $userML['address']['state'];
            $mercadoLivreData->zip_code = $userML['address']['zip_code'];
            $mercadoLivreData->refresh_token = $data['refresh_token'];
            $mercadoLivreData->phone = $userML['alternative_phone']['area_code'] . $userML['alternative_phone']['number'];
            $mercadoLivreData->permalink = $userML['permalink'];
            $mercadoLivreData->access_token = $data['access_token'];
            $mercadoLivreData->save();
        }

        return redirect('/admin/auth/mercadolibre');
    }
    public function getCategories()
    {
        $userID = session('userData')->id;
        $token = MercadoLivreData::where('user_id', $userID)->first();
        $client = new Client();
        $headers = [
            'Authorization' => 'Bearer ' . $token->token
        ];
        $body = '';
        $request = new Psr7Request('GET', 'https://api.mercadolibre.com/sites/MLB/categories', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        echo $res->getBody();
    }

    public function deleteContaML(Request $request)
    {


        // dd($request->all());
        ProductML::where('id_conta_ml', $request->id)->delete();
        $mercadoLivreData = MercadoLivreData::where('id', $request->id)->first();

        if ($mercadoLivreData) {
            // Se o registro existe, você pode excluí-lo
            $mercadoLivreData->delete();
            flash('Deletado Com Sucesso.')->success();
        }

        return redirect('/admin/auth/mercadolibre');
        // Agora o registro foi excluído do banco de dados
    }
    public function getLinksML(Request $request)
    {

        $products = ProductML::select('permalink')->where('product_id', $request->mlId)->get();
        $data = array('links' => $products);
        return response()->json($data);
    }
}
