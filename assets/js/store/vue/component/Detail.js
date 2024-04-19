const Detail = {
    name: "Detail",
    template: `
    <div class="row mt-3">
        <div class="col-xs-12 col-md-2"></div>
        <div class="col-xs-12 col-md-8">
            <div v-if="detail" class="card detail-post">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <h1>{{ detail.title }}</h1>
                    <span v-on:click="$root.add_to_car(detail.product_id)" class="btn btn-success"><i class="fa fa-shopping-cart"></i></span>
                    <span class="btn btn-danger">{{ detail.price }} $</span>
                    <div class="mt-3" v-html="detail.content"></div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-2">
            <car></car>
        </div>
    </div>`,
    data: function () {
        return {
            detail: []
        }
    },
    created() {
        this.product()
    },
    methods: {
        product() {
            fetch(BASE_URL_REST + '/product_by_url_clean/' + this.$route.params.url_clean)
                    .then(response => response.json())
                    .then(res => this.detail = res)
        },
        imagePost(image) {
            return BASE_URL + 'uploads/post/' + image;
        }
    }
}