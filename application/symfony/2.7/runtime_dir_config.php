<?php

return sys_get_temp_dir() .
    DIRECTORY_SEPARATOR .
    'symfony' .
    DIRECTORY_SEPARATOR .
    trim(str_replace(DIRECTORY_SEPARATOR, '-', dirname(__DIR__)), '-');
