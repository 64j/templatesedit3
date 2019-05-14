<?php
/**
 * default config
 */

global $_lang;

return [
    'General' => [
        'default' => true,
        'title' => $_lang['settings_general'],
        'fields' => [
            'pagetitle' => [
                'class' => 'form-control-lg'
            ],
            'longtitle' => [],
            'description' => [],
            'menutitle' => [],
            'parent' => [],
            'weblink' => [],
            'template' => []
        ]
    ],
    'Content' => [
        'title' => $_lang['description'],
        'fields' => [
            'introtext' => [
                'titleClass' => 'col-xs-12',
                'fieldClass' => 'col-xs-12',
                'rows' => 5
            ],
            'content' => [
                'titleClass' => 'col-xs-12 form-row pt-1',
                'fieldClass' => 'col-xs-12',
                'selectClass' => 'float-xs-right',
                'rows' => 15
            ],
            'richtext' => [],
        ]
    ],
    'Seo' => [
        'title' => 'SEO',
        'fields' => [
            'metaTitle' => [],
            'titl' => [],
            'metaDescription' => [],
            'desc' => [],
            'metaKeywords' => [],
            'keyw' => [],
            'alias' => [],
            'link_attributes' => [],
            'menuindex' => [],
            'hidemenu' => [],
            'noIndex' => [],
            'sitemap_exclude' => [],
            'sitemap_priority' => [],
            'sitemap_changefreq' => []
        ]
    ],
    'Settings' => [
        'title' => $_lang['settings_page_settings'],
        'fields' => [
            'published' => [],
            'alias_visible' => [],
            'isfolder' => [],
            'donthit' => [],
            'contentType' => [],
            'type' => [],
            'content_dispo' => [],
            'pub_date' => [],
            'unpub_date' => [],
            'createdon' => [],
            'editedon' => [],
            'searchable' => [],
            'cacheable' => [],
            'syncsite' => []
        ]
    ]
];
