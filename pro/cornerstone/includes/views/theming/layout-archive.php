<?php

get_header();
do_action('cs_layout_begin');
do_action('cs_layout_begin_archive');
do_action('cs_layout');
do_action('cs_layout_end_archive');
do_action('cs_layout_end');
get_footer();
