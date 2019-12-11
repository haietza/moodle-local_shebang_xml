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

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/forms/configure_xml_form.php');
require_once($CFG->dirroot . '/backup/util/xml/xml_writer.class.php');
require_once($CFG->dirroot . '/backup/util/xml/output/xml_output.class.php');
require_once($CFG->dirroot . '/backup/util/xml/output/memory_xml_output.class.php');
require_login();
global $DB, $PAGE, $CFG;

$PAGE->set_url($CFG->wwwroot . '/local/shebang_xml/configure_xml.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('pluginname', 'local_shebang_xml'));
$PAGE->set_heading(get_string('pluginname', 'local_shebang_xml'));

$mform = new configure_xml_form();

// Form processing and displaying is done here.
if ($fromform = $mform->get_data()) {
    // In this case you process validated data; $mform->get_data() returns data posted in form.
    confirm_sesskey();

    // Start XML file output.
    $xmloutput = new memory_xml_output();
    $xmlwriter = new xml_writer($xmloutput);
    $xmlwriter->start();

    $xmlwriter->begin_tag('enterprise');

    $xmlwriter->begin_tag('properties', array('lang' => 'en'));
    $xmlwriter->full_tag('datasource', 'Appalachian State University SCT Banner');
    $xmlwriter->full_tag('datetime', date('Y-m-dTH:i:s'));
    $xmlwriter->end_tag('properties');

    $children = preg_split('/\r\n/', $fromform->children);

    // Create membership property for each child course.
    foreach ($children as $child) {
        $xmlwriter->begin_tag('membership');

        $xmlwriter->begin_tag('sourcedid');
        $xmlwriter->full_tag('source', 'Appalachian State University SCT Banner');
        $xmlwriter->full_tag('id', trim($fromform->parent));
        $xmlwriter->end_tag('sourcedid');

        $xmlwriter->begin_tag('member');
        $xmlwriter->begin_tag('sourcedid');
        $xmlwriter->full_tag('source', 'Appalachian State University SCT Banner');
        $xmlwriter->full_tag('id', trim($child));
        $xmlwriter->end_tag('sourcedid');
        $xmlwriter->full_tag('idtype', 2);
        $xmlwriter->begin_tag('role', array('roletype' => '01'));
        $xmlwriter->full_tag('status', 1);
        $xmlwriter->end_tag('role');
        $xmlwriter->end_tag('member');

        $xmlwriter->end_tag('membership');
    }

    $xmlwriter->end_tag('enterprise');
    $xmlwriter->stop();
    $xmlstr = $xmloutput->get_allcontents();
    $fileprefix = addcslashes(trim($fromform->parent) . '-' . date('Y-m-dTH:i:s'), '"');
    $xmlfilename = $fileprefix . '.xml';
    send_file($xmlstr, $xmlfilename, 0, 0, true, true);
} else {
    // This branch is executed if the form is submitted but the data doesn't validate
    // and the form should be redisplayed or on the first display of the form.
    if ($mform->is_submitted()) {
        // Form is submitted but data does not validate.
    } else {
        // First display of the form, can get params from $_GET.
        echo $OUTPUT->header();
        $mform->display();
        echo $OUTPUT->footer();
    }
}