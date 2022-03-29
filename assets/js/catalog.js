$= jQuery.noConflict();

$(document).ready(function () {
    let params = new URLSearchParams(document.location.search);

    /** Mark selected checkboxes */
    markCheckboxes(params)

    filterByTagEvent()

    // click event - targeting filters inputs
    $('.checkbox-filter-search').on('click', function (event) {

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
                // console.log(element)
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

    })
    /** end of click event */

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
                // console.log(responseData['filters'])
                appendUrlParams(responseData['filters'])
                if(responseData['courses'].length > 0) {
                    appendFilteredCourses(responseData['courses'])
                } else {
                    haveNoResults()
                }
            }
        })
    }

    /** Filtering by tag function of catalog - need to remove  */
    function filterByTagEvent(){
        /** removing event from div */
        $(`#groupFiltersContainer .checkbox-filter-search`).unbind('click');

        /** click event - targeting each input for filtering */
        $('#groupFiltersContainer .checkbox-filter-search').on('click', function (event) {
            let filterData = {};
            let tagArray = [];
            let institutionArray = [];
            let certificateArray = [];
            let languageArray = [];

            /**getting specific value - inside certificate-filter */
            let certificates = $('.checkbox-filter-search');

            /** looping all certificate inputs */
            certificates.each((index, element) => {
                let id = element.id;
                let type = $(`#${id}`).data('name');
                let value = element.value;

                /** checking if value is checked */
                if(element.checked) {

                    switch (type) {
                        case 'tag':
                            tagArray.push(value);
                            break;

                        case 'institution':
                            institutionArray.push(value);
                            break;

                        case 'certificate':
                            certificateArray.push(value);
                            break;

                        case 'language':
                            languageArray.push(value);
                            break;
                    }
                }
            });

            if(tagArray || institutionArray || certificateArray || languageArray) {

                /** pushing each array to object (key and values) */
                if(tagArray.length > 0) {
                    filterData['tags'] = tagArray;
                }
                if(institutionArray.length > 0) {
                    filterData['institution'] = institutionArray;
                }
                if(certificateArray.length > 0) {
                    filterData['certificate'] = certificateArray;
                }
                if(languageArray.length > 0) {
                    filterData['language'] = languageArray;
                }
            };
        })
    }
    /** End of function filterByTagEvent */
});
/** end of jquery */

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

        // console.log("each item : ",item);
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
        // temp.id = 'coursesBox';
        // temp.classList.add('row output-courses');
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
        } // TODO add the class name of search field to the search in catalog page .

        filterItems.each((index, element) => {
            let id = element.id;
            let type = $(`#${id}`).data('name'); //TODO using for language, certificate, institution.
            let group = $(`#${id}`).data('group'); //TODO using for tags.
            let englishValue = $(`#${id}`).data('value');
            let value = element.value;

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
                // console.log(tagsGroup , ':', group)

                if(tagsGroup === group) {
                    let itemValues = entry[1].split(",");
                    // console.log(tagsGroup)
                    for(let item of itemValues){
                        if(englishValue === item) {
                            $(`#${id}`).prop('checked', true)
                        }
                    }
                }
            }
        });
    }
} // TODO verified the mark checkboxes works in english & arabic (maybe need to use the tagID)

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