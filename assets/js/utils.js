/**
 * Utils file for generic functions
 * */

/** isMobile - check screen width  */
export function isMobile(widthToCompare){
    let currentWidth = jQuery(document).width();
    if(currentWidth <= widthToCompare)
        return true;
}

