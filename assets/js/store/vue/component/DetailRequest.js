const DetailRequest = {
    name: "DetailRequest",
    template: `
    <div class="container mt-3 mb-3">
        <div v-html="detail"></div>
    </div>`,
    data: function () {
        return {
            detail: ""
        }
    },
    created() {
        this.getDetail()
    },
    methods: {
        getDetail() {
            fetch(BASE_URL_REST + '/my_request_detail/' + this.$route.params.id)
                    .then(response => response.json())
                    .then(res => this.detail = res)
        }
    }
}