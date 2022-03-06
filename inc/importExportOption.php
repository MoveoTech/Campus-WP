<?php

function import_export_options()
{
add_menu_page(
'Priority Control',
'Priority Control',
'administrator',
'campus-priority-control',
'campus-priority-function',
'',
60
);

}
add_action('admin_menu', 'import_export_options');
?>

<div class="priority-control-wrap">
    <div class="wraping-div">
        <h1>Priorety Control</h1>

        <h3>Export File</h3>
        <button id="btnExportpriority">Export File</button>
        <table>
            <thead>
            <tr>
                <td>Course ID</td>
                <td>Course Name</td>
                <td>Course order</td>
            </tr>
            </thead>

            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>





    </div>
</div>




