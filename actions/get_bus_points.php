<?php


$bus_number = isset($_GET['bus_number']) ? $_GET['bus_number'] : '';


$bus_points = db_query(
   "SELECT DISTINCT p.id, p.description 
    FROM point_in_day pid
    LEFT JOIN points p
      ON pid.point_id = p.id
    LEFT JOIN busses
      ON pid.bus_id = busses.id
    WHERE busses.number = ? ",
    array($bus_number)
);

echo json_encode($bus_points);
$uses_template = false;