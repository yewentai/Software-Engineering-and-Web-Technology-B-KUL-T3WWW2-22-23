create table feedback
(
    id      int auto_increment
        primary key,
    text    text                               not null,
    author  varchar(20)                        null,
    created datetime default CURRENT_TIMESTAMP not null
);

create table staff
(
    id    int auto_increment
        primary key,
    name  varchar(30) null,
    email varchar(50) null
);

create table course
(
    id    char(6)
        primary key,
    fase  int         null,
    name  varchar(60) null,
    staff int         null,
    constraint staff_fk
        foreign key (staff) references staff (id)
);

create table book
(
    id      int auto_increment
        primary key,
    title   varchar(70) null,
    isbn    bigint      null,
    obliged bit         null,
    course  char(6)         null,
    constraint course_fk
        foreign key (course) references course (id)
);

create table student
(
    id    int auto_increment
        primary key,
    email varchar(50) null
);

create table reservation
(
    id      int auto_increment
        primary key,
    student int                                null,
    created datetime default CURRENT_TIMESTAMP not null,
    constraint student_fk
        foreign key (student) references student (id)
);

create table reservation_book
(
    reservation int not null,
    book        int not null,
    primary key (book, reservation),
    constraint book_fk
        foreign key (book) references book (id),
    constraint reservation_fk
        foreign key (reservation) references reservation (id)
);