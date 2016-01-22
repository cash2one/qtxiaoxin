<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/storage/uploads'; // Relative to the root

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	createFolder($targetPath);
	
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
        $newname = date('YmdHis').rand(1000,9999).'.'.$fileParts['extension'];
		$targetFile = rtrim($targetPath,'/') . '/' .$newname;
		move_uploaded_file($tempFile,$targetFile);
        $path = $targetFolder = '/storage/uploads'. '/' . $newname;
		echo $path;
	} else {
		echo 'Invalid file type.';
	}
}

function createFolder($path)
{
	if (!file_exists($path)){
		createFolder(dirname($path));
		mkdir($path, 0777);
	}
}
?>