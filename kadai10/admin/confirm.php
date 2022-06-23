<?php
// confirm.phpの中身は、ほとんどpost.phpに似ています。

session_start();
require_once('../common/head_parts.php'); //added
require_once('../funcs.php');
loginCheck();

// post受け取る
// $title = $_POST['title'];
// $content = $_POST['content'];

// postされたら、セッションに保存
$title = $_SESSION['post']['title'] = $_POST['title'];
$content = $_SESSION['post']['content'] = $_POST['content'];

// 簡単なバリデーション処理。
if (trim($title) === '' || trim($content)  === '') {
    redirect('post.php?error=1');
}

// imgある場合
if ($_FILES['img']['name']) {
    $file_name = $_SESSION['post']['file_name'] = $_FILES['img']['name'];
    // 一時保存されているファイル内容を取得して、セッションに格納
    $image_data = $_SESSION['post']['image_data'] = file_get_contents($_FILES['img']['tmp_name']);

    // 一時保存されているファイルの種類を確認して、セッションにその種類に当てはまる特定のintを格納
    $image_type = $_SESSION['post']['image_type'] = exif_imagetype($_FILES['img']['tmp_name']);
} else {
    $image_data = $_SESSION['post']['image_data'] = '';
    $image_type = $_SESSION['post']['image_type'] = '';
}
// ↑↑↑↑↑↑ここまで↑↑↑↑↑↑↑↑↑↑↑

// ↓↓↓↓↓ここから追加↓↓↓↓
//写真は拡張子をチェック
if (!empty($file_name)) {
    $extension = substr($file_name, -3);
    if ($extension != 'jpg' && $extension != 'gif' && $extension != 'png') {
        redirect('post.php?error=1');
    }
}
// ↑↑↑↑↑↑ここまで↑↑↑↑↑↑↑↑↑↑↑
?>

<!DOCTYPE html>
<html lang="ja">

<head>

    <?= $head_parts ?>

    <title>記事管理</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../index.php">ブログ画面へ</a>
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

    <!-- errorを受け取ったら、エラー文出力。 -->

    <form method="POST" action="register.php" enctype="multipart/form-data" class="mb-3">
        <div class="mb-3">
            <label for="title" class="form-label">タイトル</label>
            <input type="hidden" name="title" value="<?= $title ?>">
            <p><?= $title ?></p>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">記事内容</label>
            <input type="hidden" name="content" value="<?= $content ?>">
            <div><?= nl2br($content) ?></div>
        </div>
        <!--↓追加↓ -->
        <?php if ($image_data) : ?>
            <div class="mb-3">
                <img src="image.php">
            </div>
        <?php endif; ?>
        <!--↑追加↑-->


        <button type="submit" class="btn btn-primary">投稿</button>
    </form>

    <a href="post.php?re-register=true">前の画面に戻る</a>
</body>

</html>