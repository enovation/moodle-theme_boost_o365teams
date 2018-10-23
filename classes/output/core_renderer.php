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
    /**
     * Return header html.
     * The header section includes custom content security policy setting, as well as reference to Microsoft teams JS
     * lib.
     *
     * @return string
     */
    public function standard_head_html() {
        $output = parent::standard_head_html();

        $output .= "<meta http-equiv=\"Content-Security-Policy\" content=\"default-src *; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://statics.teams.microsoft.com; font-src data: *\">\n";
        $output .= "<script src=\"https://statics.teams.microsoft.com/sdk/v1.0/js/MicrosoftTeams.min.js\"></script>\n";

        return $output;
    }

    /**
     * Return HTML for buttons to open the course page in external browser tab.
     *
     * @return bool|string
     * @throws \dml_exception
     * @throws \moodle_exception
     * @throws coding_exception
     */
    public function course_link() {
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
                $link = html_writer::link($editcourselink, '',
                    array('target' => '_blank', 'class' => 'editcourseicon fa fa-pencil-square-o',
                        'title' => get_string('edit_course', 'theme_boost_o365teams')));
                break;
            }
        }

        if (!$link) {
            $courselink = new moodle_url('/course/view.php', array('id' => $COURSE->id));
            $link = html_writer::link($courselink, '',
                array('target' => '_blank', 'class' => 'viewcourseicon fa fa-external-link',
                    'title' => get_string('open_course', 'theme_boost_o365teams')));
        }

        $linkobj = new stdClass();
        $linkobj->teachereditlink = $link;

        return $this->render_from_template('theme_boost_o365teams/course_link', $linkobj);
    }

    /**
     * Return HTML that shows logged in user link.
     *
     * @return string
     * @throws \moodle_exception
     */
    public function user_link() {
        global $USER, $OUTPUT;

        if(!empty($USER->id)) {

            $profilepagelink = new moodle_url('/user/profile.php',
                    array('id' => $USER->id));
            $profilepic = $OUTPUT->user_picture($USER, array('size'=>26, 'link' => false));
            $userfullname = fullname($USER);
            $piclink = html_writer::link($profilepagelink, $profilepic,
                    array('target' => '_blank', 'class' => 'user_details'));
            $userprofile = html_writer::link($profilepagelink, $userfullname,
                    array('target' => '_blank'));

            return $piclink . $userprofile;
        } else{
            return "";
        }
    }

    /**
     * Return page footer.
     * Page footer contains JS calls to microsoft Teams JS lib.
     *
     * @return string
     */
    public function footer() {
        $footer = parent::footer();

        $js = 'microsoftTeams.initialize();';
        $footer .= html_writer::script($js);

        return $footer;
    }

    /**
     * Return HTML for feedback link.
     *
     * @return string
     * @throws \dml_exception
     * @throws coding_exception
     */
    public function feedback_link() {
        $feedbacklink = '';

        $feedbacklinksetting = get_config('theme_boost_o365teams', 'feedbackurl');
        if ($feedbacklinksetting) {
            $feedbacklink = html_writer::link($feedbacklinksetting,
                html_writer::tag('span',
                    get_string('feedback', 'theme_boost_o365teams')),
                    array('target' => '_blank', 'class' => 'feedbacklink',
                        'title' => get_string('share_feedback', 'theme_boost_o365teams')));
        }

        return $feedbacklink;
    }

    /**
     * Return page footer stamp.
     * Stamp is from user upload in theme settings, or Moodle logo if not uploaded.
     *
     * @param int $maxwidth
     * @param int $maxheight
     *
     * @return string
     * @throws \moodle_exception
     */
    function get_footer_stamp($maxwidth = 120, $maxheight = 60) {
        global $CFG, $PAGE, $OUTPUT;

        if (!empty($PAGE->theme->setting_file_url('footer_stamp', 'footer_stamp'))) {
            $fileurl = $PAGE->theme->setting_file_url('footer_stamp', 'footer_stamp');
            // Get a URL suitable for moodle_url.
            $relativebaseurl = preg_replace('|^https?://|i', '//', $CFG->wwwroot);
            $relativefileurl = str_replace($relativebaseurl, '', $fileurl);
            $url = new moodle_url($relativefileurl);
            $img = html_writer::empty_tag('img', array("src" => $url));

            $coursepageurl = $this->page->url;
            $stamp = html_writer::link($coursepageurl, $img, array('target' => '_blank', 'class' => 'stamp'));
        } else {
            $img = html_writer::empty_tag('img', array("src" => $OUTPUT->image_url('moodlelogo', 'theme')));

            $coursepageurl = $this->page->url;
            $stamp = html_writer::link($coursepageurl, $img, array('target' => '_blank', 'class' => 'stamp'));
        }

        return $stamp;
    }
}
