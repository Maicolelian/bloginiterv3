<?php

class Store extends MY_Controller {

    public function __construct() {
        parent::__construct();
        // $this->optional_session_auto(1);
    }

    public function index() {

        $this->load->view("store/template/body");
    }

//    public function detail($c, $c2) {
//        $view['body'] = $this->load->view("store/index", NULL, TRUE);
//        $this->parser->parse("store/template/body", $view);
//         $this->load->view("store/template/body");
//        
//    }

   

    public function make_pay_stripe() {

        $this->load->library('Stripe');

        \Stripe\Stripe::setApiKey(KEY_STRIPE_SECRET);

        try {

            $charge = \Stripe\Charge::create([
                        'amount' => 20000,
                        'currency' => 'usd',
                        'description' => 'Pago de ejemplo Master CodeIgniter',
                        'source' => $_POST['stripeToken'],
            ]);

            var_dump($charge->id);


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

}
