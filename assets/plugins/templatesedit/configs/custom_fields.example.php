<?php
global $_lang, $modx;

/*
 * To use custom_fields rename this file in custom_fields.php
 *
 * @title - Title field
 * @help - Help for field
 * @default - default value in table site_content.
 * @save - If this key is present, then the field will be saved in the plugin for the OnDocFormSave event.
 * @prepareSave - Processing the value after saving.
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
    'createdon' => [
        'default' => $modx->toDateFormat(time()),
        'save' => true,
        'prepareSave' => function ($data, $modx) {
            if (!empty($data)) {
                return $modx->toTimeStamp($data);
            } else {
                return time();
            }
        }
    ],
];
