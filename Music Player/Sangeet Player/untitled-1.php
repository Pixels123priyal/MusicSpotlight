<?php
	$email = $_POST['email'];
	$password = $_POST['password'];

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
		if($stmt_result->num_rows > 0){
			$data = $stmt_result->fetch_assoc();
			if($data['password'] === $password){
				echo "<h2>Login Successful</h2>";

				$stmt2 = $conn->prepare("insert into login(email, date,time) values(?,curdate(),curtime())");
				$stmt2->bind_param("s",$email);
				$stmt2->execute();
				header("location: index.html");
				$conn->close();
				
			}else{
				header("location: untitled-1.html");
			}
		}else{
			header("location: untitled-1.html");
		}
	}
?>