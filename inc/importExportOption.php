<?php

//function import_export_options()
//{
////add_menu_page(
////'Priority Control',
////'Priority Control',
////'administrator',
////'campus-priority-control',
////'campus-priority-function',
////'',
////60
////);
//    add_submenu_page(
//        'option-page-campus',
//        'Priority Control',
//        'Priority Control',
//        'administrator',
//        'campus-priority-control',
//        'campus-priority-control'
//    );
//
//}
//add_action('admin_menu', 'import_export_options');

$params = [
    'limit'   => -1,
];
$courses = pods( 'courses', $params, true);
$found_courses = $courses->total_found();
//var_dump( $found_courses);
//$name = $courses->display( 'name' );
//foreach ($courses as $course) {
//    $id = $course->display( 'ID' );
//    $name = $course->display( 'name' );
//    $priority = $course->display( 'order' );
//    console_log($name);
//    console_log($id);
//    console_log($priority);
//
//}

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
<?php foreach ($courses as $course) {
//    console_log($course);
    $id = $course->display( 'ID' );
    $name = $course->display( 'name' );
    $priority = $course->display( 'order' );
    ?>
        <tbody id="table_body">
            <tr>
                <td id="id_selected" data-selected="<?php echo $id ?>"><?php echo $id ?></td>
                <td id="name_selected" data-selected="<?php echo $name ?>"><?php echo $name ?></td>
                <td id="priority_selected" data-selected="<?php echo $priority ?>"><?php echo $priority ?></td>
            </tr>
        </tbody>
<?php } ?>

        </table>





    </div>
</div>




