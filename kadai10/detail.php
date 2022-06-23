<?php
session_start();
require_once('common/head_parts.php'); //added
require_once('funcs.php');
loginCheck();

$id = $_GET['id'];
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM gs_content_table WHERE id=:id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
if ($status == false) {
    sql_error($stmt);
} else {
    $row = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>

    <?= $head_parts ?>

    <title>内容更新</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">ブログ画面へ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="post.php">投稿する</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">投稿一覧</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="logout.php">ログアウト</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <?php if (isset($_GET['error'])) : ?>
        <p class="text-danger">記入内容を確認してください</p>
    <?php endif; ?>

    <div class="mb-3">
        <label for="title" class="form-label">タイトル</label>
        <h1><?= $row["title"] ?></h1>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">記事内容</label>
        <br><?= $row["content"] ?>
    </div>
    <!-- ゲストは閲覧のみとした  -->

</body>

</html>