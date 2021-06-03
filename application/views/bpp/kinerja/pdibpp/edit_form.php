<div class="container-fluid">

<?php if ($this->session->flashdata('success')): ?>
<div class="alert alert-success" role="alert">
    <?php echo $this->session->flashdata('success'); ?>
</div>
<?php endif; ?>
<?php if ($this->session->flashdata('fail')): ?>
<div class="alert alert-danger" role="alert">
    <?php echo $this->session->flashdata('fail'); ?>
</div> 
<?php endif; ?>

<div class="card mb-3">
    <div class="card-header">
        <a href="<?php echo site_url('kinerjaBPP/PdiBpp') ?>"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="card-body">

        <form action="<?php base_url("kinerjaBPP/PdiBpp/edit") ?>" method="post" enctype="multipart/form-data" >

        <input type="hidden" name="id" value="<?php echo $pdibpp->id?>" />
        
            <div class="form-group">
                <label for="tahun">Tahun</label>
                <select class="form-control <?php echo form_error('tahun') ? 'is-invalid':'' ?>" name="tahun" id="tahun">
                    <option value="2021">2021</option>
                </select>        
                <div class="invalid-feedback">
                    <?php echo form_error('tahun') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="bpp_id">BPP</label>
                <input type="hidden" name="bpp_name" value="<?php echo $pdibpp->bpp_name?>" />
                <input type="hidden" name="bpp_id" value="<?php echo $pdibpp->bpp_id?>" />
                <select class="form-control <?php echo form_error('bpp') ? 'is-invalid':'' ?>" name="bpp" id="bpp">
                    <option value="<?php echo $pdibpp->bpp_id ?>"> <?php echo $pdibpp->bpp_name ?> </option>
                </select>
                <div class="invalid-feedback">
                    <?php echo form_error('bpp') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="tipe_data_info">Jenis Data dan Informasi</label>
                <select class="form-control <?php echo form_error('tipe_data_info') ? 'is-invalid':'' ?>" name="tipe_data_info" id="tipe_data_info">
                    <option value="<?php echo $pdibpp->tipe_data_info ?>"> <?php echo $pdibpp->tipe_data_info ?> </option>
                    <option value="Organisasi BPP dan Nama-nama Penyuluh">Organisasi BPP dan Nama-nama Penyuluh</option>
                    <option value="Peta Wilayah BPP">Peta Wilayah BPP</option>
                    <option value="SDM (Poktan/Gapoktan/KEP)">SDM (Poktan/Gapoktan/KEP)</option>
                    <option value="Potensi dan Laporan Pertanaman">Potensi dan Laporan Pertanaman (LT/LP/Prod/Dll)</option>
                    <option value="Informasi Penerapan Teknologi">Informasi Penerapan Teknologi</option>
                    <option value="Tingkat Serangan OPT">Tingkat Serangan OPT</option>
                    <option value="Papan Informasi / Pengumuman">Papan Informasi / Pengumuman</option>
                    <option value="Media Cetak (Leaflet, Majalah, Tabloid, Buku, Dll)">Media Cetak (Leaflet, Majalah, Tabloid, Buku, Dll)</option>
                    <option value="Informasi Lain">Informasi Lain</option>
                </select>        
                <div class="invalid-feedback">
                    <?php echo form_error('tipe_data_info') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="kebaruan_info">Kebaruan Informasi</label>
                <select class="form-control <?php echo form_error('kebaruan_info') ? 'is-invalid':'' ?>" name="kebaruan_info" id="kebaruan_info">
                    <option value="<?php echo $pdibpp->kebaruan_info ?>"> <?php echo $pdibpp->kebaruan_info ?> </option>
                    <option value="Data Terbaru">Data Terbaru</option>
                    <option value="Data Belum Diupdate">Data Belum Diupdate</option>
                </select>        
                <div class="invalid-feedback">
                    <?php echo form_error('kebaruan_info') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="ket_foto">Keterangan Foto</label>
                <input class="form-control <?php echo form_error('ket_foto') ? 'is-invalid':'' ?>" name="ket_foto" value="<?php echo $pdibpp->ket_foto ?>" id="ket_foto">     
                <div class="invalid-feedback">
                    <?php echo form_error('ket_foto') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="foto">Foto / Gambar</label>
                <input type="hidden" name="old_image" value="<?php echo $pdibpp->foto ?>">
                <input class="form-control-file <?php echo form_error('foto') ? 'is-invalid':'' ?>"
                 type="file" name="foto" />
                <div class="invalid-feedback">
                    <?php echo form_error('foto') ?>
                </div>
            </div>

            <input class="btn btn-success" type="submit" name="btn" value="Save" />
        </form>

    </div>


</div>
<!-- /.container-fluid -->
