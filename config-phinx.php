<?php
require __DIR__ . '/app/bootstrap/db_settings.php';
return [
  'paths' => [
    'migrations' => 'migrations'
  ],
  'migration_base_class' => '\bhubr\HashBack\Migration\Migration',
  'environments' => [
    'default_migration_table' => 'phinxlog',
    'default_database' => 'dev',
    'dev' => [
      'adapter' => 'mysql',
      'host' => DB_HOST,
      'name' => DB_NAME,
      'user' => DB_USER,
      'pass' => DB_PASS,
      'port' => DB_PORT
    ]
  ]
];