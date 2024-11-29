CREATE DATABASE blog_data;

USE blog_data;

CREATE TABLE posts (
                       id INT PRIMARY KEY,
                       user_id INT NOT NULL,
                       title VARCHAR(255) NOT NULL,
                       body TEXT NOT NULL
);

CREATE TABLE comments (
                          id INT PRIMARY KEY,
                          post_id INT NOT NULL,
                          name VARCHAR(255) NOT NULL,
                          email VARCHAR(255) NOT NULL,
                          body TEXT NOT NULL,
                          FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);
