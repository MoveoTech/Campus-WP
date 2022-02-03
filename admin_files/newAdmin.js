
window.addEventListener('DOMContentLoaded', (event) => {
    check();
    validateDuplicatedTagsGroup();

});


function check(){
    var container = document.querySelectorAll(".pods-form-ui-row-name-single-multiple");

    if(container.length == 0)
        return

    var radios = container[0].querySelectorAll('input[type="radio"]');

    radios.forEach(e =>{
        if (e.checked){
            changeSingleMulti(e.value)
        }
    })

    for(radio in radios) {
        radios[radio].onclick = function() {
            changeSingleMulti(this.value)
        }
    }

}


function changeSingleMulti(value){
    var group = document.getElementsByClassName("pods-form-ui-row-name-group");

    if(group.length == 0)
        return

    if(value == 1)
        group[0].style.display = "";
    else
        group[0].style.display = "none";
    // removeGroups(group[0]);

}

function removeGroups(group){

    // group.style.display = "none";

    // var x = group.getElementsByClassName("pods-pick-values");
    // x.innerHTML = '';


}





async function validateDuplicatedTagsGroup() {

    var tagsContainer = document.getElementById("pods-meta-box-tags");
    console.log(name);
    if (!tagsContainer)
        return;

    var ulContainer = tagsContainer.querySelectorAll(".pods-pick-values");

    if (!ulContainer)
        return;


    ulContainer.forEach(container => {
        container.addEventListener('DOMSubtreeModified', async function (e) {
            var tags = container.querySelectorAll("ul.pods-relationship li.pods-relationship");

            var uniqueDulicatedMode = await getUniqueDulicatedModes(tags);
            showDuplicatesTags(tags, uniqueDulicatedMode);
            // var errorContainer = tagsContainer.getElementsByClassName("pods-submittable-fields");
            var errorContainer = container.closest('div .pods-submittable-fields');

            if (uniqueDulicatedMode.length > 0)
                showErorMessage(errorContainer, uniqueDulicatedMode);
            else
                removeErrorMessage(errorContainer);

        });
    })
}


    function removeErrorMessage(errorContainer){

        var message = errorContainer.querySelector('.tags-modes-error');

        if(message){
            errorContainer.removeChild(message);
        }
        let errors = document.querySelectorAll(".tags-modes-error");
        if(errors.length == 0){
            document.getElementById("publishing-action").getElementsByTagName("input")[0].disabled = false;
        }

    }

    function showErorMessage(errorContainer,modes){
        removeErrorMessage(errorContainer);
        var message = "Duplicated Tags Group : " + modes.join();
        var error = `<div class="tags-modes-error" style='position: relative; display: block; color: #cc2727;  border-color: #d12626; margin: 5px 0 15px; padding: 12px; border-left: #ee0000 solid 3px; background: #ffe6e6; max-width: 776px;'><p>${message}</p></div>`;
        document.getElementById("publishing-action").getElementsByTagName("input")[0].disabled = true;

        errorContainer.insertAdjacentHTML("afterbegin",error);
    }


    function showDuplicatesTags(tags, modes){
        tags.forEach(e =>{
            if(checkInvalidMode(e, modes))
                e.style.backgroundColor = '#ffe6e6';
            else
                e.style.backgroundColor = '#fff';

        })
    }

    function checkInvalidMode(e, modes){
        var tagName = e.getElementsByClassName("pods-dfv-list-name");
        if(tagName[0].textContent.includes(" - ")){
            const [name, mode] = tagName[0].textContent.split(' - ');
            if(modes.includes(mode))
                return true;
        }
        return false;
    }

    function getUniqueDulicatedModes(tags){
        var tagsNameArray = [];
        tags.forEach(e =>{
            var tagName = e.getElementsByClassName("pods-dfv-list-name");
            if(tagName[0].textContent.includes(" - ")){
                const [name, mode] = tagName[0].textContent.split(' - ');
                tagsNameArray.push(mode)
            }
        })
        return [...new Set(findDuplicates(tagsNameArray))];
    }

    function toFindDuplicates(arry) {
        const uniqueElements = new Set(arry);
        const filteredElements = arry.filter(item => {
            if (uniqueElements.has(item)) {
                uniqueElements.delete(item);
            } else {
                return item;
            }
        });

        return [...new Set(uniqueElements)]
    }

    function findDuplicates(arr){
        return arr.filter((item, index) => arr.indexOf(item) != index)
    }
