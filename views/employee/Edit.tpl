<script type="text/javascript" src="{$baseUrl}/js/modules/employee/new.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/modules/employee/company_combos.js"></script>
<script type="text/javascript">
var i = 0;
var j = 0;
</script>
<div id="styledForm">
<br /><h3>{$i18n->_('Employee')}</h3>
<form class="validate" enctype="application/x-www-form-urlencoded" method="post" action="{url action=$actionForm}">
    <fieldset>
        <div class="clearfix {if $errors['name']} error{/if}">
            <div id="name-label">
                <label for="name" class="required">{$i18n->_('Name')}</label>
            </div>
            <span class="input">
                <input type="text" name="name" id="name" value="{$employee['name']}" class="required">
                {if $errors['name']}
                {foreach $errors['name'] as $error}
                    <span class="help-inline">{$error}</span>
                {/foreach}
                {/if}
            </span>
            
        </div>
        
        <div class="clearfix {if $errors['last_name']} error{/if}">
                <div id="last_name-label">
                    <label for="last_name" class="required">{$i18n->_('Last Name')}</label>
                </div>
            <span class="input">
                <input type="text" name="last_name" id="last_name" value="{$employee['last_name']}" class="required">
                {if $errors['last_name']}
                {foreach $errors['last_name'] as $error}
                    <span class="help-inline">{$error}</span>
                {/foreach}
                {/if}
            </span>
            
        </div>
        
        <div class="clearfix {if $errors['middle_name']} error{/if}">
            <div id="middle_name-label">
            <label for="name" class="required">{$i18n->_('Middle Name')}</label>
            </div>
            <span class="input">
                <input type="text" name="middle_name" id="middle_name" value="{$employee['middle_name']}" class="required">
                {if $errors['middle_name']}
                {foreach $errors['middle_name'] as $error}
                    <span class="help-inline">{$error}</span>
                {/foreach}
                {/if}
            </span>
            </div>
            
            <div class="clearfix {if $errors['id_company']} error{/if}">
                <div id="id_company-label">
                    <label for="id_company" class="required">{$i18n->_('Company')}</label>
                </div>
                <span class="input">
                    {html_options name=id_company id=id_company options=$companies class='span4 required valid' selected=$post['id_company']}
                </span>
                    {if $errors['id_company']}
                        {foreach $errors['id_company'] as $error}
                            <span class="help-inline">{$error}</span>
                        {/foreach}
                    {/if}
            </div>
            <div class="clearfix {if $errors['id_position']} error{/if}">
                <div id="id_position-label">
                    <label for="id_position" class="required">{$i18n->_('Position')}</label>
                </div>
                <span class="input">
                    {html_options name=id_position id=id_position options=$positions class='span4 required valid' selected_id=$post['id_position'] ajax_url={url action=json controller=position}}
                </span>
                    {if $errors['id_position']}
                        {foreach $errors['id_position'] as $error}
                            <span class="help-inline">{$error}</span>
                        {/foreach}
                    {/if}
            </div>
            <div class="clearfix {if $errors['id_area']} error{/if}">
                <div id="id_area-label">
                    <label for="id_area" class="required">{$i18n->_('Area')}</label>
                </div>
                <span class="input">
                    {html_options name=id_area id=id_area options=$areas class='span4 required valid' selected_id=$post['id_area'] ajax_url={url action=json controller=area}}
                </span>
                    {if $errors['id_area']}
                        {foreach $errors['id_area'] as $error}
                            <span class="help-inline">{$error}</span>
                        {/foreach}
                    {/if}
            </div>
            <div class="clearfix {if $errors['id_location']} error{/if}">
                <div id="id_location-label">
                    <label for="id_location" class="required">{$i18n->_('Location')}</label>
                </div>
                <span class="input">
                    {html_options name=id_location id=id_location options=$locations class='span4 required valid' selected_id=$post['id_location'] ajax_url={url action=json controller=location}}
                </span>
                    {if $errors['id_location']}
                        {foreach $errors['id_location'] as $error}
                            <span class="help-inline">{$error}</span>
                        {/foreach}
                    {/if}
            </div>
            
            <div class="clearfix {if $errors['language']} error{/if}">
                <div id="id_language-label">
                    <label for="language" class="required">{$i18n->_('Language')}</label>
                </div>
                <span class="input">
                    {html_options name=language id=language options=$languages class='span4 required valid' selected=$post['language']}
                </span>
                    {if $errors['language']}
                        {foreach $errors['language'] as $error}
                            <span class="help-inline">{$error}</span>
                        {/foreach}
                    {/if}
            </div>
            
            
            <div class="clearfix {if $errors['id_phone']} error{/if}">
                <div id="id_phone-label">
                    <label for="id_phone" class="required">
                        <a href="#" id="addPhone"><img src="{$baseUrl}/images/template/icons/add.png" class="tip" title="{$i18n->_('Add.')}" /></a>
                        {$i18n->_('Phone number')}
                    </label>
                </div>
                <span class="input">
                    
                    <div id="containerPhone">
                        {foreach $phones as $i => $phone}
                              <span>
                              
                                 <br /><a href="#" class="removePhone"><img src="{$baseUrl}/images/template/icons/delete.png" title="{$i18n->_('Delete')}" /></a>
                                 
                                 <input type="text" id="id_phone{$i}" dataindex="id_phone" name="id_phone[{$i}]" class="span2 required digits" value="{$phone['number']}" />
                                 {$i18n->_('Ext.')} <input type="text" id="phone_ext{$i}" dataindex="phone_ext" name="phone_ext[{$i}]" class="span2 digits" value="{$phone['extension']}" />
                                 
                              </span>
                              <script type="text/javascript">i++</script>
                        {/foreach}
                    </div>
                    
                </span>
                {if $errors['id_phone']}
                    {foreach $errors['id_phone'] as $error}
                        <span class="help-inline">{$error}</span>
                    {/foreach}
                {/if}
            </div>
            
            
            <div class="clearfix {if $errors['email']} error{/if}">
                <div id="email-label">
                    <label for="email" class="required">
                        <a href="#" id="addEmail"><img src="{$baseUrl}/images/template/icons/add.png" class="tip" title="{$i18n->_('Add.')}" /></a>
                        {$i18n->_('Email')}
                    </label>
                </div>
                <span class="input">
                    
                    <div id="containerEmail">
                        {foreach $emails as $i => $email}
                              <span>
                              
                                 <br /><a href="#" class="removeEmail"><img src="{$baseUrl}/images/template/icons/delete.png" title="{$i18n->_('Delete')}" /></a>
                                 
                                 <input type="text" id="email{$i}" dataindex="email" name="email[{$i}]" class="span2 required email" value="{$email['email']}" />
                                 
                              </span>
                              <script type="text/javascript">j++</script>
                        {/foreach}
                    </div>
                    
                </span>
                {if $errors['email']}
                    {foreach $errors['email'] as $error}
                        <span class="help-inline">{$error}</span>
                    {/foreach}
                {/if}
            </div>
            
            <input type="hidden" name="status_employee" value="1" />
        <div class="actions">
            <input type="submit" name="send" id="send" value="{$i18n->_('Save')}" class="btn primary">
            <input type="button" name="cancel" id="cancel" value="{$i18n->_('Cancel')}" class="btn">
        </div>
        
    </fieldset>
</form>
</div>