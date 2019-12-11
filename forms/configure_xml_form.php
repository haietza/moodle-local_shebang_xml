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
 * Configure XML form.
 * 
 * @package   local_shebang_xml
 * @author    Michelle Melton <meltonml@appstate.edu>
 * @copyright (c) 2019 Appalachian State Universtiy, Boone, NC
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
require_once("$CFG->libdir/formslib.php");
require_once("$CFG->libdir/adminlib.php");

/**
 * Form to configure and export XML.
 *
 * @package   local_shebang_xml
 * @copyright (c) 2019 Appalachian State Universtiy, Boone, NC
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class configure_xml_form extends moodleform {

    /**
     * Define configure XML form.
     * {@inheritDoc}
     * @see moodleform::definition()
     */
    public function definition() {
        global $DB;
        $mform = $this->_form;
        
        $mform->addElement('text', 'parent', get_string('parent', 'local_shebang_xml'));
        $mform->setType('parent', PARAM_TEXT);
        $mform->addHelpButton('parent', 'parent', 'local_shebang_xml');
        
        $mform->addElement('textarea', 'children', get_string('children', 'local_shebang_xml'));
        $mform->setType('children', PARAM_TEXT);
        $mform->addHelpButton('children', 'children', 'local_shebang_xml');

        $this->add_action_buttons(false, get_string('submit', 'local_shebang_xml'));
    }

    /**
     * Validate export settings form data.
     *
     * @param array $data data submitted
     * @param array $files files submitted
     * @return $errors array of error message to display on form
     */
    public function validation($data, $files) {
        global $DB;
        $errors = array();
        return $errors;
    }
}