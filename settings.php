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

    $settings->add($page);

}
