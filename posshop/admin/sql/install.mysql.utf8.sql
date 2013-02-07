CREATE TABLE `#__pos_shop_session` (
  session_id int NOT NULL auto_increment,
  PRIMARY KEY  (session_id)
) DEFAULT CHARSET=UTF8;

CREATE TABLE `#__pos_shop_cart` (
  session_id int NOT NULL,
  table_id int NOT NULL,
  row_id int NOT NULL,
  value float NOT NULL,
  PRIMARY KEY  (session_id, table_id, row_id)
) DEFAULT CHARSET=UTF8;

CREATE TABLE `#__pos_shop_table` (
  table_id int NOT NULL,
  row_id int NOT NULL,
  row_data TEXT NOT NULL,
  PRIMARY KEY  (table_id,row_id)
) DEFAULT CHARSET = UTF8;

CREATE TABLE `#__pos_shop_table_config` (
  table_id int NOT NULL,
  picture VARCHAR(256) NOT NULL,
  color CHAR(7) NOT NULL,
  PRIMARY KEY  (table_id)
) DEFAULT CHARSET = UTF8;

CREATE TABLE `#__pos_shop_constant` (
  id int NOT NULL,
  name VARCHAR(32) NOT NULL,
  value bigint NOT NULL,
  PRIMARY KEY  (id)
) DEFAULT CHARSET = UTF8;
