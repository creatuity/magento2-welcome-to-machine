<?php

use Magento\Framework\DB\Ddl\Table;

/* @var $installer \Magento\Setup\Module\SetupModule */
$installer = $this;

/**
 * Drop tables
 */

$installer->getConnection()->dropTable(
    $installer->getTable('welcome_tracks'));

$installer->getConnection()->dropTable(
    $installer->getTable('welcome_albums'));

/**
 * Create table 'albums'
 */

$installer->getConnection()->createTable(
    $installer->getConnection()->newTable(
        $installer->getTable('welcome_albums')
    )->addColumn(
        'album_id',
        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
        null,
        array('identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true),
        'ID'
    )->addColumn(
        'title',
        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
        255,
        array('nullable' => false, 'default' => ''),
        'Title'
    )->addColumn(
        'year',
        \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
        null,
        array('unsigned' => false, 'nullable' => true, 'default' => null),
        'Year'
    )->addIndex(
        $installer->getIdxName('welcome_albums', 'title'),
        'title'
    )->addIndex(
        $installer->getIdxName('welcome_albums', 'year'),
        'year'
    )->setComment(
        'Welcome To Machines - Albums'
    )
);


/**
 * Create table 'tracks'
 */

$installer->getConnection()->createTable(
    $installer->getConnection()->newTable(
        $installer->getTable('welcome_tracks')
    )->addColumn(
        'track_id',
        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
        null,
        array('identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true),
        'ID'
    )->addColumn(
        'title',
        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
        255,
        array('nullable' => false, 'default' => ''),
        'Title'
    )->addColumn(
        'track_number',
        \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
        null,
        array('unsigned' => true, 'nullable' => true, 'default' => null),
        'Track Number'
    )->addColumn(
        'album_id',
        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
        null,
        array('unsigned' => true, 'nullable' => false),
        'Album Id'
    )->addIndex(
        $installer->getIdxName('welcome_tracks', 'title'),
        'title'
    )->addIndex(
        $installer->getIdxName('welcome_tracks', 'track_number'),
        'track_number'
    )->addForeignKey(
        $installer->getFkName('welcome_tracks', 'album_id', 'welcome_albums', 'album_id'), 'album_id', 
        $installer->getTable('welcome_albums'), 'album_id', Table::ACTION_CASCADE
    )->setComment(
        'Welcome To Machines - Tracks'
    )
);



