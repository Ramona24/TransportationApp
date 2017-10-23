<?php


$days = array(
    'Monday', 
    'Tuesday', 
    'Wednesday', 
    'Thursday', 
    'Friday', 
    'Saturday', 
    'Sunday'
);

$bus_number = isset($_GET['bus_number']) ? $_GET['bus_number'] : '';
//echo $bus_number;


$points_in_day = db_query(
   "SELECT * 
    FROM point_in_day
    LEFT JOIN points
      ON point_in_day.point_id = points.id
    LEFT JOIN busses
      ON point_in_day.bus_id = busses.id
    WHERE busses.number = ? 
    ORDER BY hour, minute",
    array($bus_number)
);

//print_r($points_in_day);