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

$points = db_query("SELECT * FROM points WHERE 1 ORDER BY description");
$bus = db_get_by('busses', 'number', $bus_number)[0];
$blank_points = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);
$groups = array();


function parseScheduleTime($time_str) {
  $time_parts = explode(' ', $time_str);
  $hour = trim(explode(':', $time_parts[0])[0]);
  $min = trim(explode(':', $time_parts[0])[1]);

  if(strtolower(trim($time_parts[1])) == 'pm') {
    $hour = ((int)$hour) + 12;
  }

  return array('hour' => $hour, 'min' => $min);
}


// Update If POST 

if(strtolower($_SERVER['REQUEST_METHOD']) == 'post') {

  db_execute("DELETE * FROM point_in_day WHERE bus_id = ? ", array($bus['id']));

  $schedule = $_POST['schedule'];
  $schedule_days = $_POST['schedule_days'];
  $schedule_points = $_POST['schedule_points'];

  $groups = explode("\n", $schedule);
  $last_time = null;

  foreach($schedule_days as $sd) {
    $current_group_id = 0;
    foreach($groups as $group) {
      //$guid = guid();
      $group_times = str_split($group, 9);
      foreach($group_times as $point_index => $time) {
        // $time_parts = explode(' ', $time);
        // $hour = trim(explode(':', $time_parts[0])[0]);
        // $min = trim(explode(':', $time_parts[0])[1]);

        $parsed_time = parseScheduleTime($time);

        print_r($time_parts); echo '<br />';

        // if(strtolower(trim($time_parts[1])) == 'pm') {
        //   $hour = ((int)$hour) + 12;
        // }


        if($point_index != 0 && $schedule_points[$point_index] != $schedule_points[$point_index - 1]) {

          db_insert('point_in_day', array(
            'day' => $sd,
            'point_id' => $schedule_points[$point_index],
            'bus_id' => $bus['id'],
            'hour' =>$parsed_time['hour'],
            'minute' => $parsed_time['min'],
            'arrival_hour' => $parsed_time['hour'],
            'arrival_minute' => $parsed_time['min'],
            'departure_hour' => $parsed_time['hour'],
            'departure_minute' => $parsed_time['min'],
            'group_id' => $current_group_id
          ));

        } else {

          db_execute(
            "UPDATE point_in_day 
            SET 
              departure_hour = ?, 
              departure_minute = ?
            WHERE bus_id = ?
            AND arrival_hour = ?
            AND arrival_minute = ? 
            AND group_id = ?", 

            array(
              $parsed_time['hour'], 
              $parsed_time['min'], 
              $bus['id'], 
              $last_time['hour'], 
              $last_time['min'], 
              $current_group_id
            )
          );
        }

        $last_time = $parsed_time;
      }
    }
    $current_group_id ++;
  }



  //header('Location: index.php?a=manage_times_mass&bus_number='.$bus_number);
  exit;
}

//print_r($points_in_day);