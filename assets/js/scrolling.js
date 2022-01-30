function changeMenuOnScrolling(scroll) {
    const headerScroll = document.querySelector('.header_section');
    const searchScroll = document.querySelector('.search-form');
    const menuScroll = document.querySelector('.header_menu');
    const logoItems = document.querySelector('.logo_items');

    if(scroll > 55 ) {
        headerScroll.classList.add('scrolling-header');
        searchScroll.classList.add('scroll-search')
        menuScroll.classList.add('scroll-header_menu')
        logoItems.classList.add('scroll-logo_items')

        const height = (-50 + ((scroll-50) / 8));
        if(height < 0) {
            jQuery('.scrolling-header').css("top", height)
        } else {
            jQuery('.scrolling-header').css("top", 0)
        }
    } else {
        headerScroll.classList.remove('scrolling-header');
        searchScroll.classList.remove('scroll-search')
        menuScroll.classList.remove('scroll-header_menu')
        logoItems.classList.remove('scroll-logo_items')

    }
    if(scroll <= 55) {
        jQuery('.header_section').css("top", "unset")
    }
}
window.onscroll = () => {
    const scroll = window.scrollY;
    const width = window.screen.width
    if(width <= 991) return
    changeMenuOnScrolling(scroll)
}