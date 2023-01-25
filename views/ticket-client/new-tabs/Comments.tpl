<div id="commentsTab">
<table class="zebra-striped bordered-table">
		<caption>
			<h3>{$i18n->_('Comments')}</h3>
		</caption>
		<thead>
			<tr>
				<th>#</th>
				<th>{$i18n->_('User')}</th>
				<th>{$i18n->_('Date')}</th>
				<th>{$i18n->_('Comment')}</th>
			</tr>
		</thead>
		<tbody>
			{foreach $arrayComments as $comment}
			<tr>
                            {assign var="name" value=$comment['name']|cat:" "|cat:$comment['last_name']|cat:" "|cat:$comment['middle_name']} 
				<td>{$comment['id_comment']}</td>
				<td>{$name}</td>
				<td>{substr($comment['creation_date'],0,19)}</td>
				<td>{$comment['note']}</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
</div>