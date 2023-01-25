<h1 class="center">500 Internal Server Error</h1>
<hr/>
<div class="alert-message error">{$message}</div>
<div class="note">{$trace}</div>
<div class="code"><strong>{$file} ({$line})</strong><div class="source">{$source}</div></div>

{if $queries}
   <br />
   <h2>Queries</h2>
   <pre>
   {foreach $queries as $i => $query}
      <p>
      {$i}.- {$query->getQuery()} 
      {if $query->getQueryParams()}
          Params( {implode($query->getQueryParams(), ', ')})
      {/if} 
      time {round($query->getElapsedSecs(), 6)}
      </p>
   {/foreach}
   </pre>
{/if}

