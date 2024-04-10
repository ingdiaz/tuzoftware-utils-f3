<?php


namespace Core\lib;
class Autoload
{
    function autoLoadClasses($dir = null)
    {
        $f3 = \Base::instance();
        $directoryList = glob($dir . "/*", GLOB_ONLYDIR);
        if (count($directoryList) == 0) {
            $f3->set('AUTOLOAD', $f3->get('AUTOLOAD') . ';' . $dir . '/');
            return;
        }
        foreach ($directoryList as $file) {
            $this->autoLoadClasses($file);
        }
    }

}