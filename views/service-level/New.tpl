<script type="text/javascript" src="{$baseUrl}/js/modules/service-level/form.js"></script>

<div id="styledForm" style="width: 1200px;">
<br /><h3>{$i18n->_('Service Level')}</h3>
    <form id="{$form->getId()}" action="{$form->getAction()}" method="post">
        {foreach $form as $element}
            {if $element->getName() == 'slider_response_time'}
                
                <div class="clearfix">
                    <div><label for="note" class="optional">{$i18n->_('Resolution Time')}</label></div>
                    <span class="input">
                    	{$days = $post['resolution_time_days']}
                        {$hours = $post['resolution_time_hour']}
                        {$minutes = $post['resolution_time_minute']}
                    	<input type="hidden" class="input_time" name="resolution_time" value="" id="response_time">
                        {$i18n->_('Days')} &nbsp;&nbsp;<div id="slider_resolution_time_days" class="slider_days" dataValue="{$days}"></div>
						{$i18n->_('Hours')} &nbsp;&nbsp;<div id="slider_resolution_time_hours" class="slider_hour" dataValue="{$hours}"></div>
                        {$i18n->_('Minutes')} &nbsp;&nbsp;<div id="slider_resolution_time_minutes" class="slider_minute" dataValue="{$minutes}"></div> 
                
                   
                        <span class="display">({$days|default:'00'}):{$hours|default:'00'}:{$minutes|default:'00'}</span>
                    </span>
                </div>
                
            {else if $element->getName() == 'slider_resolution_time'}
                
                <div class="clearfix">
                    <div><label for="note" class="optional">{$i18n->_('Response Time')}</label></div>
                    <span class="input">
                    	{$days = $post['response_time_days']}
                    	{$hours = $post['response_time_hour']}
                        {$minutes = $post['response_time_minute']}
                    	<input type="hidden" class="input_time" name="response_time" value="" id="response_time">
                        {$i18n->_('Days')} &nbsp;&nbsp;<div id="slider_response_time_days" class="slider_days" dataValue="{$days}"></div>
						{$i18n->_('Hours')} &nbsp;&nbsp;<div id="slider_response_time_hours" class="slider_hour" dataValue="{$hours}"></div>
                        {$i18n->_('Minutes')} &nbsp;&nbsp;<div id="slider_response_time_minutes" class="slider_minute" dataValue="{$minutes}"></div>
                       
                        <span class="display">({$days|default:'00'}):{$hours|default:'00'}:{$minutes|default:'00'}</span>
                     
                    </span>
                </div>
                
                
                
                
                
                
             
            {else}
                {$element}
            {/if}

        {/foreach}
        
    
        
    </form>
</div>