/**
 * Utils file for generic functions
 * */

/** isMobile - check if screen width is equal to or smaller then 768  */
export function isMobile(){
    let width = jQuery(document).width();
        return width <= 768;
}

/** isTablet - check if screen width is smaller then 992 */
export function isTablet(){
    let width = jQuery(document).width();
    return width < 992;
}

export {isMobile,isTablet };

