<?php

if (!defined('ABSPATH')) {
    die;
}

use MyMembership\Admin\Pages\PageAbstract;
use MyMembership\Admin\Pages\TabAbstract;

/**
 * @var PageAbstract $page
 * @var TabAbstract[] $tabs
 * @var TabAbstract $currentTab
 */

?>
<nav class="nav-tab-wrapper nav-tabs-premmerce">
    <?php foreach ($tabs as $tab) : ?>
        <a href="<?php echo $tab->getUri(); ?>" class="nav-tab<?php echo $tab === $currentTab ? ' nav-tab-active' : ''; ?>"><?php echo $tab->getTitle(); ?></a>
    <?php endforeach; ?>
</nav>