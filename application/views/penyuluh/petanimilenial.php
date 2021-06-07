<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
	<link href="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<script src="<?php echo base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo base_url(); ?>assets/js/demo/datatables-demo.js"></script>

	<script type="text/javascript" charset="utf-8">
	
		var table_global;
	
		function inputup(){
			//alert('x');
			table_global.DataTable().ajax.reload();
		}
		$(document).ajaxStart(function(){
				$("#loading").show();
			}).ajaxStop(function(){
				$("#loading").hide();
			});
	
		$(document).ready(function() {
			var tabel= $('#datatables').dataTable({
				
				"paging": true,
				"searching": false,
				"lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
				"pageLength": 10,
				'ordering': true,
				"processing":true,
				"serverSide":true,
				"ajax": {
					url : "<?php echo site_url("penyuluh/milenial_data/") ?>",
					type : 'POST',
					data : function(d){
						return $.extend({},d,{
							"search_keywords": $("#searchInput").val().toLowerCase(),
							//"filter_option": $("#sortBy").val().toLowerCase(),
						});
					}
				},
				"language": {
					"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"
				},				
			});			
			table_global = tabel;
		} );
		
		
	</script>

    <div class="row">
        <div class="col-lg">
            <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
            <?php endif; ?>

            <?= $this->session->flashdata('message'); ?>
			
			<div>
				<div style="float:left">
					<a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#formModal">Tambah Data Petani Milenial</a>
				</div>
				<div style="float:right">
					<div class="form-group" align="right">
						<label>Pencarian Petani Milenial</label>
						<label class="checkbox-inline">
							<input type="text" id="searchInput"  class="form-control"  placeholder="Cari petani milenial.." onkeyup="inputup()">
						</label>
						
					</div>
				</div>
				<div style="clear:both"></div>
			</div>
			
            <table class="table table-hover display" id="datatables">
                <thead>
                    <tr>
                        <th scope="col">#</th>                        
						<th scope="col">Nama/NIK</th>
						<th scope="col">Kecamatan</th>
                        <th scope="col">Kelurahan/Desa</th>                                           
                        <th scope="col">Alamat Usaha</th>
						<th scope="col">Jenis Usaha</th>
						<th scope="col">Detail Usaha</th>
						<th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
				
            </table>


        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<div class="modal fade " id="formModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Tambah Petani Milenial Binaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
			<form action="" method="post" class="inputmilenial">
				<div class="modal-body">				
					<input type="hidden" name="id" id="id"	>
					<table class="table table-hover" >                
						<tbody>				
							<tr>
								<td align="left" width="30%" scope="row">Kecamatan</td>
								<td align="left">
									<select class="form-control" name="kecamatan" id="kecamatan" >
									   <option value="">-pilih kecamatan-</option>
									   <?php 
											foreach ($kecamatan as $k) {
												echo '<option value="'.$k['kd_kec'].'">'.$k['nm_kec'].'</option>';
											} 
										?>
									</select>
								</td>							
							</tr>
							
							<tr>
								<td align="left" width="30%" scope="row">Kelurahan/Desa</td>
								<td align="left">
									<select class="form-control" name="desa" id="desa" >
									 
									</select>
								</td>							
							</tr>
							<tr>
								<td align="left" width="30%" scope="row">Nama Petani Milenial</td>
								<td align="left">
									<input type="text" maxlength="200" class="form-control" name="nama" id="nama"	>
								</td>							
							</tr>
							<tr>
								<td align="left" width="30%" scope="row">NIK</td>
								<td align="left">
									<input type="text" maxlength="16" onkeypress="return isNumberKey(event)" class="form-control" name="nik" id="nik"	>
								</td>							
							</tr>
							<tr>
								<td align="left" width="30%" scope="row">Alamat Usaha</td>
								<td align="left">
									<input type="text" maxlength="200" class="form-control" name="alamat" id="alamat"	>
								</td>							
							</tr>
							<tr>
								<td align="left" width="30%" scope="row">Jenis Usaha</td>
								<td align="left">
									<select class="form-control" name="usaha" id="usaha">
									   <option value="">-pilih jenis usaha-</option>
									   <?php 
											foreach ($usaha as $u) {
												echo '<option value="'.$u['usaha_id'].'">'.$u['usaha_nama'].'</option>';
											} 
										?>
									</select>
								</td>							
							</tr>
							<tr>
								<td align="left" width="30%" scope="row">Detail Usaha</td>
								<td align="left">
									<input type="text" maxlength="200" class="form-control" name="detail" id="detail"	>
								</td>							
							</tr>
						</tbody>
					</table>
						
					
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-primary" name="simpan" id="save"	value="Simpan">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
        </div>
    </div>
</div> 

<div class="modal fade " id="successModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Alert</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
			<div class="modal-body">				
				<div id="msg">Data berhasil disimpan..</div>
			</div>
			<div class="modal-footer">				
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>			
        </div>
    </div>
</div> 

<div class="modal fade " id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Hapus Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				
			</div>
			<div class="modal-body">				
				<input type="hidden" name="id">
				<div class="modal-body">
					Apakah Anda yakin akan menghapus data ini ?
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

				<span id="hapusbutton"></span>
			</div>
		</div>
    </div>
</div>


<script type="text/javascript" charset="utf-8">

	function viewdetail(id)
		{	
			//Ajax Load data from ajax
			$.ajax({
				url : "<?php echo base_url().'penyuluh/milenialdetail/'?>" + id,
				type: "GET",
				dataType:"json", 
				success: function(response)
				{
					var detail = response.detail;
					var desa = response.desa;
					
					$('#formModal').modal('show'); // show bootstrap modal when complete loaded
					
					$('#newSubMenuModalLabel').text('Ubah Petani Milenial Binaan'); 
					$('#kecamatan').val(detail.kode_kec);
					$('#desa').html(desa);
					$('#id').val(detail.id);					
					$('#nama').val(detail.nama); 
					$('#nik').val(detail.nik); 
					$('#alamat').val(detail.alamat_usaha);
					$('#usaha').val(detail.jenis_usaha); 
					$('#detail').val(detail.detail_usaha);
					//$('#namapoktan2').val(profil.nama_poktan);
				},
				error: function (jqXHR, textStatus, errorThrown)	{
					alert('Error get data from ajax');
				}
			});
		}	
		
		$('#save').on('click', function(e) {
			//e.preventDefault();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "penyuluh/simpanmilenial/",
				data: $('form.inputmilenial').serialize(),
				success: function(response) {
					if (response == "error"){
						alert(response);
						$(".gagal").show();
					}
					else {						
						$("form").trigger("reset");
						$('#desa').html("");
						$('#formModal').modal('hide');
						$('#successModal').modal('show');
						$('#datatables').DataTable().ajax.reload();
					}	
				},
				error: function() {
					alert('Error');
				}
			});
			return false;
		});
		
		function showhapus(id){
			$('[name="id"]').val(id);
			$('#hapusbutton').html('<input type="button" class="btn btn-primary"  onclick="hapusin('+id+')" value="Hapus" name="simpan">');
			$('#hapusModal').modal('show'); // show bootstrap modal when complete loaded
		}
		
		function hapusin(id){
			$.ajax({
				url : "<?php echo base_url().'penyuluh/ajax_hapusmilenial/'?>" + id,
				type: "GET",
				success: function(data)		{
					data = JSON.parse(data);
					if(data.status) //if success close modal and reload ajax table
					{						
						$('#hapusModal').modal('hide');
						$('#successModal').modal('show');					
						$('#msg').text('Data berhasil dihapus..');
						$('#datatables').DataTable().ajax.reload();
					}				
					else	{
						alert('gagal');
					}	 
				},
				error: function (jqXHR, textStatus, errorThrown)	{
					alert('Error get data from ajax');
				}
			});
		}
		
		$('#kecamatan').change(function(){
			$.post("<?php echo base_url(); ?>" + "penyuluh/getdesabykecamatan/"+$('#kecamatan').val(),{},function(obj){
				$('#desa').html(obj);
				
			});
		});
		
		function isNumberKey(evt) {
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode != 46 && charCode > 31 
				&& (charCode < 48 || charCode > 57))
				return false;
			return true;
		} 
		
		
	</script>
	
	<div id="loading" style="position:fixed;
   top:40%;
   right:40%;
   background-color:#FFF;
   border:3px solid #000;
   padding:5px 7px;
   border-radius:5px;
   -moz-border-radius: 5px;
   -webkit-border-radius: 5px;
   z-index:3000;
   display:none;"><img src='http://fungsional.pertanian.go.id/assets/img/ajax_loader.gif' width="80px" /><br />Loading..</div>
      