


$= jQuery.noConflict();

$(document).ready(function($) {
    console.log("holi from js");
    $('#btnExportpriority').on('click',function () {
        //write to the file
        const rows = [
            ['Course id','Course name','Course Priority'],
        ];
        $('#table_body tr').each(function () {
            let id = $(this).find('#id_selected').attr('data-selected');
            let name = $(this).find('#name_selected').attr('data-selected');
            let priority = $(this).find('#priority_selected').attr('data-selected');
            // console.log("name : ", name)
            rows.push([id,name,priority]);
        });
        console.log("before export : ", rows)
        exportToCsv("Courses",rows)
    });

    $('#upload_template_organizations').on('click',function () {
        //need to iterate all organizations and create them
        let csv = $(this).parents('.upload_template_section').find('#file').prop("files")[0];
        if (csv === undefined) {
            Swal.fire(
                'There is no file',
                'Please choose a file',
                'info'
            )
            return;
        }
        if (csv.type !== "text/csv") {
            Swal.fire(
                'The file type is not valid',
                'Please choose a csv file',
                'info'
            )
            return;
        }

        const reader = new FileReader();
        reader.onload = async function (event) {
            function sleep(ms)
            {
                return new Promise(resolve => setTimeout(resolve, ms));
            }

            const text = event.target.result;
            const data = csvToArray(text);
            let allCountries = JSON.parse(admin_ajax.listOfCountries);
            let jsonArray = [];
            let orgNotUploadedArray = [], count = 0;
            $.each(allCountries, function (id, name) {
                jsonArray.push({id:id, name: name});
            });
            //all the organizations
            for (let i=0; i<data.length; i++) {
                if (data[i]['Organization id'] !== "") {
                    let org = data[i];
                    let countryCode,countryName;
                    const country = jsonArray.find(element => element.name === data[i]['Country']);
                    if (country) {
                        countryCode = country.id;
                        countryName = country.name;
                    }
                    $.ajax({
                        type : "post",
                        dataType : "json",
                        url: admin_ajax.ajaxurl,
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
                                orgNotUploadedArray.push(org);
                            }
                        },
                        error: function (error) {
                            org.message = error.status;
                            orgNotUploadedArray.push(org)
                            count = count + 1;
                        }
                    })
                } else {
                    count = count + 1;
                    data[i].message = "Organization id is empty";
                    orgNotUploadedArray.push(data[i])
                }
            }
            let refreshIntervalId =setInterval(function () {
                if (count === data.length) {
                    clearInterval(refreshIntervalId);
                    const rows = [
                        ['Organization id','Organization name','Country' ,'Website','Status',"Message"],
                    ];
                    for (let i = 0; i<orgNotUploadedArray.length; i++) {
                        let id = orgNotUploadedArray[i]['Organization id'];
                        let name = orgNotUploadedArray[i]['Organization name'];
                        let status = orgNotUploadedArray[i]['Status'];
                        let country = orgNotUploadedArray[i]['Country'];
                        let website = orgNotUploadedArray[i]['Website'];
                        let message = orgNotUploadedArray[i]['message'];
                        rows.push([id,name,country,website,status,message]);
                    }
                    exportToCsv("organizations_not_uploaded",rows)
                }
            },500)
        };
        reader.readAsText(csv);
    });


    // export to cvs function
    function exportToCsv(filename, rows)
    {
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

        var csvFile = '';
        for (var i = 0; i < rows.length; i++) {
            csvFile += processRow(rows[i]);
        }

        var blob = new Blob([csvFile], { type: 'text/csv;charset=utf-8;' });
        if (navigator.msSaveBlob) { // IE 10+
            navigator.msSaveBlob(blob, filename);
        } else {
            var link = document.createElement("a");
            if (link.download !== undefined) { // feature detection
                // Browsers that support HTML5 download attribute
                var url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", filename);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }
    }





});





