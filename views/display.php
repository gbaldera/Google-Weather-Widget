<h2><?php echo $information[0]->city['data']?></h2>
<div class="weather">
    <img src="http://www.google.com<?php echo $current[0]->icon['data']?>" alt="weather">
            <span class="condition">
            <?php echo $current[0]->temp_f['data']?>&deg; F, <?php echo $current[0]->temp_c['data']?>&deg; C,
                <?php echo $current[0]->condition['data']?>
            </span>
</div>
<h2>Forecast</h2>
<?php foreach ($forecast_list as $forecast): ?>
<div class="weather">
    <img src="http://www.google.com<?=$forecast->icon['data']?>" alt="weather">
    <div><?=$forecast->day_of_week['data']?></div>
            <span class="condition">
                    <?=$forecast->low['data']?>&deg; C - <?=$forecast->high['data']?>&deg; C,
                <?=$forecast->condition['data']?>
            </span>
</div>
<?php endforeach; ?>