
jQuery(document).ready(function() {

    jQuery('body').on('change', '.campus_manual_order_filter_tax select', function(e){
        var data = {
            'action' : 'admin_acf_manual_order_filter',
            'type' : jQuery(this).closest('[data-layout="automatic_order"]').length > 0 ? 'auto' : 'manual',
            'tax' : jQuery(this).val()
        },
        $this = jQuery(this),
        $parent = $this.closest('.acf-field'),
        current_val = $parent.siblings('.campus_order_filter_items').find('.acf-input-wrap [type = "text"]').val(),
        confirmed = false;

        if(current_val)
            confirmed = confirm('Your current list for this category will be deleted. Do you want to continue?');

        if(!current_val || confirmed) {
            jQuery('body').addClass('campus_admin_loading');
            jQuery.ajax({
                url: admin_vars.admin_ajax,
                data: data,
                method: 'POST',
            }).done(function (html) {
                jQuery('body').removeClass('campus_admin_loading');
                $parent.siblings('.campus_order_filter_items').find('.acf_terms_list_wrap').html(html);
                campus_admin_refresh_field($parent.siblings('.campus_order_filter_items'));
            });
        }else
            if(!confirmed) {
                var tax = $parent.siblings('.campus_order_filter_items').find('select').attr('data-tax');
                jQuery(this).val(tax);
            }
    });

    jQuery('body').on('change', '.campus_manual_order_filter_items select', function(){
        var $parent = jQuery(this).closest('.acf_terms_list_wrap');
        campus_admin_refresh_field($parent);
        if(jQuery(this).closest('.acf_terms_list_each').is(':last-child'))
            campus_admin_add_select_wrap(jQuery(this));

    });
    jQuery('body').on('change', '.admin_acf_auto_order_select', function(){
        var $this = jQuery(this);
        var items = [];
        if($this.val().length > 0) {
            jQuery.each($this.val(), function (key, val) {
                items.push(val);
            });
            var tax = $this.attr('data-tax');
            var json = JSON.stringify({tax: tax, items: items});
            $this.closest('.acf-field').find('[type = "text"]').val(json);
        }else{
            $this.closest('.acf-field').find('[type = "text"]').val('');
        }
    });
    jQuery('body').on('click', '.acf_terms_list_add', function(){
        campus_admin_add_select_wrap(jQuery(this));
    });
    jQuery('body').on('click', '.acf_terms_list_remove', function(){
        var $parent = jQuery(this).closest('.acf_terms_list_wrap'),
        $this = jQuery(this).closest('.acf_terms_list_each');
        $this.remove();

        campus_admin_refresh_field($parent);
        campus_admin_order_btns_disabled($parent);
    });
    jQuery('body').on('click', '.acf_terms_list_reorder_before', function(){
        var $parent = jQuery(this).closest('.acf_terms_list_each');
        $parent.insertBefore($parent.prev());

        campus_admin_refresh_field(jQuery(this).closest('.acf_terms_list_wrap'));
        campus_admin_order_btns_disabled(jQuery(this).closest('.acf_terms_list_wrap'));
    });

    jQuery('body').on('click', '.acf_terms_list_reorder_after', function(){
        var $parent = jQuery(this).closest('.acf_terms_list_each');
        $parent.insertAfter($parent.next());

        campus_admin_refresh_field(jQuery(this).closest('.acf_terms_list_wrap'));
        campus_admin_order_btns_disabled(jQuery(this).closest('.acf_terms_list_wrap'));
    });

});
function campus_admin_add_select_wrap($this){
    var $clone = $this.closest('.acf_terms_list_each').clone();
    $clone.find('select').val('');
    jQuery($clone).insertAfter($this.closest('.acf_terms_list_each'));

    campus_admin_order_btns_disabled($this.closest('.acf_terms_list_wrap'));
}

function campus_admin_refresh_field($field) {
    var items = [];
    if ($field.find('.acf_terms_list_each').length > 1 || $field.find('.acf_terms_list_each select').val()) {
        $field.find('.acf_terms_list_each').each(function () {
            var val = jQuery(this).find('select').val();
            if (val) {
                items.push(val);
            }
        });
    }else{
        items.push('');
    }
    var tax = $field.find('select').attr('data-tax');
    var json = JSON.stringify({tax: tax, items: items});
    $field.closest('.acf-field').find('[type = "text"]').val(json);
}
function campus_admin_order_btns_disabled($field){
    $field.find('.acf_terms_list_reorder_before, .acf_terms_list_reorder_after').prop('disabled', false);
    $field.find('.acf_terms_list_each').first().find('.acf_terms_list_reorder_before').prop('disabled', true);
    $field.find('.acf_terms_list_each').last().find('.acf_terms_list_reorder_after').prop('disabled', true);
    if($field.find('.acf_terms_list_each').length == 1)
        $field.find('.acf_terms_list_each').find('.acf_terms_list_remove').prop('disabled', true);
    else
        $field.find('.acf_terms_list_each').find('.acf_terms_list_remove').prop('disabled', false);


}