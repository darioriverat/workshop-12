<?php

namespace App\Factories\Payment;

use App\Enums\OrderStatus;
use App\Order;
use Dnetix\Redirection\PlacetoPay;

class PaymentPlaceToPay implements PaymentInterface
{
    /**
     * PlaceToPay Service.
     * @var Service
     */
    private $service;
    private $order;

    /**
     * PaymentPlaceToPay constructor.
     * @param string $country
     * @param Order $order
     * @throws \Dnetix\Redirection\Exceptions\PlacetoPayException
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->service = new PlacetoPay([
            'login' => config('app.placeToPay.login'),
            'tranKey' => config('app.placeToPay.tranKey'),
            'url' => config('app.placeToPay.urlRedirection.' . $order->country),
            'rest' => [
                'timeout' => 30,
                'connect_timeout' => 5,
            ],
        ]);
    }

    public function request()
    {
        $request = $this->service->request($this->createRequest($this->order));
        if ($request->isSuccessful()) {
            return [
                'status' => $request->isSuccessful(),
                'response' => [
                    'request_id' => $request->requestId(),
                    'process_url' => $request->processUrl(),
                ],
            ];
        } else {
            return [
                'status' => $request->isSuccessful(),
                'message' => $request->status()->message(),
            ];
        }
    }

    public function response()
    {
        $response = $this->service->query($this->order->request_id);
        if ($response->isSuccessful()) {
            if ($response->status()->isApproved()) {
                return OrderStatus::PAYED;
            } else {
                return OrderStatus::PENDING;
            }
        } else {
            return OrderStatus::REJECTED;
        }
    }

    /**
     * Crear base de pago para placeToPay.
     * @param Order $order
     * @return array
     */
    public function createRequest(Order $order): array
    {
        return [
            'payment' => [
                'reference' => $order->id,
                'description' => 'Pago de ' . $order->product->name . ' (' . $order->product->description . ' )',
                'amount' => [
                    'currency' => $order->product->currency,
                    'total' => $order->payment_amount,
                ],
                'buyer' => [
                    'name' => $order->user->name,
                    'email' => $order->user->email,
                    'mobile' => $order->user->mobile,
                ],
            ],
            'expiration' => date('c', strtotime('+1 days')),
            'returnUrl' => config('app.url') . 'orders/' . $order->id,
            'cancelUrl' => config('app.url') . 'orders/' . $order->id,
            'ipAddress' => $_SERVER['HTTP_CLIENT_IP'] ?? '127.0.0.1',
            'userAgent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Chrome',
        ];
    }
}
