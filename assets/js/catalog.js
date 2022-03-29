$= jQuery.noConflict();

$(document).ready(function () {


    filterByTagEvent()


    function filterCoursesAjax(filterData) {

            let data = {
                'action': 'filter_by_tag',
                'type' : 'courses',
                'lang' : getCookie('openedx-language-preference'),
                'dataObject': filterData,
            }

            jQuery.post(filter_by_tag_ajax.ajaxurl, data, function(response){
                if(response.success){
                    const responseData = JSON.parse(response.data);
                    appendFilteredCourses(responseData['strictFilter'])
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

    coursesData.forEach(item =>{
        let permalink = item.permalink ? item.permalink : '';
        let url = 'course/' + permalink;
        let tags = getDesktopTags(item.tags);
        let hoverTags = getHoverTags(item.tags);
        let academicInstitution = item.academic_institution ? item.academic_institution : '';

        let temp = document.createElement("div");
        temp.id = item.id;
        temp.classList.add('course-stripe-item');
        temp.innerHTML =
            '<div class="course-img" style="background-image: url('+item.image+');">'+
            '<a href="'+ url +'"></a>'+
            '<span class="info-button"></span></div>'+
            '<div class="item-content"">'+
            '<h3 ><a href="'+ url +'">'+item.name+'</a></h3>'+
            '<p >'+academicInstitution+'</p>'+
            ' </div>'+
            '<div class=" tags-div">'+tags+ '</div>'+
            '<div class="course-item-hover '+ item.id +'">'+
            '<a href="'+ url +'">'+
            '<div class="course-img" style="background-image: url('+item.image+');"></div>'+
            '<div class="item-content"">'+
            '<h3 >'+item.name+'</h3>'+
            '<p >'+academicInstitution+'</p>'+
            '</div>'+
            '<div class=" tags-div">'+ hoverTags +'</div>'+
            '<div class="course-details">'+
            '<span>'+ item.duration +'</span>'+
            '</div>'+
            '</a>'+
            '</div>'+
            '<div class="course-popup-modal mobile-course-popup'+ item.id +'">'+
            '<div class="popup-header">'+
            '<span class="course-popup-close'+ item.id +' close">&times;</span>'+
            '</div>'+
            '<div class="course-content">'+
            '<div class="course-img" style="background-image: url('+item.image+');"></div>'+
            '<div class="course-details">'+
            '<div class="course-header"">'+
            '<h3 ><a href="'+ url +'">'+item.name+'</a></h3>'+
            '<p >'+academicInstitution+'</p>'+
            '</div>'+
            '<div class="tags-div">'+ hoverTags +'</div>'+
            '<div class="details">'+
            '<span>'+ item.duration +'</span>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '<div class="popup-footer">'+
            '<a href="'+ url +'"><span>'+ item.buttonText +'</span></a>'+
            '</div>'+
            '</div>';


    });
}
