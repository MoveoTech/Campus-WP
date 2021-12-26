<?php
global $fields;
echo "<div id='single_project_quotes_floor' class='container-fluid'>
    <div class='row'>";
        $readmore = cin_get_str('muni_quote_read_more');
        $close = cin_get_str('muni_quote_close');
        foreach ($fields['quots_list'] as $item) {
            echo "
            <div class='col-12 col-md-6 single_project_quote'>
                <img src='{$item['image']}' alt='{$item['name_and_role']}' />
                <h2 class='single_project_quote_name_and_role'>{$item['name_and_role']}</h2>
                <h3 class='single_project_quote_short_text'>{$item['short_text']}</h3>
                <br />
                <div class='single_project_quote_long_text'><span>" . wrap_text_with_char(nl2br($item['long_text'])) ."</span></div>
                <a data-color='gray' class='new_design_btn single_project_quote_btn' role='button' aria-hidden='true' aria-label='{$item['name_and_role']} $readmore' aria-expanded='false' href='javascript: void(0);'>
                    <span>$readmore</span>
                    <span>$close</span>
                </a>
            </div>";
            }
    echo "</div>
</div>
";