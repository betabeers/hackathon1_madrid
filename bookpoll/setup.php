<?php

require 'lib/db.php';
require 'config.php';

// conectar base de datos
$db = new DB( $db_config );
setlocale(LC_ALL, 'es_ES');