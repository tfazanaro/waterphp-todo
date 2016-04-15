<?php
    function loadClass($className)
    {
        $fileName = '';

        if (false !== ($lastNsPos = strripos($className, '\\')))
        {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DS, $namespace) . DS;
        }

        $fileName .= $className . '.php';
        $fullFileName = LIB_PATH . $fileName;

        if (file_exists($fullFileName)) {
            require_once($fullFileName);
        }
        else {
            $fullFileName = APP_PATH . $fileName;
            if (file_exists($fullFileName)) {
                require_once($fullFileName);
            }
        }
    }
    spl_autoload_register('loadClass');