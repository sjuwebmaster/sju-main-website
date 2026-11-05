<?php
// ── All PHP first — before any output ────────────────────────────────────────
$_configCandidates = [
    '/home/sjubedu/config.php',
    __DIR__ . '/../../config.php',
    __DIR__ . '/../public_html/V2/config.php',
];
$_config = null;
foreach ($_configCandidates as $_p) { if (file_exists($_p)) { $_config = $_p; break; } }
if ($_config === null) {
    header('HTTP/1.1 503 Service Unavailable');
    exit('<html><body><p>Blog unavailable. Database configuration pending. <a href="https://blogs.sju.edu.in/">Back</a></p></body></html>');
}
require_once $_config;

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    header('HTTP/1.1 503 Service Unavailable');
    exit('<html><body><p>Database unavailable. <a href="https://blogs.sju.edu.in/">Back to Blog</a></p></body></html>');
}

function makeSlug(string $text): string {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    return trim(preg_replace('/\s+/', '-', $text), '-');
}

$slug = makeSlug(urldecode(trim($_GET['slug'] ?? '')));
if ($slug === '') { header('Location: https://blogs.sju.edu.in/'); exit; }

$stmt = $pdo->prepare(
    "SELECT p.*, c.name AS category
     FROM   blog_posts p
     LEFT JOIN blog_categories c ON c.id = p.category_id
     WHERE  p.slug = :slug AND p.is_published = 1
     LIMIT 1"
);
$stmt->execute([':slug' => $slug]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    header('HTTP/1.0 404 Not Found');
    exit('<!doctype html><html><body><h1>404 — Article not found</h1><p><a href="https://blogs.sju.edu.in/">Back to Blog</a></p></body></html>');
}

$related = [];
if (!empty($post['category_id'])) {
    $relStmt = $pdo->prepare(
        "SELECT id, title, slug, featured_img, created_at
         FROM   blog_posts
         WHERE  category_id = :cat AND id != :id AND is_published = 1
         ORDER BY created_at DESC LIMIT 3"
    );
    $relStmt->execute([':cat' => $post['category_id'], ':id' => $post['id']]);
    $related = $relStmt->fetchAll(PDO::FETCH_ASSOC);
}

$pageUrl      = 'https://blogs.sju.edu.in/post.php?slug=' . urlencode($post['slug']);
$shareTitle   = urlencode($post['title']);
$excerpt      = $post['excerpt'] ?? substr(strip_tags($post['content']), 0, 155);

// Variables for header.php
$pageTitle = htmlspecialchars($post['title']) . ' | SJU Blog';
$pageDesc  = htmlspecialchars($excerpt);

// Extra <head> tags (OG, Twitter Card, JSON-LD, canonical)
ob_start();
?>
<link rel="canonical" href="<?= htmlspecialchars($pageUrl) ?>">

<!-- Open Graph -->
<meta property="og:title"       content="<?= htmlspecialchars($post['title']) ?>">
<meta property="og:description" content="<?= htmlspecialchars($excerpt) ?>">
<meta property="og:url"         content="<?= htmlspecialchars($pageUrl) ?>">
<meta property="og:type"        content="article">
<meta property="og:site_name"   content="SJU Blog — St Joseph's University Bengaluru">
<meta property="article:published_time" content="<?= date('c', strtotime($post['created_at'])) ?>">
<meta property="article:modified_time"  content="<?= date('c', strtotime($post['updated_at'])) ?>">
<meta property="article:author"         content="<?= htmlspecialchars($post['author']) ?>">
<?php if (!empty($post['featured_img'])): ?>
<meta property="og:image" content="https://blogs.sju.edu.in/uploads/blog/<?= htmlspecialchars($post['featured_img']) ?>">
<meta property="og:image:width"  content="1200">
<meta property="og:image:height" content="630">
<?php endif; ?>

<!-- Twitter Card -->
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:site"        content="@sjcbengaluru">
<meta name="twitter:title"       content="<?= htmlspecialchars($post['title']) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($excerpt) ?>">
<?php if (!empty($post['featured_img'])): ?>
<meta name="twitter:image" content="https://blogs.sju.edu.in/uploads/blog/<?= htmlspecialchars($post['featured_img']) ?>">
<?php endif; ?>

<!-- JSON-LD: Article schema -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": <?= json_encode($post['title']) ?>,
    "description": <?= json_encode($excerpt) ?>,
    "url": <?= json_encode($pageUrl) ?>,
    "datePublished": "<?= date('c', strtotime($post['created_at'])) ?>",
    "dateModified": "<?= date('c', strtotime($post['updated_at'])) ?>",
    "author": {
        "@type": "Person",
        "name": <?= json_encode($post['author']) ?>,
        "affiliation": {
            "@type": "CollegeOrUniversity",
            "name": "St Joseph's University, Bengaluru",
            "url": "https://www.sju.edu.in"
        }
    },
    "publisher": {
        "@type": "CollegeOrUniversity",
        "@id": "https://www.sju.edu.in/#university",
        "name": "St Joseph's University, Bengaluru",
        "logo": {
            "@type": "ImageObject",
            "url": "https://www.sju.edu.in/assets/img/st-joseph-university-logo.png"
        }
    }<?php if (!empty($post['featured_img'])): ?>,
    "image": {
        "@type": "ImageObject",
        "url": "https://blogs.sju.edu.in/uploads/blog/<?= htmlspecialchars($post['featured_img']) ?>"
    }<?php endif; ?>,
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": <?= json_encode($pageUrl) ?>
    },
    "isPartOf": {
        "@type": "Blog",
        "name": "SJU Blog",
        "url": "https://blogs.sju.edu.in/"
    }<?php if (!empty($post['category'])): ?>,
    "articleSection": <?= json_encode($post['category']) ?>
    <?php endif; ?>
}
</script>
<?php
$pageHead = ob_get_clean();

// ── Now output the page ───────────────────────────────────────────────────────
require_once __DIR__ . '/header.php';
?>

<style>
    :root { --sju-navy: #002147; --sju-gold: #C5A059; }

    .article-wrap {
        width: 100%;
        max-width: min(820px, 90vw);
        margin: 0 auto;
    }
    .article-category {
        display: inline-block; background: var(--sju-gold); color: #fff;
        font-size: .75rem; font-weight: 700; letter-spacing: .06em;
        text-transform: uppercase; padding: .25rem .9rem; border-radius: 4px;
        margin-bottom: .9rem; text-decoration: none;
    }
    .article-title {
        font-family: 'Playfair Display', serif; color: var(--sju-navy);
        font-size: clamp(1.4rem, 3.5vw, 2.8rem);
        line-height: 1.25; font-weight: 800; margin-bottom: 1rem;
    }
    .article-meta {
        font-size: clamp(.78rem, 1.2vw, .9rem); color: #666;
        display: flex; flex-wrap: wrap; gap: 1rem;
        margin-bottom: 1.6rem; padding-bottom: 1.2rem; border-bottom: 1px solid #e8e8e8;
    }
    .article-meta i { color: var(--sju-gold); margin-right: .25rem; }
    .article-featured-img {
        width: 100%; max-height: clamp(220px, 40vw, 520px);
        object-fit: cover; border-radius: 14px; margin-bottom: 2rem;
    }
    .article-body {
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(1rem, 1.4vw, 1.15rem);
        line-height: 1.9; color: #333;
    }
    .article-body h2, .article-body h3 {
        font-family: 'Plus Jakarta Sans', sans-serif; color: var(--sju-navy);
        margin-top: 2rem; margin-bottom: .65rem;
        font-size: clamp(1.1rem, 1.8vw, 1.5rem);
    }
    .article-body blockquote {
        border-left: 4px solid var(--sju-gold); padding: 1rem 1.5rem;
        background: #fdf9f2; border-radius: 0 10px 10px 0;
        font-style: italic; color: #555; margin: 1.8rem 0;
    }
    .article-body img { max-width: 100%; border-radius: 10px; margin: 1.2rem 0; }
    .article-body a { color: var(--sju-gold); }

    .like-btn {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .55rem 1.4rem; border-radius: 30px;
        border: 2px solid var(--sju-gold); background: transparent;
        color: var(--sju-gold); font-weight: 700;
        font-size: clamp(.82rem, 1.1vw, .95rem);
        cursor: pointer; transition: background .2s, color .2s;
    }
    .like-btn:hover, .like-btn.liked { background: var(--sju-gold); color: #fff; }

    .share-bar { display: flex; flex-wrap: wrap; gap: .5rem; align-items: center; }
    .share-label { font-weight: 700; color: var(--sju-navy); font-size: clamp(.82rem, 1vw, .95rem); }
    .share-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: clamp(.38rem, .8vw, .55rem) clamp(.8rem, 1.5vw, 1.2rem);
        border-radius: 25px; font-size: clamp(.78rem, 1vw, .9rem);
        font-weight: 700; text-decoration: none; color: #fff;
        border: none; cursor: pointer; transition: opacity .18s, transform .15s;
        white-space: nowrap;
    }
    .share-btn:hover { opacity: .88; color: #fff; transform: translateY(-1px); }
    .share-btn.wa { background: #25D366; }
    .share-btn.li { background: #0077B5; }
    .share-btn.tw { background: #1DA1F2; }
    .share-btn.fb { background: #1877F2; }
    .share-btn.cp { background: #555; }

    .engagement-bar {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem; padding: 1.4rem 0;
        border-top: 1px solid #e8e8e8; border-bottom: 1px solid #e8e8e8;
        margin: 2.5rem 0;
    }

    .share-float {
        position: fixed; left: max(1rem, calc((100vw - 820px) / 2 - 80px));
        top: 50%; transform: translateY(-50%);
        display: flex; flex-direction: column; gap: .5rem; z-index: 40;
    }
    .share-float a, .share-float button {
        width: 44px; height: 44px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #fff; text-decoration: none; font-size: 1rem;
        border: none; cursor: pointer; transition: transform .18s, opacity .18s;
        box-shadow: 0 2px 8px rgba(0,0,0,.18);
    }
    .share-float a:hover, .share-float button:hover { transform: scale(1.12); opacity: .88; }
    .share-float .sf-fb { background: #1877F2; }
    .share-float .sf-tw { background: #1DA1F2; }
    .share-float .sf-li { background: #0077B5; }
    .share-float .sf-wa { background: #25D366; }
    .share-float .sf-cp { background: #555; }
    @media (max-width: 1100px) { .share-float { display: none; } }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 240px), 1fr));
        gap: 1.2rem;
    }
    .related-card {
        border: none; border-radius: 12px; overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,.08); text-decoration: none;
        color: inherit; display: block; transition: transform .22s;
    }
    .related-card:hover { transform: translateY(-4px); }
    .related-card img { width: 100%; height: clamp(120px, 12vw, 180px); object-fit: cover; }
    .related-card .rc-placeholder {
        width: 100%; height: clamp(120px, 12vw, 180px);
        background: linear-gradient(135deg, var(--sju-navy), #003a7a);
        display: flex; align-items: center; justify-content: center;
        color: rgba(255,255,255,.3); font-size: 2rem;
    }
    .related-card .rc-body { padding: .9rem; }
    .related-card .rc-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(.88rem, 1vw, 1rem);
        font-weight: 700; color: var(--sju-navy); margin: 0; line-height: 1.35;
    }
    .related-card .rc-date { font-size: .75rem; color: #999; margin-top: .3rem; }

    .copy-toast {
        position: fixed; bottom: 2rem; left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: #333; color: #fff; padding: .6rem 1.5rem;
        border-radius: 30px; font-size: .85rem; opacity: 0;
        transition: opacity .3s, transform .3s; pointer-events: none; z-index: 9999;
    }
    .copy-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

    @media (prefers-reduced-motion: reduce) {
        .share-btn, .related-card, .like-btn { transition: none; }
    }
</style>

<main id="post-main">

<!-- Floating share sidebar (desktop ≥ 1100px) -->
<div class="share-float" aria-label="Share this article">
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($pageUrl) ?>"
       target="_blank" rel="noopener" class="sf-fb" aria-label="Share on Facebook">
        <i class="fab fa-facebook-f" aria-hidden="true"></i>
    </a>
    <a href="https://twitter.com/intent/tweet?text=<?= $shareTitle ?>&url=<?= urlencode($pageUrl) ?>"
       target="_blank" rel="noopener" class="sf-tw" aria-label="Share on Twitter">
        <i class="fab fa-twitter" aria-hidden="true"></i>
    </a>
    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($pageUrl) ?>"
       target="_blank" rel="noopener" class="sf-li" aria-label="Share on LinkedIn">
        <i class="fab fa-linkedin-in" aria-hidden="true"></i>
    </a>
    <a href="https://wa.me/?text=<?= $shareTitle ?>%20<?= urlencode($pageUrl) ?>"
       target="_blank" rel="noopener" class="sf-wa" aria-label="Share on WhatsApp">
        <i class="fab fa-whatsapp" aria-hidden="true"></i>
    </a>
    <button class="sf-cp" id="float-copy" aria-label="Copy link">
        <i class="fas fa-link" aria-hidden="true"></i>
    </button>
</div>

<!-- Article -->
<section class="py-5">
    <div class="container-fluid px-3 px-md-5">
        <article class="article-wrap">

            <?php if (!empty($post['category'])): ?>
                <a href="https://blogs.sju.edu.in/?cat=<?= (int)$post['category_id'] ?>"
                   class="article-category"><?= htmlspecialchars($post['category']) ?></a>
            <?php endif; ?>

            <h1 class="article-title"><?= htmlspecialchars($post['title']) ?></h1>

            <div class="article-meta">
                <span><i class="fas fa-user-circle" aria-hidden="true"></i><?= htmlspecialchars($post['author']) ?></span>
                <span><i class="fas fa-calendar-alt" aria-hidden="true"></i>
                    <time datetime="<?= date('Y-m-d', strtotime($post['created_at'])) ?>">
                        <?= date('d F Y', strtotime($post['created_at'])) ?>
                    </time>
                </span>
                <span><i class="fas fa-heart" aria-hidden="true"></i>
                    <span id="like-count"><?= (int)$post['like_count'] ?></span> likes
                </span>
            </div>

            <?php if (!empty($post['featured_img'])): ?>
                <img class="article-featured-img"
                     src="/uploads/blog/<?= htmlspecialchars($post['featured_img']) ?>"
                     alt="<?= htmlspecialchars($post['title']) ?>">
            <?php endif; ?>

            <div class="article-body">
                <?= $post['content'] ?>
            </div>

            <!-- Engagement bar -->
            <div class="engagement-bar" role="region" aria-label="Article actions">
                <button class="like-btn" id="like-btn" data-post-id="<?= (int)$post['id'] ?>"
                        aria-pressed="false">
                    <i class="fas fa-heart" aria-hidden="true"></i>
                    <span id="like-btn-text">Like this article</span>
                </button>

                <div class="share-bar" aria-label="Share this article">
                    <span class="share-label"><i class="fas fa-share-alt me-1" aria-hidden="true"></i>Share:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($pageUrl) ?>"
                       target="_blank" rel="noopener" class="share-btn fb" aria-label="Share on Facebook">
                        <i class="fab fa-facebook-f" aria-hidden="true"></i> Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?text=<?= $shareTitle ?>&url=<?= urlencode($pageUrl) ?>"
                       target="_blank" rel="noopener" class="share-btn tw" aria-label="Share on Twitter">
                        <i class="fab fa-twitter" aria-hidden="true"></i> Twitter
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($pageUrl) ?>"
                       target="_blank" rel="noopener" class="share-btn li" aria-label="Share on LinkedIn">
                        <i class="fab fa-linkedin-in" aria-hidden="true"></i> LinkedIn
                    </a>
                    <a href="https://wa.me/?text=<?= $shareTitle ?>%20<?= urlencode($pageUrl) ?>"
                       target="_blank" rel="noopener" class="share-btn wa" aria-label="Share on WhatsApp">
                        <i class="fab fa-whatsapp" aria-hidden="true"></i> WhatsApp
                    </a>
                    <button class="share-btn cp" id="copy-link-btn" aria-label="Copy link to clipboard">
                        <i class="fas fa-link" aria-hidden="true"></i> Copy Link
                    </button>
                </div>
            </div>

            <a href="https://blogs.sju.edu.in/"
               style="color:var(--sju-navy);font-weight:600;font-size:.9rem;text-decoration:none;">
                <i class="fas fa-arrow-left me-1" aria-hidden="true"></i> Back to Blog
            </a>
        </article>
    </div>
</section>

<?php if (count($related) > 0): ?>
<section class="py-5 bg-light" aria-labelledby="related-heading">
    <div class="container">
        <h2 id="related-heading"
            style="font-family:'Playfair Display',serif;color:var(--sju-navy);margin-bottom:1.5rem;font-size:1.4rem;">
            Related Articles
        </h2>
        <div class="related-grid">
            <?php foreach ($related as $rel): ?>
                <a href="https://blogs.sju.edu.in/post.php?slug=<?= urlencode($rel['slug']) ?>"
                   class="related-card">
                    <?php if (!empty($rel['featured_img'])): ?>
                        <img src="/uploads/blog/<?= htmlspecialchars($rel['featured_img']) ?>"
                             alt="<?= htmlspecialchars($rel['title']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="rc-placeholder" aria-hidden="true">
                            <i class="fas fa-university"></i>
                        </div>
                    <?php endif; ?>
                    <div class="rc-body">
                        <p class="rc-title"><?= htmlspecialchars($rel['title']) ?></p>
                        <p class="rc-date">
                            <i class="fas fa-calendar-alt me-1" aria-hidden="true"></i>
                            <time datetime="<?= date('Y-m-d', strtotime($rel['created_at'])) ?>">
                                <?= date('d M Y', strtotime($rel['created_at'])) ?>
                            </time>
                        </p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

</main>

<div class="copy-toast" id="copy-toast" role="status" aria-live="polite">Link copied to clipboard!</div>

<?php require_once __DIR__ . '/footer.php'; ?>

<script>
(function () {
    var likeBtn    = document.getElementById('like-btn');
    var likeCount  = document.getElementById('like-count');
    var likeText   = document.getElementById('like-btn-text');
    var storageKey = 'sju_blog_liked_<?= (int)$post['id'] ?>';

    if (localStorage.getItem(storageKey)) {
        likeBtn.classList.add('liked');
        likeBtn.setAttribute('aria-pressed', 'true');
        likeText.textContent = 'Liked!';
    }

    likeBtn.addEventListener('click', function () {
        if (likeBtn.classList.contains('liked')) return;
        fetch('https://blogs.sju.edu.in/like_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'post_id=<?= (int)$post['id'] ?>'
        })
        .then(function(res) { return res.text(); })
        .then(function(count) {
            var n = parseInt(count, 10);
            if (!isNaN(n)) likeCount.textContent = n;
            likeBtn.classList.add('liked');
            likeBtn.setAttribute('aria-pressed', 'true');
            likeText.textContent = 'Liked!';
            localStorage.setItem(storageKey, '1');
        })
        .catch(function() {});
    });

    function doCopy() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            toast.classList.add('show');
            setTimeout(function() { toast.classList.remove('show'); }, 2500);
        }).catch(function() { prompt('Copy this link:', window.location.href); });
    }

    var copyBtn = document.getElementById('copy-link-btn');
    var floatCp = document.getElementById('float-copy');
    var toast   = document.getElementById('copy-toast');
    copyBtn.addEventListener('click', doCopy);
    if (floatCp) floatCp.addEventListener('click', doCopy);
})();
</script>
</body>
</html>
