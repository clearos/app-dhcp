<?php

///////////////////////////////////////////////////////////////////////////////
//
// Copyright 2010 ClearFoundation
//
///////////////////////////////////////////////////////////////////////////////
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//
///////////////////////////////////////////////////////////////////////////////

/**
 * DHCP server general configuration.
 *
 * @package Frontend
 * @author {@link http://www.clearfoundation.com ClearFoundation}
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @copyright Copyright 2010, ClearFoundation
 */

///////////////////////////////////////////////////////////////////////////////
// C O N T R O L L E R
///////////////////////////////////////////////////////////////////////////////

/**
 * DHCP server general configuration.
 *
 * @package Frontend
 * @author {@link http://www.clearfoundation.com ClearFoundation}
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @copyright Copyright 2010, ClearFoundation
 */

class General extends ClearOS_Controller
{
	/**
	 * DHCP server overview.
	 */

	function index($view = 'page')
	{
		// Load libraries
		//---------------

		$this->load->library('dns/DnsMasq');
		$this->lang->load('dhcp');

		// Set validation rules
		//---------------------

		$this->form_validation->set_policy('domain', 'dns_DnsMasq_ValidateDomain', TRUE);
		$this->form_validation->set_policy('authoritative', 'dns_DnsMasq_ValidateAuthoritative', TRUE);
		$form_ok = $this->form_validation->run();

		// Handle form submit
		//-------------------

		if ($this->input->post('submit') && ($form_ok)) {
			try {
				// Update
				$this->dnsmasq->SetDomainName($this->input->post('domain'));
				$this->dnsmasq->SetAuthoritativeState((bool)$this->input->post('authoritative'));
				$this->dnsmasq->Reset();

				// Redirect to main page
				 $this->page->set_success(lang('base_system_updated'));
				redirect('/dhcp/');
			} catch (Exception $e) {
				$this->page->view_exception($e->GetMessage(), $view);
				return;
			}
		}

		// Load view data
		//---------------

		try {
			$data['authoritative'] = $this->dnsmasq->GetAuthoritativeState();
			$data['domain'] = $this->dnsmasq->GetDomainName();
		} catch (Exception $e) {
			$this->page->view_exception($e->GetMessage() . "huh", $view);
			return;
		}
 
		// Load views
		//-----------

		if ($view == 'form') {
			$data['form_type'] = 'view';

			$this->load->view('dhcp/general/view_edit', $data);

		} else if ($view == 'page') {
			$data['form_type'] = 'edit';

			$this->page->set_title(lang('dhcp_dhcp') . ' - ' . lang('base_general_settings'));

			$this->load->view('theme/header');
			$this->load->view('dhcp/general/view_edit', $data);
			$this->load->view('theme/footer');
		}
	}
}

?>