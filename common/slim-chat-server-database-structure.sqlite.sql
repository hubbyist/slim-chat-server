--
# ---------------------------------------------------------------------------- *
#
# LICENSE UNDECIDED
#
# ---------------------------------------------------------------------------- *
# Copyright 2023 Mehmet Durgel. All Rights Reserved.
# ---------------------------------------------------------------------------- *
# @author Mehmet Durgel<md@legrud.net>
# ---------------------------------------------------------------------------- *
--

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS dialogs;
DROP TABLE IF EXISTS users_of_dialogs;
DROP TABLE IF EXISTS messages_of_dialogs;

CREATE TABLE users (id int PRIMARY KEY, username text, password text, salt text);
CREATE TABLE dialogs (id int PRIMARY KEY, title text);
CREATE TABLE users_of_dialogs (id int PRIMARY KEY, dialog_id int, user_id int);
CREATE TABLE messages_of_dialogs (id int PRIMARY KEY, dialog_id int, user_id int, created datetime, content text);

INSERT INTO users (id, username, password, salt) VALUES (1, 'chatter-1', '4a846a933eb4373f3a3e93e865c60ea5dc9522abdcfcbe2cd971dc800ae795d3', '223a26a6af50362adcbf6d74103f9a05');
INSERT INTO users (id, username, password, salt) VALUES (2, 'chatter-2', '2073f3f7ee7e05798c3b325e6e2a8bb69a292721a4b523c0587814a684dd0f46', '38f73ea9c0a50cbf164e4dc9a53deebb');
INSERT INTO users (id, username, password, salt) VALUES (3, 'chatter-3', 'b7859db0cc54d4a807c85e29f0b197707881d848d29f03eacf6a706eb97ec453', 'e698c4dd8adebc7573897caad278e534');
INSERT INTO dialogs (id, title) VALUES (1, 'Chat with chatter-2');
INSERT INTO dialogs (id, title) VALUES (2, 'Chat with chatter-3');
INSERT INTO dialogs (id, title) VALUES (3, 'Chat with chatter-1');
INSERT INTO users_of_dialogs (dialog_id, user_id) VALUES (1, 1);
INSERT INTO users_of_dialogs (dialog_id, user_id) VALUES (1, 2);
INSERT INTO users_of_dialogs (dialog_id, user_id) VALUES (2, 2);
INSERT INTO users_of_dialogs (dialog_id, user_id) VALUES (2, 3);
INSERT INTO users_of_dialogs (dialog_id, user_id) VALUES (3, 3);
INSERT INTO users_of_dialogs (dialog_id, user_id) VALUES (3, 1);
INSERT INTO messages_of_dialogs (id, dialog_id, user_id, created, content) VALUES (1, 1, 1, strftime('%s', '1970-01-01 00:01:00'), 'Hello chatter-2. Are you ready to start?');
INSERT INTO messages_of_dialogs (id, dialog_id, user_id, created, content) VALUES (2, 1, 2, strftime('%s', '1970-01-01 00:02:00'), 'Hello chatter-1. Yes.');
INSERT INTO messages_of_dialogs (id, dialog_id, user_id, created, content) VALUES (3, 2, 2, strftime('%s', '1970-01-01 00:03:00'), 'Hello chatter-3. Are you ready to start?');
INSERT INTO messages_of_dialogs (id, dialog_id, user_id, created, content) VALUES (4, 2, 3, strftime('%s', '1970-01-01 00:04:00'), 'Hello chatter-2. Yes.');
INSERT INTO messages_of_dialogs (id, dialog_id, user_id, created, content) VALUES (5, 3, 3, strftime('%s', '1970-01-01 00:05:00'), 'Hello chatter-1. Are you ready to start?');
INSERT INTO messages_of_dialogs (id, dialog_id, user_id, created, content) VALUES (6, 3, 1, strftime('%s', '1970-01-01 00:06:00'), 'Hello chatter-3. Yes.');
INSERT INTO messages_of_dialogs (id, dialog_id, user_id, created, content) VALUES (7, 3, 1, strftime('%s', '1970-01-01 00:07:00'), 'Loop completed. You may proceed chatter-3.');
