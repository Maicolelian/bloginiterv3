Vue.component('category-post', {
    template: `<router-link class="btn btn-danger" :to="'/category/' + p.c_url_clean">
                    {{p.category}}
                </router-link>`,
    props: {
        p: Object
    }
})
