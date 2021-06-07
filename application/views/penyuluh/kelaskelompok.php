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
		
		function lihatskor(){
			var skor = $("#skorakhir").val();
			if (skor > 1000)
				$('#kelasjadi').text("");
			else if (skor > 700)
				$('#kelasjadi').text("Utama");
			else if (skor > 455)
				$('#kelasjadi').text("Madya");
			else if (skor > 245)
				$('#kelasjadi').text("Lanjut");
			else 
				$('#kelasjadi').text("Pemula");
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
					url : "<?php echo site_url("penyuluh/poktan_data/") ?>",
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
			
			<div class="form-group" align="right">
				<label>Pencarian Kelompok Tani</label>
				<label class="checkbox-inline">
					<input type="text" id="searchInput"  class="form-control"  placeholder="Cari kelompok.." onkeyup="inputup()">
				</label>
				
			</div>
			
            <table class="table table-hover display" id="datatables">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        
						<th scope="col">Nama Kelompok Tani</th>
						<th scope="col">Kecamatan</th>
                        <th scope="col">Kelurahan/Desa</th>                                           
                        <th scope="col">Ketua Poktan</th>
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


<div class="modal fade " id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Penilaian Kelas Kelompok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
			<div class="modal-body">
				<script type="text/javascript" charset="utf-8">
					
					$(function () {
						$('#myTab a:last').tab('show');
					  })
					$('#myTab a[href="#profile"]').tab('show'); // Select tab by name
					$('#myTab a:first').tab('show'); // Select first tab
					$('#myTab a:last').tab('show'); // Select last tab
					$('#myTab li:eq(2) a').tab('show'); // Select third tab (0-indexed)
				</script>
				
				
				
				
				<div>
					
					<div style="float:right">
						<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
							<li ><a style="margin:10px 10px;" href="#tambahpenilaian" class="btn btn-danger" data-toggle="tab">Tambah Penilaian</a></li>
							<li class="active"><a style="margin:10px 10px;" href="#penilaian" class="btn btn-warning" data-toggle="tab">Daftar Penilaian Kelas Kelompok</a></li>
							<li ><a style="margin:10px 10px;" href="#profil"  class="btn btn-info" data-toggle="tab">Profil Kelompok</a></li>
						</ul>
					</div>
					<div style="clear:both"></div>
				</div>
				<div id="my-tab-content" class="tab-content">
					<div class="tab-pane"  id="tambahpenilaian">
						<div class="text-lg" style="padding:10px 0px">							
							&raquo; Tambah Penilaian Kelas Kelompok Tahun <?php echo date('Y'); ?>							
						</div>

						<form action="" method="post" class="inputpenilaian">
							<div class="bg-gradient-success text-gray-100" style="padding:20px 10px; display:none;" >Data sukses disimpan</div>
							<div class="bg-gradient-danger text-gray-100" style="padding:20px 10px; display:none;" >Data gagal disimpan</div>
							<table class="table table-hover" >                
								<tbody>						
									<tr>
										<td align="left" width="30%" scope="row">Nama Kelompok</td>
										<td align="left">
											<div id="namapoktan1"></div>
											<input type="hidden" name="namapoktan" id="namapoktan2">
											<input type="hidden" name="idpoktan" id="idpoktan">
											<input type="hidden" name="tahun" value="<?php echo date('Y'); ?>">
										</td>							
									</tr>	
									<tr>
										<td align="left" width="30%" scope="row">Skor Kelas Kelompok Awal Tahun</td>
										<td align="left">
											<div id="skor"></div>
											<input type="hidden" name="skorawal" id="skorawal">
										</td>							
									</tr>	
									<tr>
										<td align="left" width="30%" scope="row">Kelas Kelompok Awal Tahun</td>
										<td align="left">
											<div id="kelas"></div>
											<input type="hidden" name="kelasawal" id="kelasawal">
										</td>							
									</tr>	
									<tr>
										<td align="left" width="30%" scope="row">Skor Kelas Kelompok Akhir Tahun</td>
										<td align="left">
											<input type="text" maxlength="4" onkeypress="return isNumberKey(event)" onkeyup="lihatskor()" class="form-control" name="skorakhir" id="skorakhir"	>
										</td>							
									</tr>
									<tr>
										<td align="left" width="30%" scope="row">Kelas Kelompok Akhir Tahun</td>
										<td align="left">
											<div id="kelasjadi"></div>
											<!--
											<select class="form-control" name="kelasakhir" >
                                               <option value="">-pilih kelas-</option>
											   <option value="1">Pemula</option>
											   <option value="2">Lanjut</option>
											   <option value="3">Madya</option>
											   <option value="4">Utama</option>
                                            </select>
											-->
										</td>							
									</tr>
									
									<tr>
										<td align="left" width="30%" scope="row">&nbsp;</td>
										<td align="left">
											<input type="submit" class="btn btn-primary mb-3" name="simpan" id="save"	value="simpan"></td>							
									</tr>
								</tbody>
							</table>
							
						</form>
					</div>
					<div class="tab-pane active"  id="penilaian">
						<div class="text-lg" style="padding:10px 0px">							
							&raquo; Daftar Penilaian Kelas Kelompok
						</div>
						<table class="table table-hover display" id="datatables">
							<thead>
								<tr>
									<th scope="col" align="center">#</th>
									
									<th scope="col" align="center">Tahun</th>
									<th scope="col" align="center">Kelas</th>
									<th scope="col" align="center">Skor</th>  
									<th scope="col" align="center">Sumber</th>  									
									<th scope="col" align="center">Action</th>
								</tr>
							</thead>
							<tbody id="tabel">
																
							</tbody>
						</table>
					
						
					</div>
					<div class="tab-pane " id="profil">
						<div class="text-lg" style="padding:10px 0px">	&raquo; Detail Kelompok Tani</div>
						
						<table class="table table-hover" >                
							<tbody>				
								<tr>
									<td align="left" width="30%" scope="row">Nama Kelompok Tani</td>
									<td align="left" width="5%" scope="row">:</td>
									<td align="left"><div id="namapoktan"></div></td>							
								</tr>
								<tr>
									<td align="left" scope="row">Alamat</td>
									<td align="left" scope="row">:</td>
									<td align="left"><div id="alamat"></div></td>							
								</tr>								
									
								<tr>
									<td align="left" scope="row">Kecamatan</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="kecamatan"></div></td>							
								</tr>	
								<tr>
									<td align="left" scope="row">Desa/Kelurahan</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="desa"></div></td>							
								</tr>
								<tr>
									<td align="left" scope="row">Ketua Kelompok</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="ketua"></div></td>							
								</tr>
								<tr>
									<td align="left" scope="row">Jumlah Anggota</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="jumanggota"></div></td>							
								</tr>	

							</tbody>
						</table>
					</div>
				</div>
				
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		
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
				url : "<?php echo base_url().'penyuluh/poktandetail/'?>" + id,
				type: "GET",
				dataType:"json", 
				success: function(response)
				{
					
					var profil = response.datapoktan;
					var tabel = response.tabel;
					var current = response.curyear[0];
					
					$('#detailModal').modal('show'); // show bootstrap modal when complete loaded
					$('#tabel').html(tabel); 
					//$('#aktivitas').html(aktivitas); 
					//alert('mm');
					$('#namapoktan').text(profil.nama_poktan);
					$('#namapoktan1').text(profil.nama_poktan);					
					$('#alamat').text(profil.alamat); 
					$('#kecamatan').text(profil.nm_kec);
					$('#desa').text(profil.nm_desa);
					$('#ketua').text(profil.ketua_poktan); 
					$('#jumanggota').text(profil.jum_anggota); 
					
					$('#skor').text(current.skor); 
					$('#kelas').text(current.kelas); 
					$('#skorawal').val(current.skor); 
					$('#kelasawal').val(current.kelas);
					$('#idpoktan').val(response.idpoktan);
					$('#namapoktan2').val(profil.nama_poktan);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error get data from ajax');
				}
			});
		}
		
		
		
		$('#opsipoktan').change(function(){
			$.post("<?php echo base_url(); ?>" + "penyuluh/getanggotapoktan/"+$('#opsipoktan').val(),{},function(obj){
				$('#jumanggota').html(obj+' orang');
				$('#jumlahanggota').val(obj);
			});
		});
		
		$('#save').on('click', function(e) {
			//e.preventDefault();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "penyuluh/simpanpenilaian/",
				data: $('form.inputpenilaian').serialize(),
				success: function(response) {
					//console.log(response);
					if (response.status == "error"){
						alert(response.status);
						$(".gagal").show();
					}
					else {						
						$('#kelasjadi').text("");
						$("form").trigger("reset");		
						$('#tabel').html(response.tabel); 
						//$('#detailModal').modal('hide');
						$('#successModal').modal('show');
						//$('#datatables').DataTable().ajax.reload();
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
		
		function hapusin(id) {
			$.ajax({
				url : "<?php echo base_url().'penyuluh/ajax_hapuskelompok/'?>" + id,
				type: "GET",
				success: function(data)		{
					data = JSON.parse(data);
					if(data.status) //if success close modal and reload ajax table
					{						
						$("form").trigger("reset");								
						$('#hapusModal').modal('hide');
						$('#successModal').modal('show');					
						$('#tabel').html(data.tabel); 
						//$('#msg').text('Data berhasil dihapus..');
						//$('#datatables').DataTable().ajax.reload();
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
      