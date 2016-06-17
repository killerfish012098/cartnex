<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array(
    'connectionString' => 'mysql:host=localhost;dbname=cartnex',
    'emulatePrepare' => true,
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    'tablePrefix' => 'r_',
    'schemaCachingDuration' => 180, //caches database schema for given seconds
    'enableProfiling'=>false, //for query profiling
    'enableParamLogging'=>false, //for query profiling
);