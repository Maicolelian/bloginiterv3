const Pay = {
    name: "Pay",
    template: `<div class="container"> 
    <h2 class="text-center">Pagar</h2>
    <div class="col-4">
        <router-link to="/checkout" class="btn btn-primary btn-block">
            <i class="fa fa-arrow-left"></i> Regresar
        </router-link>
    </div>
    <div class="mt-4">
        <h4 class="text-center mb-3">Tus productos</h4>
        <tablepay :pay="pay"></tablepay>
    </div>
    
   <div class="offset-2 col-8">
        <div class="form-group">
            <h4 class="text-center mb-3">Datos del pedido</h4>
    
            <span v-html="error"></span>
    
            <select class="form-control" v-model="location">
                <option value=""></option>
                <option v-for="l in locations" :value="l.location_id">{{ l.name }}</option>
            </select>
        </div>
        
        <div class="form-group">
            <input class="form-control" type="text" v-model="phone" placeholder="Coloca tu teléfono">
        </div>
        <div class="form-group">
            <textarea class="form-control" type="text" v-model="address" placeholder="Coloca tu dirección"></textarea>
        </div>
    
        <div class="row">
            <div class="col-6">
                <button v-if="$root.ifAuth() && !request_success"  no-funciona-data-toggle="modal" no-funciona-data-target="#exampleModal" v-on:click="sendDataPayPal()" class="btn btn-primary btn-block mb-5">
                    <i class="fa fa-paypal"></i> Pedir <i class="fa fa-arrow-right"></i>
                </button>
            </div>
            <div class="col-6">
                <button v-if="$root.ifAuth() && !request_success" data-toggle="modal" data-target="#exampleModal" v-on:click="createCardStripe()" class="btn btn-danger btn-block mb-5">
                    <i class="fa fa-cc-stripe"></i> Pedir <i class="fa fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
    
    <modal-pay></modal-pay>
    
</div>`,
    data: function () {
        return {
            pay:true,
            request_success: false,
            error: "",
            location:"1",
            phone:"11111111",
            address:"Direccion de prueba paypal",
            locations: [
                {location_id: 1, name:"Venezuela"},
                {location_id: 2, name:"Colombia"},
                {location_id: 3, name:"España"},
                {location_id: 4, name:"Argentina"},
                {location_id: 5, name:"México"}
            ]
        }
    },
    created() {
        var self = this;
        setTimeout(function(){
            self.$root.login_need();
            self.$root.products_need();    
        },2000);
        
    },
    methods: {
        sendDataStripe(){
         var formData = new FormData();
 
         formData.append("address",this.address)
         formData.append("location_id",this.location)
         formData.append("phone",this.phone)
         formData.append("products_id", $cookies.get("car"))
         formData.append("products_count",$cookies.get("car_count"))
         
         fetch(BASE_URL_REST + 'request',{
             method: 'POST',
             body:formData
         })
           .then(response => response.json())
           .then(res => {
               
               if(res.status == "yes"){
                   this.error = "";
                   //$(".stripe-button-el").trigger("click");
                  // $cookies.set("car",[])
                   //$cookies.set("car_count",[])
                   this.makePayStripe()
                   this.request_success = true;
               }else{
                   // errores en el formulario
                   this.error = res.data
               }
               
           })
         
         
        },
        makePayStripe(){
            
         fetch(BASE_URL + 'payment/make_pay/stripe',{
             method: 'POST'
         })
           .then(response => response.json())
           .then(res => {
               
            
               
           })
            
            
        },
        sendDataPayPal(){
         var formData = new FormData();
 
         formData.append("address",this.address)
         formData.append("location_id",this.location)
         formData.append("phone",this.phone)
         formData.append("products_id", $cookies.get("car"))
         formData.append("products_count",$cookies.get("car_count"))
         
         fetch(BASE_URL_REST + 'request',{
             method: 'POST',
             body:formData
         })
           .then(response => response.json())
           .then(res => {
               
               if(res.status == "yes"){
                   this.error = "";
                   
                   this.getPayPalLink();
                   
                   $cookies.set("car",[])
                   $cookies.set("car_count",[])
                   this.request_success = true;
               }else{
                   // errores en el formulario
                   this.error = res.data
               }
               
           })
         
         
        },
        
        createCardStripe(){
            self = this
            var stripe = Stripe('pk_test_FDvgwaBIJgFDGFQRKdeAO7VM');
            var elements = stripe.elements();

            var style = {
                base: {
                    color: "#32325d",
                }
            };

            var card = elements.create("card", {style: style});
            card.mount("#card-element");

            card.on('change', ({error}) => {
                const displayError = document.getElementById('card-errors');
                if (error) {
                    displayError.textContent = error.message;
                } else {
                    displayError.textContent = '';
            }
            });

            var response = fetch(BASE_URL+'payment/client_secret_stripe/'+this.$root.total()).then(function (response) {
                return response.json();
            }).then(function (responseJson) {
                var clientSecret = responseJson.client_secret;
                // Call stripe.confirmCardPayment() with the client secret.
                var form = document.getElementById('payment-form');

                form.addEventListener('submit', function (ev) {
                    ev.preventDefault();
                    stripe.confirmCardPayment(clientSecret, {
                        payment_method: {
                            card: card,
                            billing_details: {
                                name: 'Jenny Rosen'
                            }
                        }
                    }).then(function (result) {
                        if (result.error) {
                            // Show error to your customer (e.g., insufficient funds)
                            console.log(result.error.message);
                        } else {
                            // The payment has been processed!
                            console.log(result.paymentIntent)
                            if (result.paymentIntent.status === 'succeeded') {
                                
                                self.sendDataStripe()
                                
                                // Show a success message to your customer
                                // There's a risk of the customer closing the window before callback
                                // execution. Set up a webhook or plugin to listen for the
                                // payment_intent.succeeded event that handles any business critical
                                // post-payment actions.
                            }
                        }
                    });
                });
            });
        },
        
        getPayPalLink(){
            
         fetch(BASE_URL + 'payment/make_pay',{
             method: 'POST'
         })
           .then(response => response.json())
           .then(res => {
               
               if(res.url){
                   console.log(res.url)
                   window.location.href = res.url
               }else{
                   // errores en el formulario
                   this.error = "Error al momento de generar el link de paypal"
               }
               
           })
            
            
        }
    }
};