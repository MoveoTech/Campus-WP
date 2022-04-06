$= jQuery.noConflict();

$(document).ready(function () {
    let params = new URLSearchParams(document.location.search);

    /** Mark selected checkboxes */
    markCheckboxes(params)

    /** Calling events - targeting each checkbox to open & filtering inputs **/
    openCheckboxEvent()

    /** Click event - targeting filters inputs */
    filterByTagEvent()

    /** Click event - reset filtering **/
    $('.resetFilterButton').on('click', function (event) {

        let filtersInputs = $('.checkbox-filter-search');
        filtersInputs.each((index, element) => {
            element.checked = false;
        });
        /** removing extra filters **/
        $('.extraFilter').remove();
    });

    /** Click event - adding more filters **/
    $('.moreFilters .extraFilterCheckbox').on('click', function (event) {

        /**Getting targeted input */
        let filterId = $(event.target).data('value');
        let filterGroupName = event.target.value;
        /** If element checked appending it to menu, else - remove it */
        if(event.target.checked){
            appendGroupFilter(filterGroupName, filterId)
            getFiltersGroups(filterId)
            openCheckboxEvent()
        } else {
            let filterToRemove = document.getElementsByClassName(filterId)[0];
            filterToRemove.remove()
        }
    });

    /** checking screen size for filters menu and slick stripe */
    slickStripeForMobile();
    $(window).resize(function() {
        slickStripeForMobile();
    });

/** Open mobile filters menu */
    $(".openFiltersMenu").click(function () {
        // jQuery(".nav-mobile-campus").toggleClass('open').animate({
        //     width: "toggle"
        // });
        $('.bg-overlay').addClass('filtersMenuOverlay');
        jQuery(".filters-mobile-menu-popup").toggleClass('active');

        if(!jQuery(".bg-overlay")[0].classList.contains('active') && jQuery(".filters-mobile-menu-popup")[0].classList.contains('active')) {
            jQuery(".bg-overlay").addClass('active');
            jQuery(".header_section").addClass('menu-open');

        } else if(!jQuery(".filters-mobile-menu-popup")[0].classList.contains('active')) {
            jQuery(".bg-overlay").removeClass('active');
            jQuery(".header_section").removeClass('menu-open');

        }
        jQuery('html').toggleClass('menu_open');

    });

$(".bg-overlay").click(function () {
    console.log("inside click");
    console.log("clicking overlay");
    $('.bg-overlay').removeClass('filtersMenuOverlay');
    jQuery(".bg-overlay").removeClass('active');
    jQuery(".header_section").removeClass('menu-open');
    jQuery(".filters-mobile-menu-popup").toggleClass('active');

    // jQuery(".filters-mobile-menu-popup").toggleClass('active');
})

});
/** End of ducoment ready */

/** hiding filter inputs when clicking on screen or other filter group */
$(document).click(function(event) {

    let filtergroup = $('.wrapEachFiltergroup');
    let filtersInputs = $(`.inputsContainer`);

    /** hiding input container when clicking on screen */
    if (!filtergroup.is(event.target) && !filtergroup.has(event.target).length && !filtersInputs.is(event.target) && !filtersInputs.has(event.target).length) {
        filtersInputs.hide();
    }

    /** hiding input container when clicking on other filter group */
    if (filtergroup.is(event.target) || filtergroup.has(event.target).length || filtersInputs.is(event.target) || filtersInputs.has(event.target).length) {

        let popupMenuDiv = event.target.closest(".wrapEachFiltergroup").querySelector(".inputsContainer");

        filtersInputs.each((index, element) => {
            if(element !== popupMenuDiv){
                element.style.display = "none";
            }
        })
    }

    // openFiltersMobileMenu();
    //opens filters mobile menu
    // console.log("before unbind", jQuery(".search-button"));
    // jQuery(`.search-button`).unbind('click');
    // console.log("after unbind");


});
/** end of jquery */


function slickStripeForMobile() {
    if($(window).width() <= 768){
        console.log("iffff");
        /** hiding web filters menu */
        // $('.allFiltersWrapDiv').hide();
        // $('.openFiltersMenu').show();

        /** catalog stripe slick */
        let rtl = true;
        let currnetLanguage = $('.catalog-courses-stripe').data('language');
        if(currnetLanguage == 'en'){
            rtl = false;
        }
        jQuery('.catalog-courses-stripe').slick({
            lazyLoad: 'ondemand',
            slidesToShow: 2.5,
            slidesToScroll: 2,
            rtl: rtl,
            arrows: false,
            speed: 1000,
            infinite: false,
            responsive: [
                {
                    breakpoint: 571,
                    settings: {
                        slidesToShow: 2.25,
                        slidesToScroll: 2,
                        arrows: false,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        speed: 100,
                        slidesToShow: 2.15,
                        slidesToScroll: 2,
                        arrows: false,
                    }
                },
            ]
        })
    } else{
        jQuery('.catalog-courses-stripe').slick('unslick');
        // $('.allFiltersWrapDiv').show();
        // $('.openFiltersMenu').hide();
    }


}




//
// function openFiltersMobileMenu() {
//
//
// }

/** Ido made a new function for appending */
function appendFilteredCourses(coursesData) {

    let coursesBox = document.getElementById("coursesBox");
    let output = document.createElement("div");

    output.id = 'coursesBox';
    output.classList.add('row');
    output.classList.add('output-courses');

    coursesData.forEach(item =>{
        let id = item.id;
        let name = item.name;
        let academicInstitution = item.academic_institution ? item.academic_institution : '';
        let tags = getDesktopTags(item.marketing_tags);
        let hoverTags = getHoverTags(item.marketing_tags);
        let image = item.image;
        let duration = item.duration;
        let permalink = item.permalink ? item.permalink : '';
        let url = 'course/' + permalink;
        let haveYoutube = item.haveyoutube;
        let course_attrs = 'col-xs-12 col-md-6 col-xl-4 course-item-with-border';


        let youtube;
        if(haveYoutube) {
             youtube = '<a class="course-item-image has_background_image haveyoutube " data-id="'+ id +'" data-popup aria-pressed="true" aria-haspopup="true" role="button" href="javascript:void(0)" aria-label="'+ name +'" data-classToAdd="course_info_popup" style="background-image: url('+image+')"></a>'
        } else {
             youtube = '<div class="course-item-image has_background_image donthaveyoutube " data-id="'+ id +'"data-classToAdd="course_info_popup" style="background-image: url('+image+')"></div>'
        }
        if(academicInstitution){
            let institution_name = '<p class="course-item-org">'+ academicInstitution +' </p>'
        }

        let temp = document.createElement("div");
        temp.innerHTML =
            '<div class="item_post_type_course course-item '+ course_attrs +'" data-id="'+ id +'">'+
                '<div class="course-item-inner">'+
                    ''+ youtube +''+
                    '<a class="course-item-details" tabindex="0" href="'+ url +'">'+
                        '<h3 class="course-item-title"> '+ name +'</h3>'+
                        '</a></div></div>'




            // '<div class="course-img" style="background-image: url('+image+');">'+
            // '<a href="'+ url +'"></a>'+
            // '<span class="info-button"></span></div>'+
            // '<div class="item-content"">'+
            // '<h3 ><a href="'+ url +'">'+name+'</a></h3>'+
            // '<p >'+academicInstitution+'</p>'+
            // ' </div>'+
            // '<div class=" tags-div">'+tags+ '</div>'+
            // '<div class="course-item-hover '+ id +'">'+
            // '<a href="'+ url +'">'+
            // '<div class="course-img" style="background-image: url('+image+');"></div>'+
            // '<div class="item-content"">'+
            // '<h3 >'+name+'</h3>'+
            // '<p >'+academicInstitution+'</p>'+
            // '</div>'+
            // '<div class=" tags-div">'+ hoverTags +'</div>'+
            // '<div class="course-details">'+
            // '<span>'+ duration +'</span>'+
            // '</div>'+
            // '</a>'+
            // '</div>'+
            // '<div class="course-popup-modal mobile-course-popup'+ id +'">'+
            // '<div class="popup-header">'+
            // '<span class="course-popup-close'+ id +' close">&times;</span>'+
            // '</div>'+
            // '<div class="course-content">'+
            // '<div class="course-img" style="background-image: url('+image+');"></div>'+
            // '<div class="course-details">'+
            // '<div class="course-header"">'+
            // '<h3 ><a href="'+ url +'">'+name+'</a></h3>'+
            // '<p >'+academicInstitution+'</p>'+
            // '</div>'+
            // '<div class="tags-div">'+ hoverTags +'</div>'+
            // '<div class="details">'+
            // '<span>'+ duration +'</span>'+
            // '</div>'+
            // '</div>'+
            // '</div>'+
            // '<div class="popup-footer">'+
            // '<a href="'+ url +'"><span></span></a>'+
            // '</div>'+
            // '</div>';


        output.append(temp)
    });
    coursesBox.replaceWith(output)

}

function appendUrlParams(filters) {

    let currentUrl = window.location.href;
    let resetUrl = currentUrl.split('?')[0]
    let url = new URL(resetUrl);

    if(!filters) {
        window.history.replaceState({}, '', url);
        return;
    }


    if(filters['search']) {
        let i = 0;
        Object.keys(filters['search']).some((k) => {

            if(k == 'tags'){
                Object.keys(filters['search'][k]).some((tag) => {
                    let key = k + '_' + tag;
                    let valuesArray = filters['search'][k][tag];
                    let valuesString = valuesArray.toString();

                    url.searchParams.set(key, valuesString);
                    window.history.pushState({}, '', url);
                    i++
                })
            } else {
                Object.keys(filters['search'][k]).some(() => {

                    let key = k ;
                    let valuesArray = filters['search'][k];
                    let valuesString = valuesArray.toString();

                    url.searchParams.set(key, valuesString);
                    window.history.pushState({}, '', url);

                })
            }
        })
    }
}

function markCheckboxes(params) {
    let entries = params.entries();
    let filterItems = $('.checkbox-filter-search');

    for (let entry of entries) {
        if(entry[0] == 'text_s') {
            $('.search-field').val(entry[1]);
        }

        filterItems.each((index, element) => {
            let id = element.id;
            let type = $(`#${id}`).data('name'); //TODO using for language, certificate, institution.
            let group = $(`#${id}`).data('group'); //TODO using for tags.
            let englishValue = $(`#${id}`).data('value');

            if(entry[0] === type ) {
                let itemValues = entry[1].split(",");

                for(let item of itemValues){
                    if(englishValue === item) {
                        $(`#${id}`).prop('checked', true)
                    }
                }
            }

            if(entry[0].includes('tags_')) {
                let tagsGroup = entry[0].slice(5)

                if(tagsGroup === group) {
                    let itemValues = entry[1].split(",");

                    for(let item of itemValues){
                        if(englishValue === item) {
                            $(`#${id}`).prop('checked', true)
                        }
                    }
                }
            }
        });
    }
}

function haveNoResults() {
    let coursesBox = document.getElementById("coursesBox");
    let output = document.createElement("div");

    output.id = 'coursesBox';
    output.classList.add('row');
    output.classList.add('output-courses');

        let temp = document.createElement("div");
        temp.innerHTML =
            '<div class="no-results">Sorry but there are no search results :(</div>'

        output.append(temp)

    coursesBox.replaceWith(output)
} // TODO build the div of 'no results', needs to be like the template in Courses.php

/** Filtering by tag function of catalog - need to remove  */
function filterByTagEvent(){

    /** removing event from div */
    $(`#groupFiltersContainer .catalogFilters .checkbox-filter-search`).unbind('click');

    /** click event - targeting each input for filtering */
    $('#groupFiltersContainer .catalogFilters .checkbox-filter-search').on('click', function (event) {
        let filterData = {"search": {}};
        let tagArray = {};
        let freeSearchData = [];
        let institutionArray = [];
        let certificateArray = [];
        let languageArray = [];

        /** Getting free search value from url params */
        let params = new URLSearchParams(document.location.search);
        let searchValue = params.get("text_s");
        if(searchValue) freeSearchData.push(searchValue);

        /** Getting array of inputs */
        let filterItems = $('.checkbox-filter-search');

        /** Looping all filter items inputs */
        filterItems.each((index, element) => {
            let id = element.id;
            let type = $(`#${id}`).data('name');
            let group = $(`#${id}`).data('group');
            let englishValue = $(`#${id}`).data('value');

            /** Checking if value is checked */
            if(element.checked) {
                switch (type) {
                    case 'tag':
                        if(tagArray[group]){
                            tagArray[group].push(englishValue);
                        } else {
                            tagArray[group] = [];
                            tagArray[group].push(englishValue);
                        }

                        break;

                    case 'institution':
                        institutionArray.push(englishValue);
                        break;


                    case 'certificate':
                        certificateArray.push(englishValue);
                        break;

                    case 'language':
                        languageArray.push(englishValue);
                        break;
                }
            }
        });

        /** Checking if any filter checked */
        if(Object.keys(tagArray).some(() => { return true; }) || institutionArray.length > 0 || certificateArray.length > 0 || languageArray.length > 0 || Object.keys(freeSearchData).some(() => { return true; })) {

            /** checking which filters checked and pushing each array to object (key and values) */
            if(freeSearchData.length > 0) {
                filterData['search']['text_s'] = freeSearchData;
            }
            if(Object.keys(tagArray).some((k) => { return true; })) {
                filterData['search']['tags'] = tagArray;
            }
            if(institutionArray.length > 0) {
                filterData['search']['institution'] = institutionArray;
            }

            if(certificateArray.length > 0) {
                filterData['search']['certificate'] = certificateArray;
            }
            if(languageArray.length > 0) {
                filterData['search']['language'] = languageArray;
            }

            filterCoursesAjax(filterData)
        } else {
            filterData = [];
            filterCoursesAjax(filterData)
        }

    })}
/** End of function filterByTagEvent */

/** Ajax call - getting filters group name and there tags **/
function getFiltersGroups(filterId) {

    let data = {
        'action': 'add_filters_to_menu',
        'type' : 'moreFilters',
        'dataArray': filterId,
    }
    jQuery.post(add_filters_to_menu_ajax.ajaxurl, data, function(response){
        if(response.success){
            const responseData = JSON.parse(response.data);
            appendMoreFilters(responseData)
            /** Calling event - targeting each filtering inputs **/
            filterByTagEvent()
        }
    })
}

/** Appending filter tags **/
function appendMoreFilters(filterData) {

    /**looping each filter group and appending it to the filters menu */
    let filterId = filterData.filterId;
    let dataType = filterData.dataType;
    let container = document.getElementById(`extraFilter_${filterId}`);
    let groupFilters = filterData.filtersList;
    let currentLanguage =filterData.language;

    groupFilters.forEach(element => {

        let temp = document.createElement("div");
        temp.classList.add('filterInput');
        let id = element.id;
        let name = element.name;
        let urlTitle = element.english_name;
        let checked = '';

        if(element.english_name && currentLanguage == 'en' ) {
            name = element.english_name;
        }
        if(element.arabic_name && currentLanguage == 'ar'){
            name = element.arabic_name;
        }
        temp.innerHTML =
            '<label class="filterTagLabel" for="'+id+'">'+
            '<input'+ checked +' class="checkbox-filter-search" type="checkbox" data-name="'+dataType+'" data-value="'+urlTitle+'" value="'+name+'" id="'+id+'">'+
            '<div class="wrap-term-and-sum tagNameWrap">'+
            '<span class="term-name">'+name+'</span>'+
            '</div>'+
            '</label>';
        container.append(temp);
    })
}

/** ajax call */
function filterCoursesAjax(filterData) {

    let data = {
        'action': 'filter_by_tag',
        'type' : 'courses',
        'lang' : getCookie('openedx-language-preference'),
        'filters': filterData,
    }

    jQuery.post(filter_by_tag_ajax.ajaxurl, data, function(response){
        if(response.success){
            const responseData = JSON.parse(response.data);

            appendUrlParams(responseData['filters'])
            if(responseData['courses'].length > 0) {
                appendFilteredCourses(responseData['courses'])
            } else {
                haveNoResults()
            }
        }
    })
}

/** Appending filter group **/
function appendGroupFilter(filterGroupName, filterId) {

    let vector = $('.filterVector').attr('src');
    let container = document.getElementById('groupFiltersContainer');
    let groupTitle = filterGroupName;
    let addFilterbutton = document.getElementById('morefiltersBox');
    let temp = document.createElement("div");
    temp.classList.add('wrapEachFiltergroup');
    temp.classList.add('extraFilter');
    temp.classList.add(filterId);

    temp.innerHTML =
        '<div class="wrapEachFilterTag">'+
        '<div class="buttonWrap">'+
        '<p id="'+filterId+'" class="filterGroupTitle">'+ groupTitle +' </p>'+
        '<img class="filterVector" src="'+vector+'"/>'+
        '</div>'+
        '</div>'+
        '<div class="inputsContainer catalogFilters" id="extraFilter_'+filterId+'">'+
        '</div>';

    container.insertBefore(temp, addFilterbutton);


}

function openCheckboxEvent() {
    /** removing event from div */
    $(`.wrapEachFiltergroup`).unbind('click');

    /** click event - targeting each checkbox to open */
    $('.wrapEachFiltergroup').on('click', function (event) {

        let popupMenuDiv = event.target.closest(".wrapEachFiltergroup").querySelector(".inputsContainer")
        $(popupMenuDiv).toggle();
    });
}
