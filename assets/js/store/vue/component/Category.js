Vue.component('category', {
    template: `
            <ul class="list-group">
              <li v-on:click="setCategory(c)" v-for="c in categories" class="list-group-item"><a href="#"><i v-if="c == category" class="fa fa-check"></i> {{c.name}}</a></li>
            </ul> 
            `,
    data: function () {
        return {
            category: "",
            categories: []
        }
    },
    created() {
        this.getCategory()
    },
    methods: {
        getCategory() {
            fetch(BASE_URL_REST + 'categories/')
                    .then(response => response.json())
                    .then(res => this.categories = res)
        },
        setCategory(c) {
            if (c == this.category)
                this.category = ""
            else
                this.category = c;
            this.$emit('clicked', this.category)
        }
    }
});