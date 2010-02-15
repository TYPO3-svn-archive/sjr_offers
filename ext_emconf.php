<?php

########################################################################
# Extension Manager/Repository config file for ext: "sjr_offers"
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'SJR Offers',
	'description' => 'An extension to manage, search and display recreation offers managed by youth organizations.',
	'category' => 'plugin',
	'author' => 'Jochen Rau',
	'author_company' => 'typoplanet',
	'author_email' => 'jochen.rau@typoplanet.de',
	'shy' => '',
	'dependencies' => 'extbase,fluid',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => 'uploads/tx_sjroffers/rte/',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.4.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.3.0-4.3.99',
			'extbase' => '1.0.2-0.0.0',
			'fluid' => '1.0.2-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => '',
	'suggests' => array(
	),
);

?>