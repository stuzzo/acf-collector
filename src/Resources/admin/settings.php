<?php

/*
 * This file is part of the ACF Collector plugin.
 *
 * (c) Alfredo Aiello <stuzzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

?>
<!--<h2>Advanced Custom Fields Collector Settings</h2>-->
<div class="acf-collector-container">
    <div class="acf-collector-container_body">
        <form method="post" action="options.php">
            <?php
            settings_fields($optionGroup);

            do_settings_sections($optionGroup);?>

            <?php submit_button(); ?>
        </form>
    </div>
</div>