<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">
        <h1>Tabel User</h1>
        <a href="/mvc/" class="btn btn-secondary">Add</a>
    <table id="datatable" class="table">
        <tr>
            <td>Nama</td>
            <td>Email</td>
            <td>Password</td>
            <td>Action</td>
        </tr>
        <?php foreach($user as $u): ?>
        <tr>
            <td><?= $u['username'] ?></td>
            <td><?= $u['email'] ?></td>
            <td><?= $u['password'] ?></td>
            <td><a href="/mvc/formedit?id=<?= base64_encode($u['user_id']) ?>" class="btn btn-warning">Edit</a>
                <a href="/mvc/delete?id=<?= base64_encode($u['user_id']) ?>" class="btn btn-danger" onclick="return confirm('Apakah yakin ingin dihapus?')">Delete</a>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>