<?php

namespace AcMarche\MarcheTail;


use AcMarche\MarcheTail\Inc\RouterMarche;
use AcMarche\MarcheTail\Lib\Mailer;
use AcMarche\MarcheTail\Lib\Twig;

/**
 * This page is called by symfony @file  functions.php
 */
//$statusCode;  $statusText;
//get_header();

Twig::rend500Page();
get_footer();

try {
    Mailer::sendError('error visit', "page ".RouterMarche::getCurrentUrl());

} catch (\Exception $exception) {

}