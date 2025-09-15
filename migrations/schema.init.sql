create table if not exists products
(
    id int auto_increment primary key,
    uuid varchar(255) not null comment 'UUID товара',
    category  varchar(255) not null comment 'Категория товара',
    is_active tinyint default 1  not null comment 'Флаг активности',
    name text not null comment 'Тип услуги',
    description text null comment 'Описание товара',
    thumbnail  varchar(255) null comment 'Ссылка на картинку',
    price float not null comment 'Цена'
)
    comment 'Товары';

create index uuid_idx on products (uuid);
create index is_active_category_idx on products (is_active, category);