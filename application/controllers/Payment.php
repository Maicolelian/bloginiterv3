<?php

class Payment extends MY_Controller {

    public function __construct() {
        parent::__construct();
        // $this->optional_session_auto(1);
    }

    public function client_secret_stripe($monto) {
        // Set your secret key. Remember to switch to your live secret key in production!
// See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_92m8MOLtJC17D59nYPHbMsFO');

        $intent = \Stripe\PaymentIntent::create([
                    'amount' => $monto * 100,
                    'currency' => 'usd',
                    // Verify your integration in this guide by including this parameter
                    'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);

        $this->session->set_userdata("payment_id", $intent->id);

        echo json_encode(array('client_secret' => $intent->client_secret));
    }

    public function stripe_form() {
        $this->load->view('/store/utils/stripe_form');
    }

    public function paypal_success() {
        //echo "paypal_success";

        $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                        'AUu2CpCBrva4gbNjqB5IvdV16V93hPLgumgyL7iJgQPs64Rdrp35EepAGDE8GtDlZIwg7i44FrGDY8Eq', // ClientID
                        'EDuiWwKXnXOBtCyjYFmFiriQjvroIA8kiRdsC2iNnCqAwKwxLi_-hOsZDQlZo7YPsrHDkZCK4-Lnn0iI'      // ClientSecret
                )
        );

        //var_dump($_GET);
        // Get payment object by passing paymentId
        $paymentId = $_GET['paymentId'];
        $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);
        $payerId = $_GET['PayerID'];

// Execute payment with payer ID
        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            // Execute payment
            $result = $payment->execute($execution, $apiContext);

            $request_id = $this->session->userdata("request_id");

            if ($request_id) {
                $save = array(
                    'payment_id' => $paymentId,
                    'payment_type' => 'paypal'
                );

                $this->Request->update($request_id, $save);

                $this->parser->parse("store/template/body", array("body" => view_detail_request($request_id)));

                $this->session->set_userdata("request_id", null);
            } else {
                redirect('/store');
            }



            // var_dump($result);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }

        return;
    }

    public function paypal_cancel() {
        echo "paypal_cancel";
        return;
    }

    private function paypal_pay($total, $request_id) {
        $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                        'AUu2CpCBrva4gbNjqB5IvdV16V93hPLgumgyL7iJgQPs64Rdrp35EepAGDE8GtDlZIwg7i44FrGDY8Eq', // ClientID
                        'EDuiWwKXnXOBtCyjYFmFiriQjvroIA8kiRdsC2iNnCqAwKwxLi_-hOsZDQlZo7YPsrHDkZCK4-Lnn0iI'      // ClientSecret
                )
        );

        // After Step 2
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($total);
        $amount->setCurrency('USD');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(base_url() . 'payment/paypal_success')
                ->setCancelUrl(base_url() . 'payment/paypal_cancel');

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions(array($transaction))
                ->setRedirectUrls($redirectUrls);

        // After Step 3
        try {
            $payment->create($apiContext);
            //echo $payment;

            $approvalUrl = $payment->getApprovalLink();

            $this->session->set_userdata("request_id", $request_id);

            echo json_encode(array("url" => $approvalUrl));

            //echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            echo $ex->getData();
        }
    }

//    public function detail($c, $c2) {
//        $view['body'] = $this->load->view("store/index", NULL, TRUE);
//        $this->parser->parse("store/template/body", $view);
//         $this->load->view("store/template/body");
//        
//    }

    public function make_pay($type = "paypal") {

        //echo $type;

        if ($type == "stripe") {
            \Stripe\Stripe::setApiKey(KEY_STRIPE_SECRET);
            $payment = \Stripe\PaymentIntent::retrieve(
                            $this->session->userdata("payment_id")
            );

            if ($payment->status !== "succeeded") {
                return "Ha ocurrido un error";
            }
        }

        try {

            if ($this->input->server('REQUEST_METHOD') == "POST") {

                $products_id = $this->session->userdata("request")["products_id"];
                $products_count = $this->session->userdata("request")["products_count"];
                $phone = $this->session->userdata("request")["phone"];
                $address = $this->session->userdata("request")["address"];
                $location_id = $this->session->userdata("request")["location_id"];

                $products_count = explode(",", $products_count);
                $products_id = explode(",", $products_id);

                $products = $this->Product->getByProductsGroup($products_id);

                if (sizeof($products) > 0 && sizeof($products) == sizeof($products_count)) {

                    $save = array(
                        'phone' => $phone,
                        'address' => $address,
                        'location_id' => $location_id,
                        'user_id' => $this->session->userdata("id")
                    );

                    $request_id = $this->Request->insert($save);
                    $total = 0;
                    foreach ($products as $key => $product) {
                        $save = array(
                            'product_id' => $product->product_id,
                            'count' => $products_count[$key],
                            'price' => $product->price,
                            'total' => $product->price * $products_count[$key],
                            'request_id' => $request_id,
                        );
                        $total += $product->price * $products_count[$key];

                        $this->Request_product->insert($save);
                    }

                    $save = array(
                        'total' => $total
                    );

                    $this->Request->update($request_id, $save);

                    if ($type == "stripe") {
                        $this->pay_stripe($total, $request_id);
                    } else {
                        $this->paypal_pay($total, $request_id);
                    }


                    $res["status"] = "yes";
                    $res["id"] = $request_id;
                    $res["data"] = '<div class="alert alert-success" role="alert">Pedido #' . $request_id . ' realizado con éxito</div>';
                } else {
                    $res["data"] = '<div class="alert alert-success" role="alert">Ocurrio un error con el carrito</div>';
                }
            }






            //            $customer = \Stripe\Customer::create([
            //                        'email' => $_POST['stripeEmail'],
            //                        'source' => $_POST['stripeToken'],
            //            ]);
            //
            //            $subscription = \Stripe\Subscription::create([
            //                        'customer' => $customer->id,
            //                        'items' => [['plan' => 'weekly_box']],
            //            ]);
            //            if ($subscription->status != 'incomplete') {
            //                header('Location: thankyou.html');
            //            } else {
            //                header('Location: payment_failed.html');
            //                echo ("failed to collect initial payment for subscription");
            //            }
            //            exit;
        } catch (Exception $e) {
            //            header('Location:oops.html');
            echo ("unable to sign up customer:" . $_POST['stripeEmail'] .
            ", error:" . $e->getMessage());
        }
    }

    private function pay_stripe($total, $request_id) {

       /* $this->load->library('Stripe');

        \Stripe\Stripe::setApiKey(KEY_STRIPE_SECRET);

        $total_stripe = intval($total) * 100;

        $charge = \Stripe\Charge::create([
                    'amount' => $total_stripe,
                    'currency' => 'usd',
                    'description' => 'Tu pedido en tu TEL SPA-Vue: #' . $request_id,
                    'source' => $_POST['stripeToken'],
        ]);*/

        // data vista

        $save = array(
            'payment_id' => $this->session->userdata("payment_id")
        );

        $this->Request->update($request_id, $save);

        $this->parser->parse("store/template/body", array("body" => view_detail_request($request_id)));
    }

}
