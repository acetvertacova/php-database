<?php

function template(string $template)
{
    global $templatesDir, $layout;

    ob_start();
    require_once $templatesDir . '/' . $template;
    $content = ob_get_clean();
    require_once $layout;
}
