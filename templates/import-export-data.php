<?php

//getting the data from pods and showing it on the admin
$params = [
    'limit'   => 50,
];
$courses = pods( 'courses', $params, true);
$all_rows = $courses->data();

?>

<div class="priority-control-wrap">
    <div class="wraping-div">
        <h1>Priorety Control</h1>
        <div class="buttonsArea">
            <p>import and export file description(fill in english and hebrew?)</p>
            <button id="btnExportpriority">Export File</button>
            <button id="btnImportpriority">Import File</button>
            <input type="file" id="choosefile" accept=".csv"/>
        </div>
        <table>
            <thead>
            <tr>
                <td>Count</td>
                <td>Course ID</td>
                <td>Course Name</td>
                <td>Course order</td>
            </tr>
            </thead>
            <tbody id="table_body">
            <?php
            //count for dev only
            $count = 0;
            foreach ($all_rows as $course) {
                $id = $course->id;
                $name = $course->name;
                $priority = $course->order;
                //count for dev only
                $count++;

                ?>

                <tr>
<!--                    //count for dev only-->
                    <td><?php echo $count ?></td>
                    <td id="id_selected"><?php echo $id ?></td>
                    <td id="name_selected"><?php echo $name ?></td>
                    <td id="priority_selected"><?php echo $priority ?></td>
                </tr>

            <?php } ?>
            </tbody>
        </table>





    </div>
</div>





