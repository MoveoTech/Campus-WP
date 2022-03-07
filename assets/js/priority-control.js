$= jQuery.noConflict();
// getting the data from the admin
$(document).ready(function($) {
    $('#btnExportpriority').on('click',function () {
        //write to the file
        const rows = [
            ['Course ID','Course name','Course Priority'],
        ];
        $('#table_body tr').each(function () {
            let id = $(this).find('#id_selected').html();
            let name = $(this).find('#name_selected').html();
            let priority = $(this).find('#priority_selected').html();
            rows.push([id,name,priority]);
        });
        console.log("before export : ", rows)
        exportToCsv("Courses",rows)
    });

    $('#btnImportpriority').on('click',function () {
        //need to iterate all organizations and create them
        let csv = $(this).parents('.buttonsArea').find('#choosefile').prop("files")[0];
        console.log(csv)
        if (csv === undefined) {
            console.log("inside if == undefined")
            Swal.fire(
                'There is no file',
                'Please choose a file',
                'info'
            )
            return;
        }
        if (csv.type !== "text/csv") {
            console.log("inside if type of")
            Swal.fire(
                'The file type is not valid',
                'Please choose a csv file',
                'info'
            )
            return;
        }

        const reader = new FileReader();
        reader.onload = async function (event) {
            // console.log("reader.onload event : ", event);

            const text = event.target.result;
            // console.log("reader.onload = async function text : ", text);
            const data = csvToArray(text);

            console.log("reader.onload = async function data : ", data);
            //all the organizations
            for (let i=0; i<data.length; i++) {
                // if (data[i]['Course ID'] !== "") {
                    let course= data[i];
                // console.log("course : ", course);
                  // course.forEach(element => {
                  //     console.log("course : ", element);
                  //     // console.log("course : ", element['Course ID']);
                  //     // console.log("course : ", element['Course Name']);
                  //     // console.log("Course order : ", element['Course order']);
                  // })


                    // let countryCode,countryName;
                    // const country = jsonArray.find(element => element.name === data[i]['Country']);
                    // if (country) {
                    //     countryCode = country.id;
                    //     countryName = country.name;
                    // }
                    $.ajax({
                        type : "post",
                        dataType : "json",
                        // url: admin_ajax.ajaxurl,
                        data : {
                            action: 'equal_impact_add_new_organization',
                            status : org['Status'],
                            name : org['Organization name'],
                            org_id : org['Organization id'],
                            country:countryName,
                            countryCode:countryCode,
                            website:org['Website']
                        },
                        success: function (response) {
                            count = count + 1;
                            console.log(response);
                            if (response && response.success) {
                            } else {
                                org.message = response.data;
                                // orgNotUploadedArray.push(org);
                            }
                        },
                        error: function (error) {
                            org.message = error.status;
                            // orgNotUploadedArray.push(org)
                            count = count + 1;
                        }
                    })
                // } else {
                //     console.log("error message", data[i])
                //     count = count + 1;
                //     data[i].message = "Organization id is empty";
                //     // orgNotUploadedArray.push(data[i])
                // }
            }
            // let refreshIntervalId =setInterval(function () {
            //     if (count === data.length) {
            //         clearInterval(refreshIntervalId);
            //         const rows = [
            //             ['Organization id','Organization name','Country' ,'Website','Status',"Message"],
            //         ];
            //         for (let i = 0; i<orgNotUploadedArray.length; i++) {
            //             let id = orgNotUploadedArray[i]['Organization id'];
            //             let name = orgNotUploadedArray[i]['Organization name'];
            //             let status = orgNotUploadedArray[i]['Status'];
            //             let country = orgNotUploadedArray[i]['Country'];
            //             let website = orgNotUploadedArray[i]['Website'];
            //             let message = orgNotUploadedArray[i]['message'];
            //             rows.push([id,name,country,website,status,message]);
            //         }
            //         // exportToCsv("organizations_not_uploaded",rows)
            //     }
            // },500)
        };
        reader.readAsText(csv);
    });


    // export to cvs function
    function exportToCsv(filename, rows)
    {
        // console.log(" in function exportToCsv : ",rows)
        let processRow = function (row) {
            let finalVal = '';

            for (let j = 0; j < row.length; j++) {
                let innerValue = (row[j] === null || row[j] === undefined) ? '' : row[j].toString();
                if (row[j] instanceof Date) {
                    innerValue = row[j].toLocaleString();
                };
                let result = innerValue.replace(/"/g, '""');

                if (result.search(/("|,|\n)/g) >= 0) {
                    result = '"' + result + '"';
                }
                if (j > 0) {
                    finalVal += ',';
                }
                finalVal += result;
            }
            return finalVal + '\n';
        };

        let csvFile = '';
        for (var i = 0; i < rows.length; i++) {
            csvFile += processRow(rows[i]);
        }

        let blob = new Blob([csvFile], { type: 'text/csv;charset=utf-8;' });
        if (navigator.msSaveBlob) { // IE 10+
            navigator.msSaveBlob(blob, filename);
        } else {
            let link = document.createElement("a");
            if (link.download !== undefined) { // feature detection
                // Browsers that support HTML5 download attribute
                let url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", filename);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }
    }
//excel create and upload templates
    function csvToArray(str, delimiter = ",")
    {
        const headers = str.slice(0, str.indexOf("\n")).split(delimiter);
        // console.log("function csvToArray headers : ", headers);
        const rows = str.slice(str.indexOf("\n") + 1).split("\n");
        // console.log("function csvToArray rows : ", rows);
        const arr = rows.map(function (row) {
            console.log("row : ", row);
            const values = row.split(delimiter);
            // console.log("function csvToArray values : ", values);

            const el = headers.reduce(function (object, header, index) {
                object[header] = values[index];
                // console.log("object : ", object);
                return object;
            }, {});

            // console.log("el : ", el);
            return el;
        });
        console.log("arr : ", arr);

        return arr;
    }




});





