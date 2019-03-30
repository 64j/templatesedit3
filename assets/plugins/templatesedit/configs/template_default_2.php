<?php
/**
 * default config
 */

global $content, $_lang;

return [
    'General' => [
        'title' => $_lang['settings_general'],
        'cols' => [
            [
                'title' => '',
                'class' => 'col-md-8',
                'fields' => [
                    'pagetitle' => [],
                    'longtitle' => [],
                    'description' => [
                        'type' => 'textarea',
                        'rows' => 2
                    ],
                    'introtext' => [
                        'rows' => 5
                    ]
                ]
            ],
            [
                'title' => '',
                'class' => 'col-md-4',
                'fields' => [
                    'parent' => [],
                    'template' => [],
                    'alias' => [],
                    'menutitle' => [],
                    'link_attributes' => [],
                ]
            ],
            [
                'title' => '',
                'class' => 'col-md-4 mt-1',
                'fields' => [
                    'published' => [
                        'titleClass' => 'd-inline-block',
                        'fieldClass' => 'float-xs-left'
                    ],
                    'hidemenu' => [
                        'titleClass' => 'd-inline-block',
                        'fieldClass' => 'float-xs-left'
                    ],
                    'richtext' => [
                        'titleClass' => 'd-inline-block',
                        'fieldClass' => 'float-xs-left'
                    ],
                    'isfolder' => [
                        'titleClass' => 'd-inline-block',
                        'fieldClass' => 'float-xs-left'
                    ],
                ]
            ],
            [
                'title' => '',
                'class' => 'col-xs-12 col-12',
                'fields' => [
                    'weblink' => [],
                    'content' => [
                        'titleClass' => 'col-xs-12 form-row pt-1',
                        'selectClass' => 'float-xs-right',
                        'rows' => 15
                    ]
                ]
            ]
        ]
    ],
    'TVs' => [
        'default' => true,
        'titleClass' => 'col-xs-12',
        'fieldClass' => 'col-xs-12',
        'dateGroupClass' => 'd-block',
        'title' => 'TVs'
    ],
    'Settings' => [
        'title' => $_lang['settings_page_settings'],
        'cols' => [
            [
                'title' => '',
                'class' => 'col-xs-8 col-8',
                'fields' => [
                    'contentType' => [],
                    'type' => [],
                    'content_dispo' => [],
                    'menuindex' => [],
                ]
            ],
            [
                'title' => '',
                'class' => 'col-xs-4 col-4',
                'fields' => [
                    'pub_date' => [],
                    'unpub_date' => [],
                    'createdon' => [],
                    'editedon' => []
                ]
            ],
            [
                'title' => '',
                'class' => 'col-xs-12 col-12',
                'fields' => [
                    'alias_visible' => [
                        'titleClass' => 'd-inline-block',
                        'fieldClass' => 'float-xs-left'
                    ],
                    'donthit' => [
                        'titleClass' => 'd-inline-block',
                        'fieldClass' => 'float-xs-left'
                    ],
                    'searchable' => [
                        'titleClass' => 'd-inline-block',
                        'fieldClass' => 'float-xs-left'
                    ],
                    'cacheable' => [
                        'titleClass' => 'd-inline-block',
                        'fieldClass' => 'float-xs-left'
                    ],
                    'syncsite' => [
                        'titleClass' => 'd-inline-block',
                        'fieldClass' => 'float-xs-left'
                    ]
                ]
            ],
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
            'noIndex' => [],
            'sitemap_exclude' => [],
            'sitemap_priority' => [],
            'sitemap_changefreq' => []
        ]
    ],
];
