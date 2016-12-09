<?php
// Folder where the file will be saved
$_UP['folder'] = 'uploads/';
// Maximum file size (in Bytes)
$_UP['size'] = 1024 * 1024 * 50; // 50Mb
// Array with the allowed extensions
$_UP['extensions'] = array('rar', 'jpg', 'png', 'gif', 'pdf', 'zip');
// Rename the file? (If true, the file will be saved as .jpg and a unique name)
$_UP['rename'] = false;
// Array with the PHP upload error types
$_UP['errors'][0] = 'There is no errors';
$_UP['errors'][1] = 'The file in upload it is bigger than the PHP limit';
$_UP['errors'][2] = 'The file exceeds the HTML specified size limit';
$_UP['errors'][3] = 'The upload of the file was partially made';
$_UP['errors'][4] = 'The file upload it was not done';
// Verify if there's any upload error. If yes, show a error mensage
if ($_FILES['file']['error'] != 0) {
  die("Could not upload, error:" . $_UP['errors'][$_FILES['file']['error']]);
  exit; // For the script execution
}
// Verify the file extension
$tmp = explode('.', $_FILES['file']['name']);
$extension = strtolower(end($tmp));
if (array_search($extension, $_UP['extensions']) === false) {
  echo "Imcompatible format!";
  exit;
}
// Verify the file size
if ($_UP['size'] < $_FILES['file']['size']) {
  echo "The sended file is too much big, send files until 50Mb.";
  exit;
}
// Verify if it needs to rename the file
if ($_UP['rename'] == true) {
  // Create a current UNIX TIMESTAMP based name and with the .jpg extension
  $final_name = md5(time()).'.jpg';
} else {
  // Keep the original file name
  $final_name = $_FILES['file']['name'];
}
  
// Verify if it's possible to move the file to the chosen folder
if (move_uploaded_file($_FILES['file']['tmp_name'], $_UP['folder'] . $final_name)) {
  // Upload sucessfully, display a mensage and a file link
  echo "Sucessfully upload!<br>";
  echo '<a href="' . $_UP['folder'] . $final_name . '">Click here to access the file</a>';
} else {
  // It wasn't possible to upload, probably the folder it's wrong
  echo "Couldn't send the file, try again";
}