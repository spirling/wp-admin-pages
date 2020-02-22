<?php

namespace Spirling\WpAdminPages;

function includeAdminTemplate($path, $args)
{
    if (file_exists($path)) {
        extract($args);
        include $path;
    }

}