<?php
$pageTitle = "Blog Post";
$metaDescription = $post['meta_description'] ?? '';
$featuredImageUrl = $post['featured_image_url'] ?? '';
require_once '../includes/database.php';

$slug = $_GET['slug'] ?? '';
$post = null;

if ($slug) {
    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE slug = ? AND is_published = 1 LIMIT 1");
    $stmt->execute([$slug]);
    $post = $stmt->fetch();
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<main class="blog-post-page">
    <?php if ($post): ?>
        <article class="blog-post">
            <h1><?php echo htmlspecialchars($post['title']); ?></h1>
            <div class="blog-meta">
                <?php if (!empty($post['author_image_url'])): ?>
                    <img class="author-image" src="<?php echo htmlspecialchars($post['author_image_url']); ?>" alt="<?php echo htmlspecialchars($post['author']); ?>">
                <?php endif; ?>
                <p class="blog-date"><?php echo date('F j, Y', strtotime($post['published_at'])); ?> by <?php echo htmlspecialchars($post['author']); ?></p>
            </div>
            <div class="blog-body">
                <?php echo $post['content']; ?>
            </div>
        </article>

    <?php else: ?>
        <section class="not-found">
            <h2>Post Not Found</h2>
            <p>The blog post you're looking for does not exist or has been unpublished.</p>
        </section>
    <?php endif; ?>
</main>
<?php if ($post): ?>
    <script type="application/ld+json">
        <?php
        echo json_encode([
            "@context" => "https://schema.org",
            "@type" => "BlogPosting",
            "headline" => $post['title'],
            "description" => $post['meta_description'] ?? '',
            "image" => $post['featured_image_url'] ?? null,
            "author" => [
                "@type" => "Person",
                "name" => $post['author'] ?? "XtremeCRM Team"
            ],
            "publisher" => [
                "@type" => "Organization",
                "name" => "XtremeCRM",
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => "https://yourdomain.com/assets/images/logo.png"
                ]
            ],
            "url" => "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}",
            "datePublished" => $post['published_at'],
            "mainEntityOfPage" => [
                "@type" => "WebPage",
                "@id" => "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        ?>
    </script>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>