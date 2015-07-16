<?php
$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'tota11y` (
    `id_tota11y` int(11) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY  (`id_tota11y`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
