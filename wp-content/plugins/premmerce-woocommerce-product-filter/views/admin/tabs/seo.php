<?php

if ( ! defined('ABSPATH')) {
    exit;
}

$generateUrl = menu_page_url('premmerce-filter-admin', false) . '&tab=seo&action=generate_rules';
$updateUrl   = menu_page_url('premmerce-filter-admin', false) . '&tab=seo&action=update_paths';

/** @var \Premmerce\Filter\Seo\RulesTable $rulesTable */
?>
<div class="pf-wrap-flex">
    <div id="" class="pf-wrap-flex__col">
        <a type="button" class="button" href="<?php echo $generateUrl ?>">
            <?php _e('Generate Rules', 'premmerce-filter') ?>
        </a>
        <a type="button" class="button" href="<?php echo $updateUrl ?>">
            <?php _e('Update paths', 'premmerce-filter') ?>
        </a>
        <div class="col-wrap">
            <?php include __DIR__ . '/../seo/form.php' ?>
        </div>
    </div>

    <div class="pf-wrap-flex__col">
        <div class="col-wrap pf-rules-table">
            <form method="GET" class="search-form wp-clearfix">
                <?php $rulesTable->search_box(__('Search', 'premmerce-filter'), 'search'); ?>
                <input type="hidden" name="page" value="<?php echo $_GET['page'] ?>">
                <input type="hidden" name="tab" value="<?php echo $_GET['tab'] ?>">
            </form>
            <form method="GET">
                <input type="hidden" name="page" value="<?php echo $_GET['page'] ?>">
                <input type="hidden" name="tab" value="<?php echo $_GET['tab'] ?>">
                <?php $rulesTable->display(); ?>
            </form>
        </div>
    </div>
</div>