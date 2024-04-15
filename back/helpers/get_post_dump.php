<?php

function get_post_dump()
{
    if (isset($_POST) && !empty($_POST)) {
        echo '<h4 style="color: purple;">$_POST</h4>';
        echo '<pre>';
        var_dump($_POST);
        echo '</pre>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
    }
    if (isset($_GET) && !empty($_GET)) {
        echo '<h4 style="color: orange;">$_GET</h4>';
        echo '<pre>';
        var_dump($_GET);
        echo '</pre>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
    }
}
