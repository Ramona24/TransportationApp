<?php


$days = array(
    'Monday', 
    'Tuesday', 
    'Wednesday', 
    'Thursday', 
    'Friday', 
    'Saturday', 
    'Sunday',
    'Public Holidays'
);

$bus_number = isset($_GET['bus_number']) ? $_GET['bus_number'] : '';

$display_bus_times_list = $bus_number != "";

$query_params = array(
  $bus_number
);

$sql = "
  SELECT * 
  FROM point_in_day
  LEFT JOIN points
    ON point_in_day.point_id = points.id
  LEFT JOIN busses
    ON point_in_day.bus_id = busses.id
  WHERE busses.number = ? 
";

if(isset($_GET['filter_by_point_id']) && ($_GET['filter_by_point_id'] != 'all')) {
  $sql .= " AND point_in_day.point_id = ? ";
  $query_params[] = $_GET['filter_by_point_id'];
}

$sql .= " ORDER BY group_id, arrival_hour, arrival_minute ";
$points_in_day = db_query($sql, $query_params);

//print_r($points_in_day);