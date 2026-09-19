<?php
require_once("PaymentGateway.php");
class PaymentService {
    public function __construct(private PaymentGateway $paymentGateway){}

    public function pay(float $amount){
        $this->paymentGateway->pay($amount);
    }
}