$= jQuery.noConflict();

$(document).ready(function () {
    // console.log("hola catalog");

    $('.filters_button').on('click', function (event) {

        //getting specific value - inside certificate-filter
        let certificates = $('.checkbox-filter-search');
        let tagArray = [];
        let institutionArray = [];
        let certificateArray = [];
        let languageArray = [];
        // let certificates = $('.checkbox-filter-search').attr('data-name');
// console.log(certificates)

        // looping all certificate inputs
        certificates.each((index, element) => {
            let id = element.id;
            let type = $(`#${id}`).data('name');
            let value = element.value;
            //checking if value is checked
            if(element.checked) {
                console.log(type, value)

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
        console.log("tagArray: ",tagArray);
        console.log("institutionArray: ",institutionArray);
        console.log("certificateArray: ",certificateArray);
        console.log("languageArray: ", languageArray);





    })
    // end of click event


});
