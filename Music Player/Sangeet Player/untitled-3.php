<?php
	$Name = $_POST['Name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$number = $_POST['age'];

	// Database connection
	$conn = new mysqli('localhost','root','','musicplayer');

	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt=$conn->prepare("select * from musicplayer.users where email = ?");
		$stmt->bind_param("s",$email);
		$stmt->execute();
		$stmt_result = $stmt->get_result();
		if($stmt_result->num_rows === 0){

			$stmt1 = $conn->prepare("insert into musicplayer.users(Name,Age,email,password) values(?, ?, ?, ?)");
			$stmt1->bind_param("siss",$Name, $number,$email,$password);
			$stmt1->execute();
			$stmt1->close();


			$stmt2 = $conn->prepare("insert into login(email, date,time) values(?,curdate(),curtime())");
			$stmt2->bind_param("s",$email);
			$stmt2->execute();
			header("location: index.html");
			$stmt2->close();
			
			$stmt->close();
			$conn->close();

		}
		
		
	}

	echo "DONE";
?>