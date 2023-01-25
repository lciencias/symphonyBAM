    
    <h3>{$i18n->_('Schedule')}</h3><hr />

    <form action="{$baseUrl}/workweek/create" method="post" class="validate">
        {if $workweek['id_workweek']}
        <input type="hidden" name="id_workweek" value="{$workweek['id_workweek']}" />
        {/if}
        <div class="clearfix{if $errors['name']} error{/if}">
            <label for="name">{$i18n->_('Name')}</label>
            <div class="input">
                <input type="text" name="name" id="name" class="required" value="{$workweek.name}">
                {if $errors['name']}
                {foreach $errors['name'] as $error}
                    <span class="help-inline">{$error}</span>
                {/foreach}
                {/if}
            </div>
        </div>
    
        <table>
            <thead>
                <tr>
                    <th></th>
                    {foreach from=$days key=idDay item=nameDay}
                    <th>
                        {$i18n->_($nameDay)}
                            {if $workdays[$idDay]}
                                <input type="checkbox" name="enableDays[{$idDay}]" checked="checked" class="enableDays" id="enableDay_{$idDay}" value="1" />
                            {else}
                                <input type="checkbox" name="enableDays[{$idDay}]" class="enableDays" id="enableDay_{$idDay}" value="1" />
                            {/if}
                    </th>
                    {/foreach}
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>{$i18n->_('Start Time')}</th>
                {foreach from=$days key=idDay item=NameDay}
                    <td>
                        {assign var=hour value=$workdays[$idDay].start_time}
                        {assign var=id value="timeStart_{$idDay}"}
                        {assign var=name value="start_time[{$idDay}]"}

                            {if $hour}
                                {html_options name=$name id=$id class=required options=$hours selected=$hour}
                            {else}
                                {html_options name=$name id=$id class=required disabled=disabled options=$hours selected=$hour}
                            {/if}
                    </td>
                {/foreach}
                </tr>
                
                <tr>
                    <th>{$i18n->_('Lunch Start Time')}</th>
                {foreach from=$days key=idDay item=NameDay}
                    <td>
                        {assign var=hour value=$workdays[$idDay].lunch_start_time}
                        {assign var=name value="lunch_start_time[{$idDay}]"}
                        {assign var=id value="timeLunch_{$idDay}"}

                            {if $hour}
                                {html_options name=$name id=$id options=$hours selected=$hour}
                            {else}
                                {html_options name=$name id=$id disabled=disabled options=$hours selected=$hour}
                            {/if}

                    </td>
                {/foreach}
                </tr>
                <tr>
                    <th>{$i18n->_('Lunch End Time')}</th>
                {foreach from=$days key=idDay item=NameDay}
                    <td>
                        {assign var=hour value=$workdays[$idDay].lunch_end_time}
                        {assign var=name value="lunch_end_time[{$idDay}]"}
                        {assign var=id value="timeLunchEnd_{$idDay}"}

                            {if $hour}
                                {html_options name=$name id=$id options=$hours selected=$hour}
                            {else}
                                {html_options name=$name id=$id options=$hours selected=$hour disabled=disabled}
                            {/if}

                    </td>
                {/foreach}
                </tr>
                <tr>
                    <th>{$i18n->_('End Time')}</th>
                {foreach from=$days key=idDay item=NameDay}
                    <td>
                        {assign var=hour value=$workdays[$idDay].end_time}
                        {assign var=name value="end_time[{$idDay}]"}
                        {assign var=id value="timeEnd_{$idDay}"}

                            {if $hour}
                                {html_options name=$name id=$id class=required options=$hours selected=$hour}
                            {else}
                                {html_options name=$name id=$id disabled=disabled class=required options=$hours selected=$hour}
                            {/if}

                    </td>
                {/foreach}
                </tr>

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="8" class="actions">
                         <input type="submit" class="btn primary" value="{$i18n->_('Save')}" id="buttonSend" />
                         <input type="button" class="btn" value="{$i18n->_('Cancel')}" id="cancel" />
                    </th>
                </tr>
            </tfoot>
        </table>
        
        <hr /> 

    </form>

<script type="text/javascript" src="{$baseUrl}/js/modules/workweek/edit.js"></script>
