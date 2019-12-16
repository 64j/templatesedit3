<?php
/**
 * default config
 */

global $_lang;

return [
    'General' => [
        'title' => $_lang['settings_general'],
        'default' => true,
        'fields' => [
            'pagetitle' => [],
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
                'rows' => 5
            ],
            'content' => [
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
