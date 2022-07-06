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

        jQuery(".filterVectorMobile").removeClass('active');
        let currentUrl = window.location.href;
        let resetUrl = currentUrl.split('?')[0]
        let url = new URL(resetUrl);
        window.history.replaceState({}, '', url);

        let filtersInputs = $('.checkbox-filter-search');
        filtersInputs.each((index, element) => {
            element.checked = false;
        });
        /** Clear search input fields */
        $('.search-field').val('');

        /** Get the initial courses */
        if(currentUrl.includes('?')){
            getCourses()
        }
        /** removing extra filters **/
        $('.extraFilter').remove();
        $('#morefiltersBox .filterInput').show()
        $('#morefiltersBox').show()

        /** deleting ids from hidden div **/
        const coursesContainer = $('#catalog_courses');
        coursesContainer.attr("data-value","");

    });

    /** Click event - adding more filters **/
    $('.moreFilters .extraFilterCheckbox').on('click', function (event) {
        /**Getting targeted input */
        let filterId = $(event.target).data('value');
        let filterGroupName = event.target.value;
        /** If element checked appending it to menu*/
        if(event.target.checked){
            appendGroupFilter(filterGroupName, filterId);
            getFiltersGroups(filterId);
            openCheckboxEvent();
            $(event.target.parentElement.parentElement).hide()
            let filtersLength = $('#morefiltersBox .inputsContainer').children().length;
            let count = 0;
            $('#morefiltersBox .inputsContainer').children().each((index, element) => {
                count += element.style.display === "none" ? 1 : 0;
            })
            if(count === filtersLength) {
                $('#morefiltersBox').hide()
            }
        }
    });

    /** Click event - open 'sort by' menu **/
    $('#sortByButton').on('click', function (event) {
        $('#sortByOptions').toggleClass('active');
    });

    /** Click event - sort by courses **/
    $('.sortOption').on('click', function (event) {
        const sortType = event.target.id;
        const sortingValue = event.target.innerText;
        const sortByText = $('#sortByText');
        const coursesContainer = $('#catalog_courses').data('value');
        const idsArray = coursesContainer.split(",");
        if(coursesContainer.length > 0) {
            /** targeting input to color the selected value  */
            $('.sortOption').removeClass('active');
            $(event.target).addClass('active');
            /** changing button text to the selected value */
            sortByText.text(sortingValue);
            sortByAjax(idsArray,sortType);
        }
    })

    /** checking screen size for web or mobile menu */
    slickStripeForMobile();
    $(window).resize(function() {
        slickStripeForMobile();
    });

    /** Open mobile filters menu */
    $(".openFiltersMenu").click(function () {
        /** Open mobile menu popup */
        jQuery(".filters-mobile-menu-popup").addClass('active');
        if(!jQuery(".bg-overlay")[0].classList.contains('active') && jQuery(".filters-mobile-menu-popup")[0].classList.contains('active')) {
            jQuery(".bg-overlay").addClass('active');
            jQuery(".bg-overlay").addClass('filterMenuOverlay');
            jQuery(".header_section").addClass('menu-open');

        } else if(!jQuery(".filters-mobile-menu-popup")[0].classList.contains('active')) {
            jQuery(".bg-overlay").removeClass('active');
            jQuery(".header_section").removeClass('menu-open');



        } else if (jQuery('.catalog-courses-stripe').slick()){
            jQuery('.catalog-courses-stripe').slick('unslick');
        }
        jQuery('html').addClass('menu_open');
    });

    $(".bg-overlay").click(function () {
    closingOverlay()
    })

    const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
    if(clientHeight + scrollTop >= scrollHeight - 2000) {
        loadCourses()
    }


    removeSelectedTags();
});
/** End of document ready */

/**
 * hiding filter inputs when clicking on screen or other filter group
 * */
$(document).click(function(event) {
    if(event.target.classList.contains('filter-group-skeleton')) event.target.style.display = "block";
    let filtergroup = $('.wrapEachFiltergroup');
    let filtersInputs = $(`.inputsContainer`);
    let sortByButton = $(`#sortByButton`);
    let sortByOptions = $(`#sortByOptions`);

    /** hiding input container when clicking on screen - when the event.target in not one of the filters menu / inputs */
    if (!filtergroup.is(event.target) && !filtergroup.has(event.target).length && !filtersInputs.is(event.target) && !filtersInputs.has(event.target).length ) {

        filtersInputs.each((index, element) => {
            console.log(element.classList.contains('filter-group-skeleton'))
            if(!element.classList.contains('filter-group-skeleton')){
                element.style.display = "none";
            }
        })

    }
    /** hiding sort by menu when the event.target in not the sort by menu button */
    if(!sortByButton.is(event.target) && !sortByButton.has(event.target).length){
        sortByOptions.removeClass('active');
    }
    /** Checking if the event is a filter group or input container */
    if (filtergroup.is(event.target) || filtergroup.has(event.target).length || filtersInputs.is(event.target) || filtersInputs.has(event.target).length) {

        let popupMenuDiv = event.target.closest(".wrapEachFiltergroup").querySelector(".inputsContainer");
        if((filtersInputs.is(event.target) || filtersInputs.has(event.target).length)){
            /** Closing extra filter menu when adding new extra filter */
            if(event.target.closest(".moreFilters")){
               let extraFilterMenu = event.target.closest(".moreFilters").querySelector(".inputsContainer");
                extraFilterMenu.style.display = "none";
            }
            /** hiding input container when clicking on other filter group */
        } else if ((filtergroup.is(event.target) || filtergroup.has(event.target).length)){

            filtersInputs.each((index, element) => {
                if(element !== popupMenuDiv){
                    element.style.display = "none";
                }
            })
        }
    }

});
/** end of jquery */

$(document).scroll(function() {

    /** Load More Result Courses On Catalog Page */
    const { scrollTop, scrollHeight, clientHeight } = document.documentElement;

    if(clientHeight + scrollTop >= scrollHeight - 2000) {
        loadCourses()
    }
})

function closingOverlay(){
    jQuery(".bg-overlay").removeClass('active');
    jQuery(".bg-overlay").removeClass('filterMenuOverlay');
    jQuery(".header_section").removeClass('menu-open');
    jQuery(".filters-mobile-menu-popup").removeClass('active');
    jQuery(".mobile-menu-popup").removeClass('active');
    jQuery(".filterVectorMobile").removeClass('active');
    /** closing open menu inside user menu */
    jQuery(".mobile-menu-vector").removeClass('active');
    jQuery(".change-mobile-lang").removeClass('active');
    jQuery(".secondary-mobile-lang-menu").removeClass('active');
    jQuery('html').removeClass('menu_open');
}

function slickStripeForMobile() {
    if($(window).width() <= 768){

        if($('#filtersSectionMobile')){
            /** Changing classes in filters menu inputs */
            $('#filtersSectionMobile .checkbox-filter-search').addClass('.checkboxFilterMobile');

            /** changing inputs id, for mobile */
            let checkboxArray =  $('#filtersSectionMobile .checkbox-filter-search');
            checkboxArray.each((index,item) => {
                item.id = "mobile_" + item.id;
            })

            /** changing inputs attribute for, for mobile */
            let labelsArray =  $('#filtersSectionMobile .filterTagLabel');
            labelsArray.each((index,item) => {
                item.htmlFor = "mobile_" + item.htmlFor;
            })
        }

        if(!jQuery('.catalog-courses-stripe').hasClass( "slick-initialized" )){
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
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2.5,
                            slidesToScroll: 2,
                            arrows: false,
                        }
                    },
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

        }

    } else if (jQuery('.catalog-courses-stripe').hasClass( "slick-initialized" )){
        jQuery('.catalog-courses-stripe').slick('unslick');
    }
}

function appendFilteredCourses(coursesData, loadedCourses = false) {
    let idsArray = [];
    let coursesIdsDiv =  document.getElementById("catalog_courses");
    const edxLang = getCookie('openedx-language-preference');
    const currentLang = edxLang ? edxLang.toLowerCase() : getCookie('wp-wpml_current_language').toLowerCase();
    let coursesBox = document.getElementById("coursesBox");
    let output = document.createElement("div");
    output.id = 'coursesBox';
    output.classList.add('row');
    output.classList.add('output-courses');
    output.classList.add('coursesResults');

    coursesData.forEach(item =>{
        idsArray.push(item.id);
    })

    let firstCoursesToShow = coursesData.slice(0,20);

    firstCoursesToShow.forEach(item =>{
        let id = item.id;
        let name = item.name;
        let academicInstitution = item.academic_institution ? item.academic_institution : '';
        let tags = item.marketing_tags ? getCourseResultTags(item.marketing_tags) : getCourseResultTags(item.tags);
        let hoverTags = item.marketing_tags ? getHoverTags(item.marketing_tags) : getHoverTags(item.tags);
        let image = item.image;
        let duration = item.duration;
        let permalink = item.permalink ? item.permalink : '';
        let baseUrl = window.location.origin;
        if(window.location.pathname.includes('/'+ currentLang +'/')) {
            baseUrl = baseUrl + '/'+ currentLang;
        }
        let url = baseUrl + '/onlinecourse/' + permalink;
        let buttonText = item.buttonText;

        if(academicInstitution){
            institutionName = '<p class="institutionName">'+ academicInstitution +' </p>'
        }
        let temp = document.createElement("div");
        temp.classList.add('courseResultCard');
        temp.setAttribute('data-id',id);
        temp.setAttribute('id',id);
        temp.innerHTML =
            '<div class="courseImage" style="background-image: url('+image+');">'+
            '<a href="'+ url +'"></a>'+
            '<span class="info-button"></span></div>'+
            '<div class="itemContent">'+
            '<h3 ><a href="'+ url +'">'+name+'</a></h3>'
            +institutionName+
            '<div class="tagsDiv">'+tags+ '</div>'+
            '<p class="courseDuration">'+duration+ '</p>'+
            '</div>'+
            '<div class="course-popup-modal mobile-course-popup'+ id +'">'+
            '<div class="popup-header">'+
            '<span class="course-popup-close'+ id +' close">&times;</span>'+
            '</div>'+
            '<div class="course-content">'+
            '<div class="course-img" style="background-image: url('+image+');"></div>'+
            '<div class="course-details">'+
            '<div class="course-header"">'+
            '<h3 ><a href="'+ url +'">'+name+'</a></h3>'
            +institutionName+
            '</div>'+
            '<div class="tags-div">'+ hoverTags +'</div>'+
            '<div class="details">'+
            '<span>'+ duration +'</span>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '<div class="popup-footer">'+
            '<a href="'+ url +'"><span>'+ buttonText +'</span></a>'+
            '</div>'+
            '</div>';

        output.append(temp);
        if(loadedCourses) {
            coursesBox.append(temp)
        }
    });

    if(!loadedCourses) {
        coursesBox.replaceWith(output);
        coursesIdsDiv.setAttribute("data-value",idsArray);
    }

    $('.course-skeleton').hide();

    clickOnCourseInfoButton();
}

function updateCoursesCounter(count){
    const currentLang = getCookie('openedx-language-preference') ? getCookie('openedx-language-preference') : getCookie('wp-wpml_current_language');
    let counterValue = $('#counterValue');
        if(currentLang == 'ar'){
          count = arabicNumbersTranslate(count);
        }
    counterValue.text(count);
}

function getCourseResultTags(tags) {
    let tagsHtml = '';
    if(tags.length >=3){
        tags.forEach((item, index) => {
            if(index >=2){
                tagsHtml = tagsHtml+"<span class='courseTag hiddenCourseTagMobile'><p>"+item+"</p></span>";
            } else{
                tagsHtml = tagsHtml+"<span class='courseTag'><p>"+item+"</p></span>";
            }
        })

        tagsHtml = tagsHtml+"<span class='courseTag extra-tags plusTag' >+</span>"
    }else{
        tags.forEach(item => {
            tagsHtml = tagsHtml+"<span class='courseTag'><p>"+item+"</p></span>";
        })
    }
    return tagsHtml;
}

function appendUrlParams(filters) {

    let currentUrl = window.location.href;
    let resetUrl = currentUrl.split('?')[0]
    let url = new URL(resetUrl);

    if(!filters || filters.length === 0) {
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

    let filterItems;
    if($(window).width() <= 768) {
        filterItems = $('#filtersSectionMobile .checkbox-filter-search');
    } else {
        filterItems = $('.filtersSection .checkbox-filter-search');
    }

    let tagsObj = {};
    for ( entry of entries) {
        if(entry[0] == 'text_s') {
           let inputValue = entry[1].replaceAll(`\\`, "");
            $('.search-field').val(inputValue);
        }

        if(entry[0] === 'tags_Stripe') {
            const tagId = entry[1].split('-')[0];
            appendSpecialGroupFilter()
            getTagById(tagId);
        }

        filterItems.each((index, element) => {
            let id = element.id;
            let type = $(`#${id}`).data('name'); //TODO using for language, certificate, institution.
            let group = $(`#${id}`).data('group'); //TODO using for tags.
            let englishValue = $(`#${id}`).data('value');

            if(entry[0] === type ) {
                let itemValues = entry[1].split(",");

                tagsObj[group] = tagsObj[group] ? tagsObj[group] : [];

                for(let item of itemValues){
                    if(englishValue.split(' ').join('') === item.split(' ').join('')) {

                        $(`#${id}`).prop('checked', true)

                        /** Append new selected tag */
                        tagsObj[group].push($(`#${id}`).val());
                    }
                }

            }

            if(entry[0].includes('tags_')) {
                let tagsGroup = entry[0].slice(5)

                if(tagsGroup === group) {
                    let itemValues = entry[1].split(",");
                    let groupTitle = $(`#${id}`).data('title'); //TODO using for tags.
                    tagsObj[groupTitle] = tagsObj[groupTitle] ? tagsObj[groupTitle] : [];

                    for(let item of itemValues){
                        if(englishValue.toLowerCase() === item.toLowerCase()) {
                            $(`#${id}`).prop('checked', true)

                            /** Append new selected tag */
                            tagsObj[groupTitle].push($(`#${id}`).val());
                        }
                    }
                }
            }
        });


    }

    /** Check if has params in the url */
    if(!params.entries().next().value) {
        const currentLang = getCookie('openedx-language-preference') ? getCookie('openedx-language-preference') : getCookie('wp-wpml_current_language');
        filterItems.each((index, element) => {
            let id = element.id;
            let type = $(`#${id}`).data('name');
            let englishValue = $(`#${id}`).data('value');
            let group = $(`#${id}`).data('group');

            if (type === 'language') {
                let lang;
                switch (currentLang) {
                    case 'he':
                        lang = 'Hebrew';
                        break;
                    case 'en':
                        lang = 'English';
                        break;
                    case 'ar':
                        lang = 'Arabic';
                        break;
                }

                if (englishValue.includes(lang)) {
                    $(`#${id}`).prop('checked', true)

                    /** Append new selected tag */
                    tagsObj[group] = tagsObj[group] ? tagsObj[group] : [];
                    tagsObj[group].push($(`#${id}`).val());

                    let currentUrl = window.location.href;
                    let url = new URL(currentUrl);
                    url.searchParams.set(type, lang);
                    window.history.pushState({}, '', url);

                }
            }
        });
    }

    /** Append new selected tags to DOM */
    appendSelectedTagsToDOM(tagsObj)
}

function removeSelectedTags() {
    $('.remove-filters').on('click', function(event) {
        let filterItems;
        if($(window).width() <= 768) {
            filterItems = $('#filtersSectionMobile .checkbox-filter-search');
        } else {
            filterItems = $('.filtersSection .checkbox-filter-search');
        }
        filterItems.each((index, element) => {
            let id = element.id;
            let group = $(`#${id}`).data('group');
            let groupTitle = $(`#${id}`).data('title');
            let parentName = event.target.parentElement.getAttribute('data-name')
            if (group === parentName || groupTitle === parentName) {
                $(`#${id}`).prop('checked', false)
                event.target.parentElement.remove()
            }
        })
        getCourses();
    })
}

/**
 *  Append new selected tags to DOM
 * */
function appendSelectedTagsToDOM(tagsObj) {
    let selectedTagsDiv = $('<div>');
    selectedTagsDiv.attr('id', 'selectedTags');
    for(let group in tagsObj) {

        let selectedTag = $('<div>');
        selectedTag.addClass('selected-tag')
        selectedTag.attr('data-name', group)

        let tagGroup = $('<span>');
        tagGroup.text(group + ': ')
        selectedTag.append(tagGroup);

        if(tagsObj[group].length !== 0) {
            let tagText = $('<span>');
            let firstTwoFilters = tagsObj[group].slice(0,2) // display just the first 2 tags
            tagText.text(firstTwoFilters.join(', '));
            selectedTag.append(tagText);
        }

        if(selectedTag.children.length >= 2) {
            let removeFilters = $('<div>');
            removeFilters.addClass('remove-filters')
            selectedTag.append(removeFilters);
            selectedTagsDiv.append(selectedTag)
        }
    }

    $('#selectedTags').replaceWith(selectedTagsDiv)
    removeSelectedTags()
    filterByTagEvent()
}

function haveNoResults(afterSearching= true) {
    let coursesBox = document.getElementById("coursesBox");
    let output = document.createElement("div");
    const currentLang = getCookie('openedx-language-preference') ? getCookie('openedx-language-preference') : getCookie('wp-wpml_current_language');
    let noResultText_he = "לא מצאנו בדיוק את מה שחיפשת אבל אולי יעניין אותך...";
    let noResultText_en = "We didn't find exactly what you were looking for but maybe you will be interested ...";
    let noResultText_ar = "لم نعثر على ما كنت تبحث عنه بالضبط ولكن ربما تكون مهتمًا ...";

    output.id = 'coursesBox';
    output.classList.add('row');
    output.classList.add('output-courses');
    output.classList.add('coursesResults');

        let temp = document.createElement("div");
        if(afterSearching) {
            temp.innerHTML =
                '<p class="noResultText">' +getFieldByLanguage(noResultText_he, noResultText_en, noResultText_ar, currentLang)+ '</p>'
        }

        output.append(temp)

    coursesBox.replaceWith(output)
}

/**
 * Filtering by tag function of catalog - need to remove
 * */
function filterByTagEvent(){
    /** removing event from div */
   $('.filtersSection .filtersInputWeb').off('click');

    /** click event - targeting each input for filtering */
    $('.filtersSection .filtersInputWeb').click(function (event) {
      getCourses();
    })
}

/**
 * filterByTagMobile function of catalog
 * */
function filterByTagMobile(){

    /** removing event from div */
    $(`.buttonFilterWrap`).unbind('click');

    /** click event - targeting each input for filtering */
    $('.buttonFilterWrap').on('click', function (event) {
        let filterData = {"search": {}};
        let tagArray = {};
        let freeSearchData = [];
        let institutionArray = [];
        let certificateArray = [];
        let languageArray = [];

        /** Getting free search value from url params */
        let params = new URLSearchParams(document.location.search);
        let searchValue = params.get("text_s");
        if(searchValue){
            searchValue = searchValue.replaceAll(`\\`, "");
            freeSearchData.push(searchValue);
        }

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

/**
 * Ajax call - getting filters group name and there tags
 * **/
function getFiltersGroups(filterId) {
    let data = {
        'action': 'add_filters_to_menu',
        'type' : 'moreFilters',
        'dataArray': filterId,
    }
    jQuery.post(filter_by_tag_ajax.ajaxurl, data, function(response){
        if(response.success){
            const responseData = JSON.parse(response.data);
            appendMoreFilters(responseData);
            setTimeout(() => {
                $(`#extraFilter_${responseData.filterId}`).removeClass('animate-expand-y')
            }, 300)
        }
    })
}

/**
 * Appending filter tags
 * **/
function appendMoreFilters(filterData) {
    /**looping each filter group and appending it to the filters menu */
    let filterId = filterData.filterId;
    let dataType = filterData.dataType;
    let container = document.getElementById(`extraFilter_${filterId}`);
    let groupFilters = filterData.filtersList;
    let currentLanguage =filterData.language;
    let groupName = filterData.group ? filterData.group : filterData.groupName ? filterData.groupName : '';

    groupFilters.forEach(element => {

        let temp = document.createElement("div");
        temp.classList.add('filterInput');
        let id = Math.floor(Math.random()*90000) + 10000;;
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
            '<label class="filterTagLabel" for="'+dataType + '_' + id+'">'+
            '<input'+ checked +' class="checkbox-filter-search filtersInputWeb" type="checkbox" data-name="'+dataType+'" data-group="'+ groupName +'" data-title="'+ groupName +'" data-value="'+urlTitle+'" value="'+name+'" id="'+dataType + '_' + id+'">'+
            '<div class="wrap-term-and-sum tagNameWrap">'+
            '<span class="term-name">'+name+'</span>'+
            '</div>'+
            '</label>';
        container.append(temp);
    });

    /** Add animation class for opening the new filter group */
    $(`#extraFilter_${filterData.filterId}`).addClass('animate-expand-y')

    /** Hide Skeleton */
    $(`#extraFilter_${filterId}`).removeClass('ph-item filter-group-skeleton');

    filterByTagEvent();
}

/**
 * Ajax Call Get Filter Courses
 * */
function filterCoursesAjax(filterData) {
    appendUrlParams(filterData)
    if(filterData.length != 0 && filterData['search']['tags'] && filterData['search']['tags']['Stripe']){
        let [tagId, ...tagName] = filterData['search']['tags']['Stripe'][0].split('-');
        tagName = tagName.join('-');
        filterData['search']['tags']['Stripe'][0] = tagName;
    }
    
    let data = {
        'action': 'filter_by_tag',
        'type' : 'courses',
        'lang' : getCookie('openedx-language-preference'),
        'filters': filterData,
    }
    jQuery.post(filter_by_tag_ajax.ajaxurl, data, function(response){
        if(response.success){
            const responseData = JSON.parse(response.data);
            const coursesLength = responseData['courses'].length
            if(coursesLength > 0) {
                updateCoursesCounter(coursesLength);
                appendFilteredCourses(responseData['courses']);

            } else if(responseData['params'] == null) {
                haveNoResults(false)
                updateCoursesCounter(0);
            } else {
                haveNoResults();
                updateCoursesCounter(0);
            }
        }
    })
}

/**
 * Appending filter group
 * **/
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
        '<div class="ph-item filter-group-skeleton inputsContainer catalogFilters" id="extraFilter_'+filterId+'">'+
        '</div>';

    container.insertBefore(temp, addFilterbutton);
    let extraFilterMenuDiv = temp.querySelector(".inputsContainer");
    $(extraFilterMenuDiv).toggle();

    let specialTagGroup = document.querySelector('.stripe_tag_filter');
    if(specialTagGroup) {
        container.insertBefore(temp, specialTagGroup);
    } else {
        container.insertBefore(temp, addFilterbutton);
    }

}

function openCheckboxEvent() {

    /** removing event from div */
    $(`.wrapEachFiltergroup`).unbind('click');

    /** click event - targeting each checkbox to open */
    $('.wrapEachFiltergroup').on('click', function (event) {
        let popupMenuDiv = event.target.closest(".wrapEachFiltergroup").querySelector(".inputsContainer");
        let filterGroupVector = event.target.closest(".wrapEachFiltergroup").querySelector(".filterVectorMobile");
        let allFiltersGroupVector = $(".filterVectorMobile");
        $(popupMenuDiv).toggle();
        allFiltersGroupVector.each((index,item) => {
          if(item == filterGroupVector){
              $(filterGroupVector).toggleClass('active');
          }else {
              $(item).removeClass('active');
          }
        })
    });
}

/**
 * Load more courses (not in used 14-04-2022)
 * */
async function loadCourses(coursesArray = []) {

    /** Check if the skeleton visible*/
    if(jQuery('.course-skeleton').is(':visible')) return;

    if(coursesArray.length > 0){
        appendFilteredCourses(coursesArray)
    } else {

        let divLength = $('#coursesBox').children().length
        let courses = document.getElementById("catalog_courses").getAttribute('data-value')
        let coursesIdArray = typeof courses !== 'number' ? courses.split(',') : [courses];

        if(coursesIdArray.length > 20 && coursesIdArray.length > divLength) {

            /** Display Skeleton */
            $('.course-skeleton').show();

            let coursesToGet = coursesIdArray.slice(divLength, divLength + 20)

            let data = {
                'action': 'stripe_data',
                'type' : 'courses',
                'lang' : getCookie('openedx-language-preference'),
                'idsArray': coursesToGet,
            }

            jQuery.post(stripe_data_ajax.ajaxurl, data, function(response){
                if(response.success){
                    const data = JSON.parse(response.data);
                    appendFilteredCourses(data, true)
                }
            })
        }
    }
}

function getTagById(tagId) {
    let data = {
        'action': 'get_tag_data',
        'type' : 'tags',
        'lang' : getCookie('openedx-language-preference'),
        'id': tagId,
    }

    jQuery.post(filter_by_tag_ajax.ajaxurl, data, function(response){
        if(response.success) {
            const responseData = JSON.parse(response.data);
            const tag = responseData['tag'];
            appendSpecialTagToGroup(tag)
            openCheckboxEvent();
        }
    })
}

/**
 *  Append tags stripe special group
 *  */
function appendSpecialGroupFilter() {
    const currentLang = getCookie('openedx-language-preference') ? getCookie('openedx-language-preference') : getCookie('wp-wpml_current_language');
    let vector = $('.filterVector').attr('src');
    let mobileVector = $('.filterVectorMobile').attr('src');
    let container = document.getElementById('groupFiltersContainer');
    let mobileContainer = document.getElementById('filtersSectionMobile');
    let groupTitle = getFieldByLanguage('התאמה מיוחדת', 'Customize Tag', 'تناسب خاص', currentLang);
    let addFilterbutton = document.getElementById('morefiltersBox');
    let filterId = 'stripe_tag_filter';
    let temp = document.createElement("div");
    temp.classList.add('wrapEachFiltergroup');
    temp.classList.add('extraFilter');
    temp.classList.add(filterId);

    temp.innerHTML =
        '<div class="wrapEachFilterTag">'+
        '<div class="buttonWrap">'+
        '<p id="'+filterId+'" class="filterGroupTitle">'+ groupTitle +' </p>'+
        '<img class="filterVector" src="'+vector+'"/>'+
        '<img class="filterVectorMobile" src="'+mobileVector+'"/>'+
        '</div>'+
        '</div>'+
        '<div class="inputsContainer catalogFilters" id="extraFilter_'+filterId+'">'+
        '</div>';

    container.insertBefore(temp, addFilterbutton);
    if($(window).width() <= 768){
        mobileContainer.append(temp);
    }
}

/**
 *  Add tag from tags stripe to special filters group
 *  after tag data return from Ajax call
 *  */
function appendSpecialTagToGroup(tag) {
    let container = document.getElementById('extraFilter_stripe_tag_filter');
    let temp = document.createElement("div");
    temp.classList.add('filterInput');
    let id = Math.floor(Math.random()*90000) + 10000;
    let name = tag['name'];
    let englishName = tag['english_name'];
    let tagId = tag['id'];
    let checked = ' checked';

    temp.innerHTML =
        '<label class="filterTagLabel" for="tag_'+id+'">'+
        '<input'+ checked +' class="checkbox-filter-search filtersInputWeb" type="checkbox" data-name="tag" data-group="Stripe" data-value="'+tagId+'-'+englishName+'" value="'+name+'" id="tag_'+id+'">'+
        '<div class="wrap-term-and-sum tagNameWrap">'+
        '<span class="term-name">'+name+'</span>'+
        '</div>'+
        '</label>';
    container.append(temp);

    filterByTagEvent();
}

function getCourses() {
    let filterData = {"search": {}};
    let tagArray = {};
    let freeSearchData = [];
    let institutionArray = [];
    let certificateArray = [];
    let languageArray = [];

    /** Getting free search value from url params */
    let params = new URLSearchParams(document.location.search);
    let searchValue = params.get("text_s");
    if(searchValue){
        searchValue = searchValue.replaceAll(`\\`, "");
        freeSearchData.push(searchValue);
    }
    /** Getting array of inputs depend desktop/mobile */
    let filterItems;
    if($(window).width() <= 768) {
        filterItems = $('#filtersSectionMobile .checkbox-filter-search');
    } else {
        filterItems = $('.filtersSection .checkbox-filter-search');
    }

    let tagsObj = {};

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
                    let groupTitle = $(`#${id}`).data('title');
                    tagsObj[groupTitle] = tagsObj[groupTitle] ? tagsObj[groupTitle] : [];
                    tagArray[group] = tagArray[group] ? tagArray[group] : [];

                    tagArray[group].push(englishValue);

                    /** Append new selected tag */
                    tagsObj[groupTitle].push($(`#${id}`).val());
                    break;

                case 'institution':
                    console.log(element)
                    tagsObj[group] = tagsObj[group] ? tagsObj[group] : [];
                    institutionArray.push(englishValue);

                    /** Append new selected tag */
                    tagsObj[group].push($(`#${id}`).val());
                    break;

                case 'certificate':
                    tagsObj[group] = tagsObj[group] ? tagsObj[group] : [];
                    certificateArray.push(englishValue);

                    /** Append new selected tag */
                    tagsObj[group].push($(`#${id}`).val());
                    break;

                case 'language':
                    tagsObj[group] = tagsObj[group] ? tagsObj[group] : [];
                    languageArray.push(englishValue);

                    /** Append new selected tag */
                    tagsObj[group].push($(`#${id}`).val());
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

    /** Append new selected tags to DOM */
    appendSelectedTagsToDOM(tagsObj)
}

function sortByAjax(idsArray,sortType){

    let data = {
        'action': 'sort_by_courses',
        'lang' : getCookie('openedx-language-preference'),
        'sortType': sortType,
        'coursesIds':idsArray,
    }
    jQuery.post(sort_by_courses_ajax.ajaxurl, data, function(response){
        if(response.success){
            const responseData = JSON.parse(response.data);
            const coursesLength = responseData['courses'].length
            if(coursesLength > 0) {
                appendFilteredCourses(responseData['courses']);
            }
        }
    })
}

/**
 *  General function for translate
 *  */
function getFieldByLanguage(heField, enField, arField, lang) {

    if(lang == "en" && enField && enField != ""){
        return enField;
    } else if (lang == "ar" && arField && arField != "" ){
        return arField;
    } else {
        return heField;
    }
}

/** translate arabic numbers */

function arabicNumbersTranslate(count) {
    /** turning number to string */
    let countStr = count.toString()
    let arabicNum= ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    /** replacing each number to there translated number */
    return countStr.replace(/[0-9]/g, function(w){
        return arabicNum[+w]
    });
}