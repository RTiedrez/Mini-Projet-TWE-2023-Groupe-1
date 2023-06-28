<?php
$targetDirectory = './media/';
$targetFile = $targetDirectory . basename($_FILES['media']['name']);
$uploadSuccess = move_uploaded_file($_FILES['media']['tmp_name'], $targetFile);

if ($uploadSuccess) {
	echo 'Media uploaded successfully.';
}
else {
	echo 'Media upload failed.';
}
?>
