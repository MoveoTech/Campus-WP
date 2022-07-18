<?php

$nav_search_placeholder = __('Search Course', 'Catalog_page');
$search_error_message = __('At least 2 characters must be entered', 'Catalog_page');

?>
<form role="search" class="search-form" action="<?= esc_url(home_url('/catalog')); ?>" novalidate>
    <label class="sr-only"><?php _e('Search for:', 'single_corse'); ?></label>
    <div class="input-group group-search-form">
        <input id="header-search-text" type="search" value="<?= get_search_query(); ?>" name="text_s" class="search-field form-control" placeholder="<?= $nav_search_placeholder ?>" aria-required="true">
        <span class="input-group-btn">
      <button type="submit" class="search-submit"><?php _e('Search', 'single_corse'); ?></button>
    </span>
    </div>
    <div style="display: none" class="search-error-message-header"><span><?= $search_error_message ?></span></div>

</form>