<h3>Edit Icons</h3>

<form method="post" action="{$baseUrl}/menu/save-icons">
	<div class="row">
		<div class="span12">
			<table class="table">
				<tbody>
					{$i = 0}
					{foreach $items as $item}
					<tr>
						<td>
							{$item['name']}	
						</td>
						<td>
							<input type="hidden" name="items[{$i}][id_menu_item]" value="{$item['id_menu_item']}">
							<input type="text" name="items[{$i}][icon]" value="{$item['icon']}">
						</td>
					</tr>
					{$i = $i + 1}
					{/foreach}
				</tbody>
			</table>
		</div>
		
	</div>
	<div class="row">
		<div class="form-actions">
			<input type="submit">
		</div>
	</div>
</form>