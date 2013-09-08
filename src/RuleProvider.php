<?php
/**
 * Albulescu Cosmin ( http://www.albulescu.ro/ )
 *
 * @link      http://www.albulescu.ro/
 * @copyright Copyright (c) 2012 Albulescu Cosmin. (http://www.albulescu.com)
 * @license   http://www.albulescu.ro/new-bsd New BSD License
 * @autor Albulescu Cosmin <cosmin@albulescu.ro>
 */

namespace CaSecurity;

use Zend\ServiceManager\AbstractPluginManager;
use CaSecurity\Rule\AbstractRule;
use CaSecurity\Exception;

class RuleProvider extends AbstractPluginManager {
	
	const PLUGIN_MANAGER_CLASS = 'CaSecurity\RuleProvider';
	
	protected $invokableClasses = array(
        'tomanyrequests'	=> 'CaSecurity\Rule\ToManyRequests',
        'unknownbrowser'   => 'CaSecurity\Rule\UnknownBrowser'
	);
    
	/* (non-PHPdoc)
	 * @see \Zend\ServiceManager\AbstractPluginManager::validatePlugin()
	 */
	public function validatePlugin($plugin) {
		if ($plugin instanceof AbstractRule) {
            // we're okay
            return;
        }

        throw new Exception(sprintf(
            'Filter of type %s is invalid; must implement CaSecurity\Rule\AbstractRule',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));	
	}
}