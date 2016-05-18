<?php
if(isset($_FILES["file"]["type"]))
{
$validextensions = array("jpeg", "jpg", "png","JPEG", "JPG", "PNG");
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);
if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
) && ($_FILES["file"]["size"] < 10000000000)
&& in_array($file_extension, $validextensions)) {
if ($_FILES["file"]["error"] > 0)
{
echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
}
else
{
if (file_exists("uploads/" . $_FILES["file"]["name"])) { 
}
else
{
$sourcePath = $_FILES['file']['tmp_name']; 
$targetPath = "../uploads/".$_FILES['file']['name']; 
move_uploaded_file($sourcePath,$targetPath) ; 
}
}
}
else
{ 
}
}
?>