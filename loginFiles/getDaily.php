<?php
require_once $_SERVER['DOCUMENT_ROOT'].'rabbitFiles/loginRBMQ.php';
$matchup = json_decode(getDaily());

