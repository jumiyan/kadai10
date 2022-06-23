<?php

$pw = password_hash('test1',PASSWORD_DEFAULT);
echo $pw;

// 表示された内容が 'test1' を hash化したもの
