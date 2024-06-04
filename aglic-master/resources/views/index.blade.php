<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Excel</title>
</head>
<body>
    <form  method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="import_file">
        <button type="submit">Importer</button>
    </form>
</body>
</html>
