<?php

class Cornerstone_Conditionals extends Cornerstone_Plugin_Component {

  public function get_preview_contexts() {

    if (! isset( $this->preview_contexts ) ) {
      $this->preview_contexts = apply_filters('cs_preview_contexts', [
        'labels' => [
          'single' => __('Single', 'cornerstone'),
          'archive' => __('Archive', 'cornerstone'),
        ],
        'controls' => [
          'single' => $this->preview_context_single(),
          'archive' => $this->preview_context_archive(),
        ]
      ]);
    }

    return $this->preview_contexts;

  }

  public function get_condition_contexts() {

    if (! isset( $this->condition_contexts ) ) {
      $this->condition_contexts = apply_filters('cs_condition_contexts', [
        'labels' => [
          'expression'    => __('Expression', 'cornerstone'),
          'current-post'  => __('Current Post', 'cornerstone'),
          'current-query' => __('Global Query', 'cornerstone'),
          'looper'        => __('Looper', 'cornerstone'),
          'global'        => __('Global', 'cornerstone'),
        ],
        'controls' => [
          'expression' => $this->condition_context_expression(),
          'current-post'  => $this->condition_context_current_post(),
          'current-query' => $this->condition_context_current_query(),
          'looper' => $this->condition_context_looper(),
          'global' => $this->assignment_and_condition_context_global()
        ]
      ]);
    }

    return $this->condition_contexts;

  }

  public function get_assignment_contexts() {

    if (! isset( $this->assignment_contexts ) ) {
      $this->assignment_contexts = apply_filters('cs_assignment_contexts', [
        'labels' => [
          'site'       => __('Site', 'cornerstone'),
          'single'     => __('Single', 'cornerstone'),
          'archive'    => __('Archive', 'cornerstone'),
          'global'     => __('Global', 'cornerstone'),
        ],
        'controls' => [
          'site'       => $this->assignment_context_site(),
          'single'     => $this->assignment_context_single(),
          'archive'    => $this->assignment_context_archive(),
          'global'     => $this->assignment_and_condition_context_global()
        ]
      ]);
    }

    return $this->assignment_contexts;

  }


  public function get_post_type_url_options() {
    $post_types = $this->plugin->component('Locator')->get_post_types();

    $post_type_options = [];

    foreach ($post_types as $post_type => $post_type_obj) {
      $url = get_post_type_archive_link($post_type);
      if ($url) {
        $post_type_options[] = ['value' => $url, 'label' => $post_type_obj->labels->singular_name];
      }
    }

    return $post_type_options;
  }



  public function maybe_get_front_page( $type ) {

    if (get_option('show_on_front') === 'page') {

      if ($type === 'single') {
        return get_option('page_on_front');
      }

      if ($type === 'archive') {
        return get_option('page_for_posts');
      }

    }

    return null;

  }

  public function preview_context_single() {
    $single = [];

    $front_page = $this->maybe_get_front_page( 'single' );

    if ($front_page) {
      $single[] = [
        'key'      => 'single:front-page',
        'label'    => __('Front Page', 'cornerstone'),
        'criteria' => [
          'url' => get_permalink( $front_page )
        ]
      ];
    }

    $post_types = apply_filters( 'cs_preview_context_post_types', $this->plugin->component('Locator')->get_post_types() );

    foreach ($post_types as $post_type => $post_type_obj) {
      $single[] = [
        'key'    => "single:post-type|$post_type",
        'label'  => $post_type_obj->labels->singular_name,
        'criteria' => [
          'type'    => 'select',
          'choices' => "posts:$post_type"
        ]
      ];
    }

    $single[] = [
      'key' => 'single:page-404',
      'label'  => __('404 Page', 'cornerstone'),
      'criteria' => [
        'url' => home_url( apply_filters( 'cs_404_preview_path', $this->plugin->common()->get_app_slug() . '-404-preview' ) )
      ]
    ];

    return $single;
  }

  public function preview_context_archive() {
    $archive = [];

    if (get_option('show_on_front') === 'posts') {
      $archive[] = [
        'key'      => 'archive:front-page',
        'label'    => __('Blog Page', 'cornerstone'),
        'criteria' => [
          'url' => home_url()
        ]
      ];
    } else {

      $front_page = $this->maybe_get_front_page( 'archive' );

      if ($front_page) {
        $archive[] = [
          'key'      => 'archive:front-page',
          'label'    => __('Blog Page', 'cornerstone'),
          'criteria' => [
            'url' => get_permalink( $front_page )
          ]
        ];
      }

    }


    // Post Types
    // ----------

    $archive[] = [
      'key'   => 'archive:post-type',
      'label' => __('Post Type', 'cornerstone'),
      'criteria' => [
        'type'    => 'select',
        'choices' => $this->get_post_type_url_options()
      ]
    ];


    // Post Type Terms
    // ---------------

    $post_types = apply_filters( 'cs_preview_context_post_types', $this->plugin->component('Locator')->get_post_types() );

    foreach ($post_types as $post_type => $post_type_obj) {

      $post_type_taxonomies = get_object_taxonomies($post_type);

      foreach ($post_type_taxonomies as $taxonomy) {
        if ($taxonomy === 'post_format') {
          continue;
        }

        $taxonomy_obj = get_taxonomy($taxonomy);

        $archive[] = [
          'key'    => "archive:post-type-with-term|$post_type|$taxonomy",
          'label'  => sprintf(_x('%s %s', '[Post Type] [Post Taxonomy]', 'cornerstone'), $post_type_obj->labels->singular_name, $taxonomy_obj->labels->singular_name),
          'criteria' => [
            'type'    => 'select',
            'choices' => "terms:$taxonomy"
          ]
        ];
      }

    }


    // Search
    // ------

    $archive[] = [
      'key'      => 'archive:search',
      'label'    => __('Search Results', 'cornerstone'),
      'criteria' => [
        'type'   => 'text',
        'format' => get_search_link('SEARCHQUERYPLACEHOLDER')
      ]
    ];

    // Author
    // ------

    $archive[] = [
      'key'    => 'archive:author',
      'label'  => __('Author', 'cornerstone'),
      'criteria' => [
        'type'    => 'select',
        'choices' => 'user:all'
      ]
    ];


    // Any Term
    // --------

    $archive[] = [
      'key'    => 'archive:term',
      'label'  => __('Term', 'cornerstone'),
      'criteria' => [
        'type'    => 'select',
        'choices' => 'terms:all'
      ]
    ];

    return $archive;
  }

  public function assignment_context_site() {
    return [
      [
        'key'    => 'site:entire-site',
        'label'  => __('Entire Site', 'cornerstone'),
      ]
    ];
  }

  public function assignment_context_single() {

    $conditions = [
      [
        'key'    => 'single:singular-all',
        'label'  => __('All Singular', 'cornerstone'),
      ],
      $this->maybe_get_front_page('single') ? [
        'key'    => 'single:front-page',
        'label'  => __('Front Page', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ] : null,
      [
        'key'   => 'single:post-type',
        'label' => __('Post Type', 'cornerstone'),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => $this->plugin->component('Locator')->get_post_type_options()
        ]
      ]
    ];

    $post_types = apply_filters( 'cs_assignment_context_post_types', $this->plugin->component('Locator')->get_post_types() );

    foreach ($post_types as $post_type => $post_type_obj) {

      $conditions[] = [
        'key'    => "single:specific-post-of-type|$post_type",
        'label'  => sprintf(__('%s (Specific)', 'cornerstone'), $post_type_obj->labels->singular_name),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => "posts:$post_type"
        ]
      ];

      $post_type_taxonomies = get_object_taxonomies($post_type);

      foreach ($post_type_taxonomies as $taxonomy) {
        if ($taxonomy === 'post_format') {
          continue;
        }

        $taxonomy_obj = get_taxonomy($taxonomy);

        $conditions[] = [
          'key'    => "single:post-type-with-term|$post_type|$taxonomy",
          'label'  => sprintf(_x('%s %s', '[Post Type] [Post Taxonomy]', 'cornerstone'), $post_type_obj->labels->singular_name, $taxonomy_obj->labels->singular_name),
          'toggle' => ['type' => 'boolean'],
          'criteria' => [
            'type'    => 'select',
            'choices' => "terms:$taxonomy"
          ]
        ];
      }

      if ($post_type_obj->hierarchical) {

        $conditions[] = [
          'key'    => "single:parent|$post_type",
          'label'  => sprintf(__('%s Parent', 'cornerstone'), $post_type_obj->labels->singular_name),
          'toggle' => ['type' => 'boolean'],
          'criteria' => [
            'type'    => 'select',
            'choices' => "posts:$post_type"
          ]
        ];

        $conditions[] = [
          'key'    => "single:ancestor|$post_type",
          'label'  => sprintf(__('%s Ancestor', 'cornerstone'), $post_type_obj->labels->singular_name),
          'toggle' => ['type' => 'boolean'],
          'criteria' => [
            'type'    => 'select',
            'choices' => "posts:$post_type"
          ]
        ];

        if (post_type_supports($post_type, 'page-attributes')) {
          $conditions[] = [
            'key'    => "single:page-template|$post_type",
            'label'  => sprintf(__('%s Template', 'cornerstone'), $post_type_obj->labels->singular_name),
            'toggle' => ['type' => 'boolean'],
            'criteria' => [
              'type'    => 'select',
              'choices' => cs_get_page_template_options($post_type)
            ]
          ];
        }
      }

      if (post_type_supports($post_type, 'post-formats')) {
        $conditions[] = [
          'key'    => "single:format|$post_type",
          'label'  => sprintf(__('%s Format', 'cornerstone'), $post_type_obj->labels->singular_name),
          'toggle' => ['type' => 'boolean'],
          'criteria' => [
            'type'    => 'select',
            'choices' => cs_get_post_format_options()
          ]
        ];
      }

      $conditions[] = [
        'key'    => "single:publish-date|$post_type",
        'label'  => sprintf(__('%s Publish Date', 'cornerstone'), $post_type_obj->labels->singular_name),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [csi18n('app.conditions.before'), csi18n('app.conditions.after')]
        ],
        'criteria' => ['type' => 'date-picker'],
      ];

      $conditions[] = [
        'key'    => "single:status|$post_type",
        'label'  => sprintf(__('%s Status', 'cornerstone'), $post_type_obj->labels->singular_name),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => cs_get_post_status_options()
        ]
      ];
    }

    return array_values( array_filter( array_merge( $conditions, [
      [
        'key'    => 'single:term',
        'label'  => __('Term', 'cornerstone'),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => 'terms:all'
        ]
      ], [
        'key'    => 'single:page-404',
        'label'  => __('404 Page', 'cornerstone'),
         'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ]
    ] ) ) );
  }

  public function assignment_context_archive() {
    $front_page = $this->maybe_get_front_page( 'archive' );

    $conditions = [
      [
        'key'    => 'archive:blog',
        'label'  => __('Blog', 'cornerstone'),
         'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'    => 'archive:front-page',
        'label'  => __('Front Page', 'cornerstone'),
         'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'    => 'archive:all',
        'label'  => __('All Archives', 'cornerstone'),
      ], [
        'key'   => 'archive:post-type',
        'label' => __('Post Type', 'cornerstone'),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => $this->plugin->component('Locator')->get_post_type_options()
        ]
      ], [
        'key'    => 'archive:is-first-page',
        'label'  => __('First Page', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'   => 'archive:date',
        'label' => __('Date Archive', 'cornerstone'),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => [
            ['value' => 'date', 'label' => __('Any', 'cornerstone')],
            ['value' => 'year', 'label' => __('Year', 'cornerstone')],
            ['value' => 'month', 'label' => __('Month', 'cornerstone')],
            ['value' => 'day', 'label' => __('Day', 'cornerstone')],
            ['value' => 'time', 'label' => __('Time', 'cornerstone')],
          ]
        ]
      ],
    ];

    $post_types = apply_filters( 'cs_assignment_context_post_types', $this->plugin->component('Locator')->get_post_types() );

    foreach ($post_types as $post_type => $post_type_obj) {

      $post_type_taxonomies = get_object_taxonomies($post_type);
      $taxonomy_options = [];
      $taxonomy_conditions = [];

      foreach ($post_type_taxonomies as $taxonomy) {
        if ($taxonomy === 'post_format') {
          continue;
        }

        $taxonomy_obj = get_taxonomy($taxonomy);

        $taxonomy_options[] = ['value' => $taxonomy, 'label' => $taxonomy_obj->labels->singular_name];

        $taxonomy_conditions[] = [
          'key'    => "archive:post-type-with-term|$post_type|$taxonomy",
          'label'  => sprintf(_x('%s %s', '[Post Type] [Post Taxonomy]', 'cornerstone'), $post_type_obj->labels->singular_name, $taxonomy_obj->labels->singular_name),
          'toggle' => ['type' => 'boolean'],
          'criteria' => [
            'type'    => 'select',
            'choices' => "terms:$taxonomy"
          ]
        ];
      }

      $conditions[] = [
        'key'    => "archive:taxonomy|$post_type",
        'label'  => sprintf(_x('%s Taxonomy', 'cornerstone'), $post_type_obj->labels->singular_name),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => $taxonomy_options
        ]
      ];

      $conditions = array_merge($conditions, $taxonomy_conditions);
    }

    return array_values( array_filter( array_merge($conditions, [
      [
        'key'    => 'archive:author',
        'label'  => __('Any Author', 'cornerstone'),
         'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'    => 'archive:specific-author',
        'label'  => __('Specific Author', 'cornerstone'),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type' => 'select',
          'choices' => 'user:all'
        ]
      ], [
        'key'    => 'archive:search',
        'label'  => __('Search Results', 'cornerstone'),
        'toggle' => ['type' => 'boolean'],
         'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'    => 'archive:term',
        'label'  => __('Term', 'cornerstone'),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => 'terms:all'
        ]
      ]
    ]) ) );
  }

  public function assignment_and_condition_context_global() {
    return [
      [
        'key'    => 'global:today',
        'label'  => __('Today', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [csi18n('app.conditions.before'), csi18n('app.conditions.after')]
        ],
        'criteria' => ['type' => 'date-picker'],
      ], [
        'key'        => 'global:user-loggedin',
        'label'      => __('Current User (logged in)', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.logged-in') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.logged-in') )
          ]
        ],
        'criteria' => [
          'type' => 'static',
          'label' => __('logged in', 'cornerstone')
        ]

      ], [
        'key'    => 'global:user-role',
        'label'  => __('Current User Role', 'cornerstone'),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => cs_get_wp_roles_options()
        ]
      ]
    ];
  }

  public function condition_context_current_post() {
    $conditions = [
      [
        'key'   => 'current-post:post-type',
        'label' => __('Post Type', 'cornerstone'),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => $this->plugin->component('Locator')->get_post_type_options()
        ]
      ]
    ];

    $conditions[] = [
      'key'    => "current-post:format",
      'label'  => __('Post Format', 'cornerstone'),
      'toggle' => ['type' => 'boolean'],
      'criteria' => [
        'type'    => 'select',
        'choices' => cs_get_post_format_options()
      ]
    ];

    $conditions[] = [
      'key'    => "current-post:status",
      'label'  => __('Post Status', 'cornerstone'),
      'toggle' => ['type' => 'boolean'],
      'criteria' => [
        'type'    => 'select',
        'choices' => cs_get_post_status_options()
      ]
    ];

    $conditions[] = [
      'key'    => "current-post:page-template",
      'label'  => __('Page Template', 'cornerstone'),
      'toggle' => ['type' => 'boolean'],
      'criteria' => [
        'type'    => 'select',
        'choices' => cs_get_page_template_options()
      ]
    ];

    $conditions[] = [
      'key'    => "current-post:featured-image",
      'label'  => __('Featured Image', 'cornerstone'),
        'toggle' => ['type' => 'boolean'],
         'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.set') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.set') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
    ];

    $post_types = apply_filters( 'cs_condition_context_post_types', $this->plugin->component('Locator')->get_post_types() );

    foreach ($post_types as $post_type => $post_type_obj) {

      $conditions[] = [
        'key'    => "current-post:specific-post-of-type|$post_type",
        'label'  => sprintf(__('%s (Specific)', 'cornerstone'), $post_type_obj->labels->singular_name),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => "posts:$post_type"
        ]
      ];
    }

    $conditions[] = [
      'key'    => "current-post:taxonomy",
      'label'  => __('Post (has taxonomy)', 'cornerstone'),
      'toggle' => [
        'type' => 'boolean',
        'labels' => [
          __('has', 'cornerstone'),
          __('has not', 'cornerstone'),
        ]
      ],
      'criteria' => [
        'type'    => 'select',
        'choices' => CS()->component( 'Locator' )->get_taxonomy_options()
      ]
    ];

    $conditions[] = [
      'key'    => "current-post:term",
      'label'  => __('Post (has term)', 'cornerstone'),
      'toggle' => [
        'type' => 'boolean',
        'labels' => [
          __('has', 'cornerstone'),
          __('has not', 'cornerstone'),
        ]
      ],
      'criteria' => [
        'type'    => 'select',
        'choices' => 'terms:all'
      ]
    ];

    $conditions[] = [
      'key'    => "current-post:parent",
      'label'  => __('Parent', 'cornerstone'),
      'toggle' => ['type' => 'boolean'],
      'criteria' => [
        'type'    => 'select',
        'choices' => "posts:all" // "posts:hierarchical"
      ]
    ];

    $conditions[] = [
      'key'    => "current-post:ancestor",
      'label'  => __('Ancestor', 'cornerstone'),
      'toggle' => ['type' => 'boolean'],
      'criteria' => [
        'type'    => 'select',
        'choices' => "posts:all" // "posts:hierarchical"
      ]
    ];




    $conditions[] = [
      'key'    => "current-post:comments-open",
      'label'  => __('Comments', 'cornerstone'),
      'toggle' => ['type' => 'boolean'],
        'toggle' => [
        'type'   => 'boolean',
        'labels' => [
          __( 'Open', 'cornerstone' ),
          __( 'Closed', 'cornerstone' ),
        ]
      ],
      'criteria' => [ 'type' => 'static' ]
    ];

    $conditions[] = [
      'key'    => "current-post:has-next-post",
      'label'  => __('Next Post', 'cornerstone'),
      'toggle' => ['type' => 'boolean'],
        'toggle' => [
        'type'   => 'boolean',
        'labels' => [
          __('has', 'cornerstone'),
          __('has not', 'cornerstone'),
        ]
      ],
      'criteria' => [ 'type' => 'static' ]
    ];

    $conditions[] = [
      'key'    => "current-post:has-prev-post",
      'label'  => __('Previous Post', 'cornerstone'),
      'toggle' => ['type' => 'boolean'],
        'toggle' => [
        'type'   => 'boolean',
        'labels' => [
          __('has', 'cornerstone'),
          __('has not', 'cornerstone'),
        ]
      ],
      'criteria' => [ 'type' => 'static' ]
    ];

    $conditions[] = [
      'key'    => "current-post:publish-date",
      'label'  => __('Publish Date', 'cornerstone'),
      'toggle' => [
        'type'   => 'boolean',
        'labels' => [csi18n('app.conditions.before'), csi18n('app.conditions.after')]
      ],
      'criteria' => ['type' => 'date-picker'],
    ];

    $conditions[] = [
      'key'    => "current-post:modified-date",
      'label'  => __('Last Modified', 'cornerstone'),
      'toggle' => [
        'type'   => 'boolean',
        'labels' => [csi18n('app.conditions.before'), csi18n('app.conditions.after')]
      ],
      'criteria' => ['type' => 'date-picker'],
    ];

    return $conditions;
  }

  public function condition_context_current_query() {

    return [
      [
        'key'    => 'current-query:is-404',
        'label'  => __('404', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'    => 'current-query:is-search',
        'label'  => __('Search', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'    => 'current-query:is-blog',
        'label'  => __('Blog', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'    => 'current-query:is-front-page',
        'label'  => __('Front Page', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'    => 'current-query:is-first-page',
        'label'  => __('First Page', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.being-viewed') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.being-viewed') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'   => 'current-query:date-archive',
        'label' => __('Date Archive', 'cornerstone'),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => [
            ['value' => 'date', 'label' => __('Any', 'cornerstone')],
            ['value' => 'year', 'label' => __('Year', 'cornerstone')],
            ['value' => 'month', 'label' => __('Month', 'cornerstone')],
            ['value' => 'day', 'label' => __('Day', 'cornerstone')],
            ['value' => 'time', 'label' => __('Time', 'cornerstone')],
          ]
        ]
      ],
    ];
  }


  public function condition_context_expression() {

    $string_operators = apply_filters('cs_string_operators', [
      'is'     => __( 'is', 'cornerstone' ),
      'is-not' => __( 'is not', 'cornerstone' ),
      'in'     => __( 'in', 'cornerstone' ),
      'not-in' => __( 'not in', 'cornerstone' )
    ]);

    $numeric_operators = apply_filters('cs_numeric_operators', [
      'eq'     => '==',
      'not-eq' => '!=',
      'gt'     => '>',
      'gte'    => '>=',
      'lt'     => '<',
      'lte'    => '<='
    ]);

    $datetime_operators = apply_filters('cs_datetime_operators', [
      'before' => csi18n('app.conditions.before'),
      'after' => csi18n('app.conditions.after'),
    ]);

    return [
      [
        'key'   => 'expression:string',
        'label' => __('String', 'cornerstone'),
        'type' => 'text',
        'toggle' => [
          'type'   => 'operator',
          'values' => array_keys( $string_operators ),
          'labels' => array_values( $string_operators )
        ],
        'criteria' => [ 'type' => 'text' ]
      ], [
        'key'   => 'expression:number',
        'label' => __('Number', 'cornerstone'),
        'type' => 'text',
        'toggle' => [
          'type'   => 'operator',
          'values' => array_keys( $numeric_operators ),
          'labels' => array_values( $numeric_operators ),
        ],
        'criteria' => [ 'type' => 'text' ]
      ], [
        'key'   => 'expression:datetime',
        'label' => __('Datetime', 'cornerstone'),
        'type' => 'text',
        'toggle' => [
          'type'   => 'operator',
          'values' => array_keys( $datetime_operators ),
          'labels' => array_values( $datetime_operators ),
        ],
        'criteria' => [ 'type' => 'text' ]
      ]

    ];
  }

  public function condition_context_looper() {
    return [
      [
        'key'   => 'looper:index',
        'label' => __('Index', 'cornerstone'),
        'toggle' => ['type' => 'boolean'],
        'criteria' => [
          'type'    => 'select',
          'choices' => [
            ['value' => 'first', 'label'  => __('First', 'cornerstone')],
            ['value' => 'last',  'label'  => __('Last', 'cornerstone')],
            ['value' => 'odd',  'label'   => __('Odd', 'cornerstone')],
            ['value' => 'even', 'label'   => __('Even', 'cornerstone')],
          ]
        ]
      ], [
        'key'   => 'looper:empty',
        'label' => __('Provider Output', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.empty') ),
            sprintf(csi18n('app.conditions.is-not-condition'), csi18n('app.conditions.empty') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ], [
        'key'   => 'looper:consumed-item',
        'label' => __('Consumer Output', 'cornerstone'),
        'toggle' => [
          'type'   => 'boolean',
          'labels' => [
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.initial') ),
            sprintf(csi18n('app.conditions.is-condition'), csi18n('app.conditions.repeated') )
          ]
        ],
        'criteria' => [ 'type' => 'static' ]
      ]

    ];
  }

  public function get_merged_contexts() {

    if ( !isset( $this->merged_contexts ) ) {
      $contexts = $this->get_assignment_contexts();
      $all = [];
      foreach ($contexts['controls'] as $key => $values ) {
        $all = array_merge($all, $values);
      }
      $this->merged_contexts = $all;
    }

    return $this->merged_contexts;

  }

  public function find_assignment_info( $condition ) {
    $all = $this->get_merged_contexts();
    foreach ($all as $item) {
      if ($item['key'] === $condition) {
        return $item;
      }
    }
    return null;
  }

  public function identify_assignment( $assignment ) {

    $found = $this->find_assignment_info( $assignment['condition'] );

    if ($found) {

      // Placeholder for resolving labels of more contextual assignments
      // $assignment['value']

      if ( isset($found['label'])) {
        return $found['label'];
      }
    }

    return __('Assigned', 'cornerstone');

  }

}
