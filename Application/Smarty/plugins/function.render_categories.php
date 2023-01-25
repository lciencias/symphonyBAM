<?php

use Application\Smarty\CategoryRenderer;

/**
 * print an icon
 * @param unknown_type $params
 * @param Smarty $smarty
 * @param unknown_type $template
 * @return string
 */
function smarty_function_render_categories($params, $smarty, $template)
{
    $renderer = CategoryRenderer::factory($params['renderer'], $params, $smarty, $template);

    return $renderer->render($params['nestedCategories'], array(
        'id' => 'browser',
        'class' => 'browser filetree treeview',
    ));
}




