<div class="row">
    <div class="col-md-8 offset-md-2">

        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-9">
                        <h5>Orden detalle #<?php echo $request->request_id ?></h5>
                        <h6 class="text-danger">Orden detalle #<?php echo $charge_id ?></h6>
                        <p class="card-text">Gracias por su compra, esperamos verle pronto :).</p>
                    </div>
                    <div class="col-md-3">
                        <img class="logo img-fluid" src="<?php echo base_url() . 'assets/img/logo_black.png' ?>">
                    </div>
                </div>
            </div>

            <hr>
            <ul class="list-group list-group-flush list-pay-product">
                <?php foreach ($products as $key => $product) : ?>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="https://dummyimage.com/600x400/55595c/fff" alt="Card image cap" class="card-img-top">        
                            </div>
                            <div class="col-md-9">
                                <h5><?php echo $product->title ?></h5>
                                <h6><?php echo $product->category ?></h6>

                                <p class="text-right"><?php echo $product->price ?>$ x <?php echo $product->count ?> = <span class="text-danger"><?php echo $product->total ?>$</span></p>

                                <p><a class="text-danger" target="blank" href='<?php echo base_url() . "store/" . $product->curl_clean . "/" . $product->url_clean ?>'><i class="fa fa-credit-card"></i> Comprar otra vez</a></p>
                            </div>
                        </div>


                    </li>

                <?php endforeach; ?>
                <div class="col-12">
                    <h5 class="text-right text-danger"><?php echo $request->total ?>$</h5>
                </div>
            </ul>

            <hr>

            <div class="card-body">
                <h5>Dirección: <?php echo $request->location ?></h5>
                <h5>Dirección completa:</h5>
                <p><?php echo $request->address ?></p>
            </div>
            <div class="card-body">

                <?php if ($this->session->userdata('auth_level') < 6): ?>
                    <a target="blank" href="<?php echo base_url() ?>store/requests" class="card-link btn btn-success">Ver pedidos <i class="fa fa-arrow-right"></i></a>
                    <?php endif; ?>
            </div>
        </div>
    </div>

</div>


