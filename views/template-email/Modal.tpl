
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="{url action=new}" id="create-form" class="validate" method="post">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"
				aria-hidden="true">&times;</button>
			<h3 id="myModalLabel">{$i18n->_('Template for Ticket Type')}</h3>
		</div>
		<div class="modal-body">
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Ticket Type')}</label>
				</div>
				<span class="input"> {html_options options=$kindOfTickets
					id="kind_of_ticket" name="kind_of_ticket" class="span4 required"} </span>
			</div>
		</div>
		<div class="modal-footer">
			<a id="create" class="btn btn-primary"
				value="">{$i18n->_('Create')}</a>
		</div>
	</form>
</div>
