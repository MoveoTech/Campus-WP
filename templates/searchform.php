<form role="search" class="search-form" action="<?= esc_url(home_url('/catalog')); ?>" novalidate>
    <label class="sr-only"><?php _e('Search for:', 'single_corse'); ?></label>
    <div class="input-group group-search-form">
        <input type="search" value="<?= get_search_query(); ?>" name="text_s" class="search-field form-control" placeholder="<?php echo new_search_placeholder(); ?>" aria-required="true">
        <span class="input-group-btn">
      <button type="submit" class="search-submit"><?php _e('Search', 'single_corse'); ?></button>
    </span>
    </div>
</form>