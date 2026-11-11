<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <!-- Header tiêu đề & Thanh tab chuyển đổi -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-earthOrange/15 pb-4 gap-4">
        <div>
            <span class="text-earthOrange font-semibold text-[10px] tracking-widest uppercase">✦ TRANG CÁ NHÂN ✦</span>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-warmBrown mt-1">Quản lý tài khoản</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="/account" class="px-5 py-2 rounded-full text-xs font-semibold bg-white text-warmBrown border border-earthOrange/20 hover:border-earthOrange transition">Thông tin cá nhân</a>
            <a href="/account/orders" class="px-5 py-2 rounded-full text-xs font-semibold bg-earthOrange text-white shadow-sm transition">Lịch sử đơn hàng</a>
        </div>
    </div>

    <?php if (!empty($orders)): ?>
        <div class="bg-white rounded-[24px] shadow-sm border border-earthOrange/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-customBeige/60 border-b border-earthOrange/10 text-warmBrown text-xs uppercase tracking-wider">
                            <th class="py-4 px-6 text-center">Mã đơn hàng</th>
                            <th class="py-4 px-6">Ngày đặt</th>
                            <th class="py-4 px-6">Tổng tiền</th>
                            <th class="py-4 px-6">Hình thức thanh toán</th>
                            <th class="py-4 px-6 text-center">Trạng thái</th>
                            <th class="py-4 px-6 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-earthOrange/10 text-sm text-textMain">
                        <?php foreach ($orders as $ord): ?>
                        <tr class="hover:bg-customBeige/20 transition">
                            <td class="py-4 px-6 text-center font-bold text-earthOrange">#<?= $ord['id'] ?></td>
                            <td class="py-4 px-6 text-warmGray text-xs"><?= htmlspecialchars($ord['created_at']) ?></td>
                            <td class="py-4 px-6 font-bold text-earthOrange"><?= number_format($ord['total_price'], 0, ',', '.') ?> đ</td>
                            <td class="py-4 px-6 text-warmBrown"><?= htmlspecialchars($ord['payment_method']) ?></td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-earthOrange/10 text-earthOrange border border-earthOrange/20">
                                    <?= htmlspecialchars($ord['status']) ?>
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="/account/orderDetail/<?= $ord['id'] ?>" class="inline-block px-4 py-2 bg-white border border-earthOrange text-earthOrange hover:bg-earthOrange hover:text-white rounded-full text-xs font-semibold transition shadow-sm">
                                    Xem chi tiết
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="flex flex-col items-center justify-center py-16 bg-white/60 rounded-[30px] border border-earthOrange/10 shadow-sm text-center">
            <span class="text-5xl mb-4 opacity-50">📦</span>
            <h3 class="font-serif text-xl font-bold text-warmBrown mb-2">Bạn chưa có đơn hàng nào</h3>
            <p class="text-sm text-warmGray max-w-md mb-6">Hãy khám phá bộ sưu tập hoa tươi tuyệt đẹp của chúng mình và chọn ngay một bó hoa ưng ý nhé!</p>
            <a href="/products" class="px-6 py-2.5 bg-earthOrange text-white text-sm font-semibold rounded-full hover:bg-earthHover transition shadow-sm">
                Khám phá sản phẩm ngay
            </a>
        </div>
    <?php endif; ?>
</div>