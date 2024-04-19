Vue.component('modal-pay', {
    template: `<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="form"></div>
        <div v-html="form"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
`,
    data: function () {
        return {
            form:""
        }
    },
    created() {
        //this.stripe_form();

        $.ajax({
            url:BASE_URL + 'payment/stripe_form'
        }).done(function(resHtml){
            $("#form").html(resHtml);
           //console.log(resHtml) 
        });
    },
    methods: {
//        stripe_form() {
//            fetch(BASE_URL_REST + 'stripe_form')
//                    .then(response => response.json())
//                    .then(res => this.form = res)
//        },
    }
});