<form method="post" id="form_upload">
	<div class="card card-default">
	<?php if(count($dados_card_upload) > 0): ?>
		<div class="card-header">
			<span class='qtd_carros'><?php echo count($dados_card_upload); ?></span> Carros &nbsp;<span class='ultima_data'><?php echo (count($dados_card_upload) > 0 ? $dados_card_upload[0]['DT_ARQUIVO'] : ""); ?></span>
		</div>
	<?php endif; ?>
		<div class="card-body">
			<div class="row">
				<div class="col-12">
					<label class='text-danger'>* Arquivos aceitos (TG, TGS, TGM).txt ou UD.zip </label>
					<span class='float-right timer_upload'>
						<span class="timer_upload_ini"></span>
						<span class="timer_upload_fim"></span>
					</span>
					<input type="file" multiple accept=".txt, .zip" id="files_bil" style="visibility: hidden" name="files_bil[]" />
				</div>
			</div>
			<div class="row row_msg_upload"></div>
			<div id="actions" class="row">
				<div class="col-lg-12">
					<div class="btn-group w-100">
						<span class="btn btn-success col fileinput-button dz-clickable" onclick="openDialog()">
							<i class="fas fa-plus"></i>
							<span>Add arquivos</span>
						</span>
						<button type="submit" class="btn btn-primary col start">
							<i class="fas fa-upload"></i>
							<span>Iniciar upload</span>
						</button>
						<button type="reset" class="btn btn-warning col cancel">
							<i class="fas fa-times-circle"></i>
							<span>Cancelar upload</span>
						</button>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<table class="table table-striped table_files table-sm">
						<thead></thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</form>
			