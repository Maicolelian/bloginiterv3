<form action="<?php echo base_url() ?>store/make_pay_stripe" method="POST">
    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="<?php echo KEY_STRIPE_PUCLIC ?>"
        data-image="<?php echo base_url() ?>assets/img/logo_black.png"
        data-name="Emma's Farm CSA"
        data-description="Subscription for 1 weekly box"
        data-amount="10000"
        data-label="Sign Me Up!">
    </script>
</form>