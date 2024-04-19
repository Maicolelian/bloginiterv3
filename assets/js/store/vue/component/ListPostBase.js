Vue.component('list-post-base', {
    template: `
        <div class="card p">
            <div class="card-header bg-danger">
                <list-post-base-heart v-if="p.group_user_post_id !== undefined" :p="p"></list-post-base-heart>
            </div>
            <div class="card-body">
                <router-link :to="'/' + p.c_url_clean +'/' + p.url_clean">
                    <img-post :p="p"></img-post>
                    <h3>{{ p.title }}</h3>
                    <p>{{ p.description }}</p>
                </router-link>
            </div>
        </div>`,
    props: {
        p: Object
    }
});

Vue.component('list-post-base-heart', {
    template: `
            <i @click="favorite()" :class="p.group_user_post_id > 0 ? 'fa-heart' : 'fa-heart-o'" class="fa fa-2x favorite-post"></i>`,
    props: {
        p: Object
    },
    methods: {
        heart() {
            if (this.p.group_user_post_id > 0)
                return 'fa-heart';
            return 'fa-heart-o';
        },
        favorite() {
            fetch(BASE_URL + 'spa/favorite/' + this.p.post_id)
                    .then(response => response.json())
                    .then(res => this.p.group_user_post_id = res)
        }
    }
});
