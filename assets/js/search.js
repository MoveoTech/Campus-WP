jQuery(document).ready(function () {

    jQuery('form[role = "search"]').on('submit', function (e) {
        e.preventDefault();

        /** CHECK IF SEARCH VALUE LENGTH >= 2 */
        if (jQuery(this).find('[name="text_s"]').val().length >= 2) {
            const currentLang = getCookie('openedx-language-preference') ? getCookie('openedx-language-preference') : getCookie('wp-wpml_current_language');
            let lang = getFieldByLanguage('Hebrew','English','Arabic', currentLang);
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
                    var url = form.attr('action') + '/?language=' + lang + '&text_s=' + searchValue;
                    window.location.href = url;
                })
            });
        } else {
            jQuery(this).find('[name="text_s"]').focus();
            console.log(jQuery(this).is(jQuery('.hero-search-form')))
            if(jQuery(this).is(jQuery('.hero-search-form'))) {
                jQuery('.search-error-message').show()
            } else if(jQuery(this).is(jQuery('.search-form'))) {
                jQuery('.search-error-message-header').show()
            }
        }
    });



})

