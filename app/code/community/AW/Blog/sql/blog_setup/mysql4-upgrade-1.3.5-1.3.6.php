<?php
$installer = $this;
$installer->startSetup();
$installer->run("
    ALTER TABLE {$this->getTable('blog/blog')} ADD `show_thumbnail_in_home` tinyint(1);
    ALTER TABLE {$this->getTable('blog/blog')} ADD `thumbnail` varchar(255);
");
$installer->endSetup();
