/**
 * Utils file for generic functions
 * */

/** isMobile - check if screen width is equal to or smaller then 768  */
function isMobile(){
    let width = jQuery(document).width();
        return width <= 768;
}

/** isTablet - check if screen width is smaller then 992 */
function isTablet(){
    let width = jQuery(document).width();
    return width < 992;
}

window.campusUtils = {
    isMobile,
    isTablet
}

