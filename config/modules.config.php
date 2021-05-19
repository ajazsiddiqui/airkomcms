<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

/**
 * List of enabled modules for this application.
 *
 * This should be an array of module namespaces used in the application.
 */
return [
    'Laminas\Mvc\I18n',
    'Laminas\Serializer',
    'Laminas\Cache',
    'Laminas\Paginator',
    'Laminas\Db',
    'Laminas\Form',
    'Laminas\Hydrator',
    'Laminas\I18n',
    'Laminas\InputFilter',
    'Laminas\Mvc\Plugin\FlashMessenger',
    'Laminas\Mvc\Plugin\Prg',
    'Laminas\Session',
    'Laminas\Filter',
    'Laminas\Router',
    'Laminas\Validator',
    'DoctrineModule',
    'DoctrineORMModule',
    'Application',
	'User',
	'Masters',
	'Settings',
	'Logs',
];
