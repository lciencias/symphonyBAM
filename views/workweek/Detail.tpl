<div class="center">
	
	{include file="layout/Messages.tpl"}
	
	<h3>{$i18n->_('Schedule of')}  {$person->getFullName()}</h3><hr />
	
		<table>
			<thead>
				<tr>
					<th></th>
					{foreach from=$days key=idDay item=nameDay}
					<th>
						{$nameDay}
					</th>
					{/foreach}
				</tr>
			</thead>
			<tbody>
                <tr>
                    <th>{$i18n->_('Start Time')}</th>
                {foreach from=$days key=idDay item=NameDay }
                    <td>
                        {assign var=hour value=$workdays[$idDay].time_start}
                        {if $hour != '00:00'}{$hour}{/if}
                     
                    </td>
                {/foreach}
                </tr>
                <tr>
                    <th>{$i18n->_('Lunch Start Time')}</th>
                {foreach from=$days key=idDay item=NameDay }
                    <td>
                        {assign var=hour value=$workdays[$idDay].time_lunch_start}
                        {if $hour != '00:00'}{$hour}{/if}
                    </td>
                {/foreach}
                </tr>
                <tr>
                    <th>{$i18n->_('Lunch End Time')}</th>
                {foreach from=$days key=idDay item=NameDay }
                    <td>
                        {assign var=hour value=$workdays[$idDay].time_lunch_end}
                        {if $hour != '00:00'}{$hour}{/if}
                    </td>
                {/foreach}
                </tr>
                <tr>
                    <th>{$i18n->_('End Time')}</th>
                {foreach from=$days key=idDay item=NameDay }
                    <td>
                        {assign var=hour value=$workdays[$idDay].time_end}
                        {if $hour != '00:00'}{$hour}{/if}
                    </td>
                {/foreach}
                </tr>
                <tr>
                    <th>{$i18n->_('Tolerance(minutes)')}</th>
                {foreach from=$days key=idDay item=NameDay }
                    <td>
                        {assign var=tolerance value=$workdays[$idDay].tolerance}
                        {$tolerance}
                    </td>
                {/foreach}
                </tr>
            </tbody>
		</table>
		
		<hr /> 

			<a href="{$baseUrl}/workday/edit/idPerson/{$person->getIdPerson()}">Editar</a>

	</form>
</div>

<script type="text/javascript" src="{$baseUrl}/js/modules/workday/detail.js"></script>
