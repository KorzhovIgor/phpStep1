create table comments
(
    id         int auto_increment
        primary key,
    title      varchar(30)  not null,
    content    varchar(400) not null,
    created_at date         not null
);

create table migrations
(
    id         int unsigned auto_increment
        primary key,
    name       varchar(100) not null,
    created_at date         not null
);

create table thms
(
    id          int unsigned auto_increment
        primary key,
    description varchar(30) not null
);

create table users
(
    id        int unsigned auto_increment
        primary key,
    firstname varchar(30) not null,
    lastname  varchar(30) not null
);