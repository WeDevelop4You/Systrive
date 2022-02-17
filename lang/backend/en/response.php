<?php

return array (
  'success' =>
  array (
    'vesta' =>
    array (
      'api' =>
      array (
        'success' => 'Command has been successfully performed',
      ),
    ),
    'deleted' => 'Successfully deleted',
    'saved' => 'Successfully saved',
  ),
  'error' =>
  array (
    'vesta' =>
    array (
      'api' =>
      array (
        'args' => 'Not enough arguments provided',
        'invalid' => 'Object or argument is not valid',
        'not_exist' => 'Object doesn\'t exist',
        'exists' => 'Object already exists',
        'suspended' => 'Object is suspended',
        'unsuspended' => 'Object is already unsuspended',
        'inuse' => 'Object can\'t be deleted because is used by the other object',
        'limit' => 'Object cannot be created because of hosting package limits',
        'password' => 'Wrong password',
        'forbidden' => 'Object cannot be accessed be the user',
        'disabled' => 'Subsystem is disabled',
        'parsing' => 'Configuration is broken',
        'disk' => 'Not enough disk space to complete the action',
        'la' => 'Server is to busy to complete the action',
        'connect' => 'Connection failed. Host is unreachable',
        'ftp' => 'FTP server is not responding',
        'db' => 'Database server is not responding',
        'rrd' => 'RRDtool failed to update the database',
        'update' => 'Update operation failed',
        'restart' => 'Service restart failed',
      ),
    ),
  ),
);
