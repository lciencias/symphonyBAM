  <!-- Modal Confirm -->
  <div id='confirm' style='display:none'>
    <a href='#' title='Close' class='modalCloseX simplemodal-close'>x</a>
    <div class='header'><span>{$i18n->_('Confirmar')}</span></div>
    <p class='message'></p>
    <div class='buttons'>
        <div class='no simplemodal-close'>{$i18n->_('No')}</div><div class='yes'>{$i18n->_('Si')}</div>
    </div>
  </div>
  <!--  Modal Dialog --> 
  <div id='dialog' style='display:none'>
    <a href='#' title='Close' class='modalCloseX simplemodal-close'>x</a>
    <div class='header'><span>{$i18n->_('Mensaje')}</span></div>
    <p class='message'></p>
    <div class='buttons'>
        <div class='yes'>{$i18n->_('Ok')}</div>
    </div>
  </div>
  <div id='ajaxLoader' style='display:none'><img src="{$baseUrl}/images/template/basic/ajax-loader.gif" alt="loading..." /></div>