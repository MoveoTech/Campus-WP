$= jQuery.noConflict();

$(document).ready(function () {

    let params = new URLSearchParams(document.location.search);

    /** Mark selected checkboxes */
    markCheckboxes(params)

    /** Calling events - targeting each checkbox to open & filtering inputs **/
    openCheckboxEvent();

    /** Click event - targeting tags filters on mobile filters menu */
    filterByTagMobile();

    /** Click event - targeting filters inputs */
    filterByTagEvent();


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

    /** checking screen size for web or mobile menu */
    slickStripeForMobile();
    $(window).resize(function() {
        slickStripeForMobile();
    });

/** Open mobile filters menu */
    $(".openFiltersMenu").click(function () {
        /** Open mobile menu popup */
        jQuery(".filters-mobile-menu-popup").toggleClass('active');
        if(!jQuery(".bg-overlay")[0].classList.contains('active') && jQuery(".filters-mobile-menu-popup")[0].classList.contains('active')) {
            jQuery(".bg-overlay").addClass('active');
            jQuery(".bg-overlay").addClass('filterMenuOverlay');
            jQuery(".header_section").addClass('menu-open');
        } else if(!jQuery(".filters-mobile-menu-popup")[0].classList.contains('active')) {
            jQuery(".bg-overlay").removeClass('active');
            jQuery(".header_section").removeClass('menu-open');

        }
        jQuery('html').toggleClass('menu_open');
    });

$(".bg-overlay").click(function () {
    closingOverlay()
})

});
/** End of document ready */

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
if(filtersInputs.is(event.target) || filtersInputs.has(event.target).length){
    popupMenuDiv.style.display = "none";
}
        filtersInputs.each((index, element) => {
            if(element !== popupMenuDiv){
                element.style.display = "none";
            }
        })
    }
});
/** end of jquery */


function closingOverlay(){
    jQuery(".bg-overlay").removeClass('active');
    jQuery(".bg-overlay").removeClass('filterMenuOverlay');
    jQuery(".header_section").removeClass('menu-open');
    jQuery(".filters-mobile-menu-popup").removeClass('active');
    jQuery(".mobile-menu-popup").removeClass('active');
    jQuery('html').toggleClass('menu_open');
}

function slickStripeForMobile() {
    if($(window).width() <= 768){
        /** catalog stripe slick for mobile*/
        let rtl = true;
        let currnetLanguage = $('.catalog-courses-stripe').data('language');
        if(currnetLanguage == 'en'){
            rtl = false;
        }
        jQuery('.catalog-courses-stripe').slick({
            lazyLoad: 'ondemand',
            slidesToShow: 3,
            slidesToScroll: 2,
            rtl: rtl,
            arrows: false,
            speed: 1000,
            infinite: false,
            responsive: [
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: 2.5,
                        slidesToScroll: 2,
                        arrows: false,
                    }
                },
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
        /** Changing classes in filters menu inputs */
        $('.checkbox-filter-search').removeClass('filtersInputWeb');
        $('.checkbox-filter-search').addClass('.checkboxFilterMobile');


    } else if (jQuery('.catalog-courses-stripe').slick()){
        jQuery('.catalog-courses-stripe').slick('unslick');
    }


}




function appendFilteredCourses(coursesData) {

    let coursesBox = document.getElementById("coursesBox");
    let output = document.createElement("div");

    output.id = 'coursesBox';
    output.classList.add('row');
    output.classList.add('output-courses');
    output.classList.add('coursesResults');

    coursesData.forEach(item =>{
        let id = item.id;
        let name = item.name;
        let academicInstitution = item.academic_institution ? item.academic_institution : '';
        let tags = getCourseResultTags(item.marketing_tags);
        let image = item.image;
        let duration = item.duration;
        let permalink = item.permalink ? item.permalink : '';
        let url = 'course/' + permalink;
        let institutionName = '';
        if(academicInstitution){
            institutionName = '<p class="institutionName">'+ academicInstitution +' </p>'
        }
        let temp = document.createElement("div");
        temp.classList.add('courseResultCard');
        temp.setAttribute('data-id',id);
        temp.innerHTML =
            '<div class="courseImage" style="background-image: url('+image+');">'+
            '<a href="'+ url +'"></a>'+
            '</div>'+
            '<div class="itemContent">'+
            '<h3 ><a href="'+ url +'">'+name+'</a></h3>'
            +institutionName+
            '<div class="tagsDiv">'+tags+ '</div>'+
            '<p class="courseDuration">'+duration+ '</p>'+
            '</div>'

        output.append(temp)
    });
    coursesBox.replaceWith(output)

}


function getCourseResultTags(tags) {
    let tagsHtml = '';
    tags.forEach((item, index) => {
        if(index > 4){
            return;
        }
        tagsHtml = tagsHtml+"<span class='courseTag'><p>"+item+"</p></span>";
    })
    return tagsHtml;
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
    $(`.filtersSection .filtersInputWeb`).unbind('click');

    /** click event - targeting each input for filtering */
    $('.filtersSection .filtersInputWeb').on('click', function (event) {

if($(event.target).hasClass("extraFilterCheckbox")){
    return;
}

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


/** filterByTagMobile function of catalog  */
function filterByTagMobile(){

    /** removing event from div */
    $(`.filterButtonMobileMenu`).unbind('click');

    /** click event - targeting each input for filtering */
    $('.filterButtonMobileMenu').on('click', function (event) {

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
            filterCoursesAjax(filterData);
            closingOverlay();
        } else {
            filterData = [];
            filterCoursesAjax(filterData);
            closingOverlay();
        }
    })}
/** End of function filterByTagMobile */

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
            appendMoreFilters(responseData);

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
        let popupMenuDiv = event.target.closest(".wrapEachFiltergroup").querySelector(".inputsContainer");
        $(popupMenuDiv).toggle();
        rotateVectorFilterGroup();
    });
}

function rotateVectorFilterGroup(){
    if($(window).width() <= 768){
        let buttontag = $(event.target).closest('.wrapEachFilterTag').children().children(".filterVectorMobile")[0];
        $(buttontag).toggleClass("vectorUp"); // TODO changing toggle to remove and add class with if and calling the function in al the relevant events

    }
}