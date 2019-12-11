<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Plugin settings.
 * 
 * @package   local_shebang_xml
 * @author    Michelle Melton <meltonml@appstate.edu>
 * @copyright (c) 2019 Appalachian State Universtiy, Boone, NC
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

// Ensure the configurations for this site are set.
if ($hassiteconfig) {
    $settings = new admin_settingpage('local_shebang_xml', get_string('pluginname', 'local_shebang_xml'));
    $localshebangxmlcategory = new admin_category('shebangxml', get_string('pluginname', 'local_shebang_xml'));
    $ADMIN->add('localplugins', $localshebangxmlcategory);
    $configurexmlform = new admin_externalpage('local_shebang_xml_form',
            get_string('pluginname', 'local_shebang_xml'),
            new moodle_url('/local/shebang_xml/configure_xml.php'));
    $ADMIN->add('shebangxml', $configurexmlform);
}