<?php
/**
 * Single Product tabs
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );
$pdetail_layout = ya_options() -> getCpanelValue('pdetail_layout');
$i = 0;
if ( ! empty( $tabs ) ) : ?>
    <?php if ($pdetail_layout == 'full3') { ?>
          <div class="panel-detail-product" id="paccordion" role="tablist" aria-multiselectable="true">
				<?php foreach ( $tabs as $key => $tab ) : ?>
				  <div class="panel panel-default">
					<div class="panel-heading" role="tab" id="pheading_<?php echo $key ?>">
					  <h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#paccordion" href="#pcollapse_<?php echo $key ?>" aria-expanded="true" aria-controls="pcollapse_<?php echo $key ?>" class="<?php if( $i == 1 ){ echo 'collapsed'; }?>">
						  <?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?>
						</a>
					  </h4>
					</div>
					<div id="pcollapse_<?php echo $key ?>" class="panel-collapse collapse <?php if( $i == 0 ){ echo 'in'; } ?>" role="tabpanel" aria-labelledby="pheading_<?php echo $key ?>">
					  <div class="panel-body">
					   <?php call_user_func( $tab['callback'], $key, $tab ) ?>
					  </div>
					</div>
				  </div>
				  <?php $i++; ?>
				<?php endforeach; ?>
			</div>
    <?php } else { ?>
	<div class="woocommerce-tabs wc-tabs-wrapper">
		<ul class="tabs wc-tabs">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab">
					<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<div class="panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ); ?>
			</div>
		<?php endforeach; ?>
	</div>
	<?php  } ?>
<?php endif; ?>
