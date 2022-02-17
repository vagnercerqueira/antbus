<form id="form_param_geral" autocomplete="off">
	<div class="form_crud_modal">
		<input type="hidden" name="ID" id="ID" />
		<div class="row">
			<div class="col-md-2">
				<label for="">Tipos registro</label> 
			</div>
		</div>
		<div class="row">
			<?php foreach($option_import_tipos as $k=>$v): ?>
				<div class="col-md-2">
                      <input type="checkbox" id="BIL_TIPOS_REG" name="BIL_TIPOS_REG[]" value="<?php echo $k; ?>">&nbsp;<?php echo $v.'('.$k.')'; ?></small>                        
                </div>&nbsp;&nbsp;&nbsp;		
			<?php endforeach; ?>
		</div>
		<div class="row">
			<div class="col-md-2">
				<label for="">Estados servico(001)</label> 
			</div>
		</div>
		<div class="row">
			<?php foreach($option_estados_001 as $k=>$v): ?>
				<div class="col-md-1">
                      <input type="checkbox" id="BIL_ESTADOS_001" name="BIL_ESTADOS_001[]" value="<?php echo $v; ?>">&nbsp;<?php echo $v; ?></small>                        
                </div>&nbsp;&nbsp;&nbsp;		
			<?php endforeach; ?>
		</div>
		<?php echo ns_BtnFormulario(); ?>
	</div>
	<?php echo ns_BtNovo(); ?>
	<table class="table table-bordered dataTable table-sm" id="tableBasicas">
		<thead>
			<tr>
				<th>Tipos registro</th>
				<th>Estados servico(001)</th>
				<th>AÇAO</th>
			</tr>
		</thead>
	</table>
</form>