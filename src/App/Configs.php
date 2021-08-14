<?php

$container->set('db_settings',function(){
  return(object)[
    "DB_NAME"=>'curso_angular',
    "DB_PASS"=>'root',
    "DB_CHAR"=>'utf8',
    "DB_HOST"=>'localhost',
    "DB_USER"=>'root'
  ];
});
