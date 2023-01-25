{foreach $allowedActions as $header=>$allowedActionArray}
	<h3>{$i18n->_($header)}</h3>
	<hr/>
	<ul>
	{foreach $allowedActionArray as $allowedAction}
		{assign var=action value=$actions->getByPk($allowedAction->getIdAction())}
		{assign var=controller value=$controllers->getByPk($action->getIdController())}
		<li>
			<a href="{$baseUrl}/{$controller->getName()}/{$action->getName()}">
				{$i18n->_($allowedAction->getName())}
			</a>
		</li>
	{/foreach}
	</ul>
{/foreach}