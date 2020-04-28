<?php


namespace App\Traits;

use App\Enums\CountryOptions;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\Facades\Config;

trait PlaceToPayService
{
    
    /**
     * Crear base de pago para placeToPay
     * @return request
     */
    public static function createRequest($order)
    {
        // print_r($Order);
        $request = [
            'payment' => [
                'reference' => $order->id,
                'description' => 'Pago de ' . $order->product->name . ' (' . $order->product->description . ' )',
                'amount' => [
                    'currency' => $order->product->currency,
                    'total' => $order->paymentAmount,
                ],
                "payer" => [
                    "name" =>  $order->user->name,
                    "email" => $order->user->email,
                    "mobile" => $order->user->mobile,
                ],
                "buyer" => [
                    "name" =>  $order->user->name,
                    "email" => $order->user->email,
                    "mobile" => $order->user->mobile,
                ],
                "shipping" => [
                    "name" =>  $order->user->name,
                    "email" => $order->user->email,
                    "mobile" => $order->user->mobile,
                ]
            ],
            'expiration' => date('c', strtotime('+1 days')),
            'returnUrl' => env('APP_URL') . "orders/" . $order->id,
            'cancelUrl' => env('APP_URL') . 'orders/' . $order->id,
            'ipAddress' => $_SERVER['HTTP_CLIENT_IP'] ?? '127.0.0.1',
            'userAgent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Chrome'
        ];
        

        return $request;
    }
    /**
     * Crear una instancia del Servicio de Place to play
     * @return servicio
     */
    public static function createServicePlaceToPay($country)
    {
        $placetopay = new PlacetoPay([
            'login' => Config::get('placeToPay.login'),
            'tranKey' =>Config::get('placeToPay.tranKey'),
            'url' =>Config::get('placeToPay.urlRedirection.'.$country),
            'rest' => [
                'timeout' => 30, 
                'connect_timeout' => 5, 
            ]
        ]);
        return $placetopay;
    }
    /**
     * Obtiene informacion de una transaccion en placeToPay
     * @param requestId codigo unico de transaccion de PlaceToPay
     */
    public static function requestInformation($requestId,$country)
    {
        $servicePlaceToplay = PlaceToPayService::createServicePlaceToPay($country);
        $response = $servicePlaceToplay->query($requestId);

        if ($response->isSuccessful()) {
            return $response->status();
        } else {
            return ($response->status()->message() . "\n");
        }
    }
}