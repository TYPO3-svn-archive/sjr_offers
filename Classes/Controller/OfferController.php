<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Jochen Rau <jochen.rau@typoplanet.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * The controller for actions related to Offers
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_SjrOffers_Controller_OfferController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var Tx_SjrOffers_Domain_Model_OfferRepository
	 */
	protected $offerRepository;

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	public function initializeAction() {
		$this->accessControllService = t3lib_div::makeInstance('Tx_SjrOffers_Service_AccessControlService');
		$this->offerRepository = t3lib_div::makeInstance('Tx_SjrOffers_Domain_Repository_OfferRepository');
		$this->organizationRepository = t3lib_div::makeInstance('Tx_SjrOffers_Domain_Repository_OrganizationRepository');
		$this->personRepository = t3lib_div::makeInstance('Tx_SjrOffers_Domain_Repository_PersonRepository');
		$this->categoryRepository = t3lib_div::makeInstance('Tx_SjrOffers_Domain_Repository_CategoryRepository');
		$this->regionRepository = t3lib_div::makeInstance('Tx_SjrOffers_Domain_Repository_RegionRepository');
		$this->additionalHeaderData = '
<link type="text/css" href="fileadmin/css/smoothness/jquery-ui-1.7.2.custom.css" rel="Stylesheet" />	
<script type="text/javascript" src="fileadmin/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="fileadmin/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="fileadmin/js/ui/i18n/ui.datepicker-de.js"></script>
<script type="text/javascript" src="fileadmin/js/tx_sjroffers.js"></script>
';
	}

	/**
	 * Renders a list of offers
	 *
	 * @param Tx_SjrOffers_Domain_Model_Demand $demand A demand taken as a basis for filtering the offers
	 * @return string The rendered HTML string
	 */
	public function indexAction(Tx_SjrOffers_Domain_Model_Demand $demand = NULL) {
		$this->view->assign('demand', $demand);
		$this->view->assign('organizations', array_merge(array(0 => 'Alle Organisationen'), $this->organizationRepository->findAll()));
		$this->view->assign('categories', array_merge(array(0 => 'Alle Kategorien'), $this->categoryRepository->findAllNonInternal()));
		$this->view->assign('regions', array_merge(array(0 => 'Alle Stadtteile'), $this->regionRepository->findAll()));
		$this->view->assign('offers', $this->offerRepository->findDemanded(
			$demand,
			t3lib_div::trimExplode(',', $this->settings['propertiesToSearch']),
			intval($this->settings['listCategory'])));
	}
	
	/**
	 * Renders a single offer
	 *
	 * @param Tx_SjrOffers_Domain_Model_Offer $offer The offer to be displayed
	 * @return string The rendered HTML string
	 * @dontvalidate $newContact
	 */
	public function showAction(Tx_SjrOffers_Domain_Model_Offer $offer, Tx_SjrOffers_Domain_Model_Person $newContact = NULL) {
		$organization = $offer->getOrganization();
		$this->view->assign('offer', $offer);
		$this->view->assign('organization', $organization);
		$this->view->assign('contacts', $organization->getAllContacts());
		$this->response->addAdditionalHeaderData($this->additionalHeaderData);
	}

	/**
	 * Displays a form for creating a new offer
	 *
	 * @param Tx_SjrOffers_Domain_Model_Organization $organization The organization the offer belogs to
	 * @param Tx_SjrOffers_Domain_Model_Offer $newOffer A fresh offer object taken as a basis for the rendering
	 * @return string An HTML form for creating a new offer
	 * @dontvalidate $newOffer
	 * @dontverifyrequesthash
	 */
	public function newAction(Tx_SjrOffers_Domain_Model_Organization $organization, Tx_SjrOffers_Domain_Model_Offer $newOffer = NULL) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($organization->getAdministrator())) {
			$this->view->assign('organization', $organization);
			$this->view->assign('newOffer', $newOffer);
			$frontendUserGroups = $this->accessControllService->getFrontendUserGroups();
			if (!empty($this->settings['allowedCategories'])) {
				$this->view->assign('categories', $this->categoryRepository->findAllowed(t3lib_div::intExplode(',', $this->settings['allowedCategories'])));
			} else {
				$this->view->assign('categories', $this->categoryRepository->findAll());
			}
			$this->view->assign('regions', $this->regionRepository->findAll());
			$this->view->assign('contacts', $organization->getAllContacts());
			$this->response->addAdditionalHeaderData($this->additionalHeaderData);
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
	}

	/**
	 * Creates a new offer
	 *
	 * @param Tx_SjrOffers_Domain_Model_Organization $organization The organization the offer belongs to
	 * @param Tx_SjrOffers_Domain_Model_Offer $newOffer A fresh Offer object which has not yet been added to the repository
	 * @param array $attendanceFees An array of attendence fees. array(amount => '12.50', comment => 'Children')
	 * @return void
	 * @dontverifyrequesthash
	 */
	public function createAction(Tx_SjrOffers_Domain_Model_Organization $organization, Tx_SjrOffers_Domain_Model_Offer $newOffer, array $attendanceFees = array()) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($organization->getAdministrator())) {
			$newOffer = $this->createAndAddAttendanceFees($newOffer, $attendanceFees);
			$organization->addOffer($newOffer);
			$newOffer->setOrganization($organization);
			$this->addForcedCategories($newOffer);
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
		$this->redirect('show', 'Organization', NULL, array('organization' => $organization));
	}
	
	/**
	 * Displays a form to edit an existing offer
	 *
	 * @param Tx_SjrOffers_Domain_Model_Offer $offer The original offer
	 * @return string Form for editing the existing organization
	 * @dontvalidate $offer
	 * @dontverifyrequesthash
	 */
	public function editAction(Tx_SjrOffers_Domain_Model_Offer $offer) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($offer->getOrganization()->getAdministrator())) {
			$this->view->assign('offer', $offer);
			$this->view->assign('organization', $offer->getOrganization());
			if (!empty($this->settings['allowedCategories'])) {
				$this->view->assign('categories', $this->categoryRepository->findAllowed(t3lib_div::intExplode(',', $this->settings['allowedCategories'])));
			} else {
				$this->view->assign('categories', $this->categoryRepository->findAll());
			}
			$this->view->assign('regions', $this->regionRepository->findAll());
			$this->response->addAdditionalHeaderData($this->additionalHeaderData);
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
	}

	/**
	 * Updates an existing offer
	 *
	 * @param Tx_SjrOffers_Domain_Model_Offer $offer The existing, unmodified offer
	 * @param array $attendanceFees An array of attendence fees. array(amount => '12.50', comment => 'Children')
	 * @return void
	 * @dontverifyrequesthash
	 */
	public function updateAction(Tx_SjrOffers_Domain_Model_Offer $offer, array $attendanceFees = array()) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($offer->getOrganization()->getAdministrator())) {
			$offer->removeAllAttendanceFees();
			$offer = $this->createAndAddAttendanceFees($offer, $attendanceFees);
			$this->addForcedCategories($offer);
			$this->offerRepository->update($offer);
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
		$this->redirect('show', 'Organization', NULL, array('organization' => $offer->getOrganization()));
	}

	/**
	 * Deletes an existing offer
	 *
	 * @param Tx_SjrOffers_Domain_Model_Offer $offer The offer to be deleted
	 * @return void
	 */
	public function deleteAction(Tx_SjrOffers_Domain_Model_Offer $offer) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($offer->getOrganization()->getAdministrator())) {
			$this->offerRepository->remove($offer);
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
		$this->redirect('index');
	}
	
	/**
	 * Creates and attaches a contact
	 *
	 * @param Tx_SjrOffers_Domain_Model_Offer $offer The offer the contact belongs to
	 * @param Tx_SjrOffers_Domain_Model_Person $newContact The contact to be created
	 * @return void
	 */
	public function createContactAction(Tx_SjrOffers_Domain_Model_Offer $offer, Tx_SjrOffers_Domain_Model_Person $newContact) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($offer->getOrganization()->getAdministrator())) {
			$offer->setContact($newContact);
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
		$this->redirect('show', 'Offer', NULL, array('offer' => $offer));
	}
	
	/**
	 * Attaches an extisting contact
	 *
	 * @param Tx_SjrOffers_Domain_Model_Offer $offer The offer the contact belongs to
	 * @param Tx_SjrOffers_Domain_Model_Person $contact The contact to be created
	 * @return void
	 * @dontverifyrequesthash
	 */
	public function setContactAction(Tx_SjrOffers_Domain_Model_Offer $offer) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($offer->getOrganization()->getAdministrator())) {
			$this->offerRepository->update($offer);
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
		$this->redirect('show', 'Offer', NULL, array('offer' => $offer));
	}
	
	/**
	 * Updates a contact
	 *
	 * @param Tx_SjrOffers_Domain_Model_Offer $offer The offer the contact belongs to
	 * @param Tx_SjrOffers_Domain_Model_Person $contact The contact to be updated
	 * @return void
	 * @dontverifyrequesthash
	 */
	public function updateContactAction(Tx_SjrOffers_Domain_Model_Offer $offer, Tx_SjrOffers_Domain_Model_Person $contact) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($offer->getOrganization()->getAdministrator())) {
			$this->personRepository->update($contact);
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
		$this->redirect('show', 'Offer', NULL, array('offer' => $offer));
	}
	
	/**
	 * Removes the contact form the offer
	 *
	 * @param Tx_SjrOffers_Domain_Model_Offer $offer The offer the contact belongs to
	 * @param Tx_SjrOffers_Domain_Model_Person $contact The contact to be removed
	 * @return void
	 */
	public function removeContactAction(Tx_SjrOffers_Domain_Model_Offer $offer, Tx_SjrOffers_Domain_Model_Person $contact) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($offer->getOrganization()->getAdministrator())) {
			$offer->removeContact($contact);
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
		$this->redirect('show', 'Offer', NULL, array('offer' => $offer));
	}
	
	/**
	 * Creates an AttendanceFee for every item in the attendanceFees array and adds it to the offer.
	 *
	 * @param Tx_SjrOffers_Domain_Model_Offer $offer The offer the attendance fees should be added to
	 * @param array $attendanceFees An array of attendence fees. array(amount => '12.50', comment => 'Children')
	 * @return Tx_SjrOffers_Domain_Model_Offer The offer 
	 */
	protected function createAndAddAttendanceFees( Tx_SjrOffers_Domain_Model_Offer $offer, array $attendanceFees = array()) {
		foreach ($attendanceFees['amount'] as $key => $amount) {
			if ($amount !== '') {
				$offer->addAttendanceFee(new Tx_SjrOffers_Domain_Model_AttendanceFee($amount, $attendanceFees['comment'][$key]));
			}
		}
		return $offer;
	}
	
	/**
	 * Adds categories that are mandatory in the givern setup
	 *
	 * @param Tx_SjrOffers_Domain_Model_Offer $offer 
	 * @return Tx_SjrOffers_Domain_Model_Offer
	 */
	protected function addForcedCategories(Tx_SjrOffers_Domain_Model_Offer $offer) {
		if (!empty($this->settings['forceCategories'])) {
			$forcedCategories = t3lib_div::intExplode(',', $this->settings['forceCategories']);
			foreach ($forcedCategories as $categoryUid) {
				$category = $this->categoryRepository->findByUid($categoryUid);
				$offer->addCategory($this->categoryRepository->findByUid($categoryUid));
			}
		}
		return $offer;
	}

}

?>
