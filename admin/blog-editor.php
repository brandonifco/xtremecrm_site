<?php
$AUTHORIZED = true;
if (!$AUTHORIZED) {
    http_response_code(403);
    exit('Unauthorized');
}

require_once '../includes/database.php';
$pdo = getDatabaseConnection(); // ← ADD THIS
require_once __DIR__ . '/../vendor/autoload.php'; // for HTML Purifier

$errors = [];
$success = false;

function sanitizeHTML($dirtyHtml)
{
    $config = HTMLPurifier_Config::createDefault();

    // Allow essential tags including img + links
    $config->set('HTML.Allowed', 'p,h1,h2,h3,ul,ol,li,strong,em,br,img,a[href|target],blockquote');

    // Allow base64-encoded image sources
    $config->set('URI.AllowedSchemes', [
        'http' => true,
        'https' => true,
        'data' => true
    ]);

    // Allow embedded resources (important for base64 images)
    $config->set('URI.SafeEmbed', true);
    $config->set('URI.SafeObject', true);
    $config->set('HTML.SafeEmbed', true);
    $config->set('HTML.SafeObject', true);
    $config->set('HTML.SafeIframe', true); // Optional, extra-safe

    $purifier = new HTMLPurifier($config);
    return $purifier->purify($dirtyHtml);
}


function extractGoogleDocHTML($zipPath)
{
    $extractPath = sys_get_temp_dir() . '/doc_' . uniqid();
    mkdir($extractPath);
    $zip = new ZipArchive;
    $content = '';

    if ($zip->open($zipPath) === TRUE) {
        $zip->extractTo($extractPath);
        $zip->close();

        // Debug: list extracted files
        error_log("📁 Extracted ZIP to: $extractPath");
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($extractPath)) as $file) {
            if ($file->isFile()) {
                error_log("🗂 Found: " . $file->getPathname());
            }
        }

        // Locate the first .html file
        $htmlFile = null;
        foreach (scandir($extractPath) as $file) {
            if (str_ends_with($file, '.html')) {
                $htmlFile = $extractPath . '/' . $file;
                break;
            }
        }

        if (!$htmlFile || !file_exists($htmlFile)) {
            error_log("❌ No HTML file found in ZIP");
            return '';
        }

        $htmlContent = file_get_contents($htmlFile);
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($htmlContent);
        libxml_clear_errors();

        // Use XPath to get all <img> tags
        $xpath = new DOMXPath($doc);
        $imgs = $xpath->query('//img');

        /** @var DOMElement $img */
        foreach ($imgs as $img) {
            $src = $img->getAttribute('src');
            $imgPath = $extractPath . '/' . ltrim($src, '/');
            error_log("🔍 Looking for image: $src → $imgPath");

            if (file_exists($imgPath)) {
                $ext = pathinfo($imgPath, PATHINFO_EXTENSION);
                $base64 = base64_encode(file_get_contents($imgPath));
                $img->setAttribute('src', "data:image/{$ext};base64,{$base64}");
                error_log("✅ Inlined image: $src");
            } else {
                error_log("⚠️ Image not found for: $src");
            }
        }

        // Extract and sanitize inner body content
        $body = $doc->getElementsByTagName('body')->item(0);
        $content = '';
        foreach ($body->childNodes as $child) {
            $content .= $doc->saveHTML($child);
        }

        // return sanitizeHTML($content);
        return $content;
    } else {
        error_log("❌ Failed to open ZIP file");
    }

    return '';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = trim($_POST['title']);
    $slug     = trim($_POST['slug']);
    $summary  = trim($_POST['summary']);
    $author   = trim($_POST['author']);
    $authorImage = trim($_POST['author_image_url']);
    $category = trim($_POST['category']);
    $tags     = trim($_POST['tags']);
    $featured = trim($_POST['featured_image_url']);
    $meta     = trim($_POST['meta_description']);
    $publish  = isset($_POST['is_published']) ? 1 : 0;

    $content = '';

    if (!empty($_FILES['doc_upload']['tmp_name'])) {
        $content = extractGoogleDocHTML($_FILES['doc_upload']['tmp_name']);
    }

    if (!$title || !$slug || !$content) {
        $errors[] = "Title, slug, and content (Google Doc) are required.";
    }

    if (empty($errors)) {
        file_put_contents('/tmp/last-saved-content.html', $content);

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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Blog Post - Admin</title>
    <link rel="stylesheet" href="/assets/css/main-live.css">
    <link rel="stylesheet" href="/assets/css/blog-editor.css">

</head>

<body>
    <main class="form-section">
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

        <form method="post" enctype="multipart/form-data">
            <label>Title
                <input type="text" name="title" required placeholder="e.g., 10 Tips for CRM Success">
                <small>Clear, concise blog title. Used as the post headline.</small>
            </label>

            <label>Slug
                <input type="text" name="slug" required placeholder="e.g., crm-success-tips">
                <small>URL-friendly version of the title (lowercase, hyphens instead of spaces).</small>
            </label>

            <label>Summary
                <textarea name="summary" rows="2" placeholder="Short description for previews or SEO."></textarea>
                <small>Optional. Appears in blog listings and metadata.</small>
            </label>

            <label>Author
                <input type="text" name="author" placeholder="e.g., Jane Smith" value="XtremeCRM Team">
                <small>Name of the post’s author (optional).</small>
            </label>

            <label>Author Image URL
                <input type="url" name="author_image_url" placeholder="https://example.com/author.jpg">
                <small>Optional image shown next to the author name.</small>
            </label>

            <label>Category
                <input type="text" name="category" placeholder="e.g., CRM Strategy">
                <small>Used for sorting and filtering blog posts.</small>
            </label>

            <label>Tags (comma separated)
                <input type="text" name="tags" placeholder="crm, strategy, tips">
                <small>Optional keywords to help categorize and search posts.</small>
            </label>

            <label>Featured Image URL
                <input type="url" name="featured_image_url" placeholder="https://example.com/cover.jpg">
                <small>Top image shown in blog listings and social previews.</small>
            </label>

            <label>Meta Description
                <textarea name="meta_description" rows="2" placeholder="One- or two-sentence summary for SEO."></textarea>
                <small>Optional. Used by search engines and social sharing previews.</small>
            </label>

            <label>Google Doc Export (.zip)
                <input type="file" name="doc_upload" accept=".zip" required>
                <small>Export from Google Docs: File → Download → Web Page (.zip). Include images if applicable.</small>
            </label>

            <label>
                <input type="checkbox" name="is_published" checked>
                Publish Immediately
            </label>

            <button type="submit">Save Post</button>
        </form>

    </main>
</body>

</html>