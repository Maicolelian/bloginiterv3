Vue.component('v-pagination', window['vue-plain-pagination'])

const Home = {
    template: '#homepage'
}

const About = {
    template: '#about'
}

const router = new VueRouter({
    base: 'blogigniter/spa',
    mode: 'history',
    routes: [
        {
            path: '/',
            component: ListPost
        },
        {
            path: '/category/:category',
            component: ListCategoryPost
        },
        {
            path: '/:category/:post',
            component: DetailPost
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
        res_search: ""
    },
    methods: {
        search_post: function () {

            if (this.search == "") {
                return;
            }

            fetch(BASE_URL + 'spa/search?search=' + this.search+"&category_id="+this.search_category)
                    .then(response => response.json())
                    .then(res => this.res_search = res)
        }
    }
});