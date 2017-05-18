<li <?php echo $store_hours->singleClass(); ?>>
  <span class="day"><?php echo $store_hours->currentDay->name; ?></span>: <span class="hours"><?php echo $store_hours->getHours(); ?></span>
</li>