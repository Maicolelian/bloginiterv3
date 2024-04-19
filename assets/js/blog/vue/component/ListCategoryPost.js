const ListCategoryPost = {
    name: "ListCategoryPost",
    template: `
    <div class="list-posts">
        <h1>{{ data.title }}</h1>
        <hr>
        <div v-for="post in data.posts" class="card post">
            <list-post-base :p="post"></list-post-base>
        </div>
        <v-pagination v-if="pageCount > 0" :classes="bootstrapPaginationClasses" v-model="currentPage" :page-count="pageCount"></v-pagination>
    </div>`,
    data: function () {
        return {
            data: [],
            currentPage: 1,
            pageCount: 0,
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
        this.post()
        this.count()
    },
    methods: {
        post() {
            fetch(BASE_URL + '/spa/j_post_list_category/' + this.$route.params.category + "/" + this.currentPage)
                    .then(response => response.json())
                    .then(res => this.data = res)
        },
        count() {
            fetch(BASE_URL + 'spa/j_post_list_category_count/' + this.$route.params.category)
                    .then(response => response.json())
                    .then(res => this.pageCount = res)
        }
    },
    watch: {
        currentPage: function (val) {
            this.post()
        }
    }
}