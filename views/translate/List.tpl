<br />
<form method="post" action="{url action=update}">
<table class="zebra-striped bordered-table">
     <caption><h3>{$i18n->_('Translate')}<div style="float: right;">{if 'translate/inspect'|isAllowed}<a href="{url action=inspect}" class="btn">{icon src=page_white_add}{$i18n->_('Refresh Catalogs')}</a>{/if}</div></h3></caption>
     <thead>
         <tr>
             <th>{$i18n->_('#')}</th>
             <th>{$i18n->_('String')}</th>
             <th>{$i18n->_('Spanish')}</th>
             <th>{$i18n->_('English')}</th>
             <th>{$i18n->_('Actions')}</th>
         </tr>
     </thead>
     <tfoot>
         <tr>
             <th colspan="5" class="center"><input type="submit" value="{$i18n->_('Save')}" class="btn primary" /></th>
         </tr>
     </tfoot>
     <tbody>
         {$i = 0}
         {foreach $translates as $translate}
             {$i = $i + 1}
             <tr>
                 <td>{$i}</td>
                 <td>{$translate->getString()}</td>
                 <td><input type="text" name="es[{$translate->getIdTranslate()}]" id="es_{$translate->getIdTranslate()}" value="{$translate->getEs()}"></td>
                 <td><input type="text" name="en[{$translate->getIdTranslate()}]" id="en_{$translate->getIdTranslate()}" value="{$translate->getEn()}"></td>
                 <td>{if 'translate/delete'|isAllowed}<a href="{$baseUrl}/translate/delete/id/{$translate->getIdTranslate()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Delete')}</a>{/if}</td>
             </tr>
         {/foreach}
     </tbody>
</table>
</form>
<br />