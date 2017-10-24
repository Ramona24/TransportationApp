<?php require_once(APP_DIR.'/templates/header.php') ?>


<div class="col-sm-9">

    <!-- <h2 class="page-header">Bus Times (admin)</h2> -->

    <form class="" role="form" action="index.php?a=manage_times_mass" method="POST">
        <input type="hidden" name="a" value="manage_times_mass" />
        
        <div class="form-group">
            <label for="bus_number">Bus Number</label>
            <input type="text" name="bus_number" value="<?php echo $bus_number ?>" class="form-control" id="bus_number" aria-describedby="busNumber" placeholder="Enter Bus Number" />
        </div>

        <?php foreach($days as $d): ?>
        <div class="form-group">
            <input type="checkbox" name="schedule_days[]" value="<?php echo $d ?>" />
            <label for="schedule"><?php echo $d ?></label>
        </div>
        <?php endforeach; ?>

        <?php foreach($blank_points as $bp): ?>
        <div class="form-group">
            <label for="bus_number">Point <?php echo $bp ?></label>
            <select name="schedule_points[<?php echo $bp ?>]" class="form-control">
            <?php foreach($points as $p): ?>
                <option 
                    value="<?php echo $p['id'] ?>" 
                    <?php echo (isset($_POST['schedule_points'][$bp]) && $_POST['schedule_points'][$bp] == $p['id']) ? 'selected' : ''?> >
                    <?php echo $p['description'] ?>
                </option>
            <?php endforeach; ?>
            </select>
        </div>
        <?php endforeach; ?>

        <div class="form-group">
            <label for="schedule">Schedule</label>
            <textarea name="schedule" value="" class="form-control" id="schedule" aria-describedby="schedule" placeholder="Paste Schedule"></textarea>
        </div>


        <button type="submit" class="btn btn-primary animated tada _infinite">Reset Times</button>
    </form>



    <ul class="nav nav-tabs" style="margin-top:50px;">
        <?php foreach($days as $k=>$day): ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $k==0 ? 'active' : '' ?>" data-toggle="tab" href="#<?php echo strtolower($day) ?>"><?php echo $day ?></a>
        </li>
        <?php endforeach; ?>
    </ul>

    <div class="tab-content" style="margin-top: 20px;">
        <?php foreach($days as $k=>$day): ?>    
            <div class="tab-pane <?php echo $k==0 ? 'active' : '' ?>"  id="<?php echo strtolower($day)?>" role="tab-panel">
                <form class="" role="form" action="index.php?a=manage_times" method="POST">
                    <input type="hidden" name="day" value="<?php echo strtolower($day) ?>" />
                    <input type="hidden" name="bus_number" value="<?php echo $bus_number ?>" />
                    <table class="table">
                        <thead>
                            <tr>
                            <th style="width:80%">Location</th>
                            <th>Hour</th>
                            <th>Min</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($points_in_day as $k=>$point_in_day): ?>
                                <?php if(strtolower($point_in_day['day']) == strtolower($day)): ?>
                                <tr>
                                    <td>
                                        <?php //echo $point_in_day['point_id'] ?>
                                        <input type="hidden"
                                            name="point[<?php echo $day ?>][<?php echo $k ?>][point_in_day_id]"
                                            value="<?php echo $point_in_day['point_in_day_id'] ?>"
                                            class="form-control" />

                                        <select name="point[<?php echo $day ?>][<?php echo $k ?>][point_id]" class="form-control">
                                            <?php foreach($points as $point): ?>
                                            <option <?php echo $point['id'] == $point_in_day['point_id'] ? 'selected' : '' ?> value="<?php echo $point['id'] ?>"><?php echo $point['description'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td scope="row">
                                        <input name="point[<?php echo $day ?>][<?php echo $k ?>][hour]"
                                            value="<?php echo $point_in_day['hour'] ?>"
                                            class="form-control" />
                                    </td>
                                    <td>
                                        <input name="point[<?php echo $day ?>][<?php echo $k ?>][minute]"
                                            value="<?php echo $point_in_day['minute'] ?>"
                                            class="form-control" />
                                    </td>
                                </tr>
                                <?php endif ?>
                            <?php endforeach; ?>
                            <tr>
                            <td cols="3" class="text-center"><b>New Points</b></td>
                            <tr>
                            <?php foreach(array(10000, 10001, 10002, 10003, 10004, 10005, 10006, 10007, 10008, 10009, 10010) as $k): ?>
                                <tr>
                                    <td>
                                        <?php //echo $point_in_day['point_id'] ?>
                                        <input type="hidden"
                                            name="point[<?php echo $day ?>][<?php echo $k ?>][point_in_day_id]"
                                            value=""
                                            class="form-control" />

                                        <select name="point[<?php echo $day ?>][<?php echo $k ?>][point_id]" class="form-control">
                                            <option value="0">Select Point</option>
                                            <?php foreach($points as $point): ?>
                                            <option value="<?php echo $point['id'] ?>"><?php echo $point['description'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td scope="row">
                                        <input name="point[<?php echo $day ?>][<?php echo $k ?>][hour]"
                                            value=""
                                            class="form-control" />
                                    </td>
                                    <td>
                                        <input name="point[<?php echo $day ?>][<?php echo $k ?>][minute]"
                                            value=""
                                            class="form-control" />
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-primary animated tada _infinite">Update Times</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

</div>


<style type="text/css">

    textarea[name=schedule] { 
        height: 300px;
    }

</style>













<?php require_once(APP_DIR.'/templates/footer.php') ?>