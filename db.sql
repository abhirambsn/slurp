CREATE TABLE customer(
    customer_id varchar(100) primary key,
    customer_name varchar(60) not null,
    address text not null,
    email varchar(100) not null,
    phone_number varchar(12) not null,

);

CREATE TABLE user(
    user_id varchar(100) primary key,
    email varchar(100) not null,
    password varchar(255) not null,
    isAdmin boolean not null default(false),
    customer_id varchar(100) not null,
    FOREIGN KEY (email) REFERENCES customer(email),
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
);

CREATE TABLE restaurant(
    restaurant_id varchar(100) primary key,
    restaurant_name varchar(60) not null,
    email varchar(100) not null,
    address text not null,
    phone_number varchar(12) not null
);

CREATE TABLE review(
    review_id varchar(100) primary key,
    customer_id varchar(100) not null,
    restaurant_id varchar(100) not null,
    rating decimal(2, 2) default 0.0 not null,
    comment text,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id),
    FOREIGN KEY (restaurant_id) REFERENCES restaurant(restaurant_id)
);

