<?php


namespace App\Traits;
use Dnetix\Redirection\PlacetoPay;

trait PlaceToPayService
{
    
    /**
     * Crear base de pago para placeToPay
     * @return request
     */
    public static function createRequest($myOrder)
    {
        // print_r($myOrder);
        $request = [
            'payment' => [
                'reference' => $myOrder->id,
                'description' => 'Pago de ' . $myOrder->name . ' (' . $myOrder->description . ' )',
                'amount' => [
                    'currency' => 'COP',
                    'total' => $myOrder->paymentAmount,
                ],
                "payer" => [
                    "name" =>  $myOrder->customer_name,
                    "email" => $myOrder->customer_email,
                    "mobile" => $myOrder->customer_mobile,
                ],
                "buyer" => [
                    "name" =>  $myOrder->customer_name,
                    "email" => $myOrder->customer_email,
                    "mobile" => $myOrder->customer_mobile,
                ],
                "shipping" => [
                    "name" =>  $myOrder->customer_name,
                    "email" => $myOrder->customer_email,
                    "mobile" => $myOrder->customer_mobile,
                ]
            ],
            'expiration' => date('c', strtotime('+1 days')),
            'returnUrl' => env('APP_URL') . "orders/" . $myOrder->id,
            'cancelUrl' => env('APP_URL') . 'orders/' . $myOrder->id,
            'ipAddress' => $_SERVER['HTTP_CLIENT_IP'] ?? '127.0.0.1',
            'userAgent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Chrome'
        ];
        

        return $request;
    }
    /**
     * Crear una instancia del Servicio de Place to play
     * @return servicio
     */
    public static function createServicePlaceToPay()
    {
        $placetopay = new PlacetoPay([
            'login' => env('SOAP_LOGIN'),
            'tranKey' => env('SOAP_TRANKEY'),
            'url' => env('SOAP_URL_REDIRECTION'),
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
    public static function requestInformation($requestId)
    {
        $servicePlaceToplay = PlaceToPayService::createServicePlaceToPay();
        $response = $servicePlaceToplay->query($requestId);

        if ($response->isSuccessful()) {
            return $response->status();
        } else {
            return ($response->status()->message() . "\n");
        }
    }
}