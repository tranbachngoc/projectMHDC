<div id="user-activities" class="tab-pane active">
    <div class="timeline-2">
        <?php foreach($result as $vals): ?>
            <div class="time-item">
                <div class="item-info">
                    <div class="text-muted"><?php echo date("d-m-Y H:i:s",strtotime($vals->lastupdated)); ?></div>
                    <p><strong><?php echo $vals->content; ?></strong></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>