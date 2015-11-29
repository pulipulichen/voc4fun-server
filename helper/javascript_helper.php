<?php

if (function_exists("json_header") === false) {
    function json_header() {
        header('Content-Type: application/json; charset=utf-8');
    }
}

