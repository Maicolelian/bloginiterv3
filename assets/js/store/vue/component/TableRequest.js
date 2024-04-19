const TableRequest = {
    name: "TableRequest",
    template: `<div class="container mt-4"><table class="table text-center">
     <thead class="thead-dark">    
        <tr>
            <th>
                Id
            </th>
            <th>
                Teléfono
            </th>
            <th>
                Total
            </th>
            <th>
                Ver
            </th>
        </tr>
    </thead>
        <tr v-for="(r, key) in requests">
            <td>    
                {{r.request_id}}
            </td>
            <td>    
                {{r.phone}}
            </td>
            <td>    
                {{r.total}}$
            </td>
            <td>    
                <router-link :to="{ name: 'request', params: { id: r.request_id }}" class="btn btn-primary">
                    <i class="fa fa-eye"></i>
                </router-link>
            </td>
        </tr>
    </table></div>`,
    data: function () {
        return {
            requests:[]
        }
    },
    created() {
        this.myRequests();
    },
    methods: {
         myRequests() {
                fetch(BASE_URL_REST + 'my_requests')
                    .then(response => response.json())
                    .then(res => {
                        if(res == ""){
                            console.log("Res es nulo")
                            return;
                        }
                        this.requests = res;
                    })
            },
    }
};