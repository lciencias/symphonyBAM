<div id="dtopbar"> 
   <div style="text-align: right;">
      <a href="{url action='change-language' controller=auth lang=es}">{icon src=es class=tip title=$i18n->_('Spanish')}</a>
      <a href="{url action='change-language' controller=auth lang=en}">{icon src=en class=tip title=$i18n->_('English')}</a>
      <small>{if $systemUser}{$i18n->_('Welcome')} <strong>{$systemUser->getUsername()}</strong> ({$systemAccessRole->getName()}) | <a href="{url controller=auth action=logout}" style="color: #FFF;">{$i18n->_('Logout')}</a> | <a href="{$baseUrl}/user/edit-password/id/{$systemUser->getIdUser()}" style="color: #FFF;">{$i18n->_('Edit Password')}</a>{/if}</small>
      &nbsp;&nbsp;
  </div>
</div>

<div>{$menu}</div>
