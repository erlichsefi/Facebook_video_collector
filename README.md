# Facebook_video_collector

This is a PHP project written to collect video posts from specified Facebook pages using Facebook api and enabling psychology students to do time base search for thus videos.

 
 
To use this you will need to define the parameters defined in "locals.php".
Thus are:

	$ip='SQL_DB_IP'
	$user='SQL_USER'
	$password='SQL_USER_PASSWORD'
	$database_name='DATABASE_NAME'
	$app_id='YOUR_FACEBOOK_APP_ID';
	$app_secret='YOUR_SECRET_CODE';
	$version='v2.5'
	$local_path_to_dir='PATH/TO/DIR'
	$HTTPS_URL_TO_SITE=''

Your database scheme should be as follow:

	sport_pages
	
	    id(Primary Key)	varchar(20)	utf8mb4_unicode_ci	
	    name	        tinytext	utf8mb4_unicode_ci
	    likes	        int(11)
	    about	        text	    utf8mb4_unicode_ci
	
	
	sport_videos
	
		idPrimary	    varchar(30)	utf8mb4_unicode_ci	
		page_idIndex	varchar(20)	utf8mb4_unicode_ci
		description  	text	    utf8mb4_unicode_ci	
		created_time	datetime
		picture	text	            utf8mb4_unicode_ci
		
NOTE!!! I'M NOT A WEB PROGRAMER! THIS IS A WORKING VERSION ONLY ! 
As i learned during work PHP and HTML.
