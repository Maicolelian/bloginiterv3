Vue.component('car', {
    template: `<div> 
        <div class="col-12 car-products" v-for="product in this.$root.car_products">
            <div class="card mt-2"> 
                <div class="card-body">
                    <i class="fa fa-remove text-danger close right" v-on:click="$root.delete_to_car(product.product_id)"></i>
                    <p>{{product.title}}</p>
                </div>    
            </div>
        </div>
        <div class="col-12 mt-2">
            <router-link v-if="$root.car_products.length > 0 && $root.ifAuth()" to="/checkout" class="btn btn-success btn-block">
                 Checkout <i class="fa fa-arrow-right"></i>
             </router-link>    
        </div>
    </div>`
});