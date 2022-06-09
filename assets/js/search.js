jQuery(document).ready(function () {

    jQuery('form[role = "search"]').on('submit', function (e) {
        e.preventDefault();

        /** CHECK IF SEARCH VALUE LENGTH >= 0 */
        if (jQuery(this).find('[name="text_s"]').val().length > 0) {
            var form = jQuery(this);
            let searchValue = form.find('[name = "text_s"]').val();
            let spChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/g;
            if(spChars.test(searchValue)){
                let special_char = searchValue.match(spChars);
                special_char.forEach(element => {
                    searchValue = searchValue.replace(element, "\\"+element);
                })
                    searchValue = encodeURIComponent(searchValue)
            }
            grecaptcha.ready(function () {
                grecaptcha.execute('6LclyM8aAAAAAMttjBLWQ6mu9QQoW9GBACQTaeAE', {action: 'submit'}).then(function (token) {
                    var url = form.attr('action') + '/?text_s=' + searchValue;
                    window.location.href = url;
                })
            });
        } else {
            jQuery(this).find('[name="text_s"]').focus();
        }
    });



})

