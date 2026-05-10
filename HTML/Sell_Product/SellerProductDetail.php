<?php
require_once __DIR__ . '/../../PHP/seller_product_repository.php';

$listingId = seller_clean_value($_GET['id'] ?? '');
$product = $listingId !== '' ? find_seller_product($listingId) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product ? $product['name'] . ' | Seller Detail' : 'Seller Product Detail'); ?></title>
    <link rel="stylesheet" href="../../CSS/CSSHomePage/stylesofpages.css">
    <style>
        .seller-detail-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(0, 0.95fr);
            gap: 28px;
            align-items: start;
        }

        .seller-media-panel,
        .seller-summary-panel,
        .seller-info-card {
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            background: #ffffff;
        }

        .seller-media-panel,
        .seller-summary-panel {
            padding: 28px;
        }

        .seller-main-image {
            aspect-ratio: 1 / 1;
            padding: 22px;
            border-radius: var(--radius-md);
            border: 1px solid var(--line);
            background: linear-gradient(180deg, #ffffff, #f5f5f5);
        }

        .seller-main-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .seller-gallery-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(88px, 1fr));
            gap: 12px;
            margin-top: 16px;
        }

        .seller-gallery-thumb {
            aspect-ratio: 1 / 1;
            padding: 10px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--line);
            background: #fbfbfb;
        }

        .seller-gallery-thumb img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .seller-status-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 14px 0 0;
        }

        .seller-pill {
            display: inline-flex;
            align-items: center;
            padding: 7px 12px;
            border-radius: 999px;
            background: #fff5f5;
            color: var(--accent);
            font-size: 0.84rem;
            font-weight: 600;
        }

        .seller-price {
            margin: 20px 0 0;
            color: var(--accent);
            font-size: 2rem;
            font-weight: 600;
        }

        .seller-meta {
            display: grid;
            gap: 12px;
            margin-top: 22px;
        }

        .seller-meta-item {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--line);
        }

        .seller-meta-item:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .seller-meta-label {
            color: var(--muted);
        }

        .seller-cta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 26px;
        }

        .seller-info-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .seller-info-card {
            padding: 24px;
        }

        .seller-info-card h3 {
            margin: 0 0 12px;
            font-size: 1.08rem;
        }

        .seller-info-card ul {
            margin: 0;
            padding-left: 18px;
            color: var(--muted);
            line-height: 1.8;
        }

        .seller-empty {
            max-width: 760px;
            padding: 36px;
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            background: #ffffff;
        }

        @media (max-width: 1100px) {
            .seller-detail-grid,
            .seller-info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="channel-page">
    <header class="channel-global-bar">
        <div class="channel-global-inner">
            <a class="channel-brand" href="../HomePages/index.html" aria-label="DragonGod Phone homepage">
                <span class="channel-brand-mark" aria-hidden="true"></span>
                <span>DragonGod Phone</span>
            </a>

            <nav class="channel-site-nav" aria-label="Site categories">
                <a href="../HomePages/pages/phones.html">Phones</a>
                <a href="../HomePages/pages/wearables.html">Wearables</a>
                <a href="../HomePages/pages/computers.html">Computers</a>
                <a href="../HomePages/pages/tablets.html">Tablets</a>
                <a href="../HomePages/pages/visions.html">Vision</a>
                <a href="../HomePages/pages/audio.html">Audio</a>
                <a href="../HomePages/pages/wholehome.html">Whole Home</a>
                <a href="../HomePages/pages/routers.html">Routers</a>
                <a href="../HomePages/pages/dragonos.html">DragonOS 6</a>
            </nav>

            <nav class="channel-utility-nav" aria-label="Utility pages">
                <a href="../HomePages/pages/support.html">Support</a>
                <a href="../HomePages/pages/retail.html">Retail</a>
                <a href="../HomePages/pages/business.html">Business</a>
                <a href="../HomePages/pages/store.html">DragonMall</a>
            </nav>

            <form class="channel-search-form" action="../HomePages/pages/search.html" method="get" role="search">
                <input class="channel-search-input" type="search" name="q" placeholder="Search phones">
                <button class="channel-search-button" type="submit" aria-label="Search">🔍</button>
            </form>
        </div>
    </header>

    <div class="channel-subbar">
        <div class="channel-subbar-inner">
            <div class="channel-page-title"><?php echo htmlspecialchars($product ? $product['name'] : 'Seller Product Detail'); ?></div>

            <nav class="channel-section-nav" aria-label="Seller detail shortcuts">
                <a href="#overview">Overview</a>
                <a href="#listing-info">Listing Info</a>
            </nav>

            <div class="channel-header-actions">
                <a class="channel-header-action" href="../HomePages/pages/search.html">Search</a>
                <a class="channel-header-action" href="Sell_Product.html">Seller upload</a>
                <?php if ($product): ?>
                    <a class="channel-header-action" href="SellerProductPurchase.php?id=<?php echo urlencode($product['id']); ?>">Buy this listing</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <main class="channel-main">
        <section class="channel-section channel-hero" id="overview">
            <?php if (!$product): ?>
                <div class="seller-empty">
                    <p class="channel-eyebrow">Seller Listing</p>
                    <h1 class="channel-hero-title">This seller product could not be found.</h1>
                    <p class="channel-hero-description">The listing ID is missing or no longer exists in the seller product database. Return to search or create a new listing from the seller upload page.</p>
                    <div class="seller-cta-row">
                        <a class="channel-button solid" href="../HomePages/pages/search.html">Open search</a>
                        <a class="channel-button ghost" href="Sell_Product.html">Open seller upload</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="seller-detail-grid">
                    <div class="seller-media-panel">
                        <div class="seller-main-image">
                            <img src="<?php echo htmlspecialchars(seller_asset_web_path($product['cover_image_path'], '../../')); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>

                        <div class="seller-gallery-strip">
                            <?php foreach ($product['gallery_paths'] as $galleryPath): ?>
                                <div class="seller-gallery-thumb">
                                    <img src="<?php echo htmlspecialchars(seller_asset_web_path($galleryPath, '../../')); ?>" alt="<?php echo htmlspecialchars($product['name']); ?> gallery image">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="seller-summary-panel">
                        <p class="channel-eyebrow">Second-hand Listing</p>
                        <h1 class="channel-hero-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                        <p class="channel-hero-subtitle"><?php echo htmlspecialchars($product['brand']); ?> second-hand seller listing</p>
                        <p class="channel-hero-description"><?php echo htmlspecialchars($product['description']); ?></p>

                        <div class="seller-status-row">
                            <span class="seller-pill"><?php echo htmlspecialchars($product['condition']); ?></span>
                            <span class="seller-pill">Sold by <?php echo htmlspecialchars($product['seller_name']); ?></span>
                            <span class="seller-pill">Single-unit second-hand flow</span>
                        </div>

                        <div class="seller-price">From ¥<?php echo number_format((float) $product['base_price']); ?></div>

                        <div class="seller-meta">
                            <div class="seller-meta-item">
                                <span class="seller-meta-label">Listing ID</span>
                                <strong><?php echo htmlspecialchars($product['id']); ?></strong>
                            </div>
                            <div class="seller-meta-item">
                                <span class="seller-meta-label">Seller account</span>
                                <strong><?php echo htmlspecialchars($product['seller_name']); ?></strong>
                            </div>
                            <div class="seller-meta-item">
                                <span class="seller-meta-label">Created</span>
                                <strong><?php echo htmlspecialchars($product['created_at'] !== '' ? $product['created_at'] : 'Unknown'); ?></strong>
                            </div>
                        </div>

                        <div class="seller-cta-row">
                            <a class="channel-button solid" href="SellerProductPurchase.php?id=<?php echo urlencode($product['id']); ?>">Open purchase page</a>
                            <a class="channel-button ghost" href="../HomePages/pages/search.html?q=<?php echo urlencode($product['name']); ?>">Search related listings</a>
                            <a class="channel-text-link" href="Sell_Product.html">Back to seller upload</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </section>

        <?php if ($product): ?>
            <section class="channel-section" id="listing-info">
                <div class="seller-info-grid">
                    <article class="seller-info-card">
                        <h3>Color options</h3>
                        <ul>
                            <?php foreach ($product['colors'] as $color): ?>
                                <li><?php echo htmlspecialchars($color['name']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </article>

                    <article class="seller-info-card">
                        <h3>Storage and memory</h3>
                        <ul>
                            <?php foreach ($product['storage'] as $storage): ?>
                                <li><?php echo htmlspecialchars($storage['label']); ?><?php if ((float) $storage['extra_price'] > 0): ?> (+¥<?php echo number_format((float) $storage['extra_price']); ?>)<?php endif; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </article>

                    <article class="seller-info-card">
                        <h3>Seller service options</h3>
                        <ul>
                            <?php if (count($product['services']) === 0): ?>
                                <li>No optional seller services were added for this listing.</li>
                            <?php else: ?>
                                <?php foreach ($product['services'] as $service): ?>
                                    <li><?php echo htmlspecialchars($service['name']); ?><?php if ((float) $service['price'] > 0): ?> (+¥<?php echo number_format((float) $service['price']); ?>)<?php endif; ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </article>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <footer class="channel-footer">
        <div class="channel-footer-copy">
            <strong>Seller product detail</strong>
            <p>This page turns a seller-uploaded phone into a browsable listing and connects directly into the second-hand purchase flow.</p>
        </div>

        <div class="channel-footer-actions">
            <a href="../HomePages/index.html">Back to homepage</a>
            <a href="../HomePages/pages/search.html">Open search</a>
            <a href="Sell_Product.html">Seller upload</a>
        </div>
    </footer>
</body>
</html>