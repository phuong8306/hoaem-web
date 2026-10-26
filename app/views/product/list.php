<section class="page-header">
    <h1>Hoa tươi</h1>
    <p>Chọn cho mình một bó hoa ưng ý</p>
</section>

<?php if (empty($products)): ?>
    <p>Chưa có sản phẩm nào.</p>
<?php else: ?>
    <div class="product-grid">
        <?php foreach ($products as $p): ?>
            <a href="/san-pham/<?= $p['id'] ?>" class="product-card">
                <div class="product-image">
                    <?php if (!empty($p['image'])): ?>
                        <img src="/uploads/<?= htmlspecialchars($p['image']) ?>" 
                             alt="<?= htmlspecialchars($p['name']) ?>">
                    <?php else: ?>
                        <div class="no-image">Hoa &amp; Em</div>
                    <?php endif; ?>
                </div>
                <div class="product-info">
                    <h3><?= htmlspecialchars($p['name']) ?></h3>
                    <p class="price"><?= number_format($p['price'], 0, ',', '.') ?>đ</p>
                    <?php if ($p['stock'] > 0): ?>
                        <span class="stock in">Còn hàng</span>
                    <?php else: ?>
                        <span class="stock out">Hết hàng</span>
                    <?php endif; ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>