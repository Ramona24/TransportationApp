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

if(strtolower($_SERVER['REQUEST_METHOD']) == 'get') {
  $bus_number = isset($_GET['bus_number']) ? $_GET['bus_number'] : '';
} else {
  $bus_number = isset($_POST['bus_number']) ? $_POST['bus_number'] : '';
}

$display_bus_times_list = $bus_number != "";

//echo $bus_number;


$points_in_day = db_query(
    "SELECT *, point_in_day.id as point_in_day_id 
    FROM point_in_day
    LEFT JOIN points
      ON point_in_day.point_id = points.id
    LEFT JOIN busses
      ON point_in_day.bus_id = busses.id
    WHERE busses.number = ? 
    ORDER BY hour, minute",
    array($bus_number)
);

$points = db_query("SELECT * FROM points ");


// Update If POST 

if(strtolower($_SERVER['REQUEST_METHOD']) == 'post') {

  $points = $_POST['point'];

  $bus_records = db_get_by('busses', 'number', $bus_number);
  print_r($bus_records);
  if(count($bus_records) > 0) {
    $bus_id = $bus_records[0]['id'];
  } else {
    $bus_id = db_insert('busses', array('number' => $bus_number));
  }

  foreach($points as $day => $day_points) {
    foreach($day_points as $point) {

      //print_r(array($day, $point));
      if(( ! $point['point_in_day_id']) && ($point['point_id'] != '0') ) {
        db_insert('point_in_day', array(
          'day' => $day,
          'point_id' => $point['point_id'],
          'bus_id' => $bus_id,
          'hour' => $point['hour'],
          'minute' => $point['minute'],
        ));
      } else {
        db_update('point_in_day', $point['point_in_day_id'], array(
          'day' => $day,
          'point_id' => $point['point_id'],
          'bus_id' => $bus_id,
          'hour' => $point['hour'],
          'minute' => $point['minute'],
        ));
      }
    }
  }

  header('Location: index.php?a=manage_times&bus_number='.$bus_number);
  exit;
}

//print_r($points_in_day);