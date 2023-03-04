<?php

$hours = readline('Enter a hours: ');
$minutes = readline('Enter a minutes: ');
$time_converter = new TimeToWordConverter();
$time_string = $time_converter->convert($hours, $minutes);
echo $time_string;
