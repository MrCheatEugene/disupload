<?php
    include 'functions.php';
    switch($_POST['type']){
        case 'login':
            if(auth($_POST['passwd'])){
                $_SESSION['dl_auth'] = true;
            }
            break;
        case 'file':
            if(empty($_SESSION['dl_auth']) == false and $_SESSION['dl_auth'] == true){
                header('Location: dl.php?id='.upload($_FILES['file'], isset($_POST['public'])));
                die();
            }
            break;
    }
?>

<div class="w-100 h-100" style="height: 100vh!important;display: flex;">
    <?php if(empty($_SESSION['dl_auth'])): ?>
    <form style="max-width: 80vw;width: 100%;" class="ms-auto me-auto mt-auto mb-auto" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="passwd">
        </div>
        <input type="hidden" name="type" value="login">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php else: ?>
    <form style="max-width: 80vw;width: 100%;" class="ms-auto me-auto mt-auto mb-auto" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">File</label>
            <input type="file" class="form-control" id="exampleInputPassword1" name="file" required>
        </div>
        <input type="hidden" name="type" value="file">
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="public" value="1">
            <label class="form-check-label" for="exampleCheck1">Is file public?</label>
        </div>
        <div class="gap-3 d-flex flex-row">
            <button type="submit" class="btn btn-primary">Upload</button>
            <button type="button" onclick="window.location.href='files.php'" class="btn btn-primary">File list</button>
        </div>
    </form>
    <?php endif; ?>
</div>

<?php include 'main.php'; ?>