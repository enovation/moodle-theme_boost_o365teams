<?php

defined('MOODLE_INTERNAL') || die;

use theme_boost_o365teams\css_processor;

if ($ADMIN->fulltree) {

    $themename = 'boost_o365teams';
    $themedir = $CFG->dirroot . '/theme/' . $themename;
    $component = 'theme_' . $themename;
    $theme = theme_config::load($themename);

    //// If theme is being installed for the first time, show all settings and expand all collapsible containers
    //// This will prevent uninitialized defaults.
    $wasinstalled = (isset ($theme->settings->enablestyleoverrides)) ? true : false;

    $settings = new theme_boost_admin_settingspage_tabs('themesettingboost_o365teams', get_string('configtitle', 'theme_boost'));

    // Add logo stamp
    $name = "theme_boost_o365teams/footer_stamp";
    $title = get_string('footer_stamp_title','theme_boost_o365teams');
    $description = get_string('footer_stamp_desc', 'theme_boost_o365teams');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'footer_stamp');

    // Feedback link
    $setting = new admin_setting_configtext('theme_boost_o365teams/feedbackurl',
        get_string('setting_feedbackurl', 'theme_boost_o365teams'),
        get_string('setting_feedbackurl_desc', 'theme_boost_o365teams'),
        '',
        PARAM_URL);

    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

}
