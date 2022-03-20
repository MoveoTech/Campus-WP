$= jQuery.noConflict();

$(document).ready(function () {

    $('.addFilterButton').on('click', function (event) {






    });
    //end of click event


    $('.resetFilterButton').on('click', function (event) {

        let filtersInputs = $('.checkbox-filter-search');

        filtersInputs.each((index, element) => {

           element.checked = false;

        });




    });
    //end of click event


    $('.filterGroupTitle').on('click', function (event) {
        console.log("event: ", event.target.id)
        console.log("event.target.value: ", event.target.innerHTML)
        let filtergroupValue = event.target.innerHTML.replace(/ /g,'');
        console.log("filtergroupValue: " , filtergroupValue)
        // let filtersInputs = $(`.filterGroupTitle`);
        let filtersInputs = $(`#${filtergroupValue}`);
        filtersInputs.toggle();
console.log("filtersInputs :", filtersInputs)

        // filtersInputs.each((index, element) => {
        //
        //     element.checked = false;
        //
        // });




    });
    //end of click event


});
//end of Jquery

// hiding filter inputs when clicking on screen
$(document).click(function(event) {
    let filtergroup = $('.filterGroupTitle');
    let filtersInputs = $(`.inputsContainer`);
    if (!filtergroup.is(event.target) && !filtergroup.has(event.target).length && !filtersInputs.is(event.target) && !filtersInputs.has(event.target).length) {
        filtersInputs.hide();
    }
});