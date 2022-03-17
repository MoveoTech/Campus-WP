jQuery(document).ready(function () {

    jQuery('form[role = "search"]').on('submit', function (e) {
        e.preventDefault();
        if (jQuery(this).find('[name="s"]').val()) {
            var $form = jQuery(this);
            $validUrl = $form.find('[name = "s"]').val();
            if($validUrl.length < 2) return;
            grecaptcha.ready(function () {
                grecaptcha.execute('6LclyM8aAAAAAMttjBLWQ6mu9QQoW9GBACQTaeAE', {action: 'submit'}).then(function (token) {
                    var url = $form.attr('action') + '?s=' + $validUrl;
                    window.location.href = url;
                });
            });
        } else {
            jQuery(this).find('[name="s"]').focus();

        }
    });

})

