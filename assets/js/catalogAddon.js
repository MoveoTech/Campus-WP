$= jQuery.noConflict();

$(document).ready(function () {

    $('.addFilterButton').on('click', function (event) {
        // console.log("event : ", event);






    });
    //end of click event

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