<?php
if (!empty($_GET['file'])) {
     $fileName = basename($_GET['file']);
     $filePath = 'assets/'.$fileName;
     header("Content-Description: File Transfer");
     header("Content-Type: application/octet-stream");
     header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
     header('Content-Length:' . filesize($filePath));
     flush();
     readfile($filePath);
     exit;
}
?>
