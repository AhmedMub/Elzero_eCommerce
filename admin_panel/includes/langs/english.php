<?php

function lang($phrase) {
    static $lang = array(
        'dashboard'      => 'Dashboard',
        'Admin'      => 'Home',
        'Categories' => 'Categories',
        'ITEMS'      => 'Items',
        'MEMBERS'    => 'Members',
        'COMMENTS'  =>'Comments',
        'STATISTICS' => 'Statistics',
        'LOGS' => 'Logs',
        //=============================
        'admin_name' => 'Ahmed',
        'frontWebPage' => 'Website',
        'nav_edit' => 'Edit profile',
        'nav_settings' => 'Settings',
        'nav_logout' => 'Logout'
    );

    return $lang[$phrase];
}