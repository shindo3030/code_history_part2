<?php
function dropTable($link)
{
  $sql = 'DROP TABLE IF EXISTS lists';
  $results = mysqli_query($link, $sql);
}

//function createTable($link)
//{
$sql = <<<EOT
  CREATE TABLE lists (
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    content VARCHAR(5000),
    memo_date DATE
    ) DEFAULT CHARACTER SET=utf8mb4;
  EOT;
$results = mysqli_query($link, $sql);
//}
