const List = {
    name: "List",
            template: `
<div class="col mt-3">
    <div class="row">
        <div class="col-xs-12 col-md-2 mb-3">
            <category v-on:clicked="onCategoryClick"></category>
        </div>
        <div class="col-xs-12 col-md-8 mb-3">
            <div class="row">
                <div class="mb-3 col-xs-12 col-md-6 col-lg-4" v-for="product in products">
                    <div class="card">
                        <img class="card-img-top" src="https://dummyimage.com/600x400/55595c/fff" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title">
                                <router-link :to="'/' + product.c_url_clean +'/' + product.url_clean">
                                    {{ product.title }}
                            </router-link>
                        </h4>
                        <p class="card-text">{{ product.description }}</p>
                        <div class="row">
                            <div class="col">
                                <p class="btn btn-danger btn-block">{{ product.price }} $</p>
                            </div>
                            <div class="col">
                                <span v-on:click="$root.add_to_car(product.product_id)" class="btn btn-primary btn-block"><i class="fa fa-shopping-cart"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3">
                <v-pagination class="mt-5 justify-content-center" v-if="pageCount > 0" :classes="bootstrapPaginationClasses" v-model="currentPage" :page-count="pageCount"></v-pagination>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-2">
        <car></car>
    </div>
</div>
</div>  `,
        data: function () {
        return {
            products: [],
            currentPage: 1,
            pageCount: 0,
            category_id: "",
            bootstrapPaginationClasses: {
            ul: 'pagination',
                    li: 'page-item',
                    liActive: 'active',
                    liDisable: 'disabled',
                    button: 'page-link'
            },
        }
        },
        created() {
            this.product()
            this.count();
        },
        methods: {
            product() {
                fetch(BASE_URL_REST + 'products/' + this.currentPage + "/" + this.category_id)
                    .then(response => response.json())
                    .then(res => this.products = res)
            },

        count() {
            fetch(BASE_URL_REST + 'product_count/' + this.category_id)
                .then(response => response.json())
                .then(res => this.pageCount = res)
            },

        onCategoryClick(c){
            
            if(c == "")
                this.category_id = ""    
            else
                this.category_id = c.product_category_id
            this.currentPage= 1;
            this.product();
            this.count();
        }
    },

    watch: {
        currentPage: function(val) {
            this.product()
        }
    }
};