<?php

/**
 * DHCP subnets view.
 *
 * @category   apps
 * @package    dhcp
 * @subpackage views
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2011 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/dhcp/
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.  
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// Load dependencies
///////////////////////////////////////////////////////////////////////////////

$this->lang->load('dhcp');

///////////////////////////////////////////////////////////////////////////////
// Form modes
///////////////////////////////////////////////////////////////////////////////

if ($form_type === 'edit') {
    $form_path = '/dhcp/subnets/edit';
    $buttons = array(
        form_submit_update('submit'),
        anchor_cancel('/app/dhcp/subnets/'),
        anchor_delete('/app/dhcp/subnets/delete/' . $interface)
    );
} else {
    $form_path = '/dhcp/subnets/add';
    $buttons = array(
        form_submit_add('submit'),
        anchor_cancel('/app/dhcp/subnets/')
    );
}

$dns1 = isset($dns[0]) ? $dns[0] : '';
$dns2 = isset($dns[1]) ? $dns[1] : '';
$dns3 = isset($dns[2]) ? $dns[2] : '';

///////////////////////////////////////////////////////////////////////////////
// Form open
///////////////////////////////////////////////////////////////////////////////

echo form_open($form_path . '/' . $interface);
echo form_header(lang('dhcp_subnet'));

///////////////////////////////////////////////////////////////////////////////
// Form fields and buttons
///////////////////////////////////////////////////////////////////////////////

echo field_input('interface', $interface, lang('dhcp_network_interface'), TRUE);
echo field_input('network', $network, lang('dhcp_network'), TRUE);
echo field_dropdown('lease_time', $lease_times, $lease_time, lang('dhcp_lease_time'));
echo field_input('gateway', $gateway, lang('dhcp_gateway'));
echo field_input('start', $start, lang('dhcp_ip_range_start'));
echo field_input('end', $end, lang('dhcp_ip_range_end'));
echo field_input('dns1', $dns1, lang('dhcp_dns') . " #1");
echo field_input('dns2', $dns2, lang('dhcp_dns') . " #2");
echo field_input('dns3', $dns3, lang('dhcp_dns') . " #3");
echo field_input('wins', $wins, lang('dhcp_wins'));
echo field_input('tftp', $tftp, lang('dhcp_tftp'));
echo field_input('ntp', $ntp, lang('dhcp_ntp'));
echo field_input('wpad', $wpad, lang('dhcp_wpad'));

echo field_button_set($buttons);

///////////////////////////////////////////////////////////////////////////////
// Form close
///////////////////////////////////////////////////////////////////////////////

echo form_footer();
echo form_close();
