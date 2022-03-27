jQuery(document).ready(function () {

    jQuery('form[role = "search"]').on('submit', function (e) {
        e.preventDefault();

        /** CHECK IF SEARCH VALUE LENGTH >= 2 */
        if (jQuery(this).find('[name="text_s"]').val().length > 2) {

            var $form = jQuery(this);
            $searchValue = $form.find('[name = "text_s"]').val();
            grecaptcha.ready(function () {
                grecaptcha.execute('6LclyM8aAAAAAMttjBLWQ6mu9QQoW9GBACQTaeAE', {action: 'submit'}).then(function (token) {
                    var url = $form.attr('action') + '?text_s=' + $searchValue;
                    window.location.href = url;
                });
            });
        } else {
            jQuery(this).find('[name="text_s"]').focus();
        }
    });



})
