<?php

namespace Core;

class View
{
    function generate($template_view, $data = null)
    {
        if (!is_null($data)) {
            extract($data);
        }

        include ROOT . '/src/View/' . $template_view . '.php';
    }
}