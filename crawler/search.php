<html dir="rtl">
<head>
<meta charset="utf-8">
<title>sport</title>
<style>
	table, tr{
		display: block;
		/*width: 100%;*/
		border-bottom: 3px double pink;
	}
	td{
		/*width: 1%;*/
		display: inline-block;
		word-break: break-word;
		padding: 15px;
		white-space: pre-wrap;
	}
	strong {
	    color: red;
	}
	textarea{
		width:100%;
		height:200px;
	}
</style>
</head>
<body>
<?php 
require_once "SQL_login.php";
?>
	<form dir = "ltr">
		<input name="start" placeholder="starting date" value = "<?=$_GET['start']?>"/>
		<input name="end" placeholder="endind date" value = "<?=$_GET['end']?>"/>
		<input type="submit"/>
	</form>

	<div dir="ltr">
	<?php
		
	
		$query = "SELECT sport_videos.id, sport_videos.description, picture, sport_videos.created_time
		FROM sport_videos
		WHERE  ";
		
		if($team_id)
			$query .= "page_id = $team_id AND ";
		
		if($_GET['start'])
			$query.="created_time > '" . $_GET['start'] . "' AND\n";
		if($_GET['end'])
			$query.="created_time < '" . $_GET['end'] . "' AND\n";
		
		$query.="1=1
		
		ORDER BY  sport_videos.`created_time` ASC ";
		echo '<pre>'.$query.'</pre>';
	?>
	</div>
	
	
	
	
	
	
	
	
		<script language="javascript" type="text/javascript" src="jquery.js"></script>
		<script language="javascript" type="text/javascript" src="jquery.flot.js"></script>
		<script language="javascript" type="text/javascript" src="jquery.flot.time.js"></script>
	
	
	<?php
		
		
		
	$result = $link->query($query) or trigger_error(mysqli_error($link)." ".$query);
	
	
	echo '<h2>found ' . $result->num_rows  . ' videos</h2>';
	
	$table = "";
	$first = true;
	while($vid = mysqli_fetch_array($result)){
		$table .= "<tr>";
		$table .= "<td style = 'width: 180px'><a href='http://facebook.com/" . $vid['id'] . "'>" . $vid['id'] . "</a></td>";
		$table .= "<td style = 'width: 300px'>" . $vid['description'] . "</td>";
		$table .= "<td style = 'width: 250px'><img src='" . $vid['picture'] . "'></td>";
		$table .= "<td style = 'width: 100px'>" . $vid['created_time'] . "</td>";
		$table .= "</tr>";
	}
	?>
		
		
	
	<h1>videos between relevant dates</h1>
	<table width= "100%">
		<thead>
			<tr>
				<td style = 'width: 180px'>link</td>
				<td style = 'width: 300px'>description</td>
				<td style = 'width: 250px'>picture</td>
				<td style = 'width: 100px'>date</td>
			</tr>
		</thead>
		<tbody>
			<?=$table?>
		</tbody>
	</table>
</body>
</html>