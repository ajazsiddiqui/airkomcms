<?php
/**
 * @see      http://github.com/zendframework/ZendSkeletonCards for the canonical source repository
 *
 * @copyright Copyright (c) 2005-2016 Zend Technocardies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Cards;

class Module
{
    public const VERSION = '3.0.0dev';

    public function getConfig()
    {
        return include __DIR__.'/../config/module.config.php';
    }
}
