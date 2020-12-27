# Camel Test

- It is a project that you can management users by an api rest, also you can log in in the system by way a view and 
you can read the username, the last access in date time format and where did you access.

## To make the system, it was necessary to identify three entities and their data definitions:
		
	- users -> 
		- id [int][11][auto increment][primary_key]
		- user [varchar][100][unique]
		- password [varchar][255] (sha1)
		- last_access [date_time] (it is updated in each access either through the web or api)
		- roles_id [int][11][foreign key][related: roles]

	- roles ->
		- id [int][11][auto increment][primary_key]
		- rol [varchar][150][unique]

	- sessions ->
		- id [int][11][auto increment][primary_key]
		- users_id [int][11][foreign key][related: users]
		- access_way [varchar][3] (can be "API" || "WEB")
		- token [varchar][255] (token of security to access api by http request, authorization after authentication with user & password. This token waill expire.)
		- created [date_time] (date time creation)
		- exp [date_time] (date time to expired token)

## Configure:
	- WEB ->
		config/
			config.php ->
				Line 5) $name_project = "camelTest"; /*name of the folder that contain this project.*/
				Line 9) define("EXPIRE_MINS_INAC", 3); /*mins to check if exist inactivity & close session.*/
			Database.php -> /*set values to parameters of connection to database.*/
				Line 10) $this->server = 'localhost';
        		Line 11) $this->database = 'camel';
        		Line 12) $this->username = 'root';
        		Line 13) $this->password = '';
	- API ->
		config/
			config.php ->
				Line 5) $name_project = "camelTest"; /*name of the folder that contain this project.*/
				Line 9) define("EXPIRE_MINS_INAC", 3); /*mins expire token.*/
			Database.php -> /*set values to parameters of connection to database.*/
				Line 10) $this->server = 'localhost';
        		Line 11) $this->database = 'camel';
        		Line 12) $this->username = 'root';
        		Line 13) $this->password = '';
## HTTP Status Codes using:
	- WEB ->
		-> 302 Found To use for redirect and routes founded

	- API ->
		/api/authorization.php
			-> 401 Unauthorized for users that doesn´t have credentials or no coincidence user/password.

		/api/users.php
			-> 200 OK for correctly responses.	
			-> 403 Forbidden for sessión expired or no token.
			-> 201 Created in add a new user.
			-> 500 Internal server error if exist a error when execute a transaction sql.
			-> 400 Bad request if(user == null || password == null || roles_id == null).
			-> 403 Forbidden when rol = "USUARIO" || rol.id = 2	

## Instructive API

	- To use this API, it´s necesary authentication & authorization to get a token a save a new session.

		BASE_URL_API = http://localhost/project_name <=> example http://localhost/camelTest

		/* http://localhost/camelTest/api/authorization.php */
		- endpoint: /api/authorization.php
		- method: post
		- data: {user[string | length [100], password [string | length 255]} /*minimum data required*/
		- response: json successful. Example: 
			{"token":"0bde6c863e65a2c958453b9bdfe2b4ff4dbec9633b511c51150c09b97d6392f6","created":"2020-12-26 08:29:08","expired":"2020-12-26 08:32:08"}
	 	Token with date time of creation and expire. That will register in session table. Otherwise the answer will be a http status code.

	
	Once you get the token, you can access the other endpoints, create an user[POST], update an user[PATCH], get an user or get all users[GET], delete an user[DELETE].

	- Create an user:
		/* http://localhost/camelTest/api/users.php */
		- endpoint: BASE_URL_API/api/users.php
		- method: post
		- data: {token [string | length 255], user [string | 100], password [string | 255], roles_id [integer | 11]} /*minimum data required*/
		- response: json successful. Example: 
			{"id":4,"user":"usuario3","last_access":"2020-12-27 08:12:15","roles_id":"2"} 
		Created user data is response by api. Otherwise the answer will be a http status code.

	- Update an user:
		/* http://localhost/camelTest/api/users.php */
		- endpoint: BASE_URL_API/api/users.php
		- method: patch
		- data: {token [string | length 255], user [string | 100], password [string | 255], roles_id [integer | 11], user_id [integer | 11]} */minimum data required/*
		- response a json successful. Example: 
			{"id":4,"user":"usuario3","roles_id":"2"}
		Edited user data is response by api. Otherwise the answer will be a http status code.

	- Get an user or Get all users:
		/* http://localhost/camelTest/api/users.php */
		- endpoint: BASE_URL_API/api/users.php
		- method: get
		- data: {token [string | length 255], id [integer | 11 ]} */minimum data required only token, id can be null or empty/*
		- response: json successful with a specific user or all users. Example:
				All users:
					[{"id":1,"user":"admin","last_access":"27-12-2020
					09:17:34","rol_id":1,"rol":"ADMINISTRADOR"},{"id":2,"user":"usuario1","last_access":"26-12-2020
					04:07:30","rol_id":2,"rol":"USUARIO"},{"id":3,"user":"usuario2","last_access":"25-12-2020
					00:01:30","rol_id":2,"rol":"USUARIO"},{"id":4,"user":"usuario3","last_access":"27-12-2020
					08:12:15","rol_id":2,"rol":"USUARIO"}]
				Specific user:
					{"id":1,"user":"admin","last_access":"27-12-2020 09:17:34","rol_id":1,"rol":"ADMINISTRADOR"}
		Get user data is response by api. Otherwise the answer will be a http status code.
	
	- Delete an user:
		/* http://localhost/camelTest/api/users.php */
		- endpoint: BASE_URL_API/api/users.php
		- method: delete
		- data: {token [string | length 255], id [integer | 11 ]} /*minimum data required*/
		- response: header http status code "200 OK" successful. Otherwise the answer will be a http status code.

	
## Users example:
	1) id => 1, user => admin, password => admin, rol_id => 1, rol = ADMINISTRADOR
	2) id => 2, user => usuario1, password => usuario1, rol_id => 2, rol = USUARIO