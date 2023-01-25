<script type="text/javascript" src="{$baseUrl}/js/modules/menu/manage.js"></script>

<div class="">

    <h3>{$i18n->_('User Menu')}</h3>
   
    <hr/>
    <div class="row">
        <div class="span8">
            <table class="wide">
                <caption>{$i18n->_('Shares Available')}</caption>
                <tbody>
                    {foreach from=$controllers item=controller}
                        <tr>
                            <td><img src="{$baseUrl}/images/template/icons/magnifier.png" alt="toggle" id="parent_{$controller->getIdController()}" class="parentMenu" /></td>
                            <th>{$controller->getName()}</th>
                            <th>(0)</th>
                        </tr>
                          {foreach from=$actions item=action}
                            {if $action->getIdController() == $controller->getIdController()}
                          <tr class="child childOf{$controller->getIdController()}" id="action_item_{$action->getIdAction()}">
                            <td></td>
                            <td>{$action->getName()}</td>
                            <td>
                                <img src="{$baseUrl}/images/template/icons/add.png" alt="add" id="add_child_{$action->getIdAction()}" class="moveItem" />
                            </td>
                    
                           </tr>
                            {/if}
                          {/foreach}
                    {/foreach}
                </tbody>
            </table>
            
            <table>
                <caption>{$i18n->_('Add Item')}</caption>
                <tbody>
                    <tr>
                        <th><label for="name">{$i18n->_('Name')}</label></th>
                        <td><input id="name" name="name" value=""></td>
                    </tr>
                </tbody>
            </table>
            
        </div>
        
        <div class="grid_8">
              <div class="content">
                  <div class="subHeader"><div>{$i18n->_('Results Menu')}</div></div>
                <div class="contentPanel">{$menuItems}</div>
               </div>
        </div>
    
    </div>
</div>
