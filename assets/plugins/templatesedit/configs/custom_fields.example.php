<?php
global $_lang;

/*
 * To use custom_fields rename this file in custom_fields.php
 *
 * @title - Title field
 * @help - Help for field
 * @default - default value in table site_content.
 * @save - If this key is present, then the field will be saved in the plugin for the OnDocFormSave event.
 */

return [
    'deleted' => [
        'title' => $_lang['delete_resource'],
        'default' => 0,
        'save' => true
    ],
    'custom_field' => [
        'title' => 'custom_field',
        'help' => 'custom_field',
        'default' => '',
        'save' => true
    ],
];
