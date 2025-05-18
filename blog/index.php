<?php
$pageTitle = "XtremeCRM Blog";
$metaDescription = "Explore CRM tips, product updates, and automation tutorials from the XtremeCRM team.";

require_once '../includes/database.php';

try {
    $pdo = getDatabaseConnection();

    $categoryFilter = $_GET['category'] ?? '';
    $params = [];

    $sql = "SELECT id, title, slug, summary, published_at FROM blog_posts WHERE is_published = 1";

    if ($categoryFilter) {
        $sql .= " AND category = ?";
        $params[] = $categoryFilter;
    }

    $sql .= " ORDER BY published_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error loading blog posts: " . $e->getMessage());
    $posts = [];
}

include '../includes/header.php';
include '../includes/navbar.php';
?>
<body>
    <section class="hero">
        <h1>XtremeCRM Blog</h1>
        <p>Tips, product updates, and integration guides to help you get the most out of XtremeCRM.</p>
    </section>

    <div class="blog-container">
        <section class="blog-posts">
            <?php if (empty($posts)): ?>
                <p>No blog posts available at this time.</p>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <article class="blog-preview">
                        <h2>
                            <a href="/blog/post.php?slug=<?php echo urlencode($post['slug']); ?>">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                        </h2>
                        <p class="blog-date"><?php echo date('F j, Y', strtotime($post['published_at'])); ?></p>
                        <p class="blog-summary"><?php echo htmlspecialchars($post['summary']); ?></p>
                        <a class="read-more" href="/blog/post.php?slug=<?php echo urlencode($post['slug']); ?>">Read More →</a>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <aside class="blog-sidebar">
            <h3>Recent Posts</h3>
            <ul class="recent-posts">
                <?php
                try {
                    $recentStmt = $pdo->prepare("SELECT title, slug FROM blog_posts WHERE is_published = 1 ORDER BY published_at DESC LIMIT 5");
                    $recentStmt->execute();
                    $recentPosts = $recentStmt->fetchAll();
                } catch (PDOException $e) {
                    error_log("Error loading recent posts: " . $e->getMessage());
                    $recentPosts = [];
                }

                foreach ($recentPosts as $recent):
                ?>
                    <li>
                        <a href="/blog/post.php?slug=<?php echo urlencode($recent['slug']); ?>">
                            <?php echo htmlspecialchars($recent['title']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <h3>Categories</h3>
            <ul class="blog-categories">
                <?php
                try {
                    $catStmt = $pdo->query("SELECT DISTINCT category FROM blog_posts WHERE is_published = 1 AND category IS NOT NULL ORDER BY category ASC");
                    $categories = $catStmt->fetchAll(PDO::FETCH_COLUMN);
                } catch (PDOException $e) {
                    error_log("Error loading categories: " . $e->getMessage());
                    $categories = [];
                }

                foreach ($categories as $category):
                    $isActive = ($category === $categoryFilter);
                ?>
                    <li>
                        <a href="/blog/index.php?category=<?php echo urlencode($category); ?>" class="<?php echo $isActive ? 'active-category' : ''; ?>">
                            <?php echo htmlspecialchars($category); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>
    </div>
</body>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Blog",
    "name": "XtremeCRM Blog",
    "description": "CRM tips, product updates, and integration tutorials from XtremeCRM.",
    "url": "https://<?php echo $_SERVER['HTTP_HOST']; ?>/blog/"
}
</script>

<?php include '../includes/footer.php'; ?>
