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

use Zend\EventManager\Event as ZendEvent;

class Event extends ZendEvent
{
	const EVENT_VERIFY      = 'security.rule.verify';
	const EVENT_VERIFY_SKIPPED = 'security.rule.verify.skipped';
	const EVENT_REPORT      = 'security.report';
}