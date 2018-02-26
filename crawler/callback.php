<?php

	$DO_NOT_CLOSE_SESSION = 1;
	require_once "header.php";
?>
		<?php
		try {
		  $accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  echo 'Graph returned an error: ' . $e->getMessage();
          var_dump($helper->getError());

		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}

		if (!isset($accessToken)) {
		if ($helper->getError()) {
    		  header('HTTP/1.0 401 Unauthorized');
   		      echo "Error: " . $helper->getError() . "\n";
    		  echo "Error Code: " . $helper->getErrorCode() . "\n";
    		  echo "Error Reason: " . $helper->getErrorReason() . "\n";
    		  echo "Error Description: " . $helper->getErrorDescription() . "\n";
  		} else {
   		 header('HTTP/1.0 400 Bad Request');
                   echo 'Bad request';
  		}
         exit;
		}

		//var_dump($accessToken->getValue());

		// The OAuth 2.0 client handler helps us manage access tokens
		$oAuth2Client = $fb->getOAuth2Client();

		// Get the access token metadata from /debug_token
		$tokenMetadata = $oAuth2Client->debugToken($accessToken);
		//var_dump($tokenMetadata);

		// Validation (these will throw FacebookSDKException's when they fail)
		$tokenMetadata->validateAppId($app_id); // Replace {app-id} with your app id
		// If you know the user ID this access token belongs to, you can validate it here
		//$tokenMetadata->validateUserId('123');
		$tokenMetadata->validateExpiration();

		if (! $accessToken->isLongLived()) {
  		// Exchanges a short-lived access token for a long-lived one
  			try {
   			   $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  			} catch (Facebook\Exceptions\FacebookSDKException $e) {
    			echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    			exit;
  			}

		  //echo '<h3>Long-lived</h3>';
  		//var_dump($accessToken->getValue());
		}
                   	// Logged in!
			$_SESSION['facebook_access_token'] = (string) $accessToken;

			echo "successfully logged in!<br>";
			//echo '<a href = "data.php">view data</a>';
			// Now you can redirect to another page and use the
			// access token from $_SESSION['facebook_access_token']

		session_write_close();
		?>
	</body>
</html>
