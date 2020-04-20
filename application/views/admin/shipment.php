<body>

    <!-- ini navbar -->
    <div class="row my-5 pb-5">
        <nav class="navbar navbar-expand-lg navbar-tertiary navbar-dark bg-tertiary py-2 fixed-top">
            <div class="container">
                <a class="navbar-brand" href="<?php echo site_url(); ?>dashboard"><strong>IT - Clinic</strong></a>
                </button>
                <div class="navbar-collapse" id="navbar_main">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url(); ?>dashboard/admin_view_shipment">Request Pengiriman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url(); ?>dashboard/admin_view_history">Request History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url(); ?>dashboard/admin_view_account">List User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url(); ?>dashboard/admin_verify_account">Verify User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-icon" href="#" id="" role="button" data-toggle="dropdown">
                                <i class="fas fa-bell">
                                    <span class="badge badge-danger text-light"><?php echo $notify; ?></span>
                                </i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-xl py-0">
                                <div class="py-3 px-3">
                                    <h5 class="heading h6 mb-0">User Pending List</h5>
                                </div>
                                <div class="list-group">
                                    <?php foreach ($unverified_account as $rows2) {
                                    ?>
                                        <a href="<?php echo site_url(); ?>dashboard/admin_verify_account" class="list-group-item list-group-item-action d-flex align-items-center">
                                            <div class="list-group-content">
                                                <div class="list-group-heading">
                                                    <?php echo $rows2->user; ?>
                                                </div>
                                            </div>
                                        </a>
                                    <?php
                                    } ?>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url(); ?>login/logout">Log Out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- akhir navbar -->

    <div class="row px-5 mx-5">

        <div class="col-md-6">
            <h4>Ready for Shipment :</h4>
        </div>

        <div class="col-md-6 d-flex flex-row-reverse">
            <form class="form-inline" action="<?php echo site_url(); ?>dashboard/admin_view_shipment" method="POST">
                <div class="input-group">
                    <input type="text" class="form-control border border-tertiary" id="keyword" name="keyword" placeholder="nama customer, tgl selesai">
                    <div class="input-group-append">
                        <button class="btn btn-outline-tertiary" type="submit" style="padding: 7px 20px; font-size: 12px;">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div><br><br><br>

    <div class="row mx-5">
        <div class="col md-12">
            <?php
            if ($this->session->flashdata('message') != '') {
            ?>
                <div class="alert alert-primary">
                    <?php echo $this->session->flashdata('message'); ?>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="row py-5 px-5 mx-5">
        <?php foreach ($request as $rows2) { ?>
            <div class="col-md-6 my-3">
                <div class="card shadow-lg">
                    <div class="row no-gutters">
                        <div class="col-sm-5">
                            <img class="card-img rounded" src="<?php echo base_url(); ?>data/order/<?php echo $rows2->image; ?>" alt="" height="250px" style="object-fit: cover">
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h6 class="card-text">Kode Pemesanan :
                                    <?php echo $rows2->code_order; ?>
                                    </h5>
                                    <h6 class="card-text">Nama Customer :
                                        <?php echo $rows2->customer; ?>
                                    </h6>
                                    <h6 class="card-text">Tanggal Selesai :
                                        <?php echo $rows2->date_finish; ?>
                                    </h6>
                                    <h6 class="card-text">Alamat :
                                        <?php $this->load->model('admin_model');
                                        $address = $this->admin_model->get_verified_account_details($rows2->customer, 'customer');
                                        ?>
                                        <?php foreach ($address as $rows3) {
                                            echo $rows3->address;
                                        } ?>
                                    </h6>
                                    <br>
                                    <?php if ($rows2->shipment == "in_request") { ?>
                                        <a href="#" class="btn btn-warning btn-block" data-toggle="modal" data-target="#modal_in_request_<?php echo $rows2->id; ?>"> <i class="fas fa-truck"></i> Kirim Sekarang</a>
                                    <?php } else if ($rows2->shipment == "in_delivery") { ?>
                                        <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_in_delivery_<?php echo $rows2->id; ?>"> <i class="fas fa-truck"></i> Dalam Pengiriman</a>
                                    <?php } else if ($rows2->shipment == "delivered") { ?>
                                        <a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal_delivered_<?php echo $rows2->id; ?>"> <i class="fas fa-truck"></i> Sudah Sampai</a>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal -->
                <div class="modal modal-warning fade" id="modal_in_request_<?php echo $rows2->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Konfirmasi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="py-3 text-center">
                                    <i class="fas fa-shipping-fast fa-4x"></i>
                                    <h4 class="heading mt-4">lakukan pengiriman sekarang?</h4>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-sm btn-light" href="<?php echo site_url(); ?>dashboard/admin_process_shipment/<?php echo $rows2->id; ?>/<?php echo $rows2->shipment; ?>">Kirim</a>
                                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal modal-primary fade" id="modal_in_delivery_<?php echo $rows2->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Konfirmasi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="py-3 text-center">
                                    <i class="fas fa-shipping-fast fa-4x"></i>
                                    <h4 class="heading mt-4">Pengiriman sudah sampai?</h4>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-sm btn-light" href="<?php echo site_url(); ?>dashboard/admin_process_shipment/<?php echo $rows2->id; ?>/<?php echo $rows2->shipment; ?>">Sudah</a>
                                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal modal-success fade" id="modal_delivered_<?php echo $rows2->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Konfirmasi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="py-3 text-center">
                                    <i class="fas fa-shipping-fast fa-4x"></i>
                                    <h4 class="heading mt-4">Pengiriman telah sampai :)</h4>
                                    <a href="<?php echo site_url(); ?>dashboard/admin_save_history/<?php echo $rows2->id; ?>" class="btn btn-block btn-light">Simpan ke history</a>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal -->
            </div>
        <?php
        } ?>
    </div>

    <!-- footer -->
    <footer class="pt-5 pb-3 footer footer-dark bg-tertiary">
        <div class="container">
            <div class="row">

                <div class="col-md-4">
                    <div class="pr-lg-5">
                        <h1 class="heading h6 text-uppercase font-weight-700 mb-3"><strong>IT-</strong>Clinic</h1>
                        <p>IT-Clinic didesain dan di program untuk menjadi sebuah platform yang menghubungkan antara Customer dengan Teknisi, juga menjamin keamanan dan kepuasan Customer.</p>
                    </div>
                </div>

                <!-- space kosong -->
                <div class="col-4"></div>
                <!-- space kosong -->

                <div class="col-2">
                    <h5 class="heading h6 text-uppercase font-weight-700 mb-3">Navigation</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="<?php echo base_url(); ?>dashboard">List Request</a></li>
                        <li><a class="text-muted" href="<?php echo site_url(); ?>dashboard/admin_view_history">Request History</a></li>
                        <li><a class="text-muted" href="<?php echo site_url(); ?>dashboard/admin_view_account">List User</a></li>
                        <li><a class="text-muted" href="<?php echo site_url(); ?>dashboard/admin_verify_account">Verify User</a></li>
                        <li><a class="text-muted" href="<?php echo base_url(); ?>login/logout">Logout</a></li>
                    </ul>
                </div>

                <div class="col-1 col-md">
                    <h5 class="heading h6 text-uppercase font-weight-700 mb-3">About</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="<?php echo site_url(); ?>home/about">About Us</a></li>
                        <li><a class="text-muted" href="<?php echo site_url(); ?>">Home</a></li>
                    </ul>
                </div>

            </div>
            <hr>

            <div class="d-flex align-items-center">
                <span class="text-muted">
                    © 2020 <a href="<?php echo site_url(); ?>home/about" class="text-muted">IT-Clinic</a>
                </span>
            </div>

        </div>
    </footer>
    <!-- footer -->

    <!-- cdn js ojo diganti!! -->

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="<?php base_url(); ?>assets/js/theme.js"></script>
</body>

</html>