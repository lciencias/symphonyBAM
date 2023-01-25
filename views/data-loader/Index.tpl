<div id="styledForm">
<br /><h3>{$i18n->_('Upload Data')}</h3>
	<form class="validate" action="" enctype="multipart/form-data" method="post">
		<fieldset>
			<div class="clearfix ">
				<label for="name" class="required">{$i18n->_('File')}</label>
				<div class="input">
					<input type="file" data-rule="^.*(.xls|.xlsx).*$" name="file" id="file" class="required validFiles" />
				</div>
		
			</div>
		
			<div class="actions">
				<input type="submit" name="send" id="send" value="{$i18n->_('Upload')}" class="btn primary"> 
			</div>
		</fieldset>
	</form>
</div>