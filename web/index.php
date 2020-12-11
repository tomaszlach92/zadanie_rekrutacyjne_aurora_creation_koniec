<?php

require_once '../vendor/autoload.php';

$app = new App\App();
$app->helpers['template']->render(
        'home'
);
