<?php
// ─── Optional: Simple access control ──────────────
$AUTHORIZED = true;
if (!$AUTHORIZED) {
    http_response_code(403);
    exit('Unauthorized');
}

// ─── Load DB Connection ───────────────────────────
require_once '../includes/database.php';

$errors = [];
$success = false;

// ─── Handle Form Submission ───────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = trim($_POST['title']);
    $slug     = trim($_POST['slug']);
    $summary  = trim($_POST['summary']);
    $content  = $_POST['content']; // HTML
    $author   = trim($_POST['author']);
    $authorImage = trim($_POST['author_image_url']);
    $category = trim($_POST['category']);
    $tags     = trim($_POST['tags']);
    $featured = trim($_POST['featured_image_url']);
    $meta     = trim($_POST['meta_description']);
    $publish  = isset($_POST['is_published']) ? 1 : 0;

    if (!$title || !$slug || !$content) {
        $errors[] = "Title, slug, and content are required.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "INSERT INTO blog_posts
            (title, slug, summary, content, author, author_image_url, category, tags, featured_image_url, meta_description, is_published)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $title,
            $slug,
            $summary,
            $content,
            $author,
            $authorImage,
            $category,
            $tags,
            $featured,
            $meta,
            $publish
        ]);
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Blog Post - Admin</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#content',
            height: 400,
            plugins: 'link image code lists',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code'
        });
    </script>
</head>

<body>
    <main class="admin-page">
        <h1>Create Blog Post</h1>

        <?php if ($success): ?>
            <p class="success">Blog post saved!</p>
        <?php elseif ($errors): ?>
            <ul class="errors">
                <?php foreach ($errors as $e): ?>
                    <li><?php echo htmlspecialchars($e); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="post">
            <label>Title <input type="text" name="title" required></label>
            <label>Slug <input type="text" name="slug" required></label>
            <label>Summary <textarea name="summary"></textarea></label>
            <label>Author <input type="text" name="author" value="XtremeCRM Team"></label>
            <label>Author Image URL <input type="text" name="author_image_url"></label>
            <label>Category <input type="text" name="category"></label>
            <label>Tags (comma separated) <input type="text" name="tags"></label>
            <label>Featured Image URL <input type="text" name="featured_image_url"></label>
            <label>Meta Description <textarea name="meta_description"></textarea></label>
            <label>Content</label>
            <textarea name="content" id="content"></textarea>
            <label><input type="checkbox" name="is_published" checked> Publish Immediately</label>
            <button type="submit">Save Post</button>
        </form>
    </main>
</body>

</html>