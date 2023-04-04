<?php

/**
 * Can be modifed via this filter: cornerstone_keybindings
 *
 * For single keys, you can add a prefix to ensure a behavior
 * keydown:
 * keyup:
 *
 * Be careful. Everything is bound as "Global" meaning it will take
 * effect even is a user is working in a textarea or text input.
 */

return apply_filters('cornerstone_keybindings', array(
  'save'                   => array( 'mod+s',        __( 'Save', 'cornerstone' ) ),
  'undo'                   => array( 'mod+z',        __( 'Undo Element Change', 'cornerstone' ) ),
  'redo'                   => array( 'mod+shift+z',  __( 'Redo Element Change', 'cornerstone' ) ),
  'delete'                 => array( 'delete',       __( 'Delete Element', 'cornerstone' ) ),
  'duplicate'              => array( 'mod+d',        __( 'Duplicate Element', 'cornerstone' ) ),
  'copy'                   => array( 'mod+c',        __( 'Copy Element', 'cornerstone' ) ),
  'paste'                  => array( 'mod+v',        __( 'Paste Element', 'cornerstone' ) ),
  'paste-style'            => array( 'mod+shift+v',  __( 'Paste Element Style', 'cornerstone' ) ),
  'find'                   => array( 'mod+f',        __( 'Find (focus available search)', 'cornerstone' ) ),
  'toggle-full-collapse'   => array( 'mod+shift+a',  __( 'Hide/Show Workspace', 'cornerstone' ) ),
  'toggle-elements'        => array( 'mod+shift+e',  __( 'Toggle Elements Library', 'cornerstone' ) ),
  'esc'                    => array( 'esc',          __( 'Close Open Window', 'cornerstone' ) ),
  'nav-builder-outline'    => array( 'mod+option+1', __( 'Outline', 'cornerstone' ) ),
  'nav-builder-inspector'  => array( 'mod+option+2', __( 'Inspector', 'cornerstone' ) ),
  'nav-builder-settings'   => array( 'mod+option+3', __( 'Settings', 'cornerstone' ) ),
  'nav-theme-options'      => array( 'mod+option+4', __( 'Theme Options', 'cornerstone' ) ),
  'goto-headers'           => array( 'mod+option+h', __( 'Open Headers', 'cornerstone' ) ),
  'goto-content'           => array( 'mod+option+c', __( 'Open Content', 'cornerstone' ) ),
  'goto-footers'           => array( 'mod+option+f', __( 'Open Footers', 'cornerstone' ) ),
  'goto-layouts'           => array( 'mod+option+l', __( 'Open Layouts', 'cornerstone' ) ),
  'goto-global-blocks'     => array( 'mod+option+g', __( 'Open Global Blocks', 'cornerstone' ) ),
  'goto-fonts'             => array( 'mod+option+t', __( 'Open Fonts ', 'cornerstone' ) ),
  'goto-colors'            => array( 'mod+option+k', __( 'Open Colors ', 'cornerstone' ) ),
) );