const Checkout = {
    name: "Checkout",
    template: `<div class="container"> 
        <h2 class="text-center">Checkout</h2>
        <div class="col-4">
            <router-link to="/" class="btn btn-primary btn-block">
                <i class="fa fa-arrow-left"></i> Regresar
            </router-link>
        </div>
        <div class="mt-4">
            <tablepay></tablepay>
        </div>
         <div class=" offset-8 col-4">
            <router-link v-if="$root.ifAuth()" to="/pay" class="btn btn-success btn-block">
                Pagar <i class="fa fa-arrow-right"></i>
            </router-link>
        </div>
    </div>`,
    data: function () {
        return {
            
        }
    },
    async created() {
        
        auth = this.$root.authenticate_test();

        auth = await this.$root.authenticate_test();

//        auth.then(data => {
//            console.log("data usuario: "+data.id)
//            if(data.id > 0){
//                console.log("usuario autenticado")
//            }
//        })

        console.log(auth.id);
        
        var self = this;
        setTimeout(function(){
            self.$root.login_need();
            self.$root.products_need();    
        },2000);
    },
    methods: {
 
    }
};