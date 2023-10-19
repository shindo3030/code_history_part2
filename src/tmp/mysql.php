//テーブルの作成テスト

CREATE TABLE companies (
id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255),
establishment_date DATE,
founder VARCHAR(255),
created_at TIMESTAMP NOT NULL DEFAULT
CURRENT_TIMESTAMP
) DEFAULT CHARACTER SET = utf8mb4;

//book_logテーブル作成テスト
CREATE TABLE reviews(
id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(255),
author VARCHAR(255),
status VARCHAR(10),
score INTEGER,
summary VARCHAR(1500),
created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARACTER SET = utf8mb4;

//INSERTO INTO データの追加
INSERT INTO companies (
name,
establishment_date,
founder
) VALUES (
'mercari inc',
'2013-02-01',
'Shintaro Yamada'
);

//INSERT
INSERT INTO companies (
name,
establishment_date,
founder
) VALUES (
'NTTdocomo',
'1991-08-14',
'IiTakayuki'
);

//INSERT date型にアルファベットが含まれていた場合
INSERT INTO companies (
name,
establishment_date,
founder
) VALUES (
'Hachi inc',
'2019-01-first',
'HACHI'
);

//PHPから
