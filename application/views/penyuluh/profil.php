<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>



    <div class="row">
        <div class="col-lg">
            <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
            <?php endif; ?>

            <?= $this->session->flashdata('message'); ?>


            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        
						<th scope="col">Nama Penyuluh/NIP</th>
						<th scope="col">Tanggal Lahir</th>
                        <th scope="col">Unit Kerja</th>                                           
                        <th scope="col">Wilayah Kerja</th>
						<th scope="col">Jumlah Poktan</th>    
						<th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($penyuluh as $p) { 
						$myDateTime = DateTime::createFromFormat('Y-m-d', $p['tgl_lahir']);
						$formatted = $myDateTime->format('d-m-Y');
						switch ($p['status']) {
							case 0 : $status = 'Aktif';break;
							case 6 : $status = 'Tugas Belajar';break;
							case 7 : $status = 'CPNS';break;
							default : $status = '';break;
						}
						$dtwilker = array();
						
						$wilker = explode(',',$p['wilker']);
						foreach ($wilker as $k => $v){			
							if (trim($v) <> '')
								$dtwilker[] = trim($v);
						}
						if (count($dtwilker) > 0) {
							//find wilker
							$wil = implode('m',$dtwilker);
							$dwilker = $this->penyuluh->getwilker($wil);
							$awilker = array();
							$jumpoktan=0;
							foreach ($dwilker as $key => $val) {
								$awilker[] = $val['nm_desa']; 
								$jumpoktan += $val['jumlah'];
							}
							$namawilker = implode('<br /> ',$awilker);
							
						}
						else {
							$namawilker = '';
							$jumpoktan = '';
						}
						
						
					?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                       
                        <td><?= $p['namalengkap'].'<br />'.$p['nip']; ?></td>
						<td><?= $p['tempat_lahir'].', '.$formatted; ?></td>
                        <td><?= (($p['kode_kab'] == '3') ? $p['bapel'] : $p['nama_bpp']); ?></td>                        
                        
						<td><?= $namawilker; ?></td>
						<td><?= $jumpoktan; ?></td>
                        <td>                        
							<a style="color:#fff" title="Detail Penyuluh" class="btn btn-primary mb-3" data-toggle="modal" style="cursor: pointer;" onclick="viewdetail('<?php echo $p['nip']; ?>')">Detail</a>
							<a style="color:#fff" title="Aktivitas Bulanan" class="btn btn-primary mb-3" data-toggle="modal" style="cursor: pointer;" onclick="viewaktivitas('<?php echo $p['nip'].'/'.$wil; ?>')">Aktivitas Bulanan</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    <?php } ?>
                </tbody>
            </table>


        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->

<!-- Modal -->
<div class="modal fade " id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Detail Penyuluh</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		
        </div>
    </div>
</div> 

<div class="modal fade " id="aktivitasModal" tabindex="-1" role="dialog" aria-labelledby="aktivitasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Aktivitas Bulanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/submenu'); ?>" method="post">
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div> 

<script type="text/javascript" charset="utf-8">
		function viewdetail(nip)
		{	
			//Ajax Load data from ajax
			$.ajax({
				//alert('a');
				url : "<?php echo base_url().'penyuluh/detail/'?>" + nip,
				type: "GET",
				//dataType:"json", 
				success: function(data)
				{
					//alert(data.nip);
					$('#detailModal').modal('show'); // show bootstrap modal when complete loaded
					$('.modal-body').html(data); // Set title to Bootstrap modal title
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error get data from ajax');
				}
			});
		}
		function viewaktivitas(nip, wilker)
		{	
			//Ajax Load data from ajax
			$.ajax({
				//alert('a');
				url : "<?php echo base_url().'penyuluh/aktivitas/'?>" + nip+ '/'+wilker,
				type: "GET",
				//dataType:"json", 
				success: function(data)
				{
					//alert(data.nip);
					$('#aktivitasModal').modal('show'); // show bootstrap modal when complete loaded
					$('.modal-body').html(data); // Set title to Bootstrap modal title
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error get data from ajax');
				}
			});
		}
		
	</script>