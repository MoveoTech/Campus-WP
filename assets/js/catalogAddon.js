$= jQuery.noConflict();

$(document).ready(function () {

/** Click event - reset filtering **/
    $('.resetFilterButton').on('click', function (event) {

        let filtersInputs = $('.checkbox-filter-search');

        filtersInputs.each((index, element) => {
            element.checked = false;
        });

        /** removing extra filters **/
        $('.extraFilter').remove();

    });
        /**End of click event -reset filtering **/



 /** Calling events - targeting each checkbox to open & filtering inputs **/
    openCheckboxEvent()
    filterByTagEvent()

 /** Click event - adding more filters **/
    $('.moreFilters .extraFilterCheckbox').on('click', function (event) {

        /**Getting targeted input */
        let filterId = $(event.target).data('value');

        /** If element checked appending it to menu, else - remove it */
        if(event.target.checked){
            getFiltersGroups(filterId)
        } else {
            let filterToRemove = document.getElementsByClassName(filterId)[0];
            filterToRemove.remove()
        }
    });
    /** End of click event **/
});
    /** End of Jquery */

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
            /** Calling events - targeting each checkbox to open & filtering inputs **/
            openCheckboxEvent();
            filterByTagEvent()
        }
    })
}
/** End of function getFiltersGroups */



/** Appending filter group **/
function appendMoreFilters(filterData) {

    /**looping each filter group and appending it to the filters menu */
    let vector = $('.filterVector').attr('src');

    let container = document.getElementById('groupFiltersContainer');

    let groupTitle = filterData.groupName;
    let groupFilters = '';
    let currentLanguage =filterData.language;
    let filterId = filterData.filterId


    if(filterData.tagsList) {

        groupFilters = filterData.tagsList;

    } else if(filterData.academicInstitutionsList) {

        groupFilters = filterData.academicInstitutionsList;

    } else if(filterData.languageList) {

        groupFilters = filterData.languageList;

    }else if(filterData.certificateList) {

        groupFilters = filterData.certificateList;
    }

    let temp = document.createElement("div");
    temp.classList.add('wrapEachFiltergroup');
    temp.classList.add('extraFilter');
    temp.classList.add(filterId);


    let startTempPart =
        '<div class="wrapEachFilterTag">'+
        '<div class="buttonWrap">'+
        '<p class="filterGroupTitle">'+ groupTitle +'</p>'+
        '<img class="filterVector" src="'+vector+'"/>'+
        '</div>'+
        '</div>'+
        '<div class="inputsContainer">';

    let middleTempPart;

    groupFilters.forEach(element => {

        let id = element.id;
        let name = element.name;
        let checked = '';

        if(element.english_name && currentLanguage == 'en' ) {
            name = element.english_name;
        }
        if(element.arabic_name && currentLanguage == 'ar'){
            name = element.arabic_name;
        }


        middleTempPart =
            '<div class="filterInput">'+
            '<label class="term-filter-search" for="'+id+'">'+
            '<input'+ checked +' class="checkbox-filter-search" type="checkbox" data-name="institution" data-value="'+id+'" value="'+name+'" id="'+id+'">'+
            '<div class="wrap-term-and-sum">'+
            '<span class="term-name">'+name+'</span>'+
            '</div>'+
            '</label>'+
            '</div>';
    })
    let endTempPart = '</div>';
    temp.innerHTML = startTempPart + middleTempPart + endTempPart;

    container.append(temp);

}
/** End of function appendMoreFilters */

function openCheckboxEvent() {
    //removing event from div
    $(`.wrapEachFiltergroup`).unbind('click');

    //click event - targeting each checkbox to open
    $('.wrapEachFiltergroup').on('click', function (event) {


        let popupMenuDiv = event.target.closest(".wrapEachFiltergroup").querySelector(".inputsContainer")

        $(popupMenuDiv).toggle();
    });
}
/** End of function openCheckboxEvent */


// TODO removing when merging to catalog.js

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

            //checking if value is checked
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

            //pushing each array to object (key and values)
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

});