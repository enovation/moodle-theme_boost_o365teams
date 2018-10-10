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

namespace theme_boost_o365teams\output;

use coding_exception;
use html_writer;
use tabobject;
use tabtree;
use custom_menu_item;
use custom_menu;
use block_contents;
use navigation_node;
use action_link;
use stdClass;
use moodle_url;
use preferences_groups;
use action_menu;
use help_icon;
use single_button;
use paging_bar;
use context_course;
use pix_icon;

defined('MOODLE_INTERNAL') || die;

class core_renderer extends \theme_boost\output\core_renderer {
    public function standard_head_html() {
        $output = parent::standard_head_html();

        $output .= "<meta http-equiv=\"Content-Security-Policy\" content=\"default-src *; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://unpkg.com; font-src data: *\">\n";
        $output .= "<script src=\"https://unpkg.com/@microsoft/teams-js@1.3.4/dist/MicrosoftTeams.min.js\"></script>\n";

        return $output;
    }

    public function edit_link() {
        global $DB, $COURSE;

        $coursecontext = context_course::instance($COURSE->id);
        $roleassignments = get_user_roles($coursecontext);
        $teacherrole = $DB->get_record('role', array('shortname' => 'editingteacher'));
        $noneditingteacherrole = $DB->get_record('role', array('shortname' => 'teacher'));

        $link = '';
        foreach ($roleassignments as $roleassignment) {
            if (in_array($roleassignment->roleid, array($teacherrole->id, $noneditingteacherrole->id))) {
                $editcourselink = new moodle_url('/course/view.php',
                    array('id' => $COURSE->id, 'edit' => 1, 'sesskey' => sesskey()));
                $link = html_writer::link($editcourselink, get_string('editcourse', 'theme_boost_o365teams'),
                    array('target' => '_blank'));
                break;
            }
        }

        $linkobj = new stdClass();
        $linkobj->teachereditlink = $link;

        return $this->render_from_template('theme_boost_o365teams/edit_link', $linkobj);
    }

    public function footer() {
        $footer = parent::footer();

        $js = 'microsoftTeams.initialize();';
        $footer .= html_writer::script($js);

        return $footer;
    }
    function get_footer_stamp_url($maxwidth = 120, $maxheight = 60) {
        global $CFG, $PAGE;

        if (!empty($PAGE->theme->setting_file_url('footer_stamp', 'footer_stamp'))) {
            $url = $PAGE->theme->setting_file_url('footer_stamp', 'footer_stamp');
            // Get a URL suitable for moodle_url.
            $relativebaseurl = preg_replace('|^https?://|i', '//', $CFG->wwwroot);
            $url = str_replace($relativebaseurl, '', $url);
            return new moodle_url($url);
        }
        return false;
    }
}
