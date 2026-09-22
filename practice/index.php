<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\Payments\PaypalPayment;
use App\Payments\StripePayment;
use App\Services\PaymentService;

$paypal = new PaypalPayment();
$stripe = new StripePayment();
$service = new PaymentService($paypal);
$service->pay(500);
$service = new PaymentService($stripe);
$service->pay(200.65);
