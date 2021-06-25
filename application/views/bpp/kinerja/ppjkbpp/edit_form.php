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
        <a href="<?php echo site_url('kinerjaBPP/PpjkBpp') ?>"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="card-body">

        <form action="<?php base_url("kinerjaBPP/PpjkBpp/edit") ?>" method="post" enctype="multipart/form-data" >

        <input type="hidden" name="id" value="<?php echo $ppjkbpp->id?>" />
        
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
                <label for="bulan">Bulan</label>
                <select class="form-control <?php echo form_error('bulan') ? 'is-invalid':'' ?>" name="bulan" id="bulan">
                    <option value="<?php echo $ppjkbpp->bulan ?>"> Bulan <?php echo $ppjkbpp->bulan ?> </option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>        
                <div class="invalid-feedback">
                    <?php echo form_error('bulan') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="bpp_id">BPP</label>
                <input type="hidden" name="bpp_name" value="<?php echo $ppjkbpp->bpp_name?>" />
                <input type="hidden" name="bpp_id" value="<?php echo $ppjkbpp->bpp_id?>" />
                <select class="form-control <?php echo form_error('bpp') ? 'is-invalid':'' ?>" name="bpp" id="bpp">
                    <option value="<?php echo $ppjkbpp->bpp_id ?>"> <?php echo $ppjkbpp->bpp_name ?> </option>
                </select>
                <div class="invalid-feedback">
                    <?php echo form_error('bpp') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="jenis_kegiatan">Jenis Kegiatan</label>
                <select class="form-control <?php echo form_error('jenis_kegiatan') ? 'is-invalid':'' ?>" name="jenis_kegiatan" id="jenis_kegiatan">
                    <option value="<?php echo $ppjkbpp->jenis_kegiatan ?>"> <?php echo $ppjkbpp->jenis_kegiatan ?> </option>
                    <option value="Temu Usaha">Temu Usaha</option>
                    <option value="Temu Karya">Temu Karya</option>
                    <option value="Pemeran">Pemeran</option>
                    <option value="Promosi">Promosi</option>
                    <option value="Lainnya">Lainnya</option>
                </select>        
                <div class="invalid-feedback">
                    <?php echo form_error('jenis_kegiatan') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="tempat_pelaksanaan">Tempat Pelaksanaan</label>
                <select class="form-control <?php echo form_error('tempat_pelaksanaan') ? 'is-invalid':'' ?>" name="tempat_pelaksanaan" id="tempat_pelaksanaan">
                    <option value="<?php echo $ppjkbpp->tempat_pelaksanaan ?>"> <?php echo $ppjkbpp->tempat_pelaksanaan ?> </option>
                    <option value="BPP">BPP</option>
                    <option value="Kantor Dinas Pertanian / Peternakan / Ketahanan Pangan">Kantor Dinas Pertanian / Peternakan / Ketahanan Pangan</option>
                    <option value="Lokasi Petani / Poktan / Gapoktan / KEP">Lokasi Petani / Poktan / Gapoktan / KEP</option>
                    <option value="Lainnya">Lainnya</option>
                </select>        
                <div class="invalid-feedback">
                    <?php echo form_error('tempat_pelaksanaan') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="materi">Materi</label>
                <select class="form-control <?php echo form_error('materi') ? 'is-invalid':'' ?>" name="materi" id="materi">
                    <option value="<?php echo $ppjkbpp->materi ?>"> <?php echo $ppjkbpp->materi ?> </option>
                    <option value="Teknologi">Teknologi</option>
                    <option value="Produk Pertanian">Produk Pertanian</option>
                    <option value="Sarana Produksi">Sarana Produksi</option>
                    <option value="Pemasaran">Pemasaran</option>
                    <option value="Pembiayaan">Pembiayaan</option>
                    <option value="Asuransi">Asuransi</option>
                    <option value="Pengembangan Kelembagaan">Pengembangan Kelembagaan</option>
                    <option value="Jasa yg Dibutuhkan Petani">Jasa yg Dibutuhkan Petani</option>
                    <option value="Lainnya">Lainnya</option>
                </select>        
                <div class="invalid-feedback">
                    <?php echo form_error('materi') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="unsur_pelaku_usaha">Unsur Pelaku Usaha</label>
                <select class="form-control <?php echo form_error('unsur_pelaku_usaha') ? 'is-invalid':'' ?>" name="unsur_pelaku_usaha" id="unsur_pelaku_usaha">
                    <option value="<?php echo $ppjkbpp->unsur_pelaku_usaha ?>"> <?php echo $ppjkbpp->unsur_pelaku_usaha ?> </option>
                    <option value="Pengusaha">Pengusaha</option>
                    <option value="Eksportir">Eksportir</option>
                    <option value="Lembaga Perbankan/Pembiayaan">Lembaga Perbankan/Pembiayaan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>        
                <div class="invalid-feedback">
                    <?php echo form_error('unsur_pelaku_usaha') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="nama_kegiatan">Nama Kegiatan</label>
                <input class="form-control value="<?php echo $ppjkbpp->nama_kegiatan ?>"> <?php echo form_error('nama_kegiatan') ? 'is-invalid':'' ?>" name="nama_kegiatan" id="nama_kegiatan">     
                <div class="invalid-feedback">
                    <?php echo form_error('nama_kegiatan') ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <select class="form-control" name="tanggal" id="tanggal" style="width: 200px">
                    <option value="<?php echo $ppjkbpp->tanggal ?>"> <?php echo $ppjkbpp->tanggal ?> </option>
                    <?php
                        for($i=1;$i<32;$i++) {
                    ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php
                        }
                    ?>     
                </select>        
                <div class="invalid-feedback">
                    <?php echo form_error('tanggal') ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="tindak_lanjut">Tindak Lanjut</label>
                <select class="form-control <?php echo form_error('tindak_lanjut') ? 'is-invalid':'' ?>" name="tindak_lanjut" id="tindak_lanjut">
                    <option value="<?php echo $ppjkbpp->tindak_lanjut ?>"> <?php echo $ppjkbpp->tindak_lanjut ?> </option>
                    <option value="Transaksi">Transaksi</option>
                    <option value="Naskah Kerjasama (MOU)">Naskah Kerjasama (MOU)</option>
                    <option value="Pengembangan Kelembagaan">Pengembangan Kelembagaan</option>
                    <option value="Rencana Promosi">Rencana Promosi</option>
                    <option value="Lainnya">Lainnya</option>
                </select>        
                <div class="invalid-feedback">
                    <?php echo form_error('tindak_lanjut') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="pembiayaan">Pembiayaan</label>
                <select class="form-control <?php echo form_error('pembiayaan') ? 'is-invalid':'' ?>" name="pembiayaan" id="pembiayaan">
                    <option value="<?php echo $ppjkbpp->pembiayaan ?>"> <?php echo $ppjkbpp->pembiayaan ?> </option>
                    <option value="APBN">APBN</option>
                    <option value="APBD Prov">APBD Prov</option>
                    <option value="APBD Kab/Kota">APBD Kab/Kota</option>
                    <option value="Swadaya">Swadaya</option>
                    <option value="Lainnya">Lainnya</option>
                </select>        
                <div class="invalid-feedback">
                    <?php echo form_error('pembiayaan') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="foto">Foto Kegiatan</label>
                <input type="hidden" name="old_image" value="<?php echo $ppembelajaranbpp->foto ?>">
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
