<link rel="stylesheet" media="screen" type="text/css" href="{$baseUrl}/js/modules/customize/css/colorpicker.css" />
<script type="text/javascript" src="{$baseUrl}/js/modules/customize/js/colorpicker.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/modules/customize/form.js"></script>
<div id="styledForm">{$form}
<form class="validate" enctype="application/x-www-form-urlencoded" method="post" action="/symphony/customize/{$actionForm}">
    <fieldset>
        <div class="clearfix {if $errors['id_company']} error{/if}">
            <div id="id-company-label">
                <label for="id-company" class="required">{$i18n->_('Company')}</label>
            </div>
            <span class="input">
               {html_options name=id_company id=id_company options=$companies class="span4 required valid" selected=$post['id_company']}
                {if $errors['id_company']}
                {foreach $errors['id_company'] as $error}
                    <span class="help-inline">{$error}</span>
                {/foreach}
                {/if}
            </span>
         </div>
         <div class="clearfix {if $errors['logo']} error{/if}">
            <div id="logo-label">
                <label for="logo" class="required">{$i18n->_('Logo')}</label>
            </div>
            <span class="input">
                <input type="file" name="logo" id="logo"  class="large" />
                {if $errors['logo']}
                {foreach $errors['logo'] as $error}
                    <span class="help-inline">{$error}</span>
                {/foreach}
                {/if}
            </span>
         </div>
         <div class="clearfix {if $errors['background_color']} error{/if}">
            <div id="background-color-label">
                <label for="background-color" class="required">{$i18n->_('Background color')}</label>
            </div>
            <span class="input">
                <input type="text" name="background_color" id="background_color"  class="large colorPicker" />
                {if $errors['background_color']}
                {foreach $errors['background_color'] as $error}
                    <span class="help-inline">{$error}</span>
                {/foreach}
                {/if}
            </span>
         </div>
         <div class="clearfix {if $errors['forward_color']} error{/if}">
            <div id="forward-color-label">
                <label for="forward_color" class="required">forward color</label>
            </div>
            <span class="input">
                <input type="text" name="forward_color" id="forward_color"  class="large colorPicker" />
                {if $errors['forward_color']}
                {foreach $errors['forward_color'] as $error}
                    <span class="help-inline">{$error}</span>
                {/foreach}
                {/if}
            </span>
         </div>
         <div class="clearfix {if $errors['font_size']} error{/if}">
            <div id="font-size-label">
                <label for="font-size" class="required">{$i18n->_('Font size')}</label>
            </div>
            <span class="input">
                <input type="text" name="font_size" id="font_size"  class="large" />
                {if $errors['font_size']}
                {foreach $errors['font_size'] as $error}
                    <span class="help-inline">{$error}</span>
                {/foreach}
                {/if}
            </span>
         </div>
         <div class="actions">
            <input type="submit" name="send" id="send" value="{$i18n->_('Save')}" class="btn primary">
            <input type="button" name="cancel" id="cancel" value="{$i18n->_('Cancel')}" class="btn">
        </div>
    </fieldset>
</form>
</div>