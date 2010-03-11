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
 * The controller for actions related to Organizations
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_SjrOffers_Controller_OrganizationController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var Tx_SjrOffers_Domain_Model_OrganizationRepository
	 */
	protected $organizationRepository;

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	public function initializeAction() {
		$this->accessControllService = t3lib_div::makeInstance('Tx_SjrOffers_Service_AccessControlService');
		$this->organizationRepository = t3lib_div::makeInstance('Tx_SjrOffers_Domain_Repository_OrganizationRepository');
		$this->personRepository = t3lib_div::makeInstance('Tx_SjrOffers_Domain_Repository_PersonRepository');
		$this->categoryRepository = t3lib_div::makeInstance('Tx_SjrOffers_Domain_Repository_CategoryRepository');
		// FIXME inclusion of jQuery not that elegant:
		$this->additionalHeaderData = '
<link type="text/css" href="fileadmin/css/smoothness/jquery-ui-1.7.2.custom.css" rel="Stylesheet" />	
<script type="text/javascript" src="fileadmin/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="fileadmin/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="fileadmin/js/tx_sjroffers.js"></script>
';

	}

	/**
	 * Index action for this controller. Displays a list of organizations.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		$this->view->assign('organizations', $this->organizationRepository->findAll());
	}
	
	/**
	 * Renders a single organization
	 *
	 * @param Tx_SjrOffers_Domain_Model_Organization $organization The organization of which the offers should be displayed
	 * @param Tx_SjrOffers_Domain_Model_Person $newContact The contact to be created
	 * @return string The rendered HTML string
	 * @dontvalidate $newContact
	 */
	public function showAction(Tx_SjrOffers_Domain_Model_Organization $organization, Tx_SjrOffers_Domain_Model_Person $newContact = NULL) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($organization->getAdministrator())) {
			$contacts = $organization->getAllContacts();
		} else {
			$contacts = $organization->getContacts();
		}
		$this->view->assign('contacts', $contacts);
		$this->view->assign('organization', $organization);
		$this->view->assign('newContact', $newContact);
		$this->response->addAdditionalHeaderData($this->additionalHeaderData);
	}
	
	/**
	 * Edits an existing organization
	 *
	 * @param Tx_SjrOffers_Domain_Model_Organization $organization The organization to be edited
	 * @return string The rendered HTML-form
	 * @dontvalidate $organization
	 */
	public function editAction(Tx_SjrOffers_Domain_Model_Organization $organization) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($organization->getAdministrator())) {
			$this->view->assign('organization', $organization);
			$this->view->assign('contacts', $this->personRepository->findAll());
			$this->response->addAdditionalHeaderData($this->additionalHeaderData);
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
	}

	/**
	 * Updates an existing organization
	 *
	 * @param Tx_SjrOffers_Domain_Model_Organization $organization A not yet persisted clone of the original organization containing the modifications
	 * @return void
	 */
	public function updateAction(Tx_SjrOffers_Domain_Model_Organization $organization) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($organization->getAdministrator())) {
			$this->organizationRepository->update($organization);
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
		$this->redirect('show', NULL, NULL, array('organization' => $organization));
	}

	/**
	 * Creates and attaches a contact
	 *
	 * @param Tx_SjrOffers_Domain_Model_Organization $organization The organization the contact belongs to
	 * @param Tx_SjrOffers_Domain_Model_Person $newContact The contact to be created
	 * @return void
	 */
	public function createContactAction(Tx_SjrOffers_Domain_Model_Organization $organization, Tx_SjrOffers_Domain_Model_Person $newContact) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($organization->getAdministrator())) {
			$organization->addContact($newContact);
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
		$this->redirect('show', 'Organization', NULL, array('organization' => $organization));
	}
	
	/**
	 * Updates a contact
	 *
	 * @param Tx_SjrOffers_Domain_Model_Organization $organization The organization the contact belongs to
	 * @param Tx_SjrOffers_Domain_Model_Person $contact The contact to be updated
	 * @return void
	 * @dontvalidatehmac
	 */
	public function updateContactAction(Tx_SjrOffers_Domain_Model_Organization $organization, Tx_SjrOffers_Domain_Model_Person $contact) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($organization->getAdministrator())) {
			$this->personRepository->update($contact);
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
		$this->redirect('show', 'Organization', NULL, array('organization' => $organization));
	}
	
	/**
	 * Detaches a contact form the organization
	 *
	 * @param Tx_SjrOffers_Domain_Model_Organization $organization The organization the contact belongs to
	 * @param Tx_SjrOffers_Domain_Model_Person $contact The contact to be deleted
	 * @return void
	 * @dontvalidate $contact
	 */
	public function removeContactAction(Tx_SjrOffers_Domain_Model_Organization $organization, Tx_SjrOffers_Domain_Model_Person $contact) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($organization->getAdministrator())) {
			$organization->removeContact($contact);
			$this->personRepository->remove($contact);
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
		$this->redirect('show', 'Organization', NULL, array('organization' => $organization));
	}
	
	/**
	 * Removes an existing offer
	 *
	 * @param Tx_SjrOffers_Domain_Model_Offer $offer The offer to be deleted
	 * @return void
	 * @dontvalidate $offer
	 */
	public function removeOfferAction(Tx_SjrOffers_Domain_Model_Offer $offer) {
		if ($this->accessControllService->hasLoggedInBackendAdmin() || $this->accessControllService->hasAccess($offer->getOrganization()->getAdministrator())) {
			$organization = $offer->getOrganization();
			$organization->removeOffer($offer);
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
		$this->redirect('show', 'Organization', NULL, array('organization' => $organization));
	}

	/**
	 * Deletes all existing organizations
	 *
	 * @return void
	 */
	public function deleteAllAction() {
		if ($this->accessControllService->hasLoggedInBackendAdmin()) {
			$organizations = $this->organizationRepository->findAll();
			foreach ($organizations as $organization) {
				$this->organizationRepository->remove($organization);
			}
		} else {
			$this->flashMessages->add('Sie haben keine Berechtigung die Aktion auszuführen.');
		}
		$this->redirect('index');
	}	

}

?>