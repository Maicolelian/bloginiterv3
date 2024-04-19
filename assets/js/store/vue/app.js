Vue.component('v-pagination', window['vue-plain-pagination'])

const router = new VueRouter({
    base: 'blogigniter/store',
    mode: 'history',
    routes: [
        {
            path: '/',
            component: List
        },
        {
            path: '/checkout',
            component: Checkout
        },
        {
            path: '/requests',
            component: TableRequest
        },
        {
            name: "request",
            path: '/request/:id',
            component: DetailRequest
        },
        {
            path: '/pay',
            component: Pay
        },
        {
            path: '/:c_url_clean/:url_clean',
            component: Detail
        }

    ],
    linkActiveClass: 'active',
    linkExactActiveClass: 'current'
});

var app = new Vue({
    el: "#app",
    router,
    data: {
        search: "",
        search_category: "",
        res_search: "",
        key_add_car: 0,
        car: [],
        car_count: [],
        car_products: [],
        // person
        auth: [],
        base_url: BASE_URL
    },
    created() {

        this.authenticate()
        console.log(this.ifAuth())

        if ($cookies.get("car") !== null) {
            this.car = $cookies.get("car").split(",")
            this.product_car()
        }
        if ($cookies.get("car_count") !== null) {
            this.car_count = $cookies.get("car_count").split(",")
        }
    },
    methods: {
        product_car() {
            fetch(BASE_URL_REST + 'products_by_group?products_id=' + this.car.toString())
                    .then(response => response.json())
                    .then(res => this.car_products = res)
        },
        delete_to_car(product_id) {
            index = this.car.indexOf(product_id)
            if (index >= 0) {
                this.car.splice(index, 1)
                this.car_products.splice(index, 1)
                this.car_count.splice(index, 1)

                $cookies.set("car", this.car)
                $cookies.set("car_count", this.car_count)

                // refresca la info de los productos y obliga a repintar el componente
                this.product_car();
            }
        },
        add_to_car(product_id) {
            if (this.car.indexOf(product_id) == -1) {
                this.car.push(product_id)
                $cookies.set("car", this.car)

                this.car_count.push(1)
                $cookies.set("car_count", this.car_count)

                // refresca la info de los productos y obliga a repintar el componente
                this.product_car();

                // this.$root.key_add_car = product_id
            }
        },
        minus_car(product_id) {
            index = this.car.indexOf(product_id)
            if (index >= 0) {

                this.car_count[index] = parseInt(this.car_count[index]) - 1

                if (this.car_count[index] <= 0) {
                    this.delete_to_car(product_id);
                }

                n = this.car_count.length - 1
                this.car_count[n] = this.car_count.pop()

                $cookies.set("car_count", this.car_count)
            }
        },
        plus_car(product_id) {
            index = this.car.indexOf(product_id)
            if (index >= 0) {

                this.car_count[index] = parseInt(this.car_count[index]) + 1

                n = this.car_count.length - 1
                this.car_count[n] = this.car_count.pop()

                $cookies.set("car_count", this.car_count)
            }
        },
        total: function () {
            return this.car_products.reduce(function (total, product, i) {
                return total + parseFloat(product.price) * $cookies.get("car_count").split(",")[i];
            }, 0);
        },
        // usuario
        authenticate() {
            fetch(BASE_URL_REST_PERSON + 'authenticate')
                    .then(response => response.json())
                    .then(res => this.auth = res)
        },
        async authenticate_test() {
            console.log("Hola mundo");
            var res = await fetch(BASE_URL_REST_PERSON + 'authenticate')
            res = res.json();
            console.log("Otra cosa");
            return res;
        },
        ifAuth() {
            return (this.auth.id != 0 && this.auth.id != undefined)
        },
        login_need() {
            if (!this.ifAuth()) {
                router.push({path: '/'})
            }
        },
        products_need() {
            if ($cookies.get("car") == null || $cookies.get("car") == "") {
                router.push({path: '/'})
            }
        },
        hi() {
            return "Hola " + this.auth.name
        },
        url_login() {
            return this.base_url + "login"
        }
    }
});