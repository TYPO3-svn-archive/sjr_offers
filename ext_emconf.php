<?php

########################################################################
# Extension Manager/Repository config file for ext "sjr_offers".
#
# Auto generated 09-03-2010 11:35
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'SJR Offers',
	'description' => 'An extension to manage, search and display offers.',
	'category' => 'plugin',
	'author' => 'Jochen Rau',
	'author_company' => 'typoplanet',
	'author_email' => 'jochen.rau@typoplanet.de',
	'shy' => '',
	'dependencies' => 'extbase,fluid',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => 'uploads/tx_sjroffers/rte/',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '1.0.0',
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
	'_md5_values_when_last_written' => 'a:121:{s:12:"ext_icon.gif";s:4:"e922";s:17:"ext_localconf.php";s:4:"6608";s:14:"ext_tables.php";s:4:"8f3e";s:14:"ext_tables.sql";s:4:"bffa";s:38:"Classes/Controller/OfferController.php";s:4:"34fb";s:45:"Classes/Controller/OrganizationController.php";s:4:"1509";s:38:"Classes/Domain/Model/Administrator.php";s:4:"8206";s:33:"Classes/Domain/Model/AgeRange.php";s:4:"e7f1";s:38:"Classes/Domain/Model/AttendanceFee.php";s:4:"5435";s:40:"Classes/Domain/Model/AttendanceRange.php";s:4:"dbb3";s:33:"Classes/Domain/Model/Category.php";s:4:"e9e5";s:34:"Classes/Domain/Model/DateRange.php";s:4:"9d3b";s:43:"Classes/Domain/Model/DateRangeInterface.php";s:4:"c9bf";s:33:"Classes/Domain/Model/DateTime.php";s:4:"129d";s:31:"Classes/Domain/Model/Demand.php";s:4:"6019";s:46:"Classes/Domain/Model/NumericRangeInterface.php";s:4:"2000";s:30:"Classes/Domain/Model/Offer.php";s:4:"2a10";s:37:"Classes/Domain/Model/Organization.php";s:4:"7dc9";s:31:"Classes/Domain/Model/Person.php";s:4:"1ec3";s:40:"Classes/Domain/Model/RangeConstraint.php";s:4:"05ae";s:31:"Classes/Domain/Model/Region.php";s:4:"f8da";s:48:"Classes/Domain/Repository/CategoryRepository.php";s:4:"821e";s:45:"Classes/Domain/Repository/OfferRepository.php";s:4:"f617";s:52:"Classes/Domain/Repository/OrganizationRepository.php";s:4:"212a";s:46:"Classes/Domain/Repository/PersonRepository.php";s:4:"c2ed";s:46:"Classes/Domain/Repository/RegionRepository.php";s:4:"6cef";s:44:"Classes/Domain/Validator/AmountValidator.php";s:4:"9280";s:53:"Classes/Domain/Validator/RangeConstraintValidator.php";s:4:"cdb8";s:40:"Classes/Service/AccessControlService.php";s:4:"ad95";s:35:"Classes/Service/AccessException.php";s:4:"6ac8";s:38:"Classes/ViewHelper/OrderViewHelper.php";s:4:"e3c0";s:45:"Classes/ViewHelper/Format/Nl2liViewHelper.php";s:4:"6ae3";s:45:"Classes/ViewHelper/Format/RangeViewHelper.php";s:4:"aa8f";s:57:"Classes/ViewHelper/Security/IfAccessGrantedViewHelper.php";s:4:"1f1b";s:25:"Configuration/TCA/tca.php";s:4:"a114";s:38:"Configuration/TypoScript/constants.txt";s:4:"e13c";s:34:"Configuration/TypoScript/setup.txt";s:4:"1997";s:40:"Resources/Private/Language/locallang.xml";s:4:"c475";s:44:"Resources/Private/Language/locallang_csh.xml";s:4:"0507";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"bd9e";s:44:"Resources/Private/Language/locallang_mod.xml";s:4:"cd5d";s:38:"Resources/Private/Layouts/default.html";s:4:"6e08";s:43:"Resources/Private/Partials/accessError.html";s:4:"b4bd";s:39:"Resources/Private/Partials/contact.html";s:4:"0031";s:42:"Resources/Private/Partials/formErrors.html";s:4:"5b5e";s:47:"Resources/Private/Partials/offerFormFields.html";s:4:"b68c";s:38:"Resources/Private/Partials/offers.html";s:4:"e04f";s:41:"Resources/Private/Scripts/tx_sjroffers.js";s:4:"26a0";s:43:"Resources/Private/Templates/Offer/edit.html";s:4:"45a0";s:44:"Resources/Private/Templates/Offer/index.html";s:4:"26ed";s:42:"Resources/Private/Templates/Offer/new.html";s:4:"7b7f";s:43:"Resources/Private/Templates/Offer/show.html";s:4:"86bb";s:50:"Resources/Private/Templates/Organization/edit.html";s:4:"42a2";s:51:"Resources/Private/Templates/Organization/index.html";s:4:"6d95";s:50:"Resources/Private/Templates/Organization/show.html";s:4:"b950";s:30:"Resources/Public/Icons/add.gif";s:4:"894b";s:36:"Resources/Public/Icons/arrowdown.gif";s:4:"95ab";s:36:"Resources/Public/Icons/arrowdown.png";s:4:"881e";s:37:"Resources/Public/Icons/arrowright.gif";s:4:"bab6";s:37:"Resources/Public/Icons/arrowright.png";s:4:"53f9";s:37:"Resources/Public/Icons/blackclear.gif";s:4:"916d";s:42:"Resources/Public/Icons/blinkarrow_left.gif";s:4:"f61e";s:43:"Resources/Public/Icons/blinkarrow_right.gif";s:4:"0938";s:38:"Resources/Public/Icons/button_down.gif";s:4:"9fd6";s:38:"Resources/Public/Icons/button_hide.gif";s:4:"d59e";s:38:"Resources/Public/Icons/button_left.gif";s:4:"631e";s:39:"Resources/Public/Icons/button_right.gif";s:4:"1900";s:40:"Resources/Public/Icons/button_unhide.gif";s:4:"eead";s:36:"Resources/Public/Icons/button_up.gif";s:4:"9779";s:36:"Resources/Public/Icons/clip_copy.gif";s:4:"351b";s:35:"Resources/Public/Icons/clip_cut.gif";s:4:"a273";s:34:"Resources/Public/Icons/clipbrd.gif";s:4:"6dbe";s:37:"Resources/Public/Icons/close_gray.gif";s:4:"e836";s:35:"Resources/Public/Icons/closedok.gif";s:4:"e836";s:34:"Resources/Public/Icons/contact.gif";s:4:"8e0a";s:31:"Resources/Public/Icons/edit.gif";s:4:"31b4";s:32:"Resources/Public/Icons/edit2.gif";s:4:"fb3a";s:34:"Resources/Public/Icons/edit_fe.gif";s:4:"336a";s:37:"Resources/Public/Icons/editaccess.gif";s:4:"5b3c";s:34:"Resources/Public/Icons/garbage.gif";s:4:"a708";s:37:"Resources/Public/Icons/helpbubble.gif";s:4:"1900";s:34:"Resources/Public/Icons/icon_ok.gif";s:4:"2f9b";s:35:"Resources/Public/Icons/icon_ok2.gif";s:4:"75ef";s:40:"Resources/Public/Icons/icon_relation.gif";s:4:"9e5c";s:71:"Resources/Public/Icons/icon_tx_sjroffers_domain_model_attendancefee.gif";s:4:"50a3";s:66:"Resources/Public/Icons/icon_tx_sjroffers_domain_model_category.gif";s:4:"50a3";s:63:"Resources/Public/Icons/icon_tx_sjroffers_domain_model_offer.gif";s:4:"50a3";s:70:"Resources/Public/Icons/icon_tx_sjroffers_domain_model_organization.gif";s:4:"50a3";s:64:"Resources/Public/Icons/icon_tx_sjroffers_domain_model_person.gif";s:4:"50a3";s:73:"Resources/Public/Icons/icon_tx_sjroffers_domain_model_rangeconstraint.gif";s:4:"50a3";s:64:"Resources/Public/Icons/icon_tx_sjroffers_domain_model_region.gif";s:4:"50a3";s:37:"Resources/Public/Icons/module_doc.gif";s:4:"cc3d";s:38:"Resources/Public/Icons/module_file.gif";s:4:"9d05";s:46:"Resources/Public/Icons/module_tools_config.gif";s:4:"1960";s:38:"Resources/Public/Icons/module_user.gif";s:4:"7e01";s:43:"Resources/Public/Icons/module_web_perms.gif";s:4:"bc4f";s:42:"Resources/Public/Icons/module_web_view.gif";s:4:"e76d";s:35:"Resources/Public/Icons/new_page.gif";s:4:"6ea9";s:37:"Resources/Public/Icons/new_record.gif";s:4:"c1a5";s:34:"Resources/Public/Icons/options.gif";s:4:"78d4";s:35:"Resources/Public/Icons/recycler.gif";s:4:"90c6";s:34:"Resources/Public/Icons/refresh.gif";s:4:"5c09";s:36:"Resources/Public/Icons/refresh_n.gif";s:4:"6686";s:42:"Resources/Public/Icons/saveandclosedok.gif";s:4:"8e3a";s:34:"Resources/Public/Icons/savedok.gif";s:4:"d884";s:37:"Resources/Public/Icons/savedoknew.gif";s:4:"0433";s:33:"Resources/Public/Icons/switch.gif";s:4:"2f51";s:31:"Resources/Public/Icons/zoom.gif";s:4:"e76d";s:32:"Resources/Public/Icons/zoom2.gif";s:4:"b9aa";s:47:"Tests/Controller/OrganizationControllerTest.php";s:4:"f6ea";s:35:"Tests/Domain/Model/AgeRangeTest.php";s:4:"d286";s:40:"Tests/Domain/Model/AttendanceFeeTest.php";s:4:"b8df";s:42:"Tests/Domain/Model/AttendanceRangeTest.php";s:4:"73bb";s:35:"Tests/Domain/Model/CategoryTest.php";s:4:"ccdd";s:33:"Tests/Domain/Model/DemandTest.php";s:4:"bf5a";s:32:"Tests/Domain/Model/OfferTest.php";s:4:"e9bf";s:39:"Tests/Domain/Model/OrganizationTest.php";s:4:"262a";s:33:"Tests/Domain/Model/PersonTest.php";s:4:"0454";s:33:"Tests/Domain/Model/RegionTest.php";s:4:"a8cc";s:37:"Tests/Domain/Model/TimePeriodTest.php";s:4:"1c7a";s:47:"Tests/Domain/Repository/OfferRepositoryTest.php";s:4:"79ca";}',
	'suggests' => array(
	),
);

?>