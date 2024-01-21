<?php
    include 'functions.php';
    if(!isset($_GET['id'])){
        header('Location: index.php');
    }
    $f=get_file($_GET['id']);
    if(intval($f['public']) == 0 and (empty($_SESSION['dl_auth']))){
        header('Location: index.php');
    }
?>

<div class="w-100 h-100" style="height: 100vh!important;display: flex;">
    <form style="max-width: 80vw;width: 100%;" class="ms-auto me-auto mt-auto mb-auto justify-content-center d-flex" method="POST" action="download.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
        <div class="d-flex gap-3 flex-row">
            <button type="submit" class="btn btn-primary">Download <?php echo htmlspecialchars($f['name']); ?></button>
            <button type="button" onclick="fetch('email.php?id=<?php echo htmlspecialchars($_GET['id']); ?>&email='+encodeURIComponent(prompt('Enter your E-mail'))); alert('E-mail has been sent.');" class="btn btn-primary">Share via E-mail</button>
        </div>
    </form>
</div>

<?php include 'main.php'; ?>