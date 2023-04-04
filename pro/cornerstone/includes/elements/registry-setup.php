<?php

// =============================================================================
// REGISTRY-SETUP.PHP
// -----------------------------------------------------------------------------
// Rembering things 'n' stuff.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Local Variables
//   02. Labels
//   03. Options
//   04. Settings
//   05. Control Group Toggle Values
//   06. UI Column Labels
//   07. Mixins
// =============================================================================

// Local Variables
// =============================================================================

$available_units_font_size = [ 'px', 'em', 'rem', 'vw', 'vh', 'vmin', 'vmax' ];
$ranges_font_size          = [
  'px'   => [ 'min' => 10,  'max' => 36, 'step' => 1    ],
  'em'   => [ 'min' => 0.5, 'max' => 4,  'step' => 0.05 ],
  'rem'  => [ 'min' => 0.5, 'max' => 4,  'step' => 0.05 ],
  'vw'   => [ 'min' => 0,   'max' => 10, 'step' => 0.05 ],
  'vh'   => [ 'min' => 0,   'max' => 10, 'step' => 0.05 ],
  'vmin' => [ 'min' => 0,   'max' => 10, 'step' => 0.05 ],
  'vmax' => [ 'min' => 0,   'max' => 10, 'step' => 0.05 ],
];

$available_units_letter_spacing = [ 'em', 'rem' ];
$ranges_letter_spacing          = [
  'em'  => [ 'min' => -0.125, 'max' => 1, 'step' => 0.005 ],
  'rem' => [ 'min' => -0.125, 'max' => 1, 'step' => 0.005 ],
];

$available_units_gap = [ 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ];
$ranges_gap          = [
  'px'   => [ 'min' => 0, 'max' => 50, 'step' => 1    ],
  'em'   => [ 'min' => 0, 'max' => 3,  'step' => 0.25 ],
  'rem'  => [ 'min' => 0, 'max' => 3,  'step' => 0.25 ],
  'vw'   => [ 'min' => 0, 'max' => 25, 'step' => 1    ],
  'vh'   => [ 'min' => 0, 'max' => 25, 'step' => 1    ],
  'vmin' => [ 'min' => 0, 'max' => 25, 'step' => 1    ],
  'vmax' => [ 'min' => 0, 'max' => 25, 'step' => 1    ],
];

$available_units_size = [ 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ];
$ranges_size          = [
  'px'   => [ 'min' => 0, 'max' => 1000, 'step' => 20 ],
  'em'   => [ 'min' => 0, 'max' => 100,  'step' => 1  ],
  'rem'  => [ 'min' => 0, 'max' => 100,  'step' => 1  ],
  '%'    => [ 'min' => 0, 'max' => 100,  'step' => 1  ],
  'vw'   => [ 'min' => 0, 'max' => 100,  'step' => 1  ],
  'vh'   => [ 'min' => 0, 'max' => 100,  'step' => 1  ],
  'vmin' => [ 'min' => 0, 'max' => 100,  'step' => 1  ],
  'vmax' => [ 'min' => 0, 'max' => 100,  'step' => 1  ],
];

$available_units_graphic_icon = [ 'px', 'em', 'rem' ];
$ranges_graphic_icon          = [
  'px'   => [ 'min' => 8,   'max' => 32, 'step' => 1    ],
  'em'   => [ 'min' => 0.5, 'max' => 2,  'step' => 0.05 ],
  'rem'  => [ 'min' => 0.5, 'max' => 2,  'step' => 0.05 ],
];

$available_units_graphic_image = [ 'px', 'em', 'rem', '%', 'vw', 'vh' ];
$ranges_graphic_image          = [
  'px'  => [ 'min' => 20, 'max' => 64,  'step' => 1    ],
  'em'  => [ 'min' => 1,  'max' => 4,   'step' => 0.05 ],
  'rem' => [ 'min' => 1,  'max' => 4,   'step' => 0.05 ],
  '%'   => [ 'min' => 1,  'max' => 100, 'step' => 1    ],
  'vw'  => [ 'min' => 1,  'max' => 100, 'step' => 1    ],
  'vh'  => [ 'min' => 1,  'max' => 100, 'step' => 1    ],
];

$available_units_inset = [ 'px', 'em', 'rem', '%', 'vw', 'vh', 'vmin', 'vmax' ];
$ranges_inset          = [
  'px'   => [ 'min' => 0, 'max' => 100, 'step' => 1   ],
  'em'   => [ 'min' => 0, 'max' => 5,   'step' => 0.1 ],
  'rem'  => [ 'min' => 0, 'max' => 5,   'step' => 0.1 ],
  '%'    => [ 'min' => 0, 'max' => 100, 'step' => 1   ],
  'vw'   => [ 'min' => 0, 'max' => 100, 'step' => 1   ],
  'vh'   => [ 'min' => 0, 'max' => 100, 'step' => 1   ],
  'vmin' => [ 'min' => 0, 'max' => 100, 'step' => 1   ],
  'vmax' => [ 'min' => 0, 'max' => 100, 'step' => 1   ],
];



// Labels
// =============================================================================

cs_remember( 'label_nbsp',                                            '&nbsp;'                                                                                  );
cs_remember( 'label_1st',                                             __( '1st', 'cornerstone' )                                                                );
cs_remember( 'label_2nd',                                             __( '2nd', 'cornerstone' )                                                                );
cs_remember( 'label_3rd',                                             __( '3rd', 'cornerstone' )                                                                );
cs_remember( 'label_abbr',                                            __( 'Abbr', 'cornerstone' )                                                               );
cs_remember( 'label_above',                                           __( 'Above', 'cornerstone' )                                                              );
cs_remember( 'label_above_and_below',                                 __( 'Above & Below', 'cornerstone' )                                                      );
cs_remember( 'label_above_and_below_text',                            __( 'Above & Below Text', 'cornerstone' )                                                 );
cs_remember( 'label_absolute',                                        __( 'Absolute', 'cornerstone' )                                                           );
cs_remember( 'label_accordion',                                       __( 'Accordion', 'cornerstone' )                                                          );
cs_remember( 'label_accordion_item',                                  __( 'Accordion Item', 'cornerstone' )                                                     );
cs_remember( 'label_accordion_item_1',                                __( 'Accordion Item 1', 'cornerstone' )                                                   );
cs_remember( 'label_accordion_item_2',                                __( 'Accordion Item 2', 'cornerstone' )                                                   );
cs_remember( 'label_active',                                          __( 'Active', 'cornerstone' )                                                             );
cs_remember( 'label_active_links',                                    __( 'Active Links', 'cornerstone' )                                                       );
cs_remember( 'label_adaptive',                                        __( 'Adaptive', 'cornerstone' )                                                           );
cs_remember( 'label_add',                                             __( 'Add', 'cornerstone' )                                                                );
cs_remember( 'label_add_items',                                       __( 'Add Items', 'cornerstone' )                                                          );
cs_remember( 'label_add_to_cart_form',                                __( 'Add to Cart Form', 'cornerstone' )                                                   );
cs_remember( 'label_advanced',                                        __( 'Advanced', 'cornerstone' )                                                           );
cs_remember( 'label_after',                                           __( 'After', 'cornerstone' )                                                              );
cs_remember( 'label_alert',                                           __( 'Alert', 'cornerstone' )                                                              );
cs_remember( 'label_align',                                           __( 'Align', 'cornerstone' )                                                              );
cs_remember( 'label_align_horizontal',                                __( 'Align Horizontal', 'cornerstone' )                                                   );
cs_remember( 'label_align_self',                                      __( 'Align Self', 'cornerstone' )                                                         );
cs_remember( 'label_align_vertical',                                  __( 'Align Vertical', 'cornerstone' )                                                     );
cs_remember( 'label_alignment',                                       __( 'Alignment', 'cornerstone' )                                                          );
cs_remember( 'label_all',                                             __( 'All', 'cornerstone' )                                                                );
cs_remember( 'label_all_content',                                     __( 'All Content', 'cornerstone' )                                                        );
cs_remember( 'label_all_terms',                                       __( 'All Terms', 'cornerstone' )                                                          );
cs_remember( 'label_allow',                                           __( 'Allow', 'cornerstone' )                                                              );
cs_remember( 'label_alt_text',                                        __( 'Alt Text', 'cornerstone' )                                                           );
cs_remember( 'label_always_show',                                     __( 'Always Show', 'cornerstone' )                                                        );
cs_remember( 'label_anchor',                                          __( 'Anchor', 'cornerstone' )                                                             );
cs_remember( 'label_ancestors',                                       __( 'Ancestors', 'cornerstone' )                                                          );
cs_remember( 'label_animation',                                       __( 'Animation', 'cornerstone' )                                                          );
cs_remember( 'label_animation_transition',                            __( 'Animation Transition', 'cornerstone' )                                               );
cs_remember( 'label_any',                                             __( 'Any', 'cornerstone' )                                                                );
cs_remember( 'label_api_key',                                         __( 'API Key', 'cornerstone' )                                                            );
cs_remember( 'label_aria_content',                                    __( 'ARIA Content', 'cornerstone' )                                                       );
cs_remember( 'label_aria_hidden',                                     __( 'ARIA Hidden', 'cornerstone' )                                                        );
cs_remember( 'label_array',                                           __( 'Array', 'cornerstone' )                                                              );
cs_remember( 'label_asc',                                             __( 'Asc', 'cornerstone' )                                                                );
cs_remember( 'label_ascending',                                       __( 'Ascending', 'cornerstone' )                                                          );
cs_remember( 'label_aspect_ratio',                                    __( 'Aspect Ratio', 'cornerstone' )                                                       );
cs_remember( 'label_at_edges',                                        __( 'At Edges', 'cornerstone' )                                                           );
cs_remember( 'label_audio',                                           __( 'Audio', 'cornerstone' )                                                              );
cs_remember( 'label_author',                                          __( 'Author', 'cornerstone' )                                                             );
cs_remember( 'label_author_name',                                     __( 'Author<br/>Name', 'cornerstone' )                                                    );
cs_remember( 'label_author_review',                                   __( 'Author<br/>Review', 'cornerstone' )                                                  );
cs_remember( 'label_authors',                                         __( 'Authors', 'cornerstone' )                                                            );
cs_remember( 'label_auto',                                            __( 'Auto', 'cornerstone' )                                                               );
cs_remember( 'label_autoplay',                                        __( 'Autoplay', 'cornerstone' )                                                           );
cs_remember( 'label_avoid',                                           __( 'Avoid', 'cornerstone' )                                                              );
cs_remember( 'label_back',                                            __( 'Back', 'cornerstone' )                                                               );
cs_remember( 'label_back_background_layers',                          __( 'Back Background Layers', 'cornerstone' )                                             );
cs_remember( 'label_backface',                                        __( 'Backface', 'cornerstone' )                                                           );
cs_remember( 'label_back_button',                                     __( 'Back Button', 'cornerstone' )                                                        );
cs_remember( 'label_back_content',                                    __( 'Back Content', 'cornerstone' )                                                       );
cs_remember( 'label_back_delay',                                      __( 'Back Delay', 'cornerstone' )                                                         );
cs_remember( 'label_back_icon',                                       __( 'Back Icon', 'cornerstone' )                                                          );
cs_remember( 'label_back_label',                                      __( 'Back Label', 'cornerstone' )                                                         );
cs_remember( 'label_back_setup',                                      __( 'Back Setup', 'cornerstone' )                                                         );
cs_remember( 'label_back_text',                                       __( 'Back Text', 'cornerstone' )                                                          );
cs_remember( 'label_back_speed',                                      __( 'Back Speed', 'cornerstone' )                                                         );
cs_remember( 'label_backdrop',                                        __( 'Backdrop', 'cornerstone' )                                                           );
cs_remember( 'label_backdrop_and_close',                              __( 'Backdrop & Close', 'cornerstone' )                                                   );
cs_remember( 'label_backdrop_filter',                                 __( 'Backdrop Filter', 'cornerstone' )                                                    );
cs_remember( 'label_background',                                      __( 'Background', 'cornerstone' )                                                         );
cs_remember( 'label_background_image',                                __( 'Background Image', 'cornerstone' )                                                   );
cs_remember( 'label_background_layers',                               __( 'Background Layers', 'cornerstone' )                                                  );
cs_remember( 'label_bar',                                             __( 'Bar', 'cornerstone' )                                                                );
cs_remember( 'label_base',                                            __( 'Base', 'cornerstone' )                                                               );
cs_remember( 'label_base_font_size',                                  __( 'Base Font Size', 'cornerstone' )                                                     );
cs_remember( 'label_baseline',                                        __( 'Baseline', 'cornerstone' )                                                           );
cs_remember( 'label_before',                                          __( 'Before', 'cornerstone' )                                                             );
cs_remember( 'label_behavior',                                        __( 'Behavior', 'cornerstone' )                                                           );
cs_remember( 'label_behavior_with_prefix',                            __( '{{prefix}} Behavior', 'cornerstone' )                                                );
cs_remember( 'label_below',                                           __( 'Below', 'cornerstone' )                                                              );
cs_remember( 'label_block',                                           __( 'Block', 'cornerstone' )                                                              );
cs_remember( 'label_body_scroll',                                     __( 'Body Scroll', 'cornerstone' )                                                        );
cs_remember( 'label_border',                                          __( 'Border', 'cornerstone' )                                                             );
cs_remember( 'label_border_with_prefix',                              __( '{{prefix}} Border', 'cornerstone' )                                                  );
cs_remember( 'label_border_radius',                                   __( 'Border Radius', 'cornerstone' )                                                      );
cs_remember( 'label_border_radius_with_prefix',                       __( '{{prefix}} Border Radius', 'cornerstone' )                                           );
cs_remember( 'label_both',                                            __( 'Both', 'cornerstone' )                                                               );
cs_remember( 'label_bottom',                                          __( 'Bottom', 'cornerstone' )                                                             );
cs_remember( 'label_bottom_left',                                     __( 'Bottom Left', 'cornerstone' )                                                        );
cs_remember( 'label_bottom_offset',                                   __( 'Bottom Offset', 'cornerstone' )                                                      );
cs_remember( 'label_bottom_right',                                    __( 'Bottom Right', 'cornerstone' )                                                       );
cs_remember( 'label_box_shadow',                                      __( 'Box Shadow', 'cornerstone' )                                                         );
cs_remember( 'label_box_shadow_with_prefix',                          __( '{{prefix}} Box Shadow', 'cornerstone' )                                              );
cs_remember( 'label_breadcrumbs',                                     __( 'Breadcrumbs', 'cornerstone' )                                                        );
cs_remember( 'label_breakpoint_to_hide_numbers',                      __( 'Breakpoint to Hide #', 'cornerstone' )                                               );
cs_remember( 'label_brief',                                           __( 'Brief', 'cornerstone' )                                                              );
cs_remember( 'label_bttm',                                            __( 'Bttm', 'cornerstone' )                                                               );
cs_remember( 'label_burger',                                          __( 'Burger', 'cornerstone' )                                                             );
cs_remember( 'label_button',                                          __( 'Button', 'cornerstone' )                                                             );
cs_remember( 'label_button_navigation',                               __( 'Button Navigation', 'cornerstone' )                                                  );
cs_remember( 'label_buttons',                                         __( 'Buttons', 'cornerstone' )                                                            );
cs_remember( 'label_buttons_container',                               __( 'Buttons Container', 'cornerstone' )                                                  );
cs_remember( 'label_buttons_placement',                               __( 'Buttons Placement', 'cornerstone' )                                                  );
cs_remember( 'label_cancel_reply',                                    __( 'Cancel Reply', 'cornerstone' )                                                       );
cs_remember( 'label_cancel_reply_link',                               __( 'Cancel Reply Link', 'cornerstone' )                                                  );
cs_remember( 'label_card',                                            __( 'Card', 'cornerstone' )                                                               );
cs_remember( 'label_carousel',                                        __( 'Carousel', 'cornerstone' )                                                           );
cs_remember( 'label_cart',                                            __( 'Cart', 'cornerstone' )                                                               );
cs_remember( 'label_cell',                                            __( 'Cell', 'cornerstone' )                                                               );
cs_remember( 'label_cells',                                           __( 'Cells', 'cornerstone' )                                                              );
cs_remember( 'label_center',                                          __( 'Center', 'cornerstone' )                                                             );
cs_remember( 'label_character_speed',                                 __( 'Character Speed', 'cornerstone' )                                                    );
cs_remember( 'label_children',                                        __( 'Children', 'cornerstone' )                                                           );
cs_remember( 'label_cite',                                            __( 'Cite', 'cornerstone' )                                                               );
cs_remember( 'label_citation',                                        __( 'Citation', 'cornerstone' )                                                           );
cs_remember( 'label_class',                                           __( 'Class', 'cornerstone' )                                                              );
cs_remember( 'label_clear',                                           __( 'Clear', 'cornerstone' )                                                              );
cs_remember( 'label_clear_placement',                                 __( 'Clear Placement', 'cornerstone' )                                                    );
cs_remember( 'label_click',                                           __( 'Click', 'cornerstone' )                                                              );
cs_remember( 'label_close',                                           __( 'Close', 'cornerstone' )                                                              );
cs_remember( 'label_closed',                                          __( 'Closed', 'cornerstone' )                                                             );
cs_remember( 'label_close_dimensions',                                __( 'Close<br/>Dimensions', 'cornerstone' )                                               );
cs_remember( 'label_close_offset',                                    __( 'Close<br/>Offset', 'cornerstone' )                                                   );
cs_remember( 'label_close_size',                                      __( 'Close<br/>Size', 'cornerstone' )                                                     );
cs_remember( 'label_closing',                                         __( 'Closing', 'cornerstone' )                                                            );
cs_remember( 'label_closing_mark_align',                              __( 'Closing Mark Align', 'cornerstone' )                                                 );
cs_remember( 'label_code',                                            __( 'Code', 'cornerstone' )                                                               );
cs_remember( 'label_color',                                           __( 'Color', 'cornerstone' )                                                              );
cs_remember( 'label_color_burn',                                      __( 'Color Burn', 'cornerstone' )                                                         );
cs_remember( 'label_color_dodge',                                     __( 'Color Dodge', 'cornerstone' )                                                        );
cs_remember( 'label_colors',                                          __( 'Colors', 'cornerstone' )                                                             );
cs_remember( 'label_column',                                          __( 'Column', 'cornerstone' )                                                             );
cs_remember( 'label_column_fill',                                     __( 'Column Fill', 'cornerstone' )                                                        );
cs_remember( 'label_columns',                                         __( 'Columns', 'cornerstone' )                                                            );
cs_remember( 'label_columns_with_prefix',                             __( '{{prefix}} Columns', 'cornerstone' )                                                 );
cs_remember( 'label_comment_form',                                    __( 'Comment Form', 'cornerstone' )                                                       );
cs_remember( 'label_comment_list',                                    __( 'Comment List', 'cornerstone' )                                                       );
cs_remember( 'label_comment_pagination',                              __( 'Comment Pagination', 'cornerstone' )                                                 );
cs_remember( 'label_comments',                                        __( 'Comments', 'cornerstone' )                                                           );
cs_remember( 'label_comments_closed',                                 __( 'Comments Closed', 'cornerstone' )                                                    );
cs_remember( 'label_compact',                                         __( 'Compact', 'cornerstone' )                                                            );
cs_remember( 'label_complete',                                        __( 'Complete', 'cornerstone' )                                                           );
cs_remember( 'label_complete_message',                                __( 'Complete Message', 'cornerstone' )                                                   );
cs_remember( 'label_condition',                                       __( 'Condition', 'cornerstone' )                                                          );
cs_remember( 'label_conditions',                                      __( 'Conditions', 'cornerstone' )                                                         );
cs_remember( 'label_config',                                          __( 'Config', 'cornerstone' )                                                             );
cs_remember( 'label_configuration',                                   __( 'Configuration', 'cornerstone' )                                                      );
cs_remember( 'label_contain',                                         __( 'Contain', 'cornerstone' )                                                            );
cs_remember( 'label_container',                                       __( 'Container', 'cornerstone' )                                                          );
cs_remember( 'label_containers',                                      __( 'Containers', 'cornerstone' )                                                         );
cs_remember( 'label_content',                                         __( 'Content', 'cornerstone' )                                                            );
cs_remember( 'label_content_alignment',                               __( 'Content Alignment', 'cornerstone' )                                                  );
cs_remember( 'label_content_area',                                    __( 'Content Area', 'cornerstone' )                                                       );
cs_remember( 'label_content_break',                                   __( 'Content Break', 'cornerstone' )                                                      );
cs_remember( 'label_content_end',                                     __( 'Content End', 'cornerstone' )                                                        );
cs_remember( 'label_content_height',                                  __( 'Content Height', 'cornerstone' )                                                     );
cs_remember( 'label_content_length',                                  __( 'Content Length', 'cornerstone' )                                                     );
cs_remember( 'label_content_max_length',                              __( 'Content Max Length', 'cornerstone' )                                                 );
cs_remember( 'label_content_scrolling',                               __( 'Content Scrolling', 'cornerstone' )                                                  );
cs_remember( 'label_content_setup',                                   __( 'Content Setup', 'cornerstone' )                                                      );
cs_remember( 'label_content_spacing',                                 __( 'Content Spacing', 'cornerstone' )                                                    );
cs_remember( 'label_content_sizing',                                  __( 'Content Sizing', 'cornerstone' )                                                     );
cs_remember( 'label_content_with_prefix',                             __( '{{prefix}} Content', 'cornerstone' )                                                 );
cs_remember( 'label_content_with_sprintf_prefix',                     __( '%s Content', 'cornerstone' )                                                         );
cs_remember( 'label_content_x',                                       __( 'Content X', 'cornerstone' )                                                          );
cs_remember( 'label_content_y',                                       __( 'Content Y', 'cornerstone' )                                                          );
cs_remember( 'label_controls',                                        __( 'Controls', 'cornerstone' )                                                           );
cs_remember( 'label_controls_setup_with_prefix',                      __( '{{prefix}} Controls Setup', 'cornerstone' )                                          );
cs_remember( 'label_controls_colors_with_prefix',                     __( '{{prefix}} Controls Colors', 'cornerstone' )                                         );
cs_remember( 'label_cover',                                           __( 'Cover', 'cornerstone' )                                                              );
cs_remember( 'label_creative_cta',                                    __( 'Creative CTA', 'cornerstone' )                                                       );
cs_remember( 'label_crossfade',                                       __( 'Crossfade', 'cornerstone' )                                                          );
cs_remember( 'label_cross_sells',                                     __( 'Cross Sells', 'cornerstone' )                                                        );
cs_remember( 'label_current',                                         __( 'Current', 'cornerstone' )                                                            );
cs_remember( 'label_current_post_terms',                              __( 'Current Post Terms', 'cornerstone' )                                                 );
cs_remember( 'label_current_page_children',                           __( 'Current Page Children', 'cornerstone' )                                              );
cs_remember( 'label_cursor',                                          __( 'Cursor', 'cornerstone' )                                                             );
cs_remember( 'label_cursor_color',                                    __( 'Cursor Color', 'cornerstone' )                                                       );
cs_remember( 'label_count',                                           __( 'Count', 'cornerstone' )                                                              );
cs_remember( 'label_countdown',                                       __( 'Countdown', 'cornerstone' )                                                          );
cs_remember( 'label_countdown_end',                                   __( 'Countdown End', 'cornerstone' )                                                      );
cs_remember( 'label_counter',                                         __( 'Counter', 'cornerstone' )                                                            );
cs_remember( 'label_custom',                                          __( 'Custom', 'cornerstone' )                                                             );
cs_remember( 'label_custom_attributes',                               __( 'Custom Attributes', 'cornerstone' )                                                  );
cs_remember( 'label_custom_attributes_with_prefix',                   __( '{{prefix}} Custom Attributes', 'cornerstone' )                                       );
cs_remember( 'label_custom_colors',                                   __( 'Custom Colors', 'cornerstone' )                                                      );
cs_remember( 'label_custom_image',                                    __( 'Custom Image', 'cornerstone' )                                                       );
cs_remember( 'label_custom_text',                                     __( 'Custom Text', 'cornerstone' )                                                        );
cs_remember( 'label_customize',                                       __( 'Customize', 'cornerstone' )                                                          );
cs_remember( 'label_d',                                               __( 'D', 'cornerstone' )                                                                  );
cs_remember( 'label_darken',                                          __( 'Darken', 'cornerstone' )                                                             );
cs_remember( 'label_dashed',                                          __( 'Dashed', 'cornerstone' )                                                             );
cs_remember( 'label_date',                                            __( 'Date', 'cornerstone' )                                                               );
cs_remember( 'label_day',                                             __( 'Day', 'cornerstone' )                                                                );
cs_remember( 'label_decoration',                                      __( 'Decoration', 'cornerstone' )                                                         );
cs_remember( 'label_default',                                         __( 'Default', 'cornerstone' )                                                            );
cs_remember( 'label_delay',                                           __( 'Delay', 'cornerstone' )                                                              );
cs_remember( 'label_delimiter',                                       __( 'Delimiter', 'cornerstone' )                                                          );
cs_remember( 'label_desc',                                            __( 'Desc', 'cornerstone' )                                                               );
cs_remember( 'label_descending',                                      __( 'Descending', 'cornerstone' )                                                         );
cs_remember( 'label_describe_your_image',                             __( 'Describe Your Image', 'cornerstone' )                                                );
cs_remember( 'label_design',                                          __( 'Design', 'cornerstone' )                                                             );
cs_remember( 'label_difference',                                      __( 'Difference', 'cornerstone' )                                                         );
cs_remember( 'label_digit',                                           __( 'Digit', 'cornerstone' )                                                              );
cs_remember( 'label_dimensions',                                      __( 'Dimensions', 'cornerstone' )                                                         );
cs_remember( 'label_direction',                                       __( 'Direction', 'cornerstone' )                                                          );
cs_remember( 'label_disable',                                         __( 'Disable', 'cornerstone' )                                                            );
cs_remember( 'label_disable_preview',                                 __( 'Disable Preview', 'cornerstone' )                                                    );
cs_remember( 'label_display',                                         __( 'Display', 'cornerstone' )                                                            );
cs_remember( 'label_div',                                             __( 'Div', 'cornerstone' )                                                                );
cs_remember( 'label_dots',                                            __( 'Dots', 'cornerstone' )                                                               );
cs_remember( 'label_dotted',                                          __( 'Dotted', 'cornerstone' )                                                             );
cs_remember( 'label_double',                                          __( 'Double', 'cornerstone' )                                                             );
cs_remember( 'label_down',                                            __( 'Down', 'cornerstone' )                                                               );
cs_remember( 'label_drag',                                            __( 'Drag', 'cornerstone' )                                                               );
cs_remember( 'label_draggable',                                       __( 'Draggable', 'cornerstone' )                                                          );
cs_remember( 'label_dropdown',                                        __( 'Dropdown', 'cornerstone' )                                                           );
cs_remember( 'label_dropdown_custom_attributes',                      __( 'Dropdown Custom Attributes', 'cornerstone' )                                         );
cs_remember( 'label_duration',                                        __( 'Duration', 'cornerstone' )                                                           );
cs_remember( 'label_dynamic_content',                                 __( 'Dynamic Content', 'cornerstone' )                                                    );
cs_remember( 'label_dynamic_rendering',                               __( 'Dynamic Rendering', 'cornerstone' )                                                  );
cs_remember( 'label_edit',                                            __( 'Edit', 'cornerstone' )                                                               );
cs_remember( 'label_effect',                                          __( 'Effect', 'cornerstone' )                                                             );
cs_remember( 'label_effects',                                         __( 'Effects', 'cornerstone' )                                                            );
cs_remember( 'label_element',                                         __( 'Element', 'cornerstone' )                                                            );
cs_remember( 'label_element_css',                                     __( 'Element CSS', 'cornerstone' )                                                        );
cs_remember( 'label_elements',                                        __( 'Elements', 'cornerstone' )                                                           );
cs_remember( 'label_ellipsis',                                        __( 'Ellipsis', 'cornerstone' )                                                           );
cs_remember( 'label_embed',                                           __( 'Embed', 'cornerstone' )                                                              );
cs_remember( 'label_empty',                                           __( 'Empty', 'cornerstone' )                                                              );
cs_remember( 'label_empty_icons',                                     __( 'Empty Icons', 'cornerstone' )                                                        );
cs_remember( 'label_empty_terms',                                     __( 'Empty Terms', 'cornerstone' )                                                        );
cs_remember( 'label_enable',                                          __( 'Enable', 'cornerstone' )                                                             );
cs_remember( 'label_enable_close_button',                             __( 'Enable Close Button', 'cornerstone' )                                                );
cs_remember( 'label_enable_multi_column_layout',                      __( 'Enable Multi-Column Layout', 'cornerstone' )                                         );
cs_remember( 'label_enable_secondary',                                __( 'Enable Secondary', 'cornerstone' )                                                   );
cs_remember( 'label_end',                                             __( 'End', 'cornerstone' )                                                                );
cs_remember( 'label_end_and_mid_number_count',                        __( 'End & Mid<br/># Count', 'cornerstone' )                                              );
cs_remember( 'label_end_date',                                        __( 'End Date', 'cornerstone' )                                                           );
cs_remember( 'label_end_number_count',                                __( 'End # Count', 'cornerstone' )                                                        );
cs_remember( 'label_end_rotation',                                    __( 'End Rotation', 'cornerstone' )                                                       );
cs_remember( 'label_ending_delay',                                    __( 'Ending Delay', 'cornerstone' )                                                       );
cs_remember( 'label_enter',                                           __( 'Enter', 'cornerstone' )                                                              );
cs_remember( 'label_entrance',                                        __( 'Entrance', 'cornerstone' )                                                           );
cs_remember( 'label_equal_height',                                    __( 'Equal Height', 'cornerstone' )                                                       );
cs_remember( 'label_exclude',                                         __( 'Exclude', 'cornerstone' )                                                            );
cs_remember( 'label_exclusion',                                       __( 'Exclusion', 'cornerstone' )                                                          );
cs_remember( 'label_exit',                                            __( 'Exit', 'cornerstone' )                                                               );
cs_remember( 'label_exit_pointer_events',                             __( 'Exit Pointer Events', 'cornerstone' )                                                );
cs_remember( 'label_fade',                                            __( 'Fade', 'cornerstone' )                                                               );
cs_remember( 'label_family',                                          __( 'Family', 'cornerstone' )                                                             );
cs_remember( 'label_field',                                           __( 'Field', 'cornerstone' )                                                              );
cs_remember( 'label_fill',                                            __( 'Fill', 'cornerstone' )                                                               );
cs_remember( 'label_fill_space',                                      __( 'Fill Space', 'cornerstone' )                                                         );
cs_remember( 'label_filter',                                          __( 'Filter', 'cornerstone' )                                                             );
cs_remember( 'label_first_dropdown',                                  __( 'First Dropdown', 'cornerstone' )                                                     );
cs_remember( 'label_fixed',                                           __( 'Fixed', 'cornerstone' )                                                              );
cs_remember( 'label_fixed_height',                                    __( 'Fixed Height', 'cornerstone' )                                                       );
cs_remember( 'label_flex',                                            __( 'Flex', 'cornerstone' )                                                               );
cs_remember( 'label_flexbox',                                         __( 'Flexbox', 'cornerstone' )                                                            );
cs_remember( 'label_flexbox_with_prefix',                             __( '{{prefix}} Flexbox', 'cornerstone' )                                                 );
cs_remember( 'label_flex_end',                                        __( 'Flex End', 'cornerstone' )                                                           );
cs_remember( 'label_flex_start',                                      __( 'Flex Start', 'cornerstone' )                                                         );
cs_remember( 'label_flex_with_prefix',                                __( '{{prefix}} Flex', 'cornerstone' )                                                    );
cs_remember( 'label_flip_direction',                                  __( 'Flip Direction', 'cornerstone' )                                                     );
cs_remember( 'label_flip_x',                                          __( 'Flip X', 'cornerstone' )                                                             );
cs_remember( 'label_flip_y',                                          __( 'Flip Y', 'cornerstone' )                                                             );
cs_remember( 'label_font',                                            __( 'Font', 'cornerstone' )                                                               );
cs_remember( 'label_font_family',                                     __( 'Font Family', 'cornerstone' )                                                        );
cs_remember( 'label_font_size',                                       __( 'Font Size', 'cornerstone' )                                                          );
cs_remember( 'label_font_style',                                      __( 'Font Style', 'cornerstone' )                                                         );
cs_remember( 'label_font_weight',                                     __( 'Font Weight', 'cornerstone' )                                                        );
cs_remember( 'label_footer',                                          __( 'Footer', 'cornerstone' )                                                             );
cs_remember( 'label_footers',                                         __( 'Footers', 'cornerstone' )                                                            );
cs_remember( 'label_format',                                          __( 'Format', 'cornerstone' )                                                             );
cs_remember( 'label_formation',                                       __( 'Formation', 'cornerstone' )                                                          );
cs_remember( 'label_forward_button',                                  __( 'Forward Button', 'cornerstone' )                                                     );
cs_remember( 'label_forward_icon',                                    __( 'Forward Icon', 'cornerstone' )                                                       );
cs_remember( 'label_frame',                                           __( 'Frame', 'cornerstone' )                                                              );
cs_remember( 'label_free',                                            __( 'Free', 'cornerstone' )                                                               );
cs_remember( 'label_free_scroll',                                     __( 'Free Scroll', 'cornerstone' )                                                        );
cs_remember( 'label_front',                                           __( 'Front', 'cornerstone' )                                                              );
cs_remember( 'label_front_background_layers',                         __( 'Front Background Layers', 'cornerstone' )                                            );
cs_remember( 'label_front_content',                                   __( 'Front Content', 'cornerstone' )                                                      );
cs_remember( 'label_front_text',                                      __( 'Front Text', 'cornerstone' )                                                         );
cs_remember( 'label_front_setup',                                     __( 'Front Setup', 'cornerstone' )                                                        );
cs_remember( 'label_full',                                            __( 'Full', 'cornerstone' )                                                               );
cs_remember( 'label_fwd',                                             __( 'Fwd', 'cornerstone' )                                                                );
cs_remember( 'label_fwd_delay',                                       __( 'Fwd Delay', 'cornerstone' )                                                          );
cs_remember( 'label_fwd_speed',                                       __( 'Fwd Speed', 'cornerstone' )                                                          );
cs_remember( 'label_gap',                                             __( 'Gap', 'cornerstone' )                                                                );
cs_remember( 'label_gap_height',                                      __( 'Gap Height', 'cornerstone' )                                                         );
cs_remember( 'label_gap_size',                                        __( 'Gap Size', 'cornerstone' )                                                           );
cs_remember( 'label_gap_width',                                       __( 'Gap Width', 'cornerstone' )                                                          );
cs_remember( 'label_get_started',                                     __( 'Get Started', 'cornerstone' )                                                        );
cs_remember( 'label_global_block',                                    __( 'Global Block', 'cornerstone' )                                                       );
cs_remember( 'label_global_container',                                __( 'Global Container', 'cornerstone' )                                                   );
cs_remember( 'label_google',                                          __( 'Google', 'cornerstone' )                                                             );
cs_remember( 'label_google_map_styles',                               __( 'Google Map Styles', 'cornerstone' )                                                  );
cs_remember( 'label_graphic',                                         __( 'Graphic', 'cornerstone' )                                                            );
cs_remember( 'label_graphic_with_prefix',                             __( '{{prefix}} Graphic', 'cornerstone' )                                                 );
cs_remember( 'label_graphic_with_sprintf_prefix',                     __( '%s Graphic', 'cornerstone' )                                                         );
cs_remember( 'label_graphic_icon_colors_with_prefix',                 __( '{{prefix}} Graphic Icon Colors', 'cornerstone' )                                     );
cs_remember( 'label_graphic_icon_with_prefix',                        __( '{{prefix}} Graphic Icon', 'cornerstone' )                                            );
cs_remember( 'label_graphic_icon_with_sprintf_prefix',                __( '%s Graphic Icon', 'cornerstone' )                                                    );
cs_remember( 'label_graphic_image_with_prefix',                       __( '{{prefix}} Graphic Image', 'cornerstone' )                                           );
cs_remember( 'label_graphic_image_with_sprintf_prefix',               __( '%s Graphic Image', 'cornerstone' )                                                   );
cs_remember( 'label_grid',                                            __( 'Grid', 'cornerstone' )                                                               );
cs_remember( 'label_groove',                                          __( 'Groove', 'cornerstone' )                                                             );
cs_remember( 'label_group',                                           __( 'Group', 'cornerstone' )                                                              );
cs_remember( 'label_group_name',                                      __( 'Group Name', 'cornerstone' )                                                         );
cs_remember( 'label_groups',                                          __( 'Groups', 'cornerstone' )                                                             );
cs_remember( 'label_grouped',                                         __( 'Grouped', 'cornerstone' )                                                            );
cs_remember( 'label_grow',                                            __( 'Grow', 'cornerstone' )                                                               );
cs_remember( 'label_grow_and_shrink',                                 __( 'Grow & Shrink', 'cornerstone' )                                                      );
cs_remember( 'label_grow_out',                                        __( 'Grow Out', 'cornerstone' )                                                           );
cs_remember( 'label_gutters',                                         __( 'Gutters', 'cornerstone' )                                                            );
cs_remember( 'label_h',                                               __( 'H', 'cornerstone' )                                                                  );
cs_remember( 'label_hard_light',                                      __( 'Hard Light', 'cornerstone' )                                                         );
cs_remember( 'label_half_full',                                       __( 'Half Full', 'cornerstone' )                                                          );
cs_remember( 'label_header',                                          __( 'Header', 'cornerstone' )                                                             );
cs_remember( 'label_header_setup',                                    __( 'Header Setup', 'cornerstone' )                                                       );
cs_remember( 'label_headers',                                         __( 'Headers', 'cornerstone' )                                                            );
cs_remember( 'label_headline',                                        __( 'Headline', 'cornerstone' )                                                           );
cs_remember( 'label_headline_spacing',                                __( 'Headline Spacing', 'cornerstone' )                                                   );
cs_remember( 'label_height',                                          __( 'Height', 'cornerstone' )                                                             );
cs_remember( 'label_hide',                                            __( 'Hide', 'cornerstone' )                                                               );
cs_remember( 'label_hide_during_breakpoints',                         __( 'Hide During Breakpoints', 'cornerstone' )                                            );
cs_remember( 'label_hide_empty',                                      __( 'Hide Empty', 'cornerstone' )                                                         );
cs_remember( 'label_hide_initially',                                  __( 'Hide Initially', 'cornerstone' )                                                     );
cs_remember( 'label_hide_on_end',                                     __( 'Hide on End', 'cornerstone' )                                                        );
cs_remember( 'label_hidden',                                          __( 'Hidden', 'cornerstone' )                                                             );
cs_remember( 'label_home',                                            __( 'Home', 'cornerstone' )                                                               );
cs_remember( 'label_home_label',                                      __( 'Home Label', 'cornerstone' )                                                         );
cs_remember( 'label_home_link',                                       __( 'Home Link', 'cornerstone' )                                                          );
cs_remember( 'label_hook',                                            __( 'Hook', 'cornerstone' )                                                               );
cs_remember( 'label_horizontal',                                      __( 'Horizontal', 'cornerstone' )                                                         );
cs_remember( 'label_hour',                                            __( 'Hour', 'cornerstone' )                                                               );
cs_remember( 'label_hover',                                           __( 'Hover', 'cornerstone' )                                                              );
cs_remember( 'label_html_tag',                                        __( 'HTML Tag', 'cornerstone' )                                                           );
cs_remember( 'label_hue',                                             __( 'Hue', 'cornerstone' )                                                                );
cs_remember( 'label_icon',                                            __( 'Icon', 'cornerstone' )                                                               );
cs_remember( 'label_icons',                                           __( 'Icons', 'cornerstone' )                                                              );
cs_remember( 'label_id',                                              __( 'ID', 'cornerstone' )                                                                 );
cs_remember( 'label_ignore',                                          __( 'Ignore', 'cornerstone' )                                                             );
cs_remember( 'label_image_with_prefix',                               __( '{{prefix}} Image', 'cornerstone' )                                                   );
cs_remember( 'label_image',                                           __( 'Image', 'cornerstone' )                                                              );
cs_remember( 'label_image_offset',                                    __( 'Image Offset', 'cornerstone' )                                                       );
cs_remember( 'label_images',                                          __( 'Images', 'cornerstone' )                                                             );
cs_remember( 'label_img_element',                                     __( '<img/> Element', 'cornerstone' )                                                     );
cs_remember( 'label_in',                                              __( 'In', 'cornerstone' )                                                                 );
cs_remember( 'label_in_out',                                          __( 'In-Out', 'cornerstone' )                                                             );
cs_remember( 'label_include',                                         __( 'Include', 'cornerstone' )                                                            );
cs_remember( 'label_include_sticky_posts',                            __( 'Include sticky posts', 'cornerstone' )                                               );
cs_remember( 'label_indicator',                                       __( 'Indicator', 'cornerstone' )                                                          );
cs_remember( 'label_indicators',                                      __( 'Indicators', 'cornerstone' )                                                         );
cs_remember( 'label_individual_tabs',                                 __( 'Individual Tabs', 'cornerstone' )                                                    );
cs_remember( 'label_inherit',                                         __( 'Inherit', 'cornerstone' )                                                            );
cs_remember( 'label_initial',                                         __( 'Initial', 'cornerstone' )                                                            );
cs_remember( 'label_inline',                                          __( 'Inline', 'cornerstone' )                                                             );
cs_remember( 'label_inline_block',                                    __( 'Inline Block', 'cornerstone' )                                                       );
cs_remember( 'label_inline_css',                                      __( 'Inline CSS', 'cornerstone' )                                                         );
cs_remember( 'label_inner',                                           __( 'Inner', 'cornerstone' )                                                              );
cs_remember( 'label_input',                                           __( 'Input', 'cornerstone' )                                                              );
cs_remember( 'label_input_placement',                                 __( 'Input Placement', 'cornerstone' )                                                    );
cs_remember( 'label_inset',                                           __( 'Inset', 'cornerstone' )                                                              );
cs_remember( 'label_inside',                                          __( 'Inside', 'cornerstone' )                                                             );
cs_remember( 'label_interaction',                                     __( 'Interaction', 'cornerstone' )                                                        );
cs_remember( 'label_int_content',                                     __( 'Int. Content', 'cornerstone' )                                                       );
cs_remember( 'label_interactive_content',                             __( 'Interactive Content', 'cornerstone' )                                                );
cs_remember( 'label_interactive_content_with_prefix',                 __( '{{prefix}} Interactive Content', 'cornerstone' )                                     );
cs_remember( 'label_interactive_primary_graphic_image_with_prefix',   __( '{{prefix}} Interactive Primary Graphic Image', 'cornerstone' )                       );
cs_remember( 'label_interactive_secondary_graphic_image_with_prefix', __( '{{prefix}} Interactive Secondary Graphic Image', 'cornerstone' )                     );
cs_remember( 'label_interval',                                        __( 'Interval', 'cornerstone' )                                                           );
cs_remember( 'label_item',                                            __( 'Item', 'cornerstone' )                                                               );
cs_remember( 'label_items',                                           __( 'Items', 'cornerstone' )                                                              );
cs_remember( 'label_item_address',                                    __( 'Item<br/>Address', 'cornerstone' )                                                   );
cs_remember( 'label_item_image',                                      __( 'Item<br/>Image', 'cornerstone' )                                                     );
cs_remember( 'label_item_name',                                       __( 'Item<br/>Name', 'cornerstone' )                                                      );
cs_remember( 'label_item_telephone',                                  __( 'Item<br/>Telephone', 'cornerstone' )                                                 );
cs_remember( 'label_items',                                           __( 'Items', 'cornerstone' )                                                              );
cs_remember( 'label_items_alignment',                                 __( 'Items Alignment', 'cornerstone' )                                                    );
cs_remember( 'label_items_placement',                                 __( 'Items Placement', 'cornerstone' )                                                    );
cs_remember( 'label_items_setup',                                     __( 'Items Setup', 'cornerstone' )                                                        );
cs_remember( 'label_items_size',                                      __( 'Items Size', 'cornerstone' )                                                         );
cs_remember( 'label_items_x',                                         __( 'Items X', 'cornerstone' )                                                            );
cs_remember( 'label_items_y',                                         __( 'Items Y', 'cornerstone' )                                                            );
cs_remember( 'label_json',                                            'JSON'                                                                                    );
cs_remember( 'label_justify',                                         __( 'Justify', 'cornerstone' )                                                            );
cs_remember( 'label_keep_margin',                                     __( 'Keep Margin', 'cornerstone' )                                                        );
cs_remember( 'label_key',                                             __( 'Key', 'cornerstone' )                                                                );
cs_remember( 'label_label',                                           __( 'Label', 'cornerstone' )                                                              );
cs_remember( 'label_label_placement',                                 __( 'Label Placement', 'cornerstone' )                                                    );
cs_remember( 'label_label_spacing',                                   __( 'Label Spacing', 'cornerstone' )                                                      );
cs_remember( 'label_labels',                                          __( 'Labels', 'cornerstone' )                                                             );
cs_remember( 'label_latitude',                                        __( 'Latitude', 'cornerstone' )                                                           );
cs_remember( 'label_layers',                                          __( 'Layers', 'cornerstone' )                                                             );
cs_remember( 'label_layout',                                          __( 'Layout', 'cornerstone' )                                                             );
cs_remember( 'label_leading_zero',                                    __( 'Leading Zero', 'cornerstone' )                                                       );
cs_remember( 'label_leave_a_reply',                                   __( 'Leave a Reply', 'cornerstone' )                                                      );
cs_remember( 'label_leave_a_reply_to_sprintf',                        __( 'Leave a Reply to %s', 'cornerstone' )                                                );
cs_remember( 'label_left',                                            __( 'Left', 'cornerstone' )                                                               );
cs_remember( 'label_length',                                          __( 'Length', 'cornerstone' )                                                             );
cs_remember( 'label_letter_spacing',                                  __( 'Letter Spacing', 'cornerstone' )                                                     );
cs_remember( 'label_lighten',                                         __( 'Lighten', 'cornerstone' )                                                            );
cs_remember( 'label_line',                                            __( 'Line', 'cornerstone' )                                                               );
cs_remember( 'label_line_height',                                     __( 'Line Height', 'cornerstone' )                                                        );
cs_remember( 'label_line_size',                                       __( 'Line Size', 'cornerstone' )                                                          );
cs_remember( 'label_line_width',                                      __( 'Line Width', 'cornerstone' )                                                         );
cs_remember( 'label_link_child_interactions',                         __( 'Link Child Interactions', 'cornerstone' )                                            );
cs_remember( 'label_link_with_prefix',                                __( '{{prefix}} Link', 'cornerstone' )                                                    );
cs_remember( 'label_link',                                            __( 'Link', 'cornerstone' )                                                               );
cs_remember( 'label_links',                                           __( 'Links', 'cornerstone' )                                                              );
cs_remember( 'label_links_size',                                      __( 'Links Size', 'cornerstone' )                                                         );
cs_remember( 'label_links_text_format',                               __( 'Links Text Format', 'cornerstone' )                                                  );
cs_remember( 'label_load',                                            __( 'Load', 'cornerstone' )                                                               );
cs_remember( 'label_loaded',                                          __( 'Loaded', 'cornerstone' )                                                             );
cs_remember( 'label_loading',                                         __( 'Loading', 'cornerstone' )                                                            );
cs_remember( 'label_load_reset_on_element_toggle',                    __( 'Load / reset on element toggle', 'cornerstone' )                                     );
cs_remember( 'label_location',                                        __( 'Location', 'cornerstone' )                                                           );
cs_remember( 'label_logged_in_as_label',                              __( 'Logged In As Label', 'cornerstone' )                                                 );
cs_remember( 'label_longitude',                                       __( 'Longitude', 'cornerstone' )                                                          );
cs_remember( 'label_loop',                                            __( 'Loop', 'cornerstone' )                                                               );
cs_remember( 'label_loop_typing',                                     __( 'Loop Typing', 'cornerstone' )                                                        );
cs_remember( 'label_looped',                                          __( 'Looped', 'cornerstone' )                                                             );
cs_remember( 'label_looper_consumer',                                 __( 'Looper Consumer', 'cornerstone' )                                                    );
cs_remember( 'label_looper_provider',                                 __( 'Looper Provider', 'cornerstone' )                                                    );
cs_remember( 'label_lower',                                           __( 'Lower', 'cornerstone' )                                                              );
cs_remember( 'label_ltr',                                             __( 'LTR', 'cornerstone' )                                                                );
cs_remember( 'label_ltr_delimiter',                                   __( 'LTR Delimiter', 'cornerstone' )                                                      );
cs_remember( 'label_luminosity',                                      __( 'Luminosity', 'cornerstone' )                                                         );
cs_remember( 'label_m',                                               __( 'M', 'cornerstone' )                                                                  );
cs_remember( 'label_many',                                            __( 'Many', 'cornerstone' )                                                               );
cs_remember( 'label_map',                                             __( 'Map', 'cornerstone' )                                                                );
cs_remember( 'label_map_marker',                                      __( 'Map Marker', 'cornerstone' )                                                         );
cs_remember( 'label_map_markers',                                     __( 'Map Markers', 'cornerstone' )                                                        );
cs_remember( 'label_margin',                                          __( 'Margin', 'cornerstone' )                                                             );
cs_remember( 'label_margin_with_prefix',                              __( '{{prefix}} Margin', 'cornerstone' )                                                  );
cs_remember( 'label_marker',                                          __( 'Marker', 'cornerstone' )                                                             );
cs_remember( 'label_markers',                                         __( 'Markers', 'cornerstone' )                                                            );
cs_remember( 'label_marks',                                           __( 'Marks', 'cornerstone' )                                                              );
cs_remember( 'label_marks_setup',                                     __( 'Marks Setup', 'cornerstone' )                                                        );
cs_remember( 'label_marquee',                                         __( 'Marquee', 'cornerstone' )                                                            );
cs_remember( 'label_max',                                             __( 'Max', 'cornerstone' )                                                                );
cs_remember( 'label_max_columns',                                     __( 'Max Columns', 'cornerstone' )                                                        );
cs_remember( 'label_max_height',                                      __( 'Max Height', 'cornerstone' )                                                         );
cs_remember( 'label_max_scale',                                       __( 'Max Scale', 'cornerstone' )                                                          );
cs_remember( 'label_max_width',                                       __( 'Max Width', 'cornerstone' )                                                          );
cs_remember( 'label_maximum',                                         __( 'Maximum', 'cornerstone' )                                                            );
cs_remember( 'label_menu',                                            __( 'Menu', 'cornerstone' )                                                               );
cs_remember( 'label_menu_item',                                       __( 'Menu Item', 'cornerstone' )                                                          );
cs_remember( 'label_menu_order',                                      __( 'Menu Order', 'cornerstone' )                                                         );
cs_remember( 'label_message',                                         __( 'Message', 'cornerstone' )                                                            );
cs_remember( 'label_messages',                                        __( 'Messages', 'cornerstone' )                                                           );
cs_remember( 'label_messaging',                                       __( 'Messaging', 'cornerstone' )                                                          );
cs_remember( 'label_metadata',                                        __( 'Metadata', 'cornerstone' )                                                           );
cs_remember( 'label_mid_number_count',                                __( 'Mid # Count', 'cornerstone' )                                                        );
cs_remember( 'label_min',                                             __( 'Min', 'cornerstone' )                                                                );
cs_remember( 'label_min_height',                                      __( 'Min Height', 'cornerstone' )                                                         );
cs_remember( 'label_min_max',                                         __( 'Min / Max', 'cornerstone' )                                                          );
cs_remember( 'label_min_scale',                                       __( 'Min Scale', 'cornerstone' )                                                          );
cs_remember( 'label_min_width',                                       __( 'Min Width', 'cornerstone' )                                                          );
cs_remember( 'label_mini_cart',                                       __( 'Mini-Cart', 'cornerstone' )                                                          );
cs_remember( 'label_minimum',                                         __( 'Minimum', 'cornerstone' )                                                            );
cs_remember( 'label_mix_blend_mode',                                  __( 'Mix Blend Mode', 'cornerstone' )                                                     );
cs_remember( 'label_modal',                                           __( 'Modal', 'cornerstone' )                                                              );
cs_remember( 'label_modal_custom_attributes',                         __( 'Modal Custom Attributes', 'cornerstone' )                                            );
cs_remember( 'label_mode',                                            __( 'Mode', 'cornerstone' )                                                               );
cs_remember( 'label_modified',                                        __( 'Modified', 'cornerstone' )                                                           );
cs_remember( 'label_more',                                            __( 'More', 'cornerstone' )                                                               );
cs_remember( 'label_more_horizontal',                                 __( 'More Horizontal', 'cornerstone' )                                                    );
cs_remember( 'label_more_vertical',                                   __( 'More Vertical', 'cornerstone' )                                                      );
cs_remember( 'label_move_by',                                         __( 'Move By', 'cornerstone' )                                                            );
cs_remember( 'label_movement',                                        __( 'Movement', 'cornerstone' )                                                           );
cs_remember( 'label_multiply',                                        __( 'Multiply', 'cornerstone' )                                                           );
cs_remember( 'label_multiplier',                                      __( 'Multiplier', 'cornerstone' )                                                         );
cs_remember( 'label_must_have_all_selected_terms',                    __( 'Must have all selected terms', 'cornerstone' )                                       );
cs_remember( 'label_mute',                                            __( 'Mute', 'cornerstone' )                                                               );
cs_remember( 'label_muted',                                           __( 'Muted', 'cornerstone' )                                                              );
cs_remember( 'label_name',                                            __( 'Name', 'cornerstone' )                                                               );
cs_remember( 'label_navigation_collapsed',                            __( 'Navigation Collapsed', 'cornerstone' )                                               );
cs_remember( 'label_navigation_dropdown',                             __( 'Navigation Dropdown', 'cornerstone' )                                                );
cs_remember( 'label_navigation_inline',                               __( 'Navigation Inline', 'cornerstone' )                                                  );
cs_remember( 'label_navigation_layered',                              __( 'Navigation Layered', 'cornerstone' )                                                 );
cs_remember( 'label_navigation_modal',                                __( 'Navigation Modal', 'cornerstone' )                                                   );
cs_remember( 'label_navigation_off_canvas',                           __( 'Navigation Off Canvas', 'cornerstone' )                                              );
cs_remember( 'label_newest',                                          __( 'Newest', 'cornerstone' )                                                             );
cs_remember( 'label_newline',                                         __( 'Newline', 'cornerstone' )                                                            );
cs_remember( 'label_next',                                            __( 'Next', 'cornerstone' )                                                               );
cs_remember( 'label_no_available_comments',                           __( 'No Available Comments', 'cornerstone' )                                              );
cs_remember( 'label_no_comments',                                     __( 'No Comments', 'cornerstone' )                                                        );
cs_remember( 'label_no_controls',                                     __( 'No Controls', 'cornerstone' )                                                        );
cs_remember( 'label_no_global_blocks',                                __( 'No Global Blocks', 'cornerstone' )                                                   );
cs_remember( 'label_no_output_if_empty',                              __( 'No Output If Empty', 'cornerstone' )                                                 );
cs_remember( 'label_no_pointer_events',                               __( 'No Pointer Events', 'cornerstone' )                                                  );
cs_remember( 'label_no_touch',                                        __( 'No Touch', 'cornerstone' )                                                           );
cs_remember( 'label_none',                                            __( 'None', 'cornerstone' )                                                               );
cs_remember( 'label_normal',                                          __( 'Normal', 'cornerstone' )                                                             );
cs_remember( 'label_num_per_page',                                    __( '# Per Page', 'cornerstone' )                                                         );
cs_remember( 'label_number',                                          __( 'Number', 'cornerstone' )                                                             );
cs_remember( 'label_number_start_and_end',                            __( 'Number Start & End', 'cornerstone' )                                                 );
cs_remember( 'label_object_fit',                                      __( 'Object Fit', 'cornerstone' )                                                         );
cs_remember( 'label_off',                                             __( 'Off', 'cornerstone' )                                                                );
cs_remember( 'label_offset',                                          __( 'Offset', 'cornerstone' )                                                             );
cs_remember( 'label_offset_top',                                      __( 'Offset Top', 'cornerstone' )                                                         );
cs_remember( 'label_offset_trigger',                                  __( 'Offset Trigger', 'cornerstone' )                                                     );
cs_remember( 'label_offset_side',                                     __( 'Offset Side', 'cornerstone' )                                                        );
cs_remember( 'label_offset_sides',                                    __( 'Offset Sides', 'cornerstone' )                                                       );
cs_remember( 'label_off_canvas',                                      __( 'Off Canvas', 'cornerstone' )                                                         );
cs_remember( 'label_off_canvas_custom_attributes',                    __( 'Off Canvas Custom Attributes', 'cornerstone' )                                       );
cs_remember( 'label_oldest',                                          __( 'Oldest', 'cornerstone' )                                                             );
cs_remember( 'label_on',                                              __( 'On', 'cornerstone' )                                                                 );
cs_remember( 'label_on_flick',                                        __( 'On Flick', 'cornerstone' )                                                           );
cs_remember( 'label_one',                                             __( 'One', 'cornerstone' )                                                                );
cs_remember( 'label_once',                                            __( 'Once', 'cornerstone' )                                                               );
cs_remember( 'label_opacity',                                         __( 'Opacity', 'cornerstone' )                                                            );
cs_remember( 'label_open',                                            __( 'Open', 'cornerstone' )                                                               );
cs_remember( 'label_opening',                                         __( 'Opening', 'cornerstone' )                                                            );
cs_remember( 'label_opening_mark_align',                              __( 'Opening Mark Align', 'cornerstone' )                                                 );
cs_remember( 'label_options',                                         __( 'Options', 'cornerstone' )                                                            );
cs_remember( 'label_order',                                           __( 'Order', 'cornerstone' )                                                              );
cs_remember( 'label_orderby',                                         __( 'Orderby', 'cornerstone' )                                                            );
cs_remember( 'label_order_by',                                        __( 'Order By', 'cornerstone' )                                                           );
cs_remember( 'label_origin',                                          __( 'Origin', 'cornerstone' )                                                             );
cs_remember( 'label_out',                                             __( 'Out', 'cornerstone' )                                                                );
cs_remember( 'label_outside',                                         __( 'Outside', 'cornerstone' )                                                            );
cs_remember( 'label_outer',                                           __( 'Outer', 'cornerstone' )                                                              );
cs_remember( 'label_outset',                                          __( 'Outset', 'cornerstone' )                                                             );
cs_remember( 'label_overflow',                                        __( 'Overflow', 'cornerstone' )                                                           );
cs_remember( 'label_overlap',                                         __( 'Overlap', 'cornerstone' )                                                            );
cs_remember( 'label_overlay',                                         __( 'Overlay', 'cornerstone' )                                                            );
cs_remember( 'label_overwrites',                                      __( 'Overwrites', 'cornerstone' )                                                         );
cs_remember( 'label_padding',                                         __( 'Padding', 'cornerstone' )                                                            );
cs_remember( 'label_padding_with_prefix',                             __( '{{prefix}} Padding', 'cornerstone' )                                                 );
cs_remember( 'label_page',                                            __( 'Page', 'cornerstone' )                                                               );
cs_remember( 'label_page_count',                                      __( 'Page Count', 'cornerstone' )                                                         );
cs_remember( 'label_paged',                                           __( 'Paged', 'cornerstone' )                                                              );
cs_remember( 'label_paged_count',                                     __( 'Paged Count', 'cornerstone' )                                                        );
cs_remember( 'label_pagination',                                      __( 'Pagination', 'cornerstone' )                                                         );
cs_remember( 'label_panels',                                          __( 'Panels', 'cornerstone' )                                                             );
cs_remember( 'label_parallax',                                        __( 'Parallax', 'cornerstone' )                                                           );
cs_remember( 'label_params',                                          __( 'Params', 'cornerstone' )                                                             );
cs_remember( 'label_particle_with_prefix',                            __( '{{prefix}} Particle', 'cornerstone' )                                                );
cs_remember( 'label_particles',                                       __( 'Particles', 'cornerstone' )                                                          );
cs_remember( 'label_perspective',                                     __( 'Perspective', 'cornerstone' )                                                        );
cs_remember( 'label_perspective_origin',                              __( 'Perspective Origin', 'cornerstone' )                                                 );
cs_remember( 'label_pingbacks',                                       __( 'Pingbacks', 'cornerstone' )                                                          );
cs_remember( 'label_pings',                                           __( 'Pings', 'cornerstone' )                                                              );
cs_remember( 'label_placeholder',                                     __( 'Placeholder', 'cornerstone' )                                                        );
cs_remember( 'label_placement',                                       __( 'Placement', 'cornerstone' )                                                          );
cs_remember( 'label_player',                                          __( 'Player', 'cornerstone' )                                                             );
cs_remember( 'label_pointer',                                         __( 'Pointer', 'cornerstone' )                                                            );
cs_remember( 'label_pointer_events',                                  __( 'Pointer Events', 'cornerstone' )                                                     );
cs_remember( 'label_position',                                        __( 'Position', 'cornerstone' )                                                           );
cs_remember( 'label_post_navigation',                                 __( 'Post Navigation', 'cornerstone' )                                                    );
cs_remember( 'label_post_pagination',                                 __( 'Post Pagination', 'cornerstone' )                                                    );
cs_remember( 'label_posts',                                           __( 'Posts', 'cornerstone' )                                                              );
cs_remember( 'label_poster',                                          __( 'Poster', 'cornerstone' )                                                             );
cs_remember( 'label_prefix',                                          __( 'Prefix', 'cornerstone' )                                                             );
cs_remember( 'label_prefix_and_suffix',                               __( 'Prefix & Suffix', 'cornerstone' )                                                    );
cs_remember( 'label_preload',                                         __( 'Preload', 'cornerstone' )                                                            );
cs_remember( 'label_prev',                                            __( 'Prev', 'cornerstone' )                                                               );
cs_remember( 'label_prev_next',                                       __( 'Prev / Next', 'cornerstone' )                                                        );
cs_remember( 'label_prev_next_icons',                                 __( 'Prev / Next Icons', 'cornerstone' )                                                  );
cs_remember( 'label_prev_next_text',                                  __( 'Prev / Next Text', 'cornerstone' )                                                   );
cs_remember( 'label_prev_next_type',                                  __( 'Prev / Next Type', 'cornerstone' )                                                   );
cs_remember( 'label_preview',                                         __( 'Preview', 'cornerstone' )                                                            );
cs_remember( 'label_previous',                                        __( 'Previous', 'cornerstone' )                                                           );
cs_remember( 'label_price',                                           __( 'Price', 'cornerstone' )                                                              );
cs_remember( 'label_primary',                                         __( 'Primary', 'cornerstone' )                                                            );
cs_remember( 'label_primary_icon',                                    __( 'Primary Icon', 'cornerstone' )                                                       );
cs_remember( 'label_primary_particle',                                __( 'Primary Particle', 'cornerstone' )                                                   );
cs_remember( 'label_primary_with_sprintf_prefix',                     __( '%s Primary', 'cornerstone' )                                                         );
cs_remember( 'label_primary_text',                                    __( 'Primary Text', 'cornerstone' )                                                       );
cs_remember( 'label_primary_text_with_prefix',                        __( '{{prefix}} Primary Text', 'cornerstone' )                                            );
cs_remember( 'label_primary_graphic_image_with_prefix',               __( '{{prefix}} Primary Graphic Image', 'cornerstone' )                                   );
cs_remember( 'label_product_gallery',                                 __( 'Product Gallery', 'cornerstone' )                                                    );
cs_remember( 'label_product_pagination',                              __( 'Product Pagination', 'cornerstone' )                                                 );
cs_remember( 'label_products',                                        __( 'Products', 'cornerstone' )                                                           );
cs_remember( 'label_progress',                                        __( 'Progress', 'cornerstone' )                                                           );
cs_remember( 'label_published_after',                                 __( 'Published After', 'cornerstone' )                                                    );
cs_remember( 'label_published_before',                                __( 'Published Before', 'cornerstone' )                                                   );
cs_remember( 'label_quantity',                                        __( 'Quantity', 'cornerstone' )                                                           );
cs_remember( 'label_query_builder',                                   __( 'Query Builder', 'cornerstone' )                                                      );
cs_remember( 'label_query_string',                                    __( 'Query String', 'cornerstone' )                                                       );
cs_remember( 'label_quote',                                           __( 'Quote', 'cornerstone' )                                                              );
cs_remember( 'label_radius',                                          __( 'Radius', 'cornerstone' )                                                             );
cs_remember( 'label_rail',                                            __( 'Rail', 'cornerstone' )                                                               );
cs_remember( 'label_random',                                          __( 'Random', 'cornerstone' )                                                             );
cs_remember( 'label_rating',                                          __( 'Rating', 'cornerstone' )                                                             );
cs_remember( 'label_ratio',                                           __( 'Ratio', 'cornerstone' )                                                              );
cs_remember( 'label_raw_content',                                     __( 'Raw Content', 'cornerstone' )                                                        );
cs_remember( 'label_recent_posts',                                    __( 'Recent Posts', 'cornerstone' )                                                       );
cs_remember( 'label_related_products',                                __( 'Related Products', 'cornerstone' )                                                   );
cs_remember( 'label_relative',                                        __( 'Relative', 'cornerstone' )                                                           );
cs_remember( 'label_remove_button',                                   __( 'Remove Button', 'cornerstone' )                                                      );
cs_remember( 'label_repeat',                                          __( 'Repeat', 'cornerstone' )                                                             );
cs_remember( 'label_reply_title',                                     __( 'Reply Title', 'cornerstone' )                                                        );
cs_remember( 'label_reply_to_title',                                  __( 'Reply To Title', 'cornerstone' )                                                     );
cs_remember( 'label_reset',                                           __( 'Reset', 'cornerstone' )                                                              );
cs_remember( 'label_retina',                                          __( 'Retina', 'cornerstone' )                                                             );
cs_remember( 'label_retina_ready',                                    __( 'Retina Ready', 'cornerstone' )                                                       );
cs_remember( 'label_reverse',                                         __( 'Reverse', 'cornerstone' )                                                            );
cs_remember( 'label_ridge',                                           __( 'Ridge', 'cornerstone' )                                                              );
cs_remember( 'label_right',                                           __( 'Right', 'cornerstone' )                                                              );
cs_remember( 'label_round_whole',                                     __( 'Round Whole', 'cornerstone' )                                                        );
cs_remember( 'label_row',                                             __( 'Row', 'cornerstone' )                                                                );
cs_remember( 'label_rows',                                            __( 'Rows', 'cornerstone' )                                                               );
cs_remember( 'label_rtl',                                             __( 'RTL', 'cornerstone' )                                                                );
cs_remember( 'label_rtl_delimiter',                                   __( 'RTL Delimiter', 'cornerstone' )                                                      );
cs_remember( 'label_rule_color',                                      __( 'Rule Color', 'cornerstone' )                                                         );
cs_remember( 'label_rule_style',                                      __( 'Rule Style', 'cornerstone' )                                                         );
cs_remember( 'label_rule_width',                                      __( 'Rule Width', 'cornerstone' )                                                         );
cs_remember( 'label_s',                                               __( 'S', 'cornerstone' )                                                                  );
cs_remember( 'label_saturation',                                      __( 'Saturation', 'cornerstone' )                                                         );
cs_remember( 'label_scale',                                           __( 'Scale', 'cornerstone' )                                                              );
cs_remember( 'label_scale_down',                                      __( 'Scale Down', 'cornerstone' )                                                         );
cs_remember( 'label_scale_up',                                        __( 'Scale Up', 'cornerstone' )                                                           );
cs_remember( 'label_scaling',                                         __( 'Scaling', 'cornerstone' )                                                            );
cs_remember( 'label_schema',                                          __( 'Schema', 'cornerstone' )                                                             );
cs_remember( 'label_schema_item_address',                             __( '123 Imaginary Drive', 'cornerstone' )                                                );
cs_remember( 'label_schema_item_author',                              __( 'Gordon Ramsay', 'cornerstone' )                                                      );
cs_remember( 'label_schema_item_name',                                __( 'In-N-Out', 'cornerstone' )                                                           );
cs_remember( 'label_schema_item_reviewed',                            __( 'FastFoodRestaurant', 'cornerstone' )                                                 );
cs_remember( 'label_screen',                                          __( 'Screen', 'cornerstone' )                                                             );
cs_remember( 'label_scroll',                                          __( 'Scroll', 'cornerstone' )                                                             );
cs_remember( 'label_scroll_by',                                       __( 'Scroll By', 'cornerstone' )                                                          );
cs_remember( 'label_use_effects',                                     __( 'Use Effects', 'cornerstone' )                                                        );
cs_remember( 'label_scrolling',                                       __( 'Scrolling', 'cornerstone' )                                                          );
cs_remember( 'label_search',                                          __( 'Search', 'cornerstone' )                                                             );
cs_remember( 'label_sec',                                             __( 'Sec', 'cornerstone' )                                                                );
cs_remember( 'label_secondary',                                       __( 'Secondary', 'cornerstone' )                                                          );
cs_remember( 'label_secondary_icon',                                  __( 'Secondary Icon', 'cornerstone' )                                                     );
cs_remember( 'label_secondary_particle',                              __( 'Secondary Particle', 'cornerstone' )                                                 );
cs_remember( 'label_secondary_text',                                  __( 'Secondary Text', 'cornerstone' )                                                     );
cs_remember( 'label_secondary_with_sprintf_prefix',                   __( '%s Secondary', 'cornerstone' )                                                       );
cs_remember( 'label_secondary_graphic_image_with_prefix',             __( '{{prefix}} Secondary Graphic Image', 'cornerstone' )                                 );
cs_remember( 'label_section',                                         __( 'Section', 'cornerstone' )                                                            );
cs_remember( 'label_sections',                                        __( 'Sections', 'cornerstone' )                                                           );
cs_remember( 'label_select',                                          __( 'Select', 'cornerstone' )                                                             );
cs_remember( 'label_self_flex',                                       __( 'Self Flex', 'cornerstone' )                                                          );
cs_remember( 'label_self_only',                                       __( 'Self Only', 'cornerstone' )                                                          );
cs_remember( 'label_separators',                                      __( 'Separators', 'cornerstone' )                                                         );
cs_remember( 'label_setup',                                           __( 'Setup', 'cornerstone' )                                                              );
cs_remember( 'label_setup_with_prefix',                               __( '{{prefix}} Setup', 'cornerstone' )                                                   );
cs_remember( 'label_shadow',                                          __( 'Shadow', 'cornerstone' )                                                             );
cs_remember( 'label_shop',                                            __( 'Shop', 'cornerstone' )                                                               );
cs_remember( 'label_shop_notices',                                    __( 'Shop Notices', 'cornerstone' )                                                       );
cs_remember( 'label_shop_sort',                                       __( 'Shop Sort', 'cornerstone' )                                                          );
cs_remember( 'label_show',                                            __( 'Show', 'cornerstone' )                                                               );
cs_remember( 'label_show_cursor',                                     __( 'Show Cursor', 'cornerstone' )                                                        );
cs_remember( 'label_shrink_amount',                                   __( 'Shrink Amount', 'cornerstone' )                                                      );
cs_remember( 'label_sides',                                           __( 'Sides', 'cornerstone' )                                                              );
cs_remember( 'label_side_offset',                                     __( 'Side Offset', 'cornerstone' )                                                        );
cs_remember( 'label_size',                                            __( 'Size', 'cornerstone' )                                                               );
cs_remember( 'label_size_with_prefix',                                __( '{{prefix}} Size', 'cornerstone' )                                                    );
cs_remember( 'label_slide',                                           __( 'Slide', 'cornerstone' )                                                              );
cs_remember( 'label_slide_bottom',                                    __( 'Slide Bottom', 'cornerstone' )                                                       );
cs_remember( 'label_slide_container',                                 __( 'Slide Container', 'cornerstone' )                                                    );
cs_remember( 'label_slide_left',                                      __( 'Slide Left', 'cornerstone' )                                                         );
cs_remember( 'label_slide_pagination',                                __( 'Slide Pagination', 'cornerstone' )                                                   );
cs_remember( 'label_slide_right',                                     __( 'Slide Right', 'cornerstone' )                                                        );
cs_remember( 'label_slide_top',                                       __( 'Slide Top', 'cornerstone' )                                                          );
cs_remember( 'label_slide_bottom_scale_up',                           __( 'Slide Bottom / Scale Up', 'cornerstone' )                                            );
cs_remember( 'label_slide_left_scale_up',                             __( 'Slide Left / Scale Up', 'cornerstone' )                                              );
cs_remember( 'label_slide_right_scale_up',                            __( 'Slide Right / Scale Up', 'cornerstone' )                                             );
cs_remember( 'label_slide_top_scale_up',                              __( 'Slide Top / Scale Up', 'cornerstone' )                                               );
cs_remember( 'label_slider',                                          __( 'Slider', 'cornerstone' )                                                             );
cs_remember( 'label_slides',                                          __( 'Slides', 'cornerstone' )                                                             );
cs_remember( 'label_slides_to_show',                                  __( 'Slides to Show', 'cornerstone' )                                                     );
cs_remember( 'label_slug',                                            __( 'Slug', 'cornerstone' )                                                               );
cs_remember( 'label_snap',                                            __( 'Snap', 'cornerstone' )                                                               );
cs_remember( 'label_social',                                          __( 'Social', 'cornerstone' )                                                             );
cs_remember( 'label_soft_light',                                      __( 'Soft Light', 'cornerstone' )                                                         );
cs_remember( 'label_solid',                                           __( 'Solid', 'cornerstone' )                                                              );
cs_remember( 'label_source',                                          __( 'Source', 'cornerstone' )                                                             );
cs_remember( 'label_sources_1_per_line',                              __( 'Sources<br>(1 Per Line)', 'cornerstone' )                                            );
cs_remember( 'label_space_around',                                    __( 'Space Around', 'cornerstone' )                                                       );
cs_remember( 'label_space_between',                                   __( 'Space Between', 'cornerstone' )                                                      );
cs_remember( 'label_space_evenly',                                    __( 'Space Evenly', 'cornerstone' )                                                       );
cs_remember( 'label_spacing',                                         __( 'Spacing', 'cornerstone' )                                                            );
cs_remember( 'label_specialty',                                       __( 'Specialty', 'cornerstone' )                                                          );
cs_remember( 'label_specific_posts',                                  __( 'Specific Posts', 'cornerstone' )                                                     );
cs_remember( 'label_specific_terms',                                  __( 'Specific Terms', 'cornerstone' )                                                     );
cs_remember( 'label_speed',                                           __( 'Speed', 'cornerstone' )                                                              );
cs_remember( 'label_spread',                                          __( 'Spread', 'cornerstone' )                                                             );
cs_remember( 'label_stacked',                                         __( 'Stacked', 'cornerstone' )                                                            );
cs_remember( 'label_standard',                                        __( 'Standard', 'cornerstone' )                                                           );
cs_remember( 'label_start',                                           __( 'Start', 'cornerstone' )                                                              );
cs_remember( 'label_start_rotation',                                  __( 'Start Rotation', 'cornerstone' )                                                     );
cs_remember( 'label_starts_at',                                       __( 'Starts At', 'cornerstone' )                                                          );
cs_remember( 'label_starts_open',                                     __( 'Starts Open', 'cornerstone' )                                                        );
cs_remember( 'label_statbar',                                         __( 'Statbar', 'cornerstone' )                                                            );
cs_remember( 'label_static',                                          __( 'Static', 'cornerstone' )                                                             );
cs_remember( 'label_sticky',                                          __( 'Sticky', 'cornerstone' )                                                             );
cs_remember( 'label_stop',                                            __( 'Stop', 'cornerstone' )                                                               );
cs_remember( 'label_stretch',                                         __( 'Stretch', 'cornerstone' )                                                            );
cs_remember( 'label_string',                                          __( 'String', 'cornerstone' )                                                             );
cs_remember( 'label_stroke',                                          __( 'Stroke', 'cornerstone' )                                                             );
cs_remember( 'label_stroke_width',                                    __( 'Stroke Width', 'cornerstone' )                                                       );
cs_remember( 'label_style',                                           __( 'Style', 'cornerstone' )                                                              );
cs_remember( 'label_sub_indicator',                                   __( 'Sub Indicator', 'cornerstone' )                                                      );
cs_remember( 'label_sub_indicator_with_prefix',                       __( '{{prefix}} Sub Indicator', 'cornerstone' )                                           );
cs_remember( 'label_sub_indicator_with_sprintf_prefix',               __( '%s Sub Indicator', 'cornerstone' )                                                   );
cs_remember( 'label_sub_links',                                       __( 'Sub Links', 'cornerstone' )                                                          );
cs_remember( 'label_sub_menu_items',                                  __( 'Sub Menu Items', 'cornerstone' )                                                     );
cs_remember( 'label_sub_menu_trigger',                                __( 'Sub Menu Trigger', 'cornerstone' )                                                   );
cs_remember( 'label_submit',                                          __( 'Submit', 'cornerstone' )                                                             );
cs_remember( 'label_submit_label',                                    __( 'Submit Label', 'cornerstone' )                                                       );
cs_remember( 'label_submit_placement',                                __( 'Submit Placement', 'cornerstone' )                                                   );
cs_remember( 'label_subheadline',                                     __( 'Subheadline', 'cornerstone' )                                                        );
cs_remember( 'label_subheadline_with_prefix',                         __( '{{prefix}} Subheadline', 'cornerstone' )                                             );
cs_remember( 'label_subheadline_with_sprintf_prefix',                 __( '%s Subheadline', 'cornerstone' )                                                     );
cs_remember( 'label_suffix',                                          __( 'Suffix', 'cornerstone' )                                                             );
cs_remember( 'label_swipe',                                           __( 'Swipe', 'cornerstone' )                                                              );
cs_remember( 'label_symbol',                                          __( 'Symbol', 'cornerstone' )                                                             );
cs_remember( 'label_tab',                                             __( 'Tab', 'cornerstone' )                                                                );
cs_remember( 'label_tab_1',                                           __( 'Tab 1', 'cornerstone' )                                                              );
cs_remember( 'label_tab_2',                                           __( 'Tab 2', 'cornerstone' )                                                              );
cs_remember( 'label_tab_list',                                        __( 'Tab List', 'cornerstone' )                                                           );
cs_remember( 'label_tabs',                                            __( 'Tabs', 'cornerstone' )                                                               );
cs_remember( 'label_target_element_optional',                         __( '#target-element (optional)', 'cornerstone' )                                         );
cs_remember( 'label_targets',                                         __( 'Targets', 'cornerstone' )                                                            );
cs_remember( 'label_taxonomy',                                        __( 'Taxonomy', 'cornerstone' )                                                           );
cs_remember( 'label_taxonomies',                                      __( 'Taxonomies', 'cornerstone' )                                                         );
cs_remember( 'label_template',                                        __( 'Template', 'cornerstone' )                                                           );
cs_remember( 'label_testimonial',                                     __( 'Testimonial', 'cornerstone' )                                                        );
cs_remember( 'label_text',                                            __( 'Text', 'cornerstone' )                                                               );
cs_remember( 'label_text_with_sprintf_prefix',                        __( '%s Text', 'cornerstone' )                                                            );
cs_remember( 'label_text_align',                                      __( 'Text Align', 'cornerstone' )                                                         );
cs_remember( 'label_text_color',                                      __( 'Text Color', 'cornerstone' )                                                         );
cs_remember( 'label_text_columns_with_prefix',                        __( '{{prefix}} Text Columns', 'cornerstone' )                                            );
cs_remember( 'label_text_content',                                    __( 'Text Content', 'cornerstone' )                                                       );
cs_remember( 'label_text_content_with_sprintf_prefix',                __( '%s Text Content', 'cornerstone' )                                                    );
cs_remember( 'label_text_decoration',                                 __( 'Text Decoration', 'cornerstone' )                                                    );
cs_remember( 'label_text_format',                                     __( 'Text Format', 'cornerstone' )                                                        );
cs_remember( 'label_text_format_with_prefix',                         __( '{{prefix}} Text Format', 'cornerstone' )                                             );
cs_remember( 'label_text_overflow',                                   __( 'Text Overflow', 'cornerstone' )                                                      );
cs_remember( 'label_text_setup_with_prefix',                          __( '{{prefix}} Text Setup', 'cornerstone' )                                              );
cs_remember( 'label_text_shadow',                                     __( 'Text Shadow', 'cornerstone' )                                                        );
cs_remember( 'label_text_shadow_with_prefix',                         __( '{{prefix}} Text Shadow', 'cornerstone' )                                             );
cs_remember( 'label_text_transform',                                  __( 'Text Transform', 'cornerstone' )                                                     );
cs_remember( 'label_the_content',                                     __( 'The Content', 'cornerstone' )                                                        );
cs_remember( 'label_the_excerpt',                                     __( 'The Excerpt', 'cornerstone' )                                                        );
cs_remember( 'label_thumbnail',                                       __( 'Thumbnail', 'cornerstone' )                                                          );
cs_remember( 'label_thumbnail_width',                                 __( 'Thumbnail Width', 'cornerstone' )                                                    );
cs_remember( 'label_time_rail',                                       __( 'Time Rail', 'cornerstone' )                                                          );
cs_remember( 'label_time_rail_setup_with_prefix',                     __( '{{prefix}} Time Rail Setup', 'cornerstone' )                                         );
cs_remember( 'label_timing',                                          __( 'Timing', 'cornerstone' )                                                             );
cs_remember( 'label_title',                                           __( 'Title', 'cornerstone' )                                                              );
cs_remember( 'label_toggle',                                          __( 'Toggle', 'cornerstone' )                                                             );
cs_remember( 'label_toggle_with_prefix',                              __( '{{prefix}} Toggle', 'cornerstone' )                                                  );
cs_remember( 'label_toggle_colors_with_prefix',                       __( '{{prefix}} Toggle Colors', 'cornerstone' )                                           );
cs_remember( 'label_toggle_dropdown_content',                         __( 'Toggle Dropdown Content', 'cornerstone' )                                            );
cs_remember( 'label_toggle_modal_content',                            __( 'Toggle Modal Content', 'cornerstone' )                                               );
cs_remember( 'label_top',                                             __( 'Top', 'cornerstone' )                                                                );
cs_remember( 'label_top_left',                                        __( 'Top Left', 'cornerstone' )                                                           );
cs_remember( 'label_top_links',                                       __( 'Top Links', 'cornerstone' )                                                          );
cs_remember( 'label_top_menu_items',                                  __( 'Top Menu Items', 'cornerstone' )                                                     );
cs_remember( 'label_top_offset',                                      __( 'Top Offset', 'cornerstone' )                                                         );
cs_remember( 'label_top_right',                                       __( 'Top Right', 'cornerstone' )                                                          );
cs_remember( 'label_total',                                           __( 'Total', 'cornerstone' )                                                              );
cs_remember( 'label_total_placement',                                 __( 'Total Placement', 'cornerstone' )                                                    );
cs_remember( 'label_touch_scroll',                                    __( 'Touch Scroll', 'cornerstone' )                                                       );
cs_remember( 'label_trackbacks',                                      __( 'Trackbacks', 'cornerstone' )                                                         );
cs_remember( 'label_transform',                                       __( 'Transform', 'cornerstone' )                                                          );
cs_remember( 'label_transform_origin',                                __( 'Transform Origin', 'cornerstone' )                                                   );
cs_remember( 'label_transition',                                      __( 'Transition', 'cornerstone' )                                                         );
cs_remember( 'label_trigger',                                         __( 'Trigger', 'cornerstone' )                                                            );
cs_remember( 'label_trigger_offset',                                  __( 'Trigger Offset', 'cornerstone' )                                                     );
cs_remember( 'label_trigger_selector',                                __( 'Trigger Selector', 'cornerstone' )                                                   );
cs_remember( 'label_type',                                            __( 'Type', 'cornerstone' )                                                               );
cs_remember( 'label_types',                                           __( 'Types', 'cornerstone' )                                                              );
cs_remember( 'label_typed_text_1_per_line',                           __( 'Typed Text (1 Per Line)', 'cornerstone' )                                            );
cs_remember( 'label_typing',                                          __( 'Typing', 'cornerstone' )                                                             );
cs_remember( 'label_typing_with_prefix',                              __( '{{prefix}} Typing', 'cornerstone' )                                                  );
cs_remember( 'label_unit',                                            __( 'Unit', 'cornerstone' )                                                               );
cs_remember( 'label_units',                                           __( 'Units', 'cornerstone' )                                                              );
cs_remember( 'label_up',                                              __( 'Up', 'cornerstone' )                                                                 );
cs_remember( 'label_upper',                                           __( 'Upper', 'cornerstone' )                                                              );
cs_remember( 'label_upsells',                                         __( 'Upsells', 'cornerstone' )                                                            );
cs_remember( 'label_use_global_container',                            __( 'Use Global Container', 'cornerstone' )                                               );
cs_remember( 'label_uses_get_the_terms_to_find_terms_associated',     __( 'Uses get_the_terms to find terms associated with the current post.', 'cornerstone' ) );
cs_remember( 'label_vertical',                                        __( 'Vertical', 'cornerstone' )                                                           );
cs_remember( 'label_video',                                           __( 'Video', 'cornerstone' )                                                              );
cs_remember( 'label_viewport',                                        __( 'Viewport', 'cornerstone' )                                                           );
cs_remember( 'label_visible',                                         __( 'Visible', 'cornerstone' )                                                            );
cs_remember( 'label_weight',                                          __( 'Weight', 'cornerstone' )                                                             );
cs_remember( 'label_widget_area',                                     __( 'Widget Area', 'cornerstone' )                                                        );
cs_remember( 'label_widget_spacing',                                  __( 'Widget Spacing', 'cornerstone' )                                                     );
cs_remember( 'label_width',                                           __( 'Width', 'cornerstone' )                                                              );
cs_remember( 'label_wordpress',                                       __( 'WordPress', 'cornerstone' )                                                          );
cs_remember( 'label_wp_query',                                        __( 'WP Query', 'cornerstone' )                                                           );
cs_remember( 'label_wrap',                                            __( 'Wrap', 'cornerstone' )                                                               );
cs_remember( 'label_x',                                               __( 'X', 'cornerstone' )                                                                  );
cs_remember( 'label_x_axis',                                          __( 'X Axis', 'cornerstone' )                                                             );
cs_remember( 'label_x_offset',                                        __( 'X Offset', 'cornerstone' )                                                           );
cs_remember( 'label_x_overflow',                                      __( 'X Overflow', 'cornerstone' )                                                         );
cs_remember( 'label_x_translate',                                     __( 'X Translate', 'cornerstone' )                                                        );
cs_remember( 'label_y',                                               __( 'Y', 'cornerstone' )                                                                  );
cs_remember( 'label_y_axis',                                          __( 'Y Axis', 'cornerstone' )                                                             );
cs_remember( 'label_y_offset',                                        __( 'Y Offset', 'cornerstone' )                                                           );
cs_remember( 'label_y_overflow',                                      __( 'Y Overflow', 'cornerstone' )                                                         );
cs_remember( 'label_y_translate',                                     __( 'Y Translate', 'cornerstone' )                                                        );
cs_remember( 'label_z_index',                                         __( 'Z-Index', 'cornerstone' )                                                            );
cs_remember( 'label_z_index_stack',                                   __( 'Z-Index Stack', 'cornerstone' )                                                      );
cs_remember( 'label_zoom',                                            __( 'Zoom', 'cornerstone' )                                                               );
cs_remember( 'label_zoom_level',                                      __( 'Zoom Level', 'cornerstone' )                                                         );



// Options
// =============================================================================

cs_remember( 'options_choices_off_on_bool', [
  'choices' => [
    [ 'value' => false, 'label' => cs_recall( 'label_off' ) ],
    [ 'value' => true,  'label' => cs_recall( 'label_on' )  ],
  ],
] );

cs_remember( 'options_choices_off_on_string', [
  'choices' => [
    [ 'value' => '',   'label' => cs_recall( 'label_off' ) ],
    [ 'value' => 'on', 'label' => cs_recall( 'label_on' )  ],
  ],
] );

cs_remember( 'options_choices_off_on_bool_string', [
  'choices' => [
    [ 'value' => '',  'label' => cs_recall( 'label_off' ) ],
    [ 'value' => '1', 'label' => cs_recall( 'label_on' )  ],
  ],
] );

cs_remember( 'options_font_size',                [ 'available_units' => $available_units_font_size,      'fallback_value' => '1em',  'valid_keywords' => [ 'calc' ],         'ranges' => $ranges_font_size      ] );
cs_remember( 'options_letter_spacing',           [ 'available_units' => $available_units_letter_spacing, 'fallback_value' => '0em',  'valid_keywords' => [ 'calc' ],         'ranges' => $ranges_letter_spacing ] );
cs_remember( 'options_line_height',              [ 'unit_mode' => 'unitless', 'min' => 1, 'max' => 2.5, 'step' => 0.1                                                                                           ] );
cs_remember( 'options_width_and_height',         [ 'available_units' => $available_units_size,           'fallback_value' => 'auto', 'valid_keywords' => [ 'auto', 'calc' ], 'ranges' => $ranges_size           ] );
cs_remember( 'options_min_width_and_min_height', [ 'available_units' => $available_units_size,           'fallback_value' => '0px',  'valid_keywords' => [ 'calc' ],         'ranges' => $ranges_size           ] );
cs_remember( 'options_max_width_and_max_height', [ 'available_units' => $available_units_size,           'fallback_value' => 'none', 'valid_keywords' => [ 'none', 'calc' ], 'ranges' => $ranges_size           ] );
cs_remember( 'options_gap',                      [ 'available_units' => $available_units_gap,            'fallback_value' => '1rem', 'valid_keywords' => [ 'calc' ],         'ranges' => $ranges_gap            ] );
cs_remember( 'options_graphic_icon',             [ 'available_units' => $available_units_graphic_icon,   'fallback_value' => '1em',  'valid_keywords' => [ 'auto', 'calc' ], 'ranges' => $ranges_graphic_icon   ] );
cs_remember( 'options_graphic_image',            [ 'available_units' => $available_units_graphic_image,  'fallback_value' => 'none', 'valid_keywords' => [ 'none', 'calc' ], 'ranges' => $ranges_graphic_image  ] );
cs_remember( 'options_inset',                    [ 'available_units' => $available_units_inset,          'fallback_value' => 'none', 'valid_keywords' => [ 'auto', 'calc' ], 'ranges' => $ranges_inset          ] );

cs_remember( 'options_justify_content_grid',           [ 'display' => 'grid', 'axis' => 'main',  'context' => 'content',                'icon_direction' => 'x' ] );
cs_remember( 'options_align_content_grid',             [ 'display' => 'grid', 'axis' => 'cross', 'context' => 'content',                'icon_direction' => 'y' ] );
cs_remember( 'options_justify_items_grid',             [ 'display' => 'grid', 'axis' => 'main',  'context' => 'items',                  'icon_direction' => 'x' ] );
cs_remember( 'options_align_items_grid',               [ 'display' => 'grid', 'axis' => 'cross', 'context' => 'items',                  'icon_direction' => 'y' ] );
cs_remember( 'options_justify_content_flex',           [ 'display' => 'flex', 'axis' => 'main',  'context' => 'content',                'icon_direction' => 'x' ] );
cs_remember( 'options_align_items_flex',               [ 'display' => 'flex', 'axis' => 'cross', 'context' => 'items',                  'icon_direction' => 'y' ] );
cs_remember( 'options_justify_slide_container_inline', [ 'display' => 'flex', 'axis' => 'main',  'context' => 'slide-container-inline', 'icon_direction' => 'x' ] );


$layout_tags = [
  [ 'value' => 'div',     'label' => '<div>',     ],
  [ 'value' => 'section', 'label' => '<section>', ],
  [ 'value' => 'article', 'label' => '<article>', ],
  [ 'value' => 'aside',   'label' => '<aside>',   ],
  [ 'value' => 'header',  'label' => '<header>',  ],
  [ 'value' => 'footer',  'label' => '<footer>',  ],
  [ 'value' => 'figure',  'label' => '<figure>',  ],
  [ 'value' => 'ul',      'label' => '<ul>',      ],
  [ 'value' => 'ol',      'label' => '<ol>',      ],
  [ 'value' => 'li',      'label' => '<li>',      ],
];

cs_remember( 'options_choices_layout_tags', [
  'choices' => array_merge( $layout_tags , [
    [ 'value' => 'a', 'label' => '<a>' ],
  ])
] );

cs_remember( 'options_choices_layout_tags_no_anchor', [
  'choices' => $layout_tags
] );

cs_remember( 'options_choices_text_tags', [
  'choices' => [
    [ 'value' => 'p',    'label' => '<p>'    ],
    [ 'value' => 'h1',   'label' => '<h1>'   ],
    [ 'value' => 'h2',   'label' => '<h2>'   ],
    [ 'value' => 'h3',   'label' => '<h3>'   ],
    [ 'value' => 'h4',   'label' => '<h4>'   ],
    [ 'value' => 'h5',   'label' => '<h5>'   ],
    [ 'value' => 'h6',   'label' => '<h6>'   ],
    [ 'value' => 'div',  'label' => '<div>'  ],
    [ 'value' => 'span', 'label' => '<span>' ],
  ],
] );

cs_remember( 'options_choices_position', [
  'choices' => [
    [ 'value' => 'static',   'label' => cs_recall( 'label_static' )   ],
    [ 'value' => 'relative', 'label' => cs_recall( 'label_relative' ) ],
    [ 'value' => 'absolute', 'label' => cs_recall( 'label_absolute' ) ],
    [ 'value' => 'fixed',    'label' => cs_recall( 'label_fixed' )    ],
    // [ 'value' => 'sticky',   'label' => cs_recall( 'label_sticky' )   ],
  ],
] );

cs_remember( 'options_choices_border_styles', [
  'choices' => [
    [ 'value' => 'none',   'label' => cs_recall( 'label_none' )   ],
    [ 'value' => 'solid',  'label' => cs_recall( 'label_solid' )  ],
    [ 'value' => 'dotted', 'label' => cs_recall( 'label_dotted' ) ],
    [ 'value' => 'dashed', 'label' => cs_recall( 'label_dashed' ) ],
    [ 'value' => 'double', 'label' => cs_recall( 'label_double' ) ],
    [ 'value' => 'groove', 'label' => cs_recall( 'label_groove' ) ],
    [ 'value' => 'ridge',  'label' => cs_recall( 'label_ridge' )  ],
    [ 'value' => 'inset',  'label' => cs_recall( 'label_inset' )  ],
    [ 'value' => 'outset', 'label' => cs_recall( 'label_outset' ) ],
  ],
] );

cs_remember( 'options_choices_layout_overflow_icons', [
  'choices' => [
    [ 'value' => 'visible', 'icon' => 'ui:visible' ],
    [ 'value' => 'hidden',  'icon' => 'ui:hidden'  ],
  ],
] );

cs_remember( 'options_choices_layout_overflow_labels', [
  'choices' => [
    [ 'value' => 'visible', 'label' => cs_recall( 'label_visible' ) ],
    [ 'value' => 'hidden',  'label' => cs_recall( 'label_hidden' )  ],
  ],
] );

cs_remember( 'options_choices_layout_overflow_labels_bool', [
  'choices' => [
    [ 'value' => false, 'label' => cs_recall( 'label_visible' ) ],
    [ 'value' => true,  'label' => cs_recall( 'label_hidden' )  ],
  ],
] );

cs_remember( 'options_choices_text_overflow_labels_bool', [
  'choices' => [
    [ 'value' => false, 'label' => cs_recall( 'label_normal' )   ],
    [ 'value' => true,  'label' => cs_recall( 'label_ellipsis' ) ],
  ],
] );

cs_remember( 'options_choices_layout_overflow_full_list', [
  'choices' => [
    [ 'value' => 'visible', 'label' => cs_recall( 'label_visible' ) ],
    [ 'value' => 'hidden',  'label' => cs_recall( 'label_hidden' )  ],
    [ 'value' => 'auto',    'label' => cs_recall( 'label_auto' )    ],
    [ 'value' => 'scroll',  'label' => cs_recall( 'label_scroll' )  ],
  ],
] );

cs_remember( 'options_choices_direction_hv', [
  'choices' => [
    [ 'value' => 'horizontal', 'label' => cs_recall( 'label_horizontal' ) ],
    [ 'value' => 'vertical',   'label' => cs_recall( 'label_vertical' )   ],
  ],
] );

cs_remember( 'options_choices_direction_rc', [
  'choices' => [
    [ 'value' => 'row',    'label' => cs_recall( 'label_row' )    ],
    [ 'value' => 'column', 'label' => cs_recall( 'label_column' ) ],
  ],
] );

cs_remember( 'options_choices_before_after', [
  'choices' => [
    [ 'value' => true,  'label' => cs_recall( 'label_before' ) ],
    [ 'value' => false, 'label' => cs_recall( 'label_after' )  ],
  ],
] );

cs_remember( 'options_choices_before_after_inverse', [
  'choices' => [
    [ 'value' => false, 'label' => cs_recall( 'label_before' ) ],
    [ 'value' => true,  'label' => cs_recall( 'label_after' )  ],
  ],
] );

cs_remember( 'options_choices_before_after_strings', [
  'choices' => [
    [ 'value' => 'before', 'label' => cs_recall( 'label_before' ) ],
    [ 'value' => 'after',  'label' => cs_recall( 'label_after' )  ],
  ],
] );

cs_remember( 'options_choices_close_dimensions', [
  'choices' => [
    [ 'value' => '1',   'label' => 'x1'   ],
    [ 'value' => '1.5', 'label' => 'x1.5' ],
    [ 'value' => '2',   'label' => 'x2'   ],
    [ 'value' => '2.5', 'label' => 'x2.5' ],
    [ 'value' => '3',   'label' => 'x3'   ],
  ],
] );

cs_remember( 'options_choices_1_2_3_placement', [
  'choices' => [
    [ 'value' => '1', 'label' => cs_recall( 'label_1st' ) ],
    [ 'value' => '2', 'label' => cs_recall( 'label_2nd' ) ],
    [ 'value' => '3', 'label' => cs_recall( 'label_3rd' ) ],
  ],
] );

cs_remember( 'options_choices_body_scroll', [
  'choices' => [
    [ 'value' => 'allow',   'label' => cs_recall( 'label_allow' )   ],
    [ 'value' => 'disable', 'label' => cs_recall( 'label_disable' ) ],
  ],
] );

cs_remember( 'options_choices_toggle_trigger', [
  'choices' => [
    [ 'value' => 'click', 'label' => cs_recall( 'label_click' ) ],
    [ 'value' => 'hover', 'label' => cs_recall( 'label_hover' ) ],
  ],
] );

cs_remember( 'options_choices_display', [
  'choices' => [
    [ 'value' => 'inline-block', 'label' => cs_recall( 'label_inline_block' ) ],
    [ 'value' => 'block',        'label' => cs_recall( 'label_block' )        ],
  ],
] );

cs_remember( 'options_swatch_label', [
  'label' => cs_recall( 'label_select' ),
] );

cs_remember( 'options_base_interaction_labels', [
  'label'     => cs_recall( 'label_base' ),
  'alt_label' => cs_recall( 'label_interaction' ),
] );

cs_remember( 'options_swatch_base_interaction_labels', [
  'swatch_label' => cs_recall( 'label_select' ),
  'label'        => cs_recall( 'label_base' ),
  'alt_label'    => cs_recall( 'label_interaction' ),
] );

cs_remember( 'options_color_base_interaction_labels', [
  'color' => [
    'label'     => cs_recall( 'label_base' ),
    'alt_label' => cs_recall( 'label_interaction' ),
  ]
] );

cs_remember( 'options_color_swatch_base_interaction_labels', [
  'color' => [
    'swatch_label' => cs_recall( 'label_select' ),
    'label'        => cs_recall( 'label_base' ),
    'alt_label'    => cs_recall( 'label_interaction' ),
  ]
] );

cs_remember( 'options_layout_z_index', [
  'unit_mode'      => 'unitless',
  'valid_keywords' => [ 'auto' ],
  'fallback_value' => 'auto',
] );



// Settings
// =============================================================================

cs_remember( 'settings_anchor:toggle', [
  'type'             => 'toggle',
  'k_pre'            => 'toggle',
  'group'            => 'toggle_anchor',
  'group_title'      => cs_recall( 'label_toggle' ),
  'add_custom_atts'  => true
] );

cs_remember( 'settings_anchor:cart-button', [
  'type'             => 'button',
  'k_pre'            => 'cart',
  'group'            => 'cart_button_anchor',
  'group_title'      => cs_recall( 'label_buttons' ),
  'has_template'     => false,
] );

cs_remember( 'conditions_tbf_detect', [
  'conditions' => [
    [ 'key' => 'legacy_region_detect', 'value' => true ],
    [ 'key' => '_region', 'op' => 'IN', 'value' => [ 'top', 'bottom', 'footer' ] ]
  ]
] );



// Control Group Toggle Values
// =============================================================================

cs_remember( 'options_group_toggle_off_on_bool',          [ 'toggle' => [ 'on' => true, 'off' => false ] ] );
cs_remember( 'options_group_toggle_off_on_string',        [ 'toggle' => [ 'on' => 'on', 'off' => '' ]    ] );
cs_remember( 'options_group_toggle_off_on_bool_string',   [ 'toggle' => [ 'on' => '1', 'off' => '' ]     ] );

cs_remember( 'options_group_checkbox_off_on_bool',        [ 'on' => true, 'off' => false ] );
cs_remember( 'options_group_checkbox_off_on_string',      [ 'on' => 'on', 'off' => ''    ] );
cs_remember( 'options_group_checkbox_off_on_bool_string', [ 'on' => '1',  'off'  => ''   ] );



// UI Column Labels
// =============================================================================

// cs_remember( 'ui_columns_width_and_height_2x', [
//   'type'     => 'group',
//   'label'    => '&nbsp;',
//   'controls' => [
//     [ 'type' => 'label', 'label' => cs_recall( 'label_width' ),  'options' => [ 'columns' => 2 ] ],
//     [ 'type' => 'label', 'label' => cs_recall( 'label_height' ), 'options' => [ 'columns' => 2 ] ],
//   ],
// ] );

// cs_remember( 'ui_columns_width_and_height_3x', [
//   'type'     => 'group',
//   'label'    => '&nbsp;',
//   'controls' => [
//     [ 'type' => 'label', 'label' => cs_recall( 'label_width' ),  'options' => [ 'columns' => 3 ] ],
//     [ 'type' => 'label', 'label' => cs_recall( 'label_height' ), 'options' => [ 'columns' => 3 ] ],
//   ],
// ] );



// Mixins
// =============================================================================

// Layout
// ------

cs_remember( 'control_mixin_gap', [
  'type'    => 'unit-slider',
  'label'   => cs_recall( 'label_gap' ),
  'options' => cs_recall( 'options_gap' ),
] );

cs_remember( 'control_mixin_justify_content', [
  'type'    => 'placement',
  'label'   => cs_recall( 'label_content_x' ),
  'options' => cs_recall( 'options_justify_content_grid' ),
] );

cs_remember( 'control_mixin_align_content', [
  'type'    => 'placement',
  'label'   => cs_recall( 'label_content_y' ),
  'options' => cs_recall( 'options_align_content_grid' ),
] );

cs_remember( 'control_mixin_justify_items', [
  'type'    => 'placement',
  'label'   => cs_recall( 'label_items_x' ),
  'options' => cs_recall( 'options_justify_items_grid' ),
] );

cs_remember( 'control_mixin_align_items', [
  'type'    => 'placement',
  'label'   => cs_recall( 'label_items_y' ),
  'options' => cs_recall( 'options_align_items_grid' ),
] );

cs_remember( 'control_mixin_justify_slide_container_inline', [
  'type'    => 'placement',
  'label'   => cs_recall( 'label_justify' ),
  'options' => cs_recall( 'options_justify_slide_container_inline' ),
] );


// Setup
// -----

cs_remember( 'control_mixin_layout_tag', [
  'type'    => 'select',
  'label'   => cs_recall( 'label_html_tag' ),
  'options' => cs_recall( 'options_choices_layout_tags' ),
] );

cs_remember( 'control_mixin_layout_tag_no_anchor', [
  'type'    => 'select',
  'label'   => cs_recall( 'label_html_tag' ),
  'options' => cs_recall( 'options_choices_layout_tags_no_anchor' ),
] );

cs_remember( 'control_mixin_text_tag', [
  'type'    => 'select',
  'label'   => cs_recall( 'label_html_tag' ),
  'options' => cs_recall( 'options_choices_text_tags' ),
] );

cs_remember( 'control_mixin_overflow', [
  'type'    => 'choose',
  'label'   => cs_recall( 'label_overflow' ),
  'options' => cs_recall( 'options_choices_layout_overflow_labels' ),
] );

cs_remember( 'control_mixin_z_index', [
  'type'    => 'unit',
  'label'   => cs_recall( 'label_z_index' ),
  'options' => cs_recall( 'options_layout_z_index' ),
] );

cs_remember( 'control_mixin_transition', [
  'type'  => 'transition',
  'label' => cs_recall( 'label_transition' ),
] );

cs_remember( 'control_mixin_1_2_3_placement', [
  'type'    => 'choose',
  'label'   => cs_recall( 'label_input_placement' ),
  'options' => cs_recall( 'options_choices_1_2_3_placement' ),
] );

cs_remember( 'control_mixin_direction_hv', [
  'type'    => 'choose',
  'label'   => cs_recall( 'label_direction' ),
  'options' => cs_recall( 'options_choices_direction_hv' ),
] );

cs_remember( 'control_mixin_direction_rc', [
  'type'    => 'choose',
  'label'   => cs_recall( 'label_direction' ),
  'options' => cs_recall( 'options_choices_direction_rc' ),
] );


// Colors and Background
// ---------------------

cs_remember( 'control_mixin_color_solo', [
  'type'  => 'color',
  'label' => cs_recall( 'label_color' ),
] );

cs_remember( 'control_mixin_color_int', [
  'type'    => 'color',
  'label'   => cs_recall( 'label_color' ),
  'options' => cs_recall( 'options_swatch_base_interaction_labels' ),
] );

cs_remember( 'control_mixin_bg_color_solo', [
  'type'  => 'color',
  'label' => cs_recall( 'label_background' ),
] );

cs_remember( 'control_mixin_bg_color_solo_adv', [
  'type'    => 'color',
  'label'   => cs_recall( 'label_background' ),
  'options' => array_merge(
    cs_recall( 'options_swatch_label' ),
    [ 'checkbox_label' => cs_recall( 'label_advanced' )]
  )
] );

cs_remember( 'control_mixin_bg_color_int', [
  'type'    => 'color',
  'label'   => cs_recall( 'label_background' ),
  'options' => cs_recall( 'options_swatch_base_interaction_labels' ),
] );

cs_remember( 'control_mixin_bg_color_int_adv', [
  'type'    => 'color',
  'label'   => cs_recall( 'label_background' ),
  'options' => array_merge(
    cs_recall( 'options_swatch_base_interaction_labels' ),
    [ 'checkbox_label' => cs_recall( 'label_advanced' )]
  )
] );


// Typography
// ----------

cs_remember( 'control_mixin_font_size', [
  'type'    => 'unit-slider',
  'label'   => cs_recall( 'label_font_size' ),
  'options' => cs_recall( 'options_font_size' ),
] );

cs_remember( 'control_mixin_font_style', [
  'type'  => 'font-style',
  'label' => cs_recall( 'label_style' ),
] );

cs_remember( 'control_mixin_letter_spacing', [
  'type'    => 'unit-slider',
  'label'   => cs_recall( 'label_spacing' ),
  'options' => cs_recall( 'options_letter_spacing' ),
] );

cs_remember( 'control_mixin_line_height', [
  'type'    => 'unit-slider',
  'label'   => cs_recall( 'label_height' ),
  'options' => cs_recall( 'options_line_height' ),
] );

cs_remember( 'control_mixin_text_align', [
  'type'  => 'text-align',
  'label' => cs_recall( 'label_align' ),
] );

cs_remember( 'control_mixin_text_overflow', [
  'type'    => 'choose',
  'label'   => cs_recall( 'label_text_overflow' ),
  'options' => cs_recall( 'options_choices_text_overflow_labels_bool' ),
] );

cs_remember( 'control_mixin_text_transform', [
  'type'  => 'text-transform',
  'label' => cs_recall( 'label_transform' ),
] );


// Size
// ----

cs_remember( 'control_mixin_global_container', [
  'type'    => 'choose',
  'label'   => cs_recall( 'label_container' ),
  'options' => cs_recall( 'options_choices_off_on_bool' ),
] );

cs_remember( 'control_mixin_global_container_placeholder_x2', [
  'type'    => 'global-container-placeholder',
  'options' => [ 'height' => 2, 'clickValue' => false ]
] );

cs_remember( 'control_mixin_global_container_placeholder_x3', [
  'type'    => 'global-container-placeholder',
  'options' => [ 'height' => 3, 'clickValue' => false ]
] );

cs_remember( 'control_mixin_width', [
  'type'    => 'unit-slider',
  'label'   => cs_recall( 'label_width' ),
  'options' => cs_recall( 'options_width_and_height' ),
] );

cs_remember( 'control_mixin_min_width', [
  'type'    => 'unit-slider',
  'label'   => cs_recall( 'label_min_width' ),
  'options' => cs_recall( 'options_min_width_and_min_height' ),
] );

cs_remember( 'control_mixin_max_width', [
  'type'    => 'unit-slider',
  'label'   => cs_recall( 'label_max_width' ),
  'options' => cs_recall( 'options_max_width_and_max_height' ),
] );

cs_remember( 'control_mixin_height', [
  'type'    => 'unit-slider',
  'label'   => cs_recall( 'label_height' ),
  'options' => cs_recall( 'options_width_and_height' ),
] );

cs_remember( 'control_mixin_min_height', [
  'type'    => 'unit-slider',
  'label'   => cs_recall( 'label_min_height' ),
  'options' => cs_recall( 'options_min_width_and_min_height' ),
] );

cs_remember( 'control_mixin_max_height', [
  'type'    => 'unit-slider',
  'label'   => cs_recall( 'label_max_height' ),
  'options' => cs_recall( 'options_max_width_and_max_height' ),
] );

cs_remember( 'control_mixin_inset', [
  'type'    => 'unit-slider',
  'options' => cs_recall( 'options_inset' ),
] );
