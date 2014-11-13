--initial dump
CREATE TABLE categories (
    id serial primary key,
    name text NOT NULL
);

CREATE TABLE books (
    id serial primary key,
    category_id int references categories(id),
    name text NOT NULL,
    description text,
    author text NOT NULL,
    rating int,
    link text
);

CREATE TABLE users ( 
    id serial primary key,
    firstname text,
    lastname text,
    email varchar,
    password VARCHAR
);

CREATE TABLE contacts (
    id serial primary key,
    name text,
    value varchar,
    userId int references users(id)
);

CREATE TABLE  users_to_books (
    id serial primary key,
    user_id int REFERENCES users(id),
    book_id int REFERENCES books(id)
);
