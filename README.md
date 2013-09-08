CaSecurity
===========

This is a Zend Framework 2 Security Module. Install it and activate the rules.
To activate the rule place in your configuration file the key *CaSecurity*

<pre>
'CaSecurity' => array(
	'unknownbrowser' => array(
		'patterns' => array(
			'.*Links.*',//This will allow a browser with name Links ( Check UserAgent )
		)
	)
)
</pre>

##Available Rules
+ UnknownBrowser ( key to use it unknownbrowser )
+ ToManyRequests ( tomanyrequests )

##Reporting
By default all security breaches will be logged in a file. For custom reporting, take the service *CaSecurity/Rules*
and add a listener to his event manager to the CaSecurity\Rule\Event::EVENT_REPORT and stop propagation.

##Performance
Waiting for first release