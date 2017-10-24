<?php require_once(APP_DIR.'/templates/header.php') ?>


<div class="">

    <h2 class="page-header <?php echo $display_bus_times_list ? '' : 'front-page' ?>">Bus Times</h2>

    <form class="" role="form" action="index.php" method="GET">
        <input type="hidden" name="a" value="find_bus_times" />

        <div class="form-group">
            <label for="bus_number">Bus Number</label>
            <input type="text" name="bus_number" value="<?php echo $bus_number ?>" class="form-control" id="bus_number" aria-describedby="busNumber" placeholder="Enter Bus Number" />
            <small id="emailHelp" class="form-text text-muted">Let us help you stay on time.</small>
        </div>

        <button type="submit" class="btn btn-primary <?php echo ($bus_number == '') ? 'animated tada' : '' ?> _infinite">Find Times</button>
    </form>

    <?php if($bus_number != ""): ?>
    <div id="bus-times" class="animated slideInUp">
        <ul class="nav nav-tabs " style="margin-top:50px;">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#monday">Mon</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " data-toggle="tab" href="#tuesday">Tue</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " data-toggle="tab" href="#wednesday">Wed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " data-toggle="tab" href="#thursday">Thu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " data-toggle="tab" href="#friday">Fri</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " data-toggle="tab" href="#saturday">Sat</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " data-toggle="tab" href="#sunday">Sun</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " data-toggle="tab" href="#public_holidays">Public Holidays</a>
            </li>
        </ul>

        <div class="tab-content" style="">
            <?php foreach($days as $k=>$day): ?>
                <div class="tab-pane animated fadeIn <?php echo $k==0 ? 'active' : '' ?>"  id="<?php echo strtolower($day)?>" role="tab-panel">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th style="width:80%">Location</th>
                            <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($points_in_day as $k=>$point): ?>
                            <?php if(strtolower($point['day']) == strtolower($day)): ?>
                            <tr>
                                <td><?php echo $point['description'] ?></td>
                                <th scope="row">
                                    <?php echo $point['arrival_hour'] ?>:<?php echo str_pad($point['arrival_minute'], 2, "0", STR_PAD_LEFT) ?>
                                    <?php if($point['arrival_hour'] != $point['departure_hour'] || $point['arrival_minute'] != $point['departure_minute']): ?>
                                        - <?php echo $point['departure_hour'] ?>:<?php echo str_pad($point['departure_minute'], 2, "0", STR_PAD_LEFT) ?>
                                    <?php endif; ?>
                                </th>
                            </tr>
                            <?php endif ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
















<?php require_once(APP_DIR.'/templates/footer.php') ?>