<html>
<head>
    <title>上传照片</title>
</head>
<body>

<form action="<?=site_url('user/upload_photo');?>" method="post" enctype="multipart/form-data">
    <input type="file" name="pic">
    <br>
    <input type="submit" name="submit" value="上传">
</form>

</body>
</html>