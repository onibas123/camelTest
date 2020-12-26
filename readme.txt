Camel Test
It is a project that you can management users by an api rest, also you can log in in the system by way a view and 
you can read the username, the last access in date time format and where did you access.

To make the system, it was necessary to identify three entities:
	users -> 
		- id [int][11][auto increment][primary_key]
		- user [varchar][100][unique]
		- password [varchar][255] (sha1)
		- last_access [date_time] (it is updated in each access either through the web or api)
		- roles_id [int][11][foreign key][related: roles]

	roles ->
		- id [int][11][auto increment][primary_key]
		- rol [varchar][150][unique]

	sessions ->
		- id [int][11][auto increment][primary_key]
		- users_id [int][11][foreign key][related: users]
		- access_way [varchar][3] (can be "API" || "WEB")
		- token [varchar][255] (token of security to access api by http request, authorization after authentication with user & password. This token waill expire.)
		- created [date_time] (date time creation)
		- exp [date_time] (date time to expired token)

Configure:
	WEB ->
		config.php ->
		Database.php ->





	API ->
		config.php ->
		Database.php ->


HTTP Status Codes using:
	WEB ->
		


	API ->


Instructive API
	To use this API, it´s necesary authentication & authorization to get a token a save a new session.

	endpoint: http://localhost/project_name/api/authorization.php
	method: post
	data: {user[string | length 100], password [string | length 255]}
	response a json. Example: 
	{"token":"0bde6c863e65a2c958453b9bdfe2b4ff4dbec9633b511c51150c09b97d6392f6","created":"2020-12-26 08:29:08","expired":"2020-12-26 08:32:08"}
	 => token with date time of creation and expire. That will register in session table.

	
	Once i get the token, i can access the other endpoints, create a user[POST], update a user[PATCH], get a user or get all users[GET], delete a user[DELETE].


	