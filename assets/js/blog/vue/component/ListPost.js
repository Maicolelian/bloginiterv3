const ListPost = {
    name: "ListPost",
    template: `
    <div class="list-posts">
        <div v-for="post in posts.posts" class="card post">
            <list-post-base :p="post"></list-post-base>
        </div>
        <v-pagination v-if="pageCount > 0" :classes="bootstrapPaginationClasses" v-model="currentPage" :page-count="pageCount"></v-pagination>
    </div>`,
    data: function () {
        return {
            posts: [],
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
        this.count();
    },
    methods: {
        post() {
            fetch(BASE_URL + 'spa/jpost_list/' + this.currentPage)
                    .then(response => response.json())
                    .then(res => this.posts = res)
        },
        count() {
            fetch(BASE_URL + 'spa/jpost_list_count/')
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