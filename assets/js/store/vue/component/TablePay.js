Vue.component('tablepay', {
    template: `<table class="table text-center">
        <tr>
            <th>
                Imagen
            </th>
            <th>
                Nombre
            </th>
            <th>
                Precio
            </th>
            <th>
                Cantidades
            </th>
            <th v-if="!pay">
                Eliminar
            </th>
        </tr>
        <tr v-for="(product, key) in this.$root.car_products">
            <td>    
                img
            </td>
            <td>    
                {{product.title}}
            </td>
            <td>    
                {{product.price * $root.car_count[key]}}$
            </td>
            <td v-if="!pay">    
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary" type="button"  v-on:click="$root.minus_car(product.product_id)">-</button>
                    </div>
                    <input readonly type="text" class="form-control" :value="$root.car_count[key]">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" v-on:click="$root.plus_car(product.product_id)">+</button>
                    </div>
                </div>
            </td>
            <td v-else>
                {{ $root.car_count[key] }}
            </td>
            <td v-if="!pay">    
                <button class="btn btn-danger">
                    <i class="fa fa-remove" v-on:click="$root.delete_to_car(product.product_id)"></i>
                </button>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            </td>
            <td>
                <h4>{{this.$root.total()}}$</h4>
            </td>
            <td colspan="2">
            </td>
        </tr>
    </table> `,
    props: {
        pay: {
            type: Boolean,
            default: false
        }
    },
    created() {
        
    },
    methods: {
       
    }
});