$= jQuery.noConflict();

$(document).ready(function () {

    $('.moreFilters .checkbox-filter-search').on('click', function (event) {


        let groupsArray = [];

        //getting specific value - inside certificate-filter
        let filtersGroup = $('.moreFilters .checkbox-filter-search');

        // looping all certificate inputs
        filtersGroup.each((index, element) => {
            let id = element.id;
            let filterName = $(`#${id}`).data('value');
            // let value = element.value;

            //checking if value is checked
            if(element.checked) {
                console.log("filter group :", filterName)
                // console.log("value :", value)
                    groupsArray.push(filterName);
                getFiltersGroups(groupsArray)


            }

        });

console.log("groupsArray: ", groupsArray)


    });
    //end of click event

    function getFiltersGroups(groupsArray) {

        let data = {
            'action': 'filter_by_tag',
            'type' : 'courses',
            'dataObject': filterData,
        }

        jQuery.post(filter_by_tag_ajax.ajaxurl, data, function(response){
            if(response.success){
                const responseData = JSON.parse(response.data);
                // console.log("data in filterCoursesAjax strictt : ", responseData['strictFilter'])
                // console.log("data in filterCoursesAjax : ", responseData)
                appendFilteredCourses(responseData['strictFilter'])
                // if(responseData.length > 0) {
                //
                //
                // } else {
                //     // showing "no courses found" message
                //
                // }


            }
        })
    }


//reset filtering
    $('.resetFilterButton').on('click', function (event) {

        let filtersInputs = $('.checkbox-filter-search');

        filtersInputs.each((index, element) => {
           element.checked = false;

        });
    });
    //end of click event


    //targeting each checkbox to open
    $('.wrapEachFiltergroup').on('click', function (event) {
        // console.log("event : ", event)
        // console.log("event target: ", event.target)

    let popupMenuDiv = event.target.closest(".wrapEachFiltergroup").querySelector(".inputsContainer")
    //     let id = event.target.id
    //     if(!id) id = event.target.parentElement.id;
    //     if(!id) id = event.target.parentElement.parentElement.id;
    //     let popupMenuDiv = $(`.${id}`);

        $(popupMenuDiv).toggle();
        $(popupMenuDiv).toggleClass('showInputsContainer');


    });
    //end of click event


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