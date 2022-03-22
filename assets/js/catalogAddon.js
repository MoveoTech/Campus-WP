$= jQuery.noConflict();

$(document).ready(function () {

    //click event - reset filtering
    $('.resetFilterButton').on('click', function (event) {

        let filtersInputs = $('.checkbox-filter-search');

        filtersInputs.each((index, element) => {
            element.checked = false;

        });
    });
    //end of click event -reset filtering


    //click event - targeting each checkbox to open
    $('.wrapEachFiltergroup').on('click', function (event) {
        // console.log("event.targettttt", event.target);

        let popupMenuDiv = event.target.closest(".wrapEachFiltergroup").querySelector(".inputsContainer")

        $(popupMenuDiv).toggle();
    });
    //end of click event - targeting each checkbox to open


    // click event - adding more filters
    $('.moreFilters .checkbox-filter-search').on('click', function (event) {
        let groupsArray = [];

        //getting targeted inputs
        let filtersGroup = $('.moreFilters .checkbox-filter-search');

        // looping all group inputs
        filtersGroup.each((index, element) => {
            let id = element.id;
            let filterId = $(`#${id}`).data('value');

            //checking if value is checked
            if(element.checked) {
                console.log("filterId : ", filterId)
                groupsArray.push(filterId);
                console.log("groupsArray : ", groupsArray)

                getFiltersGroups(groupsArray)
            }

        });



    });
    //end of click event

    //ajax call - getting filters group name and there tags
    function getFiltersGroups(groupsArray) {

        let data = {
            'action': 'add_filters_to_menu',
            'type' : 'moreFilters',
            'dataArray': groupsArray,
        }

        jQuery.post(add_filters_to_menu_ajax.ajaxurl, data, function(response){

            if(response.success){
                const responseData = JSON.parse(response.data);
                // console.log("data Ajax : ", responseData)

                if(responseData.length > 0) {
                    appendMoreFilters(responseData)

                } else {
                    // no filters for this group?

                }


            }
        })
    }

function appendMoreFilters(filtersData) {
//looping each filter group and appending it to the filters menu

    let container = document.getElementById('moreFiltersWrap');
    // let existFilters = document.getElementsByClassName('term-name');

    filtersData.forEach(filterData => {


        let groupTitle = filterData.groupName;
        let groupFilters = '';
        let currentLanguage =filterData.language;


    if(filterData.tagsList) {

        groupFilters = filterData.tagsList;

    } else if(filterData.academicInstitutionsList) {

        groupFilters = filterData.academicInstitutionsList;

    } else if(filterData.languageList) {

        groupFilters = filterData.languageList;

    }else if(filterData.certificateList) {

        groupFilters = filterData.certificateList;
    }
    else{
        //remove after
        console.log("else - something nt working")
    }


        let temp = document.createElement("div");
        temp.classList.add('wrapEachFiltergroup');


            let startTempPart =
                '<div class="wrapEachFilterTag">'+
                    '<div class="buttonWrap">'+
                        '<p class="filterGroupTitle">'+ groupTitle +'</p>'+
                        // '<img class="filterVector" src="../images/vector-black.svg"/>'+
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





    })

}
//end of function appendMoreFilters




});
//end of Jquery



// hiding filter inputs when clicking on screen
//TODO changing function to close other open tabs
$(document).click(function(event) {
    let filtergroup = $('.wrapEachFiltergroup');
    let filtersInputs = $(`.inputsContainer`);
    if (!filtergroup.is(event.target) && !filtergroup.has(event.target).length && !filtersInputs.is(event.target) && !filtersInputs.has(event.target).length) {
        filtersInputs.hide();
    }
});