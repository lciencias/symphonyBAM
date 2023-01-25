{if !$nestedCategories}{$nestedCategories = []}{/if}
<span class="input">
    <select name="id_category" class='span4 nested'>
      <option value="">{$i18n->_('All')}</option>
      {render_categories nestedCategories=$nestedCategories renderer="select-standart" selected=$post['id_category']}
    </select>
</span>