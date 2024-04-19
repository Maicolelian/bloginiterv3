stripe_formstripe_formstripe_form<form action="<?php echo base_url() ?>payment/make_pay/stripe" method="POST" style="display:none">
    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="<?php echo KEY_STRIPE_PUCLIC ?>"
        data-image="<?php echo base_url() ?>assets/img/logo_black.png"
        data-name="Mi TEL SPA-Vue"
        data-description="La tienda para comprar de todo"
        data-amount="<?php echo $this->session->userdata("request")["total_stripe"] ?>"
        data-label="Sign Me Up! ">
    </script>
    
    <!--<input name="name" value="Andres" type="hidden">-->
    
</form>
<script>
//$(".stripe-button-el").trigger("click")
</script>