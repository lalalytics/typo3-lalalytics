CREATE TABLE tx_lalalytics_domain_model_event (
	site varchar(255) NOT NULL DEFAULT '',
	type varchar(255) NOT NULL DEFAULT '',
	selector varchar(255) NOT NULL DEFAULT '',
	name varchar(255) NOT NULL DEFAULT '',
	description text NOT NULL DEFAULT '',
	tags varchar(255) NOT NULL DEFAULT '',
	attribute varchar(255) NOT NULL DEFAULT ''
);
