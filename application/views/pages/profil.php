<div class="container-fluid py-4">
    <div class="row">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

        <div class="card mb-3 col-lg-8">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="<?= base_url('assets/img/profile/default.jpg') ?>" class="card-img">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Nama Penyuluh</h5>
                        <p class="card-text">Email Penyuluh</p>
                        <p class="card-text"><small class="text-muted">Member since <?= date('d F Y'); ?></small></p>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('templates/footer'); ?>

    </div>
</div>