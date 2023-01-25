{if $paginator}

{$pages = $paginator->getPages()}

<div class="pagination" id="paginator">
   <ul>
   {if $pages->last > 1}
   
       {if $pages->first neq $pages->current}
           <li><a class="pag" href="?page={$pages->first}" rel="{$pages->first}">&lt;&lt;</a></li>
       {/if}
       
       {if $pages->previous && $pages->previous neq $pages->first}
           <li class="prev"><a  class="pag" href="?page={$pages->previous}" rel="{$pages->previous}">&lt;</a></li>
       {/if}

       {foreach from=$pages->pagesInRange key=i item=page}
           {if $page eq $pages->current}
               <li class="active"><a  class="pag" rel="{$page}">{$page}</a></li>
           {else}
               <li><a  class="pag" href="?page={$page}" rel="{$page}">{$page}</a></li>
           {/if}
       {/foreach}

       {if $pages->next && $pages->next neq $pages->last}
           <li class="next"><a  class="pag" href="?page={$pages->next}" rel="{$pages->next}">&gt;</a></li>
       {/if}

       {if $pages->last neq $pages->current}
           <li><a  class="pag" href="?page={$pages->last}" rel="{$pages->last}">&gt;&gt;</a></li>
       {/if}
       
       <li><a>{'Total:'} {$paginator->getTotalItemCount()}</a></li>
   {/if}
   </ul>
   
</div>

<script type="text/javascript">

$('#paginator a').live('click', function(){
    if( $('#page').length != 0  ){
        $('#page').val($(this).attr('rel'));
        $('#page').parents('form').submit();
        return false;
    }
});

$('input[type=submit]').click(function(){
    $(this).parents('form').find('#page').val(1);
});

</script>
{/if}