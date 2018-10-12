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
 * A one column layout for the boost theme.
 *
 * @package   theme_boost_o365teams
 * @copyright  2018 Enovation Solutions
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
global $PAGE;

$bodyattributes = $OUTPUT->body_attributes([]);

$course_page = $CFG->wwwroot.'/course/view.php?id='.$PAGE->course->id;

// determine if page is main course page, and if it is then remove the "< Course Overview" link text
$url = $PAGE->url;
$link_text="";
if ((strpos($url, 'course/view.php') !== false) && (strpos($url, 'section=') == false) ){
    $link_text="";
} else {
    $link_text="< Course Overview";
}

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    'moodle_logo' => $OUTPUT->image_url('moodlelogo', 'theme'),
    'course_page' => $course_page,
    'link_text' => $link_text,
];

echo $OUTPUT->render_from_template('theme_boost_o365teams/columns1', $templatecontext);
