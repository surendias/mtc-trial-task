<?php

// Render Twig template within container
$app->get('/hello/{name}', 'Controllers\\HelloController:index');
