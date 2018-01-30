<?php

namespace taytus\climenu\classes;

use taytus\climenu\classes\Posta;
use Symfony\Component\Console\Application;



$app = new Application();
$app->add(new Posta());
$app->run();


