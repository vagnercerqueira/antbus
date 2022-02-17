<div class="row">
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-success box_upload">
			<div class="inner">
				<h4>Transações </h4>
				<p>Uso de cartão</p>
			</div>

			<a href="javascript:;" onclick="eventos_table(1)" class="small-box-footer">Consultar&nbsp;&nbsp;<i class="fa fa-id-card"></i></a>
		</div>
	</div>
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-primary box_upload">
			<div class="inner">
				<h4>Intervalo de horario</h4>
				<p>Pagantes x Gratuidade </p>
			</div>

			<a href="javascript:;" onclick="eventos_table(2)"  class="small-box-footer">Consultar&nbsp;&nbsp;<i class="fa fa-clock"></i></a>
		</div>
	</div>
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-danger box_upload">
			<div class="inner">
				<h4>Cartao Rejeitado</h4>
				<p>Cartao / Motivo </p>
			</div>

			<a href="javascript:;" onclick="eventos_table(3)"  class="small-box-footer">Consultar&nbsp;&nbsp;<i class="fas fa-stopwatch"></i></a>
		</div>
	</div>	
</div>
<!-- /.modal transacoes -->

<div class="modal fade" id="modal-transacoes" data-backdrop="static">
	<div class="modal-dialog modal-xl modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Consultar transações</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" id="form_transacao">
					<div class="row">
						<!-- <div class="col-xl-3 monta_seach" mysearch='{"ID": "VEICULO", "LABEL": "Veiculo", "LIST": []}'></div>-->
						<div class="col-1">
							<label>Carro</label>
							<input type="number" min=1 max='999999' step=1 name="CARRO" id="CARRO" class="form-control-sm form-control text-center" />
						</div>
						<div class="col-sm-1">
							<label for="NOME_LINHA">Linha</label>
							<input id="LINHA" name="LINHA" type="number" min=1 max='999999' class='form-control-sm form-control text-center'/>
						</div>							
					<div class="col-sm-1">
						<label for="SENTIDO">Sentido</label>
						<select id="SENTIDO" name="SENTIDO" class='custom-select custom-select-sm'>
							<option value="">Todos</option>
							<option value=0>Ida</option>
							<option value=1>Volta</option>
						</select>
					  </div>
                     <div class="col-sm-1 transac">
						<label for="BOLSAO">Bolsao ?</label>
						<select id="BOLSAO" name="BOLSAO" class='custom-select custom-select-sm'>
							<option value='N' selected>Nao</option>
							<option value='S'>Sim</option>
							<option value=''>Todos</option>
						</select>
					  </div>
                     <div class="col-sm-1 transac">
						<label for="EMBARQUE">Embarque</label>
						<select id="EMBARQUE" name="EMBARQUE" class='custom-select custom-select-sm'>
							<option value='G'>Grat</option>
							<option value='P'>Pag</option>
							<option value='' selected>Todos</option>
						</select>
					  </div>					  
                     <div class="col-sm-1 transac">
						<label for="STATUS">Status</label>
						<select id="STATUS" name="STATUS" class='custom-select custom-select-sm'>
							<option value='0' selected>0 (Sucesso)</option>
							<option value='1'>1 (Time Out)</option>
							<option value=''>Todos</option>
						</select>
					  </div>					  				  
					  <div class="col-sm-1">
						<label for="HRI">Hr. ini</label>
						<input type="time" name="HRI" id="HRI" class='form-control-sm form-control text-center'  />
					  </div>
					  <div class="col-sm-1">
						<label for="HRF">Hr. fim</label>
						<input type="time" name="HRF" id="HRF" class='form-control-sm form-control text-center' />
					  </div>						  						  		
                     <div class="col-sm-2">
						<label for="DTI">Data Ini</label>
						<input type="date" name="DTI" class='form-control-sm form-control text-center'  id="DTI" value="<?php echo date('Y-m-d', strtotime('-1 day'));?>" required />
					  </div>
                     <div class="col-sm-2">
						<label for="DTF">Data Fim</label>
						<input type="date"  class='form-control-sm form-control text-center' name="DTF" id="DTF" value="<?php echo date('Y-m-d', strtotime('-1 day'));?>" required />
					  </div>

					<!--	<div class="col-1">
							<label>&nbsp</label>
							<div><button type="submit" class="btn btn-primary float-right btn-sm btn_consulta_transacao"><i class="fa fa-search"></i></button></div>
						</div>-->
					</div>
					<br>
					<div class="row row_transacao">
						<div class="col-12">
							<div class="card">
								<div class="card-body table-responsive p-0">
									<table  style='font-size: 11px' class="table table-head-fixed table-sm table-bordered table-hover table-sm" id="table_transacao">
										<thead>
											<tr>
												<th>Data</th>
												<th>Hora</th>
												<th>Estado</th>
												<th>Carro</th>
												<th>Mot</th>
												<th>Linha</th>
												<th>Turno</th>
												<th>Sentido</th>
												<th>Embarque</th>
												<th>Cartao</th>
												<th>TSN</th>
												<th>Aplicacao</th>
												<th>Debitado</th>
												<th>Tarifa</th>
												<!-- <th>Arquivo</th> -->
											</tr>
										</thead>
									</table>
								</div>
								<!-- /.card-body -->
							</div>
							<!-- /.card -->
						</div>
					</div>
					
					<div class="row row_intervalo">
						<div class="col-12">
							<div class="table-responsive-sm">
								<table style='font-size: 11px' class="table table-head-fixed table-sm table-bordered table-hover table-sm" id="table_intervalo">
									<thead>
										<tr>
											<th>DATA</th>
											<th>LINHA</th>
											<th>SENTIDO</th>
											<th>CARRO</th>
											<th>HR INI</th>
											<th>HR FIM</th>
											<th>MOTORISTA</th>
											<th>PAGANTES(<span class='pag_int'></span>)</th>
											<th>GRATUIDADES(<span class='grt_int'></span>)</th>
										</tr>
									</thead>
								<!--	<tbody></tbody>
									<tfoot>
										<tr>
											<th colspan="7" class="text-right">Total (pagante+gratuidade): </th>
											<th colspan="2" class="total_intervalo"></th>
										</tr>
									</tfoot> -->
								</table>
							</div>
						</div>
					</div>
					<div class="row row_rejeitados">
						<div class="col-12">
							<div class="table-responsive-sm">
								<table style='font-size: 11px' class="table table-head-fixed table-sm table-bordered table-hover table-sm" id="table_rejeitados">
									<thead>
										<tr>
											<tr>
												<th>Data</th>
												<th>Hora</th>
												<th>Estado</th>
												<th>Carro</th>
												<th>Mot</th>
												<th>Linha</th>
												<th>Turno</th>
												<th>Sentido</th>
												<th>Cartao</th>
												<th>Aplicacao</th>
												<th>Erro</th>
											</tr>
										</tr>
									</thead>
								<!--	<tbody></tbody>
									<tfoot>
										<tr>
											<th colspan="7" class="text-right">Total (pagante+gratuidade): </th>
											<th colspan="2" class="total_intervalo"></th>
										</tr>
									</tfoot> -->
								</table>
							</div>
						</div>
					</div>					
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger float-right btn-sm" data-dismiss="modal">Voltar</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<!-- /.modal intervalo horario -->

