<?php
	require_once "SQL_login.php";
	require_once "header.php";
	require_once "locals.php";
	if(isset($_GET['page_id']))
	    $pages = [ $_GET['page_id'] ];
    else
		$pages = array();
		$query = 'SELECT sport_pages.id FROM sport_pages';
		$result = $link->query($query) or trigger_error(mysqli_error($link)." ".$query);
		while($row = mysqli_fetch_assoc($result)) {
			array_push($pages, $row['id']); 
		}
	    
	shuffle($pages);
?>

		<?php
		if (isset($_SESSION['facebook_access_token'])) {
	    ?>
        <form method="get">
            <input name="page_id" placeholder="enter page id">
            <input type="submit">
        </form>

        <script   src="https://code.jquery.com/jquery-2.2.2.min.js"   integrity="sha256-36cp2Co+/62rEAAYHLmRCPIych47CvdM+uTBJwSzWjI=" crossorigin="anonymous"></script>
    
    	<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>

	    
	        you are now log in !
	        <br>
	        
	    
		    <input type = 'checkbox' id='moveon'>read posts since 2015-01-01?</input>
        <?php } else { ?>
        you are not log in !
        <?php } ?>

		<p>
		<?php
		if (isset($_SESSION['facebook_access_token'])) {
			
			$accessToken = $_SESSION['facebook_access_token'];
						
			$fb->setDefaultAccessToken($accessToken);
				foreach($pages as $page){
				try {
				  $response = $fb->get($page .'?fields=name,id,about,likes');
				  $Node = $response->getGraphObject();
				} catch(Facebook\Exceptions\FacebookResponseException $e) {
				  // When Graph returns an error
				  echo 'Graph returned an error: ' . $e->getMessage();
				  //exit;
				} catch(Facebook\Exceptions\FacebookSDKException $e) {
				  // When validation fails or other local issues
				  echo 'Facebook SDK returned an error: ' . $e->getMessage();
				  exit;
				}
				
				echo '<br><br><br>
				
				
				
				';
				echo 'scanning page: ' . $Node->getField('name');
				echo "<br>\n";
				
				
				
				
				$like=$Node;
				
				$result = $link->query('SELECT * FROM sport_pages WHERE id=' . $like->getField('id'));
				if($result->num_rows == 0){
					echo 'id: ' . $like->getField('id'). "\n";
					echo "<br>\n~~~~~~~~~~~~<br>\n";
					echo "NEW ITEM!<br>\n";
					$query = "
						INSERT INTO
						 `sport_pages` 
						(`id`, `name`, `likes`, `about`)
						 VALUES
						(
							". $like->getField('id') .",
							'". trim(htmlspecialchars($like->getField('name'), ENT_QUOTES)) ."',
							". 1 .",
							'". trim(htmlspecialchars($like->getField('about'), ENT_QUOTES))."'
						)";
					$result = $link->query($query);
					echo '<pre>' . $query . "</pre><br>\n";
					if(!$result) echo mysqli_error($link) . "<br>\n";
					
					echo "<br>\n~~~~~~~~~~~~<br>\n";
				}else
					echo 'page id ' . $like->getField('id') . ' ("' . $like->getField('name') . '") has already been inserted. ';
				echo "<span class='pagePostsCrawling' id='page_".$like->getField('id')."_data'>waiting to read page's posts</span><br>";
			
			}
		}
		?>
		</p>
		
		
		
		<script>
		// reteive data from firebase about the already read data
		var PagesLastReadingRef = new Firebase("https://csnoamproject.firebaseio.com/").child("sport_PagesLastReading");
		var PagesLastReading;
		PagesLastReadingRef.on("value", function(snapshot) {
		  PagesLastReading = snapshot.val() || [];
		}, function (errorObject) {
		  console.log("The read failed: " + errorObject.code);
		});
		
		
		var pageLoadingDataDivs = $(".pagePostsCrawling");
		var index = 0;
		var max_pages=50;
		var currTime = new Date().valueOf();
		function scan_page_likes(){
			var page_id = pageLoadingDataDivs[index].id.split('_')[1];
			
			if($('#moveon').is(':checked')){
				  			  	//if V is marked
				if(!PagesLastReading){					//if Firabase not loaded yet
					window.setTimeout(function(){
						if(index<pageLoadingDataDivs.length)
							scan_page_likes()
					},300);
				}else if( latelyScanned(PagesLastReading[page_id]) ){			//if post has already been read
					$(pageLoadingDataDivs[index]).html("no need to load data - data already scanned at: "+formatTime(PagesLastReading[page_id]));
					index++;
					if(index<pageLoadingDataDivs.length)
						scan_page_likes();
				}else{
					$.get("data-posts.php?start=0&page_id="+page_id+"&max_pages="+max_pages, function(data){
						$(pageLoadingDataDivs[index]).html(data);
						PagesLastReadingRef.child(page_id).set(new Date().valueOf());
						index++;
						if(index<pageLoadingDataDivs.length)
							scan_page_likes()
					});
				}
			}else{
				window.setTimeout(scan_page_likes, 300);
			}
		}
		scan_page_likes();
		
		
		
		function latelyScanned(t){
			if(!t) return false;
			if(currTime - t < 1000 * 60) // one minute
				return true;
			return false;
		}
		
		function formatTime(t){
			t = new Date(t);
			return '  '+t.getDate() +"/"+(t.getMonth()+1)+"/"+t.getFullYear()+"  "+t.getHours()+":"+t.getMinutes()+":"+t.getSeconds();
		}
		</script>
	</body>
</html>