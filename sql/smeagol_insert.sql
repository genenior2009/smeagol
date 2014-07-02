use smeagol
-- Table role
INSERT INTO role (type,description) VALUE("admin","Admin User"); 
INSERT INTO role (type,description) VALUE("editor","User with rol of editor"); 
INSERT INTO role (type,description) VALUE("user","Every Authenticate User"); 

-- Table user
INSERT INTO user (id,username,password,name,surname,email,active,role_type,modified)
VALUES (NULL,"admin",md5("alumno"),"Admin","of Universe","tucorreo@gmail.com",1,"admin",NOW());

-- Table node_type 
INSERT INTO node_type (id,name) VALUES(NULL,"page");
INSERT INTO node_type (id,name) VALUES(NULL,"notice");

-- Table node
INSERT INTO node (id,node_type_id,title,content,url,user_id,created) 
VALUES(NULL,1,"Smeagol CMS","Smeagol CMS, un demo de desarrolado en Zend Framework 2","/smeagol",1,NOW());

INSERT INTO node (id,node_type_id,title,content,url,user_id,created) 
VALUES(NULL,2,"Smeagol primer CMS en ZF2","haber si funca","/noticias/smeagol-primer-cms-en-zf2",1,NOW());

INSERT INTO node (id,node_type_id,title,content,url,user_id,created) 
VALUES(NULL,2,"El mundial Brasil 2014 esta que quema","ELl mundial esta super emocionante","/noticias/mundialsuper-emocionante",1,NOW());