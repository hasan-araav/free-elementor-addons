<div class="wrap">
    <div class="content">
        <div class="tab-headers">
            <?php $tabs = self::get_tabs(); ?>
            <?php foreach ($tabs as $tab) : ?>
                <button class="tablink" data-target="<?php echo $tab['template']; ?>"><?php echo $tab['title']; ?></button>
            <?php endforeach; ?>
        </div>
        <div class="tab-contents">
            <?php foreach ($tabs as $tab) : ?>
                <?php self::load_template( $tab['template'] ); ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>