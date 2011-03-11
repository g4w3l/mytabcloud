-- Script PostGRESQL

CREATE TABLE mtc_user
(
  usr_id serial NOT NULL,
  usr_login character varying(50) NOT NULL,
  usr_name character varying(50),
  usr_password character varying(32) NOT NULL,
  usr_mail character varying(100),
  usr_created timestamp with time zone,
  CONSTRAINT pk_user PRIMARY KEY (usr_id),
  CONSTRAINT unique_usr_login UNIQUE (usr_login)
)
WITH (
  OIDS=FALSE
);

CREATE TABLE mtc_tab
(
  tab_id serial NOT NULL,
  tab_artist character varying(50),
  tab_title character varying(50),
  tab_nb_strings integer,
  tab_user integer NOT NULL,
  CONSTRAINT pk_tab PRIMARY KEY (tab_id),
  CONSTRAINT fk_user_tab FOREIGN KEY (tab_user)
      REFERENCES mtc_user (usr_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);