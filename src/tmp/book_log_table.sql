DROP TABLE IF EXISTS reviews;

CREATE TABLE reviews (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  author VARCHAR(255),
  status VARCHAR(10),
  score INTEGER,
  summary VARCHAR(1500),
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARACTER SET = utf8mb4;

//INSERT
INSERT INTO reviews (
  title,
  author,
  status,
  score,
  summary
) VALUES (
  'Momo',
  'Micheel Ende',
  'complete',
  '5',
  'I love this book since I was little.'
);
