jQuery(document).ready(function () {
    const menu = document.querySelector('.menu-user-menu-container');
    const lang_menu = document.querySelector('.secondary-lang-menu');

    jQuery('.user-information').click(function() {
        menu.classList.toggle('active');
        if(lang_menu.classList.contains('active')) {
            lang_menu.classList.toggle('active')
            jQuery('.change-lang-menu').toggleClass('active')
        }
    })

    jQuery('.change-lang-menu').hover(function() {
        jQuery('.secondary-lang-menu').toggleClass('active')
        jQuery('.change-lang-menu').toggleClass('active')
    })

    jQuery(window).click(function(event) {
        console.log(event.target)
        if(event.target.parentElement.classList.contains('user-information')) return // click on user button
        if(event.target.parentElement.classList.contains('nav-user')) return // click on user-menu
        if(event.target.parentElement.classList.contains('a-link')) return // click on user-menu
        if(event.target.classList.contains('list-item-content')) return // click on list-item
        if(menu.classList.contains("active") && !event.target.classList.contains('user-information')) {
            menu.classList.toggle('active');
        }

    });

    jQuery('.change-mobile-lang').click(function() {
        jQuery('.secondary-mobile-lang-menu').toggleClass('active')
        jQuery('.mobile-menu-vector').toggleClass('active')
        jQuery('.change-mobile-lang').toggleClass('active')
    })

})