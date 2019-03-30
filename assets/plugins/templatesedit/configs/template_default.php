<?php
/**
 * default config
 */

global $content, $_lang;

return [
    'General' => [
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
        'title' => 'Описание',
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
    'TVs' => [
        'default' => true,
        'title' => 'TVs'
    ],
    'Seo' => [
        'title' => 'SEO',
        'fields' => [
            'metaTitle' => [],
            'titl' => [],
            'metaDescription' => [],
            'desc' => [],
            'metaKeywords' => [
                'choices' => true
            ],
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
