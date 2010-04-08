CREATE TABLE tx_sjroffers_domain_model_organization (
	uid int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	name varchar(255) NOT NULL,
	address text NOT NULL,
	telephone_number varchar(80) NOT NULL,
	telefax_number varchar(80) NOT NULL,
	url varchar(80) NOT NULL,
	email_address varchar(80) NOT NULL,
	description text NOT NULL,
	image varchar(255) NOT NULL,
	contacts int(11) NOT NULL,
	offers int(11) NOT NULL,
	administrator int(11),
	
	tstamp int(10) unsigned NOT NULL,
	crdate int(10) unsigned NOT NULL,
	deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(3) unsigned DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	access_group int(11) NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
);

CREATE TABLE tx_sjroffers_domain_model_offer (
	uid int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	organization int(11) NOT NULL,
	title varchar(255) NOT NULL,
	teaser text NOT NULL,
	description text NOT NULL,
	services text NOT NULL,
	dates text NOT NULL,
	venue text NOT NULL,
	image tinyblob NOT NULL,
	age_range int(11) NOT NULL,
	date_range int(11) NOT NULL,
	attendance_range int(11) NOT NULL,
	attendance_fees int(11) NOT NULL,
	contact int(11) NOT NULL,
	categories int(11) NOT NULL,
	regions int(11) NOT NULL,
	
	tstamp int(10) unsigned NOT NULL,
	crdate int(10) unsigned NOT NULL,
	deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(3) unsigned DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
);

CREATE TABLE tx_sjroffers_domain_model_person (
	uid int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	name varchar(255) DEFAULT '' NOT NULL,
	role varchar(255) DEFAULT '' NOT NULL,
	address text NOT NULL,
	telephone_number varchar(80) DEFAULT '' NOT NULL,
	telefax_number varchar(80) DEFAULT '' NOT NULL,
	url varchar(80) DEFAULT '' NOT NULL,
	email_address varchar(80) DEFAULT '' NOT NULL,
	
	tstamp int(10) unsigned NOT NULL,
	crdate int(10) unsigned NOT NULL,
	deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(3) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
);

CREATE TABLE tx_sjroffers_domain_model_agerange (
	uid int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	minimum_value int(10) unsigned,
	maximum_value int(10) unsigned,
	
	PRIMARY KEY (uid),
	KEY parent (pid),
);

CREATE TABLE tx_sjroffers_domain_model_daterange (
	uid int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	minimum_value int(10) unsigned,
	maximum_value int(10) unsigned,
	
	PRIMARY KEY (uid),
	KEY parent (pid),
);

CREATE TABLE tx_sjroffers_domain_model_attendancerange (
	uid int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	minimum_value int(10) unsigned,
	maximum_value int(10) unsigned,
	
	PRIMARY KEY (uid),
	KEY parent (pid),
);

CREATE TABLE tx_sjroffers_domain_model_attendancefee (
	uid int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	offer int(11) DEFAULT '0' NOT NULL,
	amount decimal(10,2) DEFAULT '0.00' NOT NULL,
	comment text NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid),
);

CREATE TABLE tx_sjroffers_domain_model_category (
	uid int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	is_internal tinyint(10) unsigned DEFAULT '0' NOT NULL,
		
	tstamp int(10) unsigned NOT NULL,
	crdate int(10) unsigned NOT NULL,
	deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(3) unsigned DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
);

CREATE TABLE tx_sjroffers_domain_model_region (
	uid int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
		
	tstamp int(10) unsigned NOT NULL,
	crdate int(10) unsigned NOT NULL,
	deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(3) unsigned DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
);

CREATE TABLE tx_sjroffers_organization_person_mm (
	uid int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	uid_local int(10) unsigned NOT NULL,
	uid_foreign int(10) unsigned NOT NULL,
	sorting int(10) unsigned NOT NULL,
	sorting_foreign int(10) unsigned NOT NULL,

	tstamp int(10) unsigned NOT NULL,
	crdate int(10) unsigned NOT NULL,
	deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(3) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid,uid_local,uid_foreign)
);

CREATE TABLE tx_sjroffers_offer_category_mm (
	uid int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	uid_local int(10) unsigned NOT NULL,
	uid_foreign int(10) unsigned NOT NULL,
	sorting int(10) unsigned NOT NULL,
	sorting_foreign int(10) unsigned NOT NULL,

	tstamp int(10) unsigned NOT NULL,
	crdate int(10) unsigned NOT NULL,
	deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(3) unsigned DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid,uid_local,uid_foreign)
);

CREATE TABLE tx_sjroffers_offer_region_mm (
	uid int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	uid_local int(10) unsigned NOT NULL,
	uid_foreign int(10) unsigned NOT NULL,
	sorting int(10) unsigned NOT NULL,
	sorting_foreign int(10) unsigned NOT NULL,
	
	tstamp int(10) unsigned NOT NULL,
	crdate int(10) unsigned NOT NULL,
	deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(3) unsigned DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid,uid_local,uid_foreign)
);