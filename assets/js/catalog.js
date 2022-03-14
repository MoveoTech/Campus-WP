$= jQuery.noConflict();

$(document).ready(function () {


    $('.filters_button').on('click', function (event) {
        let filterData = {};
        let tagArray = [];
        let institutionArray = [];
        let certificateArray = [];
        let languageArray = [];

        //getting specific value - inside certificate-filter
        let certificates = $('.checkbox-filter-search');

        // let certificates = $('.checkbox-filter-search').attr('data-name');
// console.log(certificates)

        // looping all certificate inputs
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
        // console.log("tagArray: ",tagArray);
        // console.log("institutionArray: ",institutionArray);
        // console.log("certificateArray: ",certificateArray);
        // console.log("languageArray: ", languageArray);


        if(tagArray || institutionArray || certificateArray || languageArray) {

            // console.log("tagArray: ",tagArray);
            // console.log("institutionArray: ",institutionArray);
            // console.log("certificateArray: ",certificateArray);
            // console.log("languageArray: ", languageArray);

            if(tagArray.length > 0) {
                //pushing array to object
                filterData['tags'] = tagArray;
            }
            if(institutionArray.length > 0) {
                //pushing array to object
                filterData['institution'] = institutionArray;

            }
            if(certificateArray.length > 0) {
                //pushing array to object
                filterData['certificate'] = certificateArray;

            }
            if(languageArray.length > 0) {
                //pushing array to object
                filterData['language'] = languageArray;
            }
            console.log(" array before Ajax : ", filterData);
            filterCoursesAjax(filterData);
        }



    })
    // end of click event



    function filterCoursesAjax(filterData) {

            let data = {
                'action': 'filter_by_tag',
                'type' : 'courses',
                // 'lang' : getCookie('openedx-language-preference'),
                'dataObject': filterData,
            }

            jQuery.post(filter_by_tag_ajax.ajaxurl, data, function(response){
                // console.log("response.data : ", response.data)
                if(response.success){
                    const data = JSON.parse(response.data);
                    console.log("data in filterCoursesAjax : ", data.data.rows)
                    // apppendCourses(data, id);
                    // button unable
                    // jQuery(`#${nextButton.id}`).prop('disabled', false);
                }
            })
        // }
    }


});
// end of jquery
