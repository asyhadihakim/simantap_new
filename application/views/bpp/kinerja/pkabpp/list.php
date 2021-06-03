<div class="container-fluid">

<!-- DataTables -->
<div class="card mb-3">
    <div class="card-header">
        <h3> BPP sebagai Pusat Konsultasi Agribisnis </h3>
    </div>
    <div class="card-body">
    <?php
            $throw = "";
            if(isset($_POST['bpp_id'])){
                $throw = $_POST['bpp_id'];
            }
            ?>
        <form action="<?php echo site_url('kinerjaBPP/PkaBpp/searchBPP/') ?>" method="post" enctype="multipart/form-data" >
            <div class="form-group">
                <label for="bpp_id">BPP</label>
                <select class="form-control" name="bpp_id" id="bpp_id">
                    <?php 
                    if($this->uri->segment(3)=="searchBPP") { ?><option value="<?php echo $bpp_detail['id'] ?>"> <?php echo $bpp_detail['nama_bpp'] ?> </option>
                    <?php } ?>
                    <option value=""> -- Filter -- </option>
                    <?php foreach ($bpp as $bpp_row) {
					?>	
                        <option value="<?php echo $bpp_row['id']?>"><?php echo $bpp_row['id'].'-'.$bpp_row['nama_bpp']?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            
            <input class="btn btn-success" type="submit" name="btn" value="Filter" />
        </form>    
        <a href="<?php echo site_url('kinerjaBPP/PkaBpp/add') ?>"><button class="btn btn-info" type="btn" name="btn"><i class="fas fa-plus"></i> Tambahkan </button></a>
        <div class="table-responsive">
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Bulan</th>
                        <th>BPP</th>
                        <th>Metode</th>
                        <th>Tempat</th>
                        <th>Jumlah Petani</th>
                        <th>Jumlah Materi Konsultasi</th>
                        <th>Jumlah Rekomendasi</th>
                        <th>Informasi yg Dikonsultasikan</th>
                        <th>Foto</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pkabpp as $row): ?>
                    <tr>
                        <td>
                            <?php echo $row->tahun ?>
                        </td>
                        <td>
                            <?php echo $row->bulan ?>
                        </td>
                        <td>
                            <?php echo $row->bpp_name ?>
                        </td>
                        <td>
                            <?php echo $row->metode ?>
                        </td>
                        <td>
                            <?php echo $row->tempat_pelaksanaan ?>
                        </td>
                        <td>
                            <?php echo $row->jumlah_petani ?>
                        </td>
                        <td>
                            <?php echo $row->jumlah_materi_konsultasi ?>
                        </td>
                        <td>
                            <?php echo $row->jumlah_rekomendasi ?>
                        </td>
                        <td>
                            <?php echo $row->informasi ?>
                        </td>
                        <td>
                            <img src="<?php echo base_url('assets/img/bpp/'.$row->foto) ?>" width="64" />
                        </td>
                        <td width="250">
                            <a href="<?php echo site_url('kinerjaBPP/PkaBpp/edit/'.$row->id) ?>"
                             class="btn btn-small"><i class="fas fa-edit"></i> Edit</a>
                            <a onclick="deleteConfirm('<?php echo site_url('kinerjaBPP/PkaBpp/delete/'.$row->id) ?>')"
                             href="<?php echo site_url('kinerjaBPP/PkaBpp/delete/'.$row->id) ?>" class="btn btn-small text-danger"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->