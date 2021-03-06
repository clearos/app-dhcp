#!/usr/clearos/sandbox/usr/bin/php
<?php

/**
 * MAC address update.
 *
 * A list of MAC addresses is publicly available from 
 * http://standards-oui.ieee.org/oui.txt.
 * This tool converts the oui.txt file to a PHP array.
 *
 * @category   apps
 * @package    dhcp
 * @subpackage scripts
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

$contents = preg_split("/\n/", file_get_contents('oui.txt'));
$macs = array();

foreach ($contents as $line) {
    $matches = array();

    if (preg_match("/^\s*([0-9A-F]{1,2}-[0-9A-F]{1,2}-[0-9A-F]{1,2})\s+(\(.*\))\s+(.*)/", $line, $matches)) {
        $mac_prefix = preg_replace('/-/', ':', $matches[1]);
        $company = preg_replace("/'/", "\'", $matches[3]);
        $company = ucwords(strtolower($company));

        $macs[$mac_prefix] = $company; 
    }
}

ksort($macs);
echo "<?php\n\n";
echo "\$mac_database = array(\n";

foreach ($macs as $prefix => $company)
    echo "'" . $prefix . "' => '" . $company . "',\n";

echo ");\n";
