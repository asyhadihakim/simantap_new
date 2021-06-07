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
					url : "<?php echo site_url("penyuluh/penyuluh_data/") ?>",
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
				<label>Pencarian Penyuluh</label>
				<label class="checkbox-inline">
					<input type="text" id="searchInput"  class="form-control"  placeholder="Cari penyuluh.." onkeyup="inputup()">
				</label>				
			</div>
			
            <table class="table table-hover display" id="datatables">
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
                <h5 class="modal-title" id="newSubMenuModalLabel">Pengisian Aktivitas Bulanan</h5>
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
					<div style="float:left; margin-top:10px">
						<h6 >
							<span style="font-weight:bold" id="namalengkap"></span><br />
							<span style="font-weight:bold" id="nip"></span>
						</h6>
					</div>
					<div style="float:right">
						<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
							<li ><a style="margin:10px 10px;" href="#tambahaktivitas" class="btn btn-danger" data-toggle="tab">Tambah Aktivitas</a></li>
							<li class="active"><a style="margin:10px 10px;" href="#aktivitas" class="btn btn-warning" data-toggle="tab">Daftar Aktivitas</a></li>
							<li ><a style="margin:10px 10px;" href="#profil"  class="btn btn-info" data-toggle="tab">Profil Penyuluh</a></li>
						</ul>
					</div>
					<div style="clear:both"></div>
				</div>
				<div id="my-tab-content" class="tab-content">
					<div class="tab-pane"  id="tambahaktivitas">
						<div class="text-lg" style="padding:10px 0px">							
							&raquo; Tambah Aktivitas Bulanan									
						</div>

						<form action="" method="post" class="inputaktivitas">
							
							<table class="table table-hover" >                
								<tbody>						
									<tr>
										<td align="left" width="30%" scope="row">Periode</td>
										<td align="left">
											 <select class="form-control" name="periode">
												 <option value="">-pilih periode-</option>
												<?php 
													$bulan = array('1'=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'); 
													for ($th=2021;$th<=date('Y');$th++){
														foreach ($bulan as $k =>$v){
															echo '<option value="'.$k.'-'.$th.'">'.$v.' '.$th.'</option>';
														}
													}												
												?>
                                            </select>											
                                       </td>							
									</tr>	
									<tr>
										<td align="left" width="30%" scope="row">Kelompok</td>
										<td align="left">
                                            <select class="form-control" name="poktan" id="opsipoktan">
                                                
                                            </select>
                                       </td>							
									</tr>	
									<tr>
										<td align="left" width="30%" scope="row">Jumlah Anggota</td>
										<td align="left"><div id="jumanggota"></div>
											<input type="hidden" name="jumlahanggota" id="jumlahanggota">
											<input type="hidden" name="penyuluh_nip" id="penyuluhnip">
										</td>							
									</tr>	
									<tr>
										<td align="left" width="30%" scope="row">Metode</td>
										<td align="left">
											<select class="form-control" name="metode" id="opsimetode">
                                               
                                            </select>
										</td>							
									</tr>
									<tr>
										<td align="left" width="30%" scope="row">Kategori Teknologi</td>
										<td align="left">
											<select class="form-control" name="teknologi_kategori" id="opsiteknologi">
                                               
                                            </select>
										</td>							
									</tr>
									<tr>
										<td align="left" width="30%" scope="row">Nama Teknologi</td>
										<td align="left">
											<input type="text" class="form-control" name="teknologi_nama" id="exampleFirstName"	></td>							
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
					<div class="tab-pane active"  id="aktivitas">
						<div class="text-lg" style="padding:10px 0px">							
							&raquo; Aktivitas Bulanan
						</div>
						<table class="table table-hover display" id="datatables">
							<thead>
								<tr>
									<th scope="col">#</th>
									
									<th scope="col">Periode</th>
									<th scope="col">Kelompok</th>
									<th scope="col">Metode</th>                                           
									<th scope="col">Kategori Teknologi</th>
									<th scope="col">Nama Teknologi</th>    
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody id="tabel">
																
							</tbody>
						</table>
					
						
					</div>
					<div class="tab-pane " id="profil">
						<div class="text-lg" style="padding:10px 0px">	&raquo; Detail Penyuluh</div>
						
						<table class="table table-hover" >                
							<tbody>				
								<tr>
									<td align="left" width="30%" scope="row">Nama Lengkap</td>
									<td align="left" width="5%" scope="row">:</td>
									<td align="left"><div id="namalengkap1"></div></td>							
								</tr>	
								<tr>
									<td align="left" scope="row">NIP</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="nip1"></div></td>							
								</tr>	
								<tr>
									<td align="left" scope="row">Tempat Tanggal Lahir</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="ttl"></div></td>							
								</tr>	
								<tr>
									<td align="left" scope="row">Jenis Kelamin</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="jenkel"></div></td>							
								</tr>
								<tr>
									<td align="left" scope="row">Alamat</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="alamat"></div></td>							
								</tr>
								<tr>
									<td align="left" scope="row">No HP</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="nohp"></div></td>							
								</tr>	
								<tr>
									<td align="left" scope="row">Email</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="email"></div></td>							
								</tr>	
								<tr>
									<td align="left" scope="row">Status</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="status"></div></td>							
								</tr>	
								<tr>
									<td align="left" scope="row">Penempatan</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="penempatan"></div></td>							
								</tr>	
								<tr>
									<td align="left" scope="row">Unit Kerja</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="unker"></div></td>							
								</tr>	
								<tr>
									<td align="left" scope="row">Gol Ruang</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="golruang"></div></td>							
								</tr>	
								<tr>
									<td align="left" scope="row">Jabatan</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="jabatan"></div></td>							
								</tr>	
								
								<tr>
									<td align="left" scope="row">Wilayah Kerja</td>
									<td align="left" scope="row">:</td>
									<td align="left" ><div id="wilker"></div></td>							
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

<script type="text/javascript" charset="utf-8">

	function viewdetail(id)
		{	
			//Ajax Load data from ajax
			$.ajax({
				//alert('a');
				url : "<?php echo base_url().'penyuluh/detail/'?>" + id,
				type: "GET",
				dataType:"json", 
				success: function(response)
				{
					var profil = response.profil;
					var aktivitas = response.aktivitas;
					var poktan = response.poktan;
					var metode = response.metode;
					var teknologi = response.teknologi;
					var tabel = response.tabel;
					
					$('#detailModal').modal('show'); // show bootstrap modal when complete loaded
					$('#opsipoktan').html(poktan); 
					$('#opsimetode').html(metode); 
					$('#opsiteknologi').html(teknologi); 
					$('#tabel').html(tabel); 
					//$('#aktivitas').html(aktivitas); 
					$('#nip').text(profil.nip); 
					$('#namalengkap').text(profil.namalengkap); 
					$('#nip1').text(profil.nip);
					$('#penyuluhnip').val(profil.nip); 					
					$('#namalengkap1').text(profil.namalengkap); 
					$('#ttl').text(profil.ttl); 
					$('#jenkel').text(profil.jenkel); 
					$('#alamat').text(profil.alamat); 
					$('#nohp').text(profil.hp); 
					$('#email').text(profil.email); 
					$('#penempatan').text(profil.penempatan); 
					$('#status').text(profil.stat); 
					$('#golruang').text(profil.gol_ruang); 
					$('#jabatan').text(profil.jabatan); 
					$('#wilker').text(profil.wilkerja); 
					$('#unker').text(profil.unker); 
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error get data from ajax');
				}
			});
		}
		
		 $("#loading").ajaxStart(function(){
				  $(this).show();
			   }).ajaxStop(function(){
				  $(this).hide();
			   });
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
				url: "<?php echo base_url(); ?>" + "penyuluh/simpanaktivitas/",
				data: $('form.inputaktivitas').serialize(),
				success: function(response) {
					if (response.status == "error"){
						alert(response);
						$(".gagal").show();
					}
					else {
						$("form").trigger("reset");		
						//$('#tabel').html(response.tabel); 
						$('#successModal').modal('show');
						//$(".inputaktivitas").reset();
						//$(".success").show();
					}	
				},
				error: function() {
					alert('Error');
				}
			});
			return false;
		});
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
   display:none;"><img src='http://fungsional.pertanian.go.id/assets/img/ajax_loader.gif' width="80px" /><br />Loading...</div>
      