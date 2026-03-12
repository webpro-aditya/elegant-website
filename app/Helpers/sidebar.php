<?php

if (!function_exists('sideMenu')) {
    function sideMenu($data = [])
    {
        $sideMenuList = [
            // [
            //     'name' => __('CMS'),
            //     'icon' => '<i class="ki-duotone ki-category fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>',
            //     'permission' => [],
            //     'active' => routeMatch([
            //         'contents_view', ['category' => 'major-milestones'],
            //         // 'contents_add',
            //         // 'contents_edit',
            //         // 'contents_delete',

            //     ]),
            //     'level' => 0,
            //     'child' => [
            //         [
            //             'name' => __('Companies And Startups'),
            //             'permission' => ['pages_read'],
            //             'active' => routeMatch([
            //                 'contents_view', ['category' => 'major-milestones'],
            //                 // 'contents_add',
            //                 // 'contents_edit',
            //                 // 'contents_delete',

            //             ]),
            //             'url' => route('contents_edit_section', ['category' => 'companies-and-startups']),
            //             'level' => 1,
            //         ],
            //         [
            //             'name' => __('Testimonials'),
            //             'permission' => ['course_read'],
            //             'active' => routeMatch([
            //                 'contents_view', ['category' => 'testimonials'],
            //                 // 'contents_add',
            //                 // 'contents_edit',
            //                 // 'contents_delete',
            //             ]),
            //             'url' => route('contents_view', ['category' => 'testimonials']),
            //             'level' => 1,
            //         ],
            //         [
            //             'name' => __('Major Milestones'),
            //             'permission' => ['course_read'],
            //             'active' => routeMatch([
            //                 'contents_view', ['category' => 'major-milestones'],
            //                 // 'contents_add',
            //                 // 'contents_edit',
            //                 // 'contents_delete',
            //             ]),
            //             'url' => route('contents_view', ['category' => 'major-milestones']),
            //             'level' => 1,
            //         ],                   
            //     ],
            // ],

            [
                'name' => __('Pages'),
                'icon' => '<i class="ki-duotone ki-category fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>',
                'permission' => [],
                'active' => routeMatch([
                    ['contents_edit_section'],
                    ['contents_view', 'category' => 'companies-and-startups'],
                    ['contents_view', 'category' => 'our-clients'],
                    ['contents_view', 'category' => 'testimonials'],
                    ['contents_view', 'category' => 'major-milestones'],
                    ['contents_view', 'category' => 'contact-information'],
                    ['contents_add'],
                    ['contents_edit'],
                    ['contents_delete'],

                    request()->is('admin/contents/view') && request()->query('category') === 'contact-information'
                        || request()->is('admin/contents/add') && request()->query('category') === 'contact-information'
                        || request()->is('admin/contents/edit') && request()->query('category') === 'contact-information',

                    request()->is('admin/contents/view') && request()->query('category') === 'major-milestones'
                        || request()->is('admin/contents/add') && request()->query('category') === 'major-milestones'
                        || request()->is('admin/contents/edit') && request()->query('category') === 'major-milestones',
                    request()->is('admin/contents/view') && request()->query('category') === 'testimonials'
                        || request()->is('admin/contents/add') && request()->query('category') === 'testimonials'
                        || request()->is('admin/contents/edit') && request()->query('category') === 'testimonials',
                ]),

                'level' => 0,
                'child' => [
                    [
                        'name' => __('Companies And Startups'),
                        'permission' => ['pages_read'],
                        'active' => routeMatch([
                            // 'contents_edit_section',
                            ['category' => 'companies-and-startups'],
                            // 'contents_add',
                            'contents_edit',
                            // 'contents_delete',

                        ]),
                        'url' => route('contents_edit_section', ['category' => 'companies-and-startups']),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Our Clients'),
                        'permission' => ['pages_read'],
                        'active' => routeMatch([
                            // 'contents_edit_section',
                            ['category' => 'our-clients'],
                            // 'contents_add',
                            'contents_edit',
                            // 'contents_delete',

                        ]),
                        'url' => route('contents_edit_section', ['category' => 'our-clients']),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Terms and Conditions'),
                        'permission' => ['pages_read'],
                        'active' => routeMatch([
                            // 'contents_edit_section',
                            ['category' => 'our-clients'],
                            // 'contents_add',
                            'contents_edit',
                            // 'contents_delete',

                        ]),
                        'url' => route('contents_edit_section', ['category' => 'terms-and-conditions']),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Privacy Policy'),
                        'permission' => ['pages_read'],
                        'active' => routeMatch([
                            // 'contents_edit_section',
                            ['category' => 'our-clients'],
                            // 'contents_add',
                            'contents_edit',
                            // 'contents_delete',

                        ]),
                        'url' => route('contents_edit_section', ['category' => 'privacy-policy']),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Testimonials'),
                        'permission' => ['course_read'],
                        'active' => request()->is('admin/contents/view') && request()->query('category') === 'testimonials'
                            || request()->is('admin/contents/add') && request()->query('category') === 'testimonials'
                            || request()->is('admin/contents/edit') && request()->query('category') === 'testimonials',
                        'url' => route('contents_view', ['category' => 'testimonials']),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Major Milestones'),
                        'permission' => ['course_read'],
                        'active' => request()->is('admin/contents/view') && request()->query('category') === 'major-milestones'
                            || request()->is('admin/contents/add') && request()->query('category') === 'major-milestones'
                            || request()->is('admin/contents/edit') && request()->query('category') === 'major-milestones',
                        'url' => route('contents_view', ['category' => 'major-milestones']),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Contact Information / Our Centers'),
                        'permission' => ['course_read'],
                        'active' => request()->is('admin/contents/view') && request()->query('category') === 'contact-information'
                            || request()->is('admin/contents/add') && request()->query('category') === 'contact-information'
                            || request()->is('admin/contents/edit') && request()->query('category') === 'contact-information',
                        'url' => route('contents_view', ['category' => 'contact-information']),
                        'level' => 1,
                    ],
                ],
            ],

            [
                'name' => __('Courses'),
                'icon' => '<i class="fa-solid fa-user-group fs-4 me-2"></i>',
                'permission' => ['course_read'],
                'active' => routeMatch([
                    'course_category_list',
                    'course_category_add',
                    'course_category_edit',
                    'course_list',
                    'course_edit',
                    'batch_list',
                    'batch_add',
                    'batch_edit',
                    'faq_list',
                    'faq_add',
                    'faq_edit',
                    'faq_view', 
                    ['contents_view', 'category' => 'feature'],
                    ['contents_view', 'category' => 'join-now-for-course'],
                    ['contents_view', 'category' => 'top-companies-hiring'],
                    ['contents_view', 'category' => 'banner-features'],
                    ['contents_view', 'category' => 'corporate-training-course'],

                    request()->is('admin/contents/view') && request()->query('category') === 'corporate-training-course'
                        || request()->is('admin/contents/add') && request()->query('category') === 'corporate-training-course'
                        || request()->is('admin/contents/edit') && request()->query('category') === 'corporate-training-course',


                    request()->is('admin/contents/view') && request()->query('category') === 'feature'
                        || request()->is('admin/contents/add') && request()->query('category') === 'feature'
                        || request()->is('admin/contents/edit') && request()->query('category') === 'feature',

                    request()->is('admin/contents/view') && request()->query('category') === 'join-now-for-course'
                        || request()->is('admin/contents/add') && request()->query('category') === 'join-now-for-course'
                        || request()->is('admin/contents/edit') && request()->query('category') === 'join-now-for-course',


                    request()->is('admin/contents/view') && request()->query('category') === 'top-companies-hiring'
                        || request()->is('admin/contents/add') && request()->query('category') === 'top-companies-hiring'
                        || request()->is('admin/contents/edit') && request()->query('category') === 'top-companies-hiring',

                    request()->is('admin/contents/view') && request()->query('category') === 'banner-features'
                        || request()->is('admin/contents/add') && request()->query('category') === 'banner-features'
                        || request()->is('admin/contents/edit') && request()->query('category') === 'banner-features',

                    // 'contents_view',
                    // ['category' => 'feature'],
                    // 'contents_view',
                    // ['category' => 'join-now-for-course'],
                    // 'contents_view',
                    // ['category' => 'top-companies-hiring'],
                    // 'contents_view',
                    // ['category' => 'banner-features'],
                    // 'contents_view',
                    // ['category' => 'corporate-training-course'],
                ]),

                'url' => route('course_list'),
                'level' => 0,
                'child' => [
                    [
                        'name' => __('Courses'),
                        // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                        'permission' => ['course_read'],
                        'active' => routeMatch(['course_list', 'course_add', 'course_edit', 'course_view']),
                        'url' => route('course_list'),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Categories'),
                        // 'icon' => '<i class="ki-outline ki-key-square fs-4 me-2"></i>',
                        'permission' => ['course_read'],
                        'active' => routeMatch(['course_category_list', 'course_category_list_add', 'course_category_list_edit', 'course_category_list_view']),
                        'url' => route('course_category_list'),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Course - Features'),
                        // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                        'permission' => ['course_read'],
                        'active' => request()->is('admin/contents/view') && request()->query('category') === 'feature'
                            || request()->is('admin/contents/add') && request()->query('category') === 'feature'
                            || request()->is('admin/contents/edit') && request()->query('category') === 'feature',

                        'url' => route('contents_view', ['category' => 'feature']),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Course - Join Now'),
                        // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                        'permission' => ['course_read'],
                        'active' => request()->is('admin/contents/view') && request()->query('category') === 'join-now-for-course'
                            || request()->is('admin/contents/add') && request()->query('category') === 'join-now-for-course'
                            || request()->is('admin/contents/edit') && request()->query('category') === 'join-now-for-course',
                        'url' => route('contents_view', ['category' => 'join-now-for-course']),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Course - Top Companies Hiring'),
                        //   'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                        'permission' => ['course_read'],
                        'active' => request()->is('admin/contents/view') && request()->query('category') === 'top-companies-hiring'
                            || request()->is('admin/contents/add') && request()->query('category') === 'top-companies-hiring'
                            || request()->is('admin/contents/edit') && request()->query('category') === 'top-companies-hiring',
                        'url' => route('contents_view', ['category' => 'top-companies-hiring']),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Course Banner Feature'),
                        //   'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                        'permission' => ['pages_read'],
                        'active' => request()->is('admin/contents/view') && request()->query('category') === 'banner-features'
                            || request()->is('admin/contents/add') && request()->query('category') === 'banner-features'
                            || request()->is('admin/contents/edit') && request()->query('category') === 'banner-features',
                        'url' => route('contents_view', ['category' => 'banner-features']),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Coporate Training Courses'),
                        //   'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                        'permission' => ['pages_read'],
                        'active' => request()->is('admin/contents/view') && request()->query('category') === 'corporate-training-course'
                            || request()->is('admin/contents/add') && request()->query('category') === 'corporate-training-course'
                            || request()->is('admin/contents/edit') && request()->query('category') === 'corporate-training-course',
                        'url' => route('contents_view', ['category' => 'corporate-training-course']),
                        'level' => 1,
                    ],
                    // [
                    //     'name' => __('FAQ'), 
                    //     // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                    //     'permission' => ['course_read'],
                    //     'active' => routeMatch(['contents_view']),
                    //     'url' => route('contents_view', ['category' => 'faq']),
                    //     'level' => 2,
                    // ],
                    [
                        'name' => __('Faq'),
                        'permission' => ['settings_read'],
                        'active' => routeMatch(['faq_list', 'faq_add', 'faq_edit', 'faq_view']),
                        'url' => route('faq_list'),
                        'level' => 2,
                    ],




                    // [
                    //     'name' => __('Coporate Training Courses'),
                    //     'icon' => '<i class="fa-solid fa-book-open fs-4 me-2"></i>',
                    //     'permission' => ['pages_read'],
                    //     'active' => routeMatch([
                    //         'contents_view',
                    //         'contents_add',
                    //         'contents_edit',
                    //         'contents_delete',
                    //     ]),
                    //     'level' => 0,
                    //     'url' => route('contents_view', ['category' => 'corporate-training-course']),
                    // ],
                    // [
                    //     'name' => __('Course Banner Feature'),
                    //     'icon' => '<i class="fa-solid fa-book-open-reader fs-4 me-2"></i>',
                    //     'permission' => ['pages_read'],
                    //     'active' => routeMatch([
                    //         'contents_view',
                    //         'contents_add',
                    //         'contents_edit',
                    //         'contents_delete',
                    //     ]),
                    //     'level' => 0,
                    //     'url' => route('contents_view', ['category' => 'banner-features']),
                    // ],
                    // [
                    //     'name' => __('Training Calender'),
                    //     // 'icon' => '<i class="ki-outline ki-key-square fs-4 me-2"></i>',
                    //     'permission' => ['course_read'],
                    //     'active' => routeMatch(['training_calendar_list']),
                    //     'url' => route('training_calendar_list'),
                    //     'level' => 1,
                    // ],
                    // [
                    //     'name' => __('Training Calendar'),
                    //     // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                    //     'permission' => ['course_read'],
                    //     'active' => routeMatch(['training_calendar_list']),
                    //     'url' => route('training_calendar_list'),
                    //     'level' => 1,
                    //     'child' => [
                    //         // [
                    //         //     'name' => __('FAQ'),
                    //         //     // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                    //         //     'permission' => ['course_read'],
                    //         //     'active' => routeMatch(['contents_view']),
                    //         //     'url' => route('contents_view', ['category' => 'faq']),
                    //         //     'level' => 2,
                    //         // ],
                    //         [
                    //             'name' => __('Features'),
                    //             // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                    //             'permission' => ['course_read'],
                    //             'active' => routeMatch(['course_training_calendar_list']),
                    //             'url' => route('contents_view', ['category' => 'feature']),
                    //             'level' => 2,
                    //         ],
                    //         [
                    //             'name' => __('Top Companies Hiring'),
                    //             // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                    //             'permission' => ['course_read'],
                    //             'active' => routeMatch(['contents_view']),
                    //             'url' => route('contents_view', ['category' => 'top-companies-hiring']),
                    //             'level' => 2,
                    //         ],
                    //     ]
                    // ],

                    // [
                    //     'name' => __('Batch'),
                    //     //   'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                    //     'permission' => ['batch_read'],
                    //     'active' => routeMatch(['batch_list', 'batch_add', 'batch_edit']),
                    //     'url' => route('batch_list'),
                    //     'level' => 1,
                    // ]
                ]
            ],

            [
                'name' => __('Career'),
                'icon' => '<i class="fa-solid fa-graduation-cap  fs-4 me-2"></i> ',
                'permission' => ['career_read'],
                'active' => routeMatch(['career_category_list', 'career_category_add', 'career_category_edit', 'career_category_delete', 'career_list', 'career_add', 'career_edit', 'career_update', 'career_applicant_list']),
                'url' => route('course_list'),
                'level' => 0,
                'child' => [
                    [
                        'name' => __('Career Category'),
                        // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                        'permission' => ['career_category_read'],
                        'active' => routeMatch(['career_category_list', 'career_category_add', 'career_category_edit', 'career_category_delete']),
                        'url' => route('career_category_list'),
                        'level' => 2,
                    ],
                    [
                        'name' => __('Career'),
                        // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                        'permission' => ['career_read'],
                        'active' => routeMatch(['career_list', 'career_add', 'career_edit', 'career_update', 'career_view']),
                        'url' => route('career_list'),
                        'level' => 2,
                    ],
                    [
                        'name' => __('Career Applicants'),
                        // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                        'permission' => ['career_read'],
                        'active' => routeMatch(['career_applicant_list', 'career_applicant_view']),
                        'url' => route('career_applicant_list'),
                        'level' => 2,
                    ],
                ]
            ],

            [
                'name' => __('Blog'),
                'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                'permission' => ['blog_read'],
                'active' => routeMatch(['author_add', 'author_edit', 'author_list', 'blog_list', 'blog_add', 'blog_edit', 'blog_update', 'blog_category_list', 'blog_category_add', 'blog_category_edit', 'blog_category_update']),
                'url' => route('course_list'),
                'level' => 0,
                'child' => [
                    [
                        'name' => __('Blog Category'),
                        // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                        'permission' => ['blog_category_read'],
                        'active' => routeMatch(['blog_category_list', 'blog_category_add', 'blog_category_edit', 'blog_category_update']),
                        'url' => route('blog_category_list'),
                        'level' => 2,
                    ],
                    [
                        'name' => __('Blog'),
                        // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                        'permission' => ['blog_read'],
                        'active' => routeMatch(['blog_list', 'blog_add', 'blog_edit', 'blog_update']),
                        'url' => route('blog_list'),
                        'level' => 2,
                    ],
                    [
                        'name' => __('Author'),
                        // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                        'permission' => ['author_read'],
                        'active' => routeMatch(['author_add', 'author_edit', 'author_list']),
                        'url' => route('author_list'),
                        'level' => 2,
                    ],
                ]
            ],

            [
                'name' => __('About US - Youtube Video'),
                'icon' => '<i class="fa-brands fa-youtube fs-4 me-2"></i>',
                'permission' => ['pages_read'],
                'active' => request()->is('admin/contents/view') && request()->query('category') === 'channel-videos'
                    || request()->is('admin/contents/add') && request()->query('category') === 'channel-videos'
                    || request()->is('admin/contents/edit') && request()->query('category') === 'channel-videos',
                'level' => 0,
                'url' => route('contents_view', ['category' => 'channel-videos']),
            ],





            [
                'name' => __('Gallery'),
                'icon' => '<i class="fa-regular fa-images fs-4 me-2"></i>',
                'permission' => ['gallery_read'],
                'active' => routeMatch(['gallery_list', 'gallery_add', 'gallery_edit']),

                'level' => 0,
                'url' => route('gallery_list'),
            ],
            [
                'name' => __('Subscribers'),
                'icon' => '<i class="fa-solid fa-book-open fs-4 me-2"></i>',
                'permission' => ['subscriber_read'],
                'active' => routeMatch(['subscriber_list']),

                'level' => 0,
                'url' => route('subscriber_list'),
            ],
            [
                'name' => __('Free Resource'),
                'icon' => '<i class="fa-solid fa-laptop-code fs-4 me-2"></i>',
                'permission' => ['free_resource_read'],
                'active' => routeMatch(['free_resource_add', 'free_resource_contents_add', 'free_resource_list', 'free_resource_edit', 'free_resource_contents_edit']),

                'level' => 0,
                'url' => route('free_resource_list'),
            ],

            [
                'name' => __('Enquiry'),
                'icon' => '<i class="fa-solid fa-comments fs-4 me-2"></i>',
                'permission' => ['settings_read'],
                'active' => routeMatch(['enquiry_list', 'enquiry_detail']),
                'level' => 0,
                'url' => route('enquiry_list'),
            ],

            // [
            //     'name' => __(''),
            //     'active' => routeMatch([
            //         'contents_view'
            //         // 'user_role_list', 'user_role_add', 'user_role_edit', 'user_role_view',
            //         // 'user_list', 'user_add', 'user_edit', 'user_view',
            //     ]),
            //     'level' => 0,
            //     'child' => [
            //         [
            //             'name' => __('Information and Reviews'),
            //             // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
            //             'permission' => ['course_read'],
            //             'active' => routeMatch(['user_list', 'user_add', 'user_edit', 'user_view']),
            //             'url' => route('course_list'),
            //             'level' => 1,
            //             'child' => [
            //                 [
            //                     'name' => __('FAQ'),
            //                     // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
            //                     'permission' => ['course_read'],
            //                     'active' => routeMatch(['contents_view']),
            //                     'url' => route('contents_view', ['category' => 'faq']),
            //                     'level' => 2,
            //                 ],
            //            
            //                
            //             ]
            //         ],


            //     ],

            // ],

            [
                'name' => __('Users'),
                'icon' => '<i class="fa-solid fa-user-group fs-4 me-2"></i>',
                'permission' => ['user_role_read', 'user_read'],
                'active' => routeMatch([
                    'user_role_list',
                    'user_role_add',
                    'user_role_edit',
                    'user_role_view',
                    'user_list',
                    'user_add',
                    'user_edit',
                    'user_view',
                ]),
                'level' => 0,
                'child' => [
                    [
                        'name' => __('Users'),
                        // 'icon' => '<i class="ki-outline ki-faceid fs-4 me-2"></i>',
                        'permission' => ['user_read'],
                        'active' => routeMatch(['user_list', 'user_add', 'user_edit', 'user_view']),
                        'url' => route('user_list'),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Roles'),
                        // 'icon' => '<i class="ki-outline ki-key-square fs-4 me-2"></i>',
                        'permission' => ['role_read'],
                        'active' => routeMatch(['user_role_list', 'user_role_add', 'user_role_edit', 'user_role_view']),
                        'url' => route('user_role_list'),
                        'level' => 1,
                    ],
                ],
            ],

            [
                'name' => __('Settings'),
                'icon' => '<i class="fa-solid fa-gear me-2"></i>',
                'permission' => ['settings_read'],
                'active' => routeMatch([
                    'settings_branding_view',
                    'settings_social_view',
                    'settings_config_view',
                    'settings_keys_view',
                    'seo_list',
                    'seo_add',
                    'seo_edit',
                    'seo_view',
                    'course_curriculum_list',
                    'course_curriculum_detail',
                    'translation_view'
                ]),
                'level' => 0,
                'child' => [
                    [
                        'name' => __('Branding'),
                        'permission' => ['settings_read'],
                        'active' => routeMatch(['settings_branding_view']),
                        'url' => route('settings_branding_view'),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Seo'),
                        'permission' => ['settings_read'],
                        'active' => routeMatch(['settings_seo_view']),
                        'url' => route('settings_seo_view'),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Social'),
                        'permission' => ['settings_read'],
                        'active' => routeMatch(['settings_social_view']),
                        'url' => route('settings_social_view'),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Website'),
                        'permission' => ['settings_read'],
                        'active' => routeMatch(['settings_config_view']),
                        'url' => route('settings_config_view'),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Key Settings'),
                        'permission' => ['settings_read'],
                        'active' => routeMatch(['settings_keys_view']),
                        'url' => route('settings_keys_view'),
                        'level' => 1,
                    ],
                    // [
                    //     'name' => __('Seo'),
                    //     'permission' => ['seo_read'],
                    //     'active' => routeMatch(['seo_list', 'seo_add', 'seo_edit', 'seo_view']),
                    //     'url' => route('seo_list'),
                    //     'level' => 1,
                    // ],
               
               
                    [
                        'name' => __('Curriculum'),
                        'permission' => ['course_read'],
                        'active' => routeMatch(['course_curriculum_list', 'course_curriculum_detail']),
                        'url' => route('course_curriculum_list'),
                        'level' => 1,
                    ],
                    [
                        'name' => __('Translation'),
                        'permission' => ['translation_read'],
                        'active' => routeMatch(['translation_view']),
                        'url' => route('translation_view'),
                        'level' => 1,
                    ],

                ],
            ],



        ];
        $user = auth()->guard(auth()->guard()->name)->user();
        $sideMenu = renderList($sideMenuList, $user);

        return $sideMenu['view'];
    }

    function renderList($sideMenuList, $user)
    {
        $sideMenuView = '';
        $sideMenuActive = false;

        foreach ($sideMenuList as $sideMenu) {
            $menuRoles = isset($sideMenu['role']) ? $sideMenu['role'] : [];
            $menuPermissions = isset($sideMenu['permission']) ? $sideMenu['permission'] : [];
            $menuUrl = isset($sideMenu['url']) ? $sideMenu['url'] : '#';
            $menuIcon = isset($sideMenu['icon']) ? $sideMenu['icon'] : '';
            $menuName = isset($sideMenu['name']) ? $sideMenu['name'] : '';
            $menuActive = isset($sideMenu['active']) ? $sideMenu['active'] : false;

            $sideMenuActive = $sideMenuActive || $menuActive;

            $userCan = true;

            if (!empty($menuPermissions)) {
                $userCan = false;

                foreach ($menuPermissions as $permission) {
                    if ($user->can($permission)) {
                        $userCan = true;

                        break;
                    }
                }
            }

            if (!empty($menuRoles)) {
                $roleAccess = $user->hasAnyRole($menuRoles);
                $userCan = (!empty($menuPermissions)) ? ($userCan = $userCan || $roleAccess) : $roleAccess;
            }

            if ($userCan) {
                if (isset($sideMenu['child'])) {
                    $subMenu = renderList($sideMenu['child'], $user);

                    if (!empty($subMenu['view'])) {
                        $sideMenuView .= '<div data-kt-menu-trigger="click" class="menu-item menu-accordion ' . ($menuActive ? 'here show' : '') . ' py-1 ps-' . $sideMenu['level'] . '">
                                    <span class="menu-link">
                                        <span class="menu-bullet ' . ($menuActive ? 'text-primary' : '') . '"> ' . $menuIcon . '</span>
                                        <span class="menu-title ' . ($menuActive ? 'text-primary' : '') . '">' . $menuName . '</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-state-gray-900 menu-fit ' . ($menuActive ? 'open' : '') . '">
                                    ' . $subMenu['view'] . '
                                    </div>
                                </div>';
                    }
                } else {
                    $sideMenuView .= '<div class="menu-item ps-' . $sideMenu['level'] . '">
                                <a class="menu-link ' . ($menuActive ? 'active' : '') . '" href="' . $menuUrl . '">
                                    <span class="menu-bullet ' . ($menuActive ? 'text-primary' : '') . '"> ' . $menuIcon . '</span>
                                    <span class="menu-title ' . ($menuActive ? 'text-primary' : '') . '">' . $menuName . '</span>
                                </a>
                            </div>';
                }
            }
        }

        return ['view' => $sideMenuView, 'active' => $sideMenuActive];
    }
}
