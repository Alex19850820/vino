<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'AWS_Admin_Fields' ) ) :

    /**
     * Class for plugin admin ajax hooks
     */
    class AWS_Admin_Fields {

        /**
         * @var AWS_Admin_Fields The array of options that is need to be generated
         */
        private $options_array;

        /**
         * @var AWS_Admin_Fields Current plugin instance options
         */
        private $plugin_options;

        /*
         * Constructor
         */
        public function __construct( $options, $plugin_options ) {

            $this->options_array = $options;
            $this->plugin_options = $plugin_options;

            $this->generate_fields();

        }

        /*
         * Generate options fields
         */
        private function generate_fields() {

            if ( empty( $this->options_array ) ) {
                return;
            }

            $current_section = isset( $_GET['section'] ) ? sanitize_title( $_GET['section'] ) : 0;

            $plugin_options = $this->plugin_options;

            echo '<table class="form-table">';
            echo '<tbody>';

            foreach ( $this->options_array as $k => $value ) {

                if ( isset( $value['depends'] ) && ! $value['depends'] ) {
                    continue;
                }

                if ( ( ! $current_section && isset( $value['section'] ) ) || ( $current_section && ( ! isset( $value['section'] ) || $value['section'] !== $current_section ) ) ) {
                    continue;
                }

                if ( $current_section ) {
                    echo '<a class="button aws-back-to-filters" href="' . AWS_Helpers::get_settings_instance_page_url() . '" title="' . __( 'Back to filter settings', 'aws' ) . '">' . __( 'Back to filter settings', 'aws' ) . '</a>';
                }

                switch ( $value['type'] ) {

                    case 'text': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo $value['name']; ?></th>
                            <td>
                                <input type="text" name="<?php echo $value['id']; ?>" class="regular-text" value="<?php echo stripslashes( $plugin_options[ $value['id'] ] ); ?>">
                                <br><span class="description"><?php echo $value['desc']; ?></span>
                            </td>
                        </tr>
                        <?php break;

                    case 'image': ?>

                        <tr valign="top">
                            <th scope="row"><?php echo $value['name']; ?></th>
                            <td>
                                <img class="image-preview" src="<?php echo stripslashes( $plugin_options[ $value['id'] ] ); ?>"  />
                                <input type="hidden" size="40" name="<?php echo $value['id']; ?>" class="image-hidden-input" value="<?php echo stripslashes( $plugin_options[ $value['id'] ] ); ?>" />
                                <input class="button image-upload-btn" type="button" value="Upload Image" data-size="<?php echo $value['size']; ?>" />
                                <input class="button image-remove-btn" type="button" value="Remove Image" />
                            </td>
                        </tr>

                        <?php

                        break;

                    case 'number': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo $value['name']; ?></th>
                            <td>
                                <input type="number" name="<?php echo $value['id']; ?>" class="regular-text" value="<?php echo stripslashes( $plugin_options[ $value['id'] ] ); ?>">
                                <br><span class="description"><?php echo $value['desc']; ?></span>
                            </td>
                        </tr>
                        <?php break;

                    case 'textarea': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo $value['name']; ?></th>
                            <td>
                                <textarea id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>" cols="65" rows="3"><?php print stripslashes( $plugin_options[ $value['id'] ] ); ?></textarea>
                                <br><span class="description"><?php echo $value['desc']; ?></span>
                            </td>
                        </tr>
                        <?php break;

                    case 'checkbox': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo $value['name']; ?></th>
                            <td>
                                <?php $checkbox_options = $plugin_options[ $value['id'] ]; ?>
                                <?php foreach ( $value['choices'] as $val => $label ) { ?>
                                    <input type="checkbox" name="<?php echo $value['id'] . '[' . $val . ']'; ?>" id="<?php echo $value['id'] . '_' . $val; ?>" value="1" <?php checked( $checkbox_options[$val], '1' ); ?>> <label for="<?php echo $value['id'] . '_' . $val; ?>"><?php echo $label; ?></label><br>
                                <?php } ?>
                                <br><span class="description"><?php echo $value['desc']; ?></span>
                            </td>
                        </tr>
                        <?php break;

                    case 'radio': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo $value['name']; ?></th>
                            <td>
                                <?php foreach ( $value['choices'] as $val => $label ) { ?>
                                    <input class="radio" type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id'].$val; ?>" value="<?php echo $val; ?>" <?php checked( $plugin_options[ $value['id'] ], $val ); ?>> <label for="<?php echo $value['id'].$val; ?>"><?php echo $label; ?></label><br>
                                <?php } ?>
                                <br><span class="description"><?php echo $value['desc']; ?></span>
                            </td>
                        </tr>
                        <?php break;

                    case 'radio-image': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo $value['name']; ?></th>
                            <td>
                                <ul class="img-select">
                                    <?php foreach ( $value['choices'] as $val => $img ) { ?>
                                        <li class="option">
                                            <input class="radio" type="radio" name="<?php echo $value['id']; ?>" id="<?php echo $value['id'].$val; ?>" value="<?php echo $val; ?>" <?php checked( $plugin_options[ $value['id'] ], $val ); ?>>
                                            <span class="ico" style="background: url('<?php echo AWS_PRO_URL . '/assets/img/' . $img; ?>') no-repeat 50% 50%;"></span>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <br><span class="description"><?php echo $value['desc']; ?></span>
                            </td>
                        </tr>
                        <?php break;

                    case 'select': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo $value['name']; ?></th>
                            <td>
                                <select name="<?php echo $value['id']; ?>">
                                    <?php foreach ( $value['choices'] as $val => $label ) { ?>
                                        <option value="<?php echo $val; ?>" <?php selected( $plugin_options[ $value['id'] ], $val ); ?>><?php echo $label; ?></option>
                                    <?php } ?>
                                </select>
                                <br><span class="description"><?php echo $value['desc']; ?></span>
                            </td>
                        </tr>
                        <?php break;

                    case 'select_advanced': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo $value['name']; ?></th>
                            <td>
                                <select name="<?php echo $value['id'].'[]'; ?>" multiple class="chosen-select">
                                    <?php $values = $plugin_options[ $value['id'] ]; ?>
                                    <?php foreach ( $value['choices'] as $val => $label ) {  ?>
                                        <?php $selected = ( is_array( $values ) && in_array( $val, $values ) ) ? ' selected="selected" ' : ''; ?>
                                        <option value="<?php echo $val; ?>"<?php echo $selected; ?>><?php echo $label; ?></option>
                                    <?php } ?>
                                </select>
                                <br><span class="description"><?php echo $value['desc']; ?></span>

                            </td>
                        </tr>
                        <?php break;

                    case 'sortable': ?>
                        <tr valign="top">
                            <th scope="row"><?php echo $value['name']; ?></th>
                            <td>

                                <script>
                                    jQuery(document).ready(function() {

                                        jQuery( "#<?php echo $value['id']; ?>1, #<?php echo $value['id']; ?>2" ).sortable({
                                            connectWith: ".connectedSortable",
                                            placeholder: "highlight",
                                            update: function(event, ui){
                                                var serviceList = '';
                                                jQuery("#<?php echo $value['id']; ?>2 li").each(function(){

                                                    serviceList = serviceList + ',' + jQuery(this).attr('id');

                                                });
                                                var serviceListOut = serviceList.substring(1);
                                                jQuery('#<?php echo $value['id']; ?>').attr('value', serviceListOut);
                                            }
                                        }).disableSelection();

                                    })
                                </script>

                                <span class="description"><?php echo $value['desc']; ?></span><br><br>

                                <?php
                                $all_buttons = $value['choices'];
                                $active_buttons = explode( ',', $plugin_options[ $value['id'] ] );
                                $active_buttons_array = array();

                                if ( count( $active_buttons ) > 0 ) {
                                    foreach ($active_buttons as $button) {
                                        $active_buttons_array[$button] = $all_buttons[$button];
                                    }
                                }

                                $inactive_buttons = array_diff($all_buttons, $active_buttons_array);
                                ?>

                                <div class="sortable-container">

                                    <div class="sortable-title">
                                        <?php _e( 'Active sources', 'aws' ) ?><br>
                                        <?php _e( 'Change order by drag&drop', 'aws' ) ?>
                                    </div>

                                    <ul id="<?php echo $value['id']; ?>2" class="sti-sortable enabled connectedSortable">
                                        <?php
                                        if ( count( $active_buttons_array ) > 0 ) {
                                            foreach ($active_buttons_array as $button_value => $button) {
                                                if ( ! $button ) continue;
                                                echo '<li id="' . $button_value . '" class="sti-btn sti-' . $button_value . '-btn">' . $button . '</li>';
                                            }
                                        }
                                        ?>
                                    </ul>

                                </div>

                                <div class="sortable-container">

                                    <div class="sortable-title">
                                        <?php _e( 'Deactivated sources', 'aws' ) ?><br>
                                        <?php _e( 'Excluded from search results', 'aws' ) ?>
                                    </div>

                                    <ul id="<?php echo $value['id']; ?>1" class="sti-sortable disabled connectedSortable">
                                        <?php
                                        if ( count( $inactive_buttons ) > 0 ) {
                                            foreach ($inactive_buttons as $button_value => $button) {
                                                echo '<li id="' . $button_value . '" class="sti-btn sti-' . $button_value . '-btn">' . $button . '</li>';
                                            }
                                        }
                                        ?>
                                    </ul>

                                </div>

                                <input type="hidden" id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>" value="<?php echo $plugin_options[ $value['id'] ]; ?>" />

                            </td>
                        </tr>
                        <?php break;

                    case 'table': ?>

                        <tr valign="top">

                            <th scope="row"><?php echo $value['name']; ?></th>

                            <td>

                                <span class="description"><?php echo $value['desc']; ?></span><br><br>

                                <table class="aws-table aws-table-sources widefat" cellspacing="0">

                                    <thead>
                                        <tr>
                                            <th class="aws-name"><?php echo __( 'Search Source', 'aws' ); ?></th>
                                            <th class="aws-actions"></th>
                                            <th class="aws-active"></th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php $table_options = $plugin_options[ $value['id'] ]; ?>

                                        <?php if ( is_array( $table_options ) ) { ?>

                                            <?php foreach ( $value['choices'] as $val => $label ) { ?>
                                                <?php $active_class = isset( $table_options[$val] ) && $table_options[$val] ? 'active' : ''; ?>

                                                <tr>
                                                    <td class="aws-name"><?php echo $label; ?></td>
                                                    <td class="aws-actions">
                                                        <?php if ( $val === 'attr' || $val === 'tax' || $val === 'meta' ): ?>
                                                            <a class="button alignright tips edit" title="Edit" href="<?php echo AWS_Helpers::get_settings_instance_page_url('&section=' . $val); ?>"><?php echo __( 'Edit', 'aws' ); ?></a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="aws-active <?php echo $active_class; ?>">
                                                        <span data-change-state="1" data-setting="<?php echo $value['id']; ?>" data-name="<?php echo $val; ?>" class="aws-yes" title="Disable this source">Yes</span>
                                                        <span data-change-state="0" data-setting="<?php echo $value['id']; ?>" data-name="<?php echo $val; ?>" class="aws-no" title="Enable this source">No</span>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        <?php } ?>

                                    </tbody>

                                </table>

                            </td>

                        </tr>

                        <?php break;

                    case 'heading': ?>
                        <tr valign="top">
                            <th scope="row"><h3><?php echo $value['name']; ?></h3></th>
                        </tr>
                        <?php break;
                }

            }

            echo '</tbody>';
            echo '</table>';

            if ( ! $current_section ) {
                echo '<p class="submit"><input name="Submit" type="submit" class="button-primary" value="' . __( 'Save Changes', 'aws' ) . '" /></p>';
            }

        }

    }

endif;
