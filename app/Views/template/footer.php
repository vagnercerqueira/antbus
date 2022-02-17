			</section>
			<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->
			<footer class="main-footer">
				<!-- To the right -->
				<div class="float-right d-none d-sm-inline">
					<a href="https://antwort.com.br">antwor</a>
				</div>
				<!-- Default to the left -->
				<strong>arkivar </strong>| Sistema de armazenamento e gerenciamento de documentos
			</footer>

			<!-- Control Sidebar -->
			<aside class="control-sidebar control-sidebar-dark">
				<!-- Control sidebar content goes here -->
			</aside>
			<!-- /.control-sidebar -->
			</div>
			<!-- ./wrapper -->

			<!-- jQuery -->
			<script src="<?php echo base_url('assets/adminlte504/plugins/jquery/jquery.min.js'); ?>"></script>
			<!-- Bootstrap 4 -->
			<script src="<?php echo base_url('assets/adminlte504/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
			<script src="<?php echo base_url('assets/adminlte504/plugins/toastr/toastr.min.js'); ?>"></script>
			<script src="<?php echo base_url('assets/adminlte504/plugins/bs-custom-file-input/bs-custom-file-input.min.js'); ?>"></script>
			<!-- DataTables -->
			<?php
			if (isset($arquivo_dataTable)) :
			?>
				<script src="<?php echo base_url('assets/adminlte504/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
				<script src="<?php echo base_url('assets/adminlte504/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
				<script src="<?php echo base_url('assets/adminlte504/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
				<script src="<?php echo base_url('assets/adminlte504/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
				<script type="text/javascript">
					$.extend($.fn.dataTable.defaults, {
						language: {
							url: "<?php echo base_url('assets/js/datatable_Portuguese-Brasil.json'); ?>"
						}
					});
					$(document).ready(function() {
						bsCustomFileInput.init();
					});
					var initDataTable = (param={})=> { 
						
						var idTab = param.idTab ?? 'tableBasicas';
						var urlTab = param.urlTab ?? 'DataTable';
						var btCsv = param.btCsv ?? false;
						var paramUrl = param.paramUrl ?? {};
						
						console.log(urlTab);											
						var tb = $('#'+idTab).DataTable({
							"processing": true,
							"serverSide": true,
							"ajax": {
								url: pag_url + urlTab,
								data: function(d) {
									Object.keys(paramUrl).forEach(indicie => {
										d[indicie] = paramUrl[indicie];
									})
								}
							},
							"paging": true,
							//"lengthChange": false,
							//"searching": false,
							"ordering": true,
							"info": true,
							"autoWidth": false,
							"responsive": true,
							"columnDefs": [
								{
									"className": 'text-center',
									"width": "20%",
									"targets": -1,
									"orderable": false
								}
							],
							"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
							"initComplete": function(settings, json) {
								if(param.btCsv === true)
									$("#"+settings.sTableId+"_length").append('&nbsp;&nbsp;<a href="javascript:;" onclick="DataTableCsv(\''+settings.sTableId+'\', this)" class="btn btn-primary btn-sm"><i class="far fa-file-excel"></i>&nbsp;CSV</a>');
							}							
						});							
						return tb;						
					};
					var DataTableCsv = (idTabela, exportBtn) => {

						const nameTable = ( document.querySelector(".titulo_pag").innerHTML ).replace(" ", "_");
						
						const tableRows = document.querySelectorAll("#" + idTabela + " tr");						
						const rowsArr = Array.from(tableRows)
							.map(row => Array.from((row.cells))
								.map(cell => cell.textContent)
							);
						var csvString = [];
						rowsArr.forEach((row, i) => { row.pop(); csvString[i] = (rowsArr[i].join(";")) });
						exportBtn.setAttribute('href', `data:application/csv;charset=UTF-8,${encodeURIComponent(csvString.join('\n'))}`);
						exportBtn.setAttribute('download', nameTable+'.csv');
					}					
				</script>
			<?php
			endif;
			?>
			<!-- AdminLTE App -->
			<script src="<?php echo base_url('assets/adminlte504/dist/js/adminlte.min.js'); ?>"></script>
			<script src="<?php echo base_url('assets/js/app/app.js'); ?>"></script>
			<?php
			if (isset($arquivo_js)) {
				foreach ($arquivo_js as $r) {
					echo '<script src="' . base_url() . '/assets/js/' . $r . '.js"></script>';
				}
			}
			if ($js_crud !== false)
				echo '<script src="' . base_url() . '/assets/js/app/crud.js"></script>';
			if ($js_app !== false)
				echo '<script src="' . base_url() . '/assets/js/app/' . $js_app . '.js"></script>';
			?>
			<script>
				var qtd_acesso = "<?php echo session()->get('qtd_acessos'); ?>";
				var super_user = "<?php echo session()->get('superusuario'); ?>";
				if ( ( qtd_acesso ) == 1 && super_user !== 'S') {
					trocar_senha();
					document.querySelector(".altera_senha-modal-sm button[type='reset']").remove();
					document.getElementById("altsenhaprimacc").innerHTML = '* Primeiro acesso, altere a senha.';
				}
			</script>
			</body>

			</html>