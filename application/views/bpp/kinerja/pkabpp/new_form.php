<div class="container-fluid">

<?php if ($this->session->flashdata('success')): ?>
<div class="alert alert-success" role="alert">
    <?php echo $this->session->flashdata('success'); ?>
</div>
<?php endif; ?>

<div class="card mb-3">
    <div class="card-header">
        <a href="<?php echo site_url('kinerjaBPP/PkaBpp') ?>"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="card-body">

        <form action="<?php echo site_url('kinerjaBPP/PkaBpp/add') ?>" method="post" enctype="multipart/form-data" >
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
                    <option value=""> -- Pilih Bulan -- </option>
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
                <?php
                  //  $bpp_id="";
                 //   $bpp_name="";
                 //   if(isset($_POST["bpp"]) && $_POST["bpp"]!=""){
                 //     $bpparr=(explode('-',$_POST["bpp"],2));
                 //     $bpp_id=$bpparr[0];
                 //     $bpp_name=$bpparr[1];
                      //print_r($bpp_id);
                      //print_r($bpp_name);
                      //die();
                 //   }  
                ?>
                <label for="bpp">BPP</label>
                <select class="form-control <?php echo form_error('bpp') ? 'is-invalid':'' ?>" name="bpp" id="bpp" onchange="bppFunction()">
                    <option value=""> -- Pilih BPP -- </option>
                    <?php foreach ($bpp as $bpp_row) {
					?>	
                        <option value="<?php echo $bpp_row['id'].'-'.$bpp_row['nama_bpp']?>"><?php echo $bpp_row['id'].'-'.$bpp_row['nama_bpp']?></option>
                    <?php
                    }
                    ?>
                </select>        
                <div class="invalid-feedback">
                    <?php echo form_error('bpp') ?>
                </div>
                <input type="hidden" name="bpp_id" id="bpp_id" value="">
                <input type="hidden" name="bpp_name" id="bpp_name" value="">
            </div>

            <script>
                function bppFunction() {
                var bpp = document.getElementById("bpp").value;
                var explode_bpp = bpp.split("-");
                var bpp_id = explode_bpp[0];
                var bpp_name = explode_bpp[1];
                document.getElementById("bpp_id").value = bpp_id;
                document.getElementById("bpp_name").value = bpp_name;
                }
            </script>

            <div class="form-group">
                <label for="metode">Metode</label>
                <select class="form-control <?php echo form_error('metode') ? 'is-invalid':'' ?>" name="metode" id="metode">
                    <option value=""> -- Pilih Metode -- </option>
                    <option value="Tatap Muka">Tatap Muka</option>
                    <option value="Daring">Daring</option>
                </select>        
                <div class="invalid-feedback">
                    <?php echo form_error('metode') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="tempat_pelaksanaan">Tempat</label>
                <select class="form-control <?php echo form_error('tempat_pelaksanaan') ? 'is-invalid':'' ?>" name="tempat_pelaksanaan" id="tempat_pelaksanaan">
                    <option value=""> -- Pilih Tempat -- </option>
                    <option value="BPP">BPP</option>
                    <option value="Aplikasi Pesan">Aplikasi Pesan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>        
                <div class="invalid-feedback">
                    <?php echo form_error('tempat_pelaksanaan') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="jumlah_petani">Jumlah Petani</label>
                <input class="form-control <?php echo form_error('jumlah_petani') ? 'is-invalid':'' ?>" name="jumlah_petani" id="jumlah_petani">     
                <div class="invalid-feedback">
                    <?php echo form_error('jumlah_petani') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="jumlah_materi_konsultasi">Jumlah Materi Konsultasi</label>
                <input class="form-control <?php echo form_error('jumlah_materi_konsultasi') ? 'is-invalid':'' ?>" name="jumlah_materi_konsultasi" id="jumlah_materi_konsultasi">     
                <div class="invalid-feedback">
                    <?php echo form_error('jumlah_materi_konsultasi') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="jumlah_rekomendasi">Jumlah Rekomendasi</label>
                <input class="form-control <?php echo form_error('jumlah_rekomendasi') ? 'is-invalid':'' ?>" name="jumlah_rekomendasi" id="jumlah_rekomendasi">     
                <div class="invalid-feedback">
                    <?php echo form_error('jumlah_rekomendasi') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="informasi">Informasi yg Dikonsultasikan</label>
                <select class="form-control <?php echo form_error('informasi') ? 'is-invalid':'' ?>" name="informasi" id="informasi">
                    <option value=""> -- Pilih Informasi yg Dikonsultasikan -- </option>
                    <option value="Sarana Produksi"> Sarana Produksi </option>
                    <option value="Budidaya">Budidaya</option>
                    <option value="Pengendalian OPT">Pengendalian OPT</option>
                    <option value="Panen dan Pasca Panen">Panen dan Pasca Panen</option>
                    <option value="Pengolahan Hasil">Pengolahan Hasil</option>
                    <option value="Pemasaran">Pemasaran</option>
                    <option value="Pembiayaan">Pembiayaan</option>
                    <option value="Asuransi">Asuransi</option>
                    <option value="Pemanfaatan Alsintan">Pemanfaatan Alsintan</option>
                </select>   
                <div class="invalid-feedback">
                    <?php echo form_error('informasi') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="foto">Foto Kegiatan</label>
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
