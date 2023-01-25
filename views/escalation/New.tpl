<script type="text/javascript">
var i = 0;
</script>
<div id="styledForm">
<br /><h3>{$i18n->_('Escalation')}</h3>
<form class="validate" enctype="application/x-www-form-urlencoded" method="post" action="{$baseUrl}/escalation/{$actionForm}">
    <fieldset>
        <div class="clearfix {if $errors['name']} error{/if}">
            <label for="name" class="required">{$i18n->_('Name')}</label>
            <div class="input">
                <input type="text" name="name" id="name" value="{$escalation['name']}">
                {if $errors['name']}
                {foreach $errors['name'] as $error}
                    <span class="help-inline">{$error}</span>
                {/foreach}
                {/if}
            </div>
            
        </div>

        <a href="#" id="addEscalation"><img src="{$baseUrl}/images/template/icons/add.png" class="tip" title="{$i18n->_('Add.')}" />{$i18n->_('Add.')}</a>
        <div id="container">
            {foreach from=$details key=i item=detail}
                  <span>
                     <br />
                     <a href="#" class="removeEscalation"><img src="{$baseUrl}/images/template/icons/delete.png" class="tip" title="{$i18n->_('Delete')}" /></a>
                     
                     {$i18n->_('Percentage')}: <input type="text" id="percentage{$i}" dataindex="percentage" name="percentage[{$i}]" class="span2 required digits" value="{$detail['percentage']}" />
                     
                     {$i18n->_('Type')}: {html_options options=$types dataindex=type name="type[{$i}]" class="typeButton required" selected=$detail['type']}
                     
                     <input type="text" name="autocomplete[{$i}]"  dataindex="autocomplete" value="{$detail['autocomplete']}" id="autocompleteEmployee{$i}" class="autocompleteEmployee required" />
                     
                     <input name="value[{$i}]" type="text" dataindex="value" value="{$detail['value']}" id="percentage_{$i}" class="value required" />
                  
                     {if $errors[$i]}{foreach $errors[$i] as $error}<span class="error">{$error}</span>{/foreach}{/if}   
                  </span>
                  
                  
                  
                  <script type="text/javascript">i++</script>
            {/foreach}
        </div>
        
        <div class="actions">
            <input type="submit" name="send" id="send" value="{$i18n->_('Save')}" class="btn primary">
            <input type="button" name="cancel" id="cancel" value="{$i18n->_('Cancel')}" class="btn">
        </div>
        
    </fieldset>
</form>
</div>
<script type="text/javascript" src="{$baseUrl}/js/modules/escalation/form.js"></script>
