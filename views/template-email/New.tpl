<script type="text/javascript">
kindOfTicket = {$kindOfTicket};
</script>
<script type="text/javascript" src="{$baseUrl}/js/modules/template-email/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/modules/template-email/form.js"></script>
<script type="text/javascript"> 
tinyMCE.init({
    // General options
    mode : "textareas",
    theme : "advanced",
    plugins : "autolink,table,advimage,inlinepopups,paste,insertdatetime, -example",
            
    // Theme options
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,|,cut,copy,paste,|,bullist,numlist,|outdent,indent",
    theme_advanced_buttons2 : "undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,preview,|,forecolor,backcolor,|,tablecontrols,|,hr,removeformat,|,insertdate, inserttime,|,mylistbox",
    theme_advanced_buttons3 : "",
    theme_advanced_buttons4 : "styleprops,|,cite,abbr,acronym,del,ins,attribs",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    
    plugin_insertdate_dateFormat:"%d-%B-%Y", 
    plugin_insertdate_timeFormat:"%H:%M" ,

    // Example content CSS (should be your site CSS)
    content_css : "{$baseUrl}/js/modules/template-email/tinymce/examples/css/content.css",

    // Drop lists for link/image/media/template dialogs
    template_external_list_url : "lists/template_list.js",
    external_link_list_url : "lists/link_list.js",
    external_image_list_url : "lists/image_list.js",
    media_external_list_url : "lists/media_list.js",

        });
  </script>
<div id="styledForm" class="">
<br /><h3>{$i18n->_('Template Email')}</h3>
<form class="validate" enctype="application/x-www-form-urlencoded" method="post" action="{$baseUrl}/template-email/{$actionForm}">
    <fieldset>
        <div class="clearfix {if $errors['name']} error{/if}">
            <div id="name-label">
                <label for="name" >{$i18n->_('Name')}</label>
            </div>
            <span class="input">
                <input type="text" name="name" id="name" class="required" value="{$template['name']}">
                {if $errors['name']}
                    {foreach $errors['name'] as $error}
                        <span class="help-inline">{$error}</span>
                    {/foreach}
                {/if}
            </span>
        </div>
        <div class=" clearfix {if $errors['subject']} error{/if}">
                <div id="subject-label">
                    <label for="subject" >{$i18n->_('Subject')}</label>
                </div>
            <span class="input">
                <input type="text" name="subject" id="subject" class="required" value="{$template['subject']}">
                {if $errors['subject']}
                {foreach $errors['subject'] as $error}
                    <span class="help-inline">{$error}</span>
                {/foreach}
                {/if}
            </span>
             
       </div>
       
       <div class=" clearfix {if $errors['subject']} error{/if}">
       
       <span class="{if $errors['event']} error{/if}">
                <div id="id-event-label">
                    <label for="event" class="required">{$i18n->_('Event')}</label>
                </div>
             </span>
             <span class="input">
                    {html_options name=event id=event options=$events class="span4 required valid" selected=$template['event']}
                </span>
                    {if $errors['event']}
                        {foreach $errors['id_event'] as $error}
                            <span class="help-inline">{$error}</span>
                        {/foreach}
                    {/if}
       
       </div>
       
        <div class="clearfix {if $errors['language']} error{/if}">
                <div id="id_language-label">
                    <label for="language" class="required">{$i18n->_('Language')}</label>
                </div>
                <span class="input">
                    {html_options name=language id=language options=$languages class='span4 required valid' selected=$template['language']}
                </span>
                    {if $errors['language']}
                        {foreach $errors['language'] as $error}
                            <span class="help-inline">{$error}</span>
                        {/foreach}
                    {/if}
            </div>
       
       <div class="clearfix {if $errors['account']}error{/if}" >
              <div id="account-label">
                 <label>{$i18n->_('Account')}</label>
              </div>
            <span class="input">
             <label>{$i18n->_('To employee')}</label>         
            </span>
            <span class="input">
                <input type="hidden" name="to_employee" value="0" />
                <input type="checkbox" name="to_employee" id="to_employee" {if $template['to_employee'] == 1}checked="checked"{/if} value="1" /> 
            </span>
            <span class="input">
                <label>{$i18n->_('To user')}</label>         
            </span>
            <span class="input">
                <input type="hidden" name="to_user" value="0" />
                <input type="checkbox" name="to_user" id="to_user" {if $template['to_user'] == 1}checked="checked"{/if} value="1" /> 
            </span>
            <span class="input">
                <label>{$i18n->_('To group')}</label>         
            </span>
            <span class="input">
                <input type="hidden" name="to_group" value="0" />
                <input type="checkbox" name="to_group" id="to_group" {if $template['to_group'] == 1}checked="checked"{/if} value="1" /> 
            </span>
           
        </div>  
       <input type="hidden" name="status" value="1" />
        </fieldset>
        <div class="center">
    <textarea name="body" cols="90" rows="20">{$template['body']}</textarea>
        <div class="actions">
            <input type="submit" name="send" id="send" value="{$i18n->_('Save')}" class="btn primary">
            <input type="button" name="cancel" id="cancel" value="{$i18n->_('Cancel')}" class="btn">
        </div>
        </div>
     

</form>
</div>