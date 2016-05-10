<?php
/**
 * Autoloader
 *
 * @author Joubert <eu@redrat.com.br>
 * @copyright Copyright (c) 2016 Vector Internet Business and AjaxTable contributors
 * @license: MIT
 * @see https://github.com/vectornet/ajaxtable/
 * @see http://www.vectornet.com.br
 */

namespace VectorDev\AjaxTable;

spl_autoload_register(function ($class) {
    if (strpos($class, __NAMESPACE__.'\\') === 0) {
        $name = substr($class, strlen(__NAMESPACE__));
        require(__DIR__.strtr($name, '\\', DIRECTORY_SEPARATOR).'.php');
    }
});
