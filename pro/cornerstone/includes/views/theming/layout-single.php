<?php

get_header();
do_action('cs_layout_begin');

while ( have_posts() ) : the_post();
  do_action('cs_layout_begin_single');
  do_action('cs_layout');
  do_action('cs_layout_end_single');
endwhile;

if (is_404()) :
  do_action('cs_layout_begin_404');
  do_action('cs_layout');
  do_action('cs_layout_end_404');
endif;

do_action('cs_layout_end');
get_footer();
