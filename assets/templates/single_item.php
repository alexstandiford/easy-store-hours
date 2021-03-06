<li itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification" <?php echo $store_hours->singleClass(); ?>>
  <span itemprop="dayOfWeek" class="day">
    <?php echo $store_hours->currentDay->name; ?>
  </span>:
  <?php if($store_hours->currentDay->isOpen()): ?>
  <span class="hours">
    <time itemprop="opens" datetime="<?php echo $store_hours->currentDay->getTimestamp('open'); ?>">
      <?php echo $store_hours->currentDay->getTime('open'); ?>
    </time>
    <?php echo $store_hours->hourSeparator; ?>
    <time itemprop="closes" datetime="<?php echo $store_hours->currentDay->getTimestamp('closed'); ?>">
      <?php echo $store_hours->currentDay->getTime('closed'); ?>
    </time>
  </span>
  <?php else: ?>
  <span class="is-closed">
    <?php echo $store_hours->closedText; ?>
  </span>
  <?php endif; ?>
</li>