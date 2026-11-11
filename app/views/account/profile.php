<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <!-- Header tiêu đề & Thanh tab chuyển đổi -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-earthOrange/15 pb-4 gap-4">
        <div>
            <span class="text-earthOrange font-semibold text-[10px] tracking-widest uppercase">✦ TRANG CÁ NHÂN ✦</span>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-warmBrown mt-1">Quản lý tài khoản</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="/account" class="px-5 py-2 rounded-full text-xs font-semibold bg-earthOrange text-white shadow-sm transition">Thông tin cá nhân</a>
            <a href="/account/orders" class="px-5 py-2 rounded-full text-xs font-semibold bg-white text-warmBrown border border-earthOrange/20 hover:border-earthOrange transition">Lịch sử đơn hàng</a>
        </div>
    </div>

    <!-- CHỈ DÙNG ĐÚNG 1 FORM DUY NHẤT BỌC TOÀN BỘ -->
    <form action="/account/updateProfile" method="POST" id="mainAccountForm" class="bg-white rounded-[24px] p-6 sm:p-8 shadow-sm border border-earthOrange/10 space-y-8">
        
        <!-- PHẦN 1: THÔNG TIN TÀI KHOẢN -->
        <div class="space-y-6">
            <h3 class="font-serif text-lg font-bold text-warmBrown border-b border-earthOrange/10 pb-3">Thông tin tài khoản</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Họ và tên -->
                <div>
                    <label class="block text-xs font-bold text-warmBrown uppercase tracking-wider mb-2">Họ và tên</label>
                    <div id="view-name" class="w-full px-4 py-3 rounded-full border border-earthOrange/10 text-sm text-textMain bg-customBeige/20 font-medium flex items-center">
                        <?= htmlspecialchars($user['name'] ?? '') ?>
                    </div>
                    <input type="text" id="edit-name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required
                           class="w-full px-4 py-3 rounded-full border border-earthOrange/20 text-sm text-textMain focus:outline-none focus:ring-2 focus:ring-earthOrange/30 bg-customBeige/30 transition hidden">
                </div>

                <!-- Email đăng nhập -->
                <div>
                    <label class="block text-xs font-bold text-warmBrown uppercase tracking-wider mb-2">Email đăng nhập</label>
                    <div class="w-full px-4 py-3 rounded-full border border-earthOrange/10 text-sm text-warmGray bg-gray-100 flex items-center select-none">
                        <?= htmlspecialchars($user['email'] ?? '') ?>
                    </div>
                    <span class="text-[10px] text-warmGray mt-1 block">Email không thể thay đổi.</span>
                </div>

                <!-- Số điện thoại -->
                <div>
                    <label class="block text-xs font-bold text-warmBrown uppercase tracking-wider mb-2">Số điện thoại</label>
                    <div id="view-phone" class="w-full px-4 py-3 rounded-full border border-earthOrange/10 text-sm text-textMain bg-customBeige/20 font-medium flex items-center">
                        <?= !empty($user['phone']) ? htmlspecialchars($user['phone']) : '<span class="text-warmGray italic">Chưa cập nhật số điện thoại</span>' ?>
                    </div>
                    <input type="text" id="edit-phone" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="Nhập số điện thoại..."
                           class="w-full px-4 py-3 rounded-full border border-earthOrange/20 text-sm text-textMain focus:outline-none focus:ring-2 focus:ring-earthOrange/30 bg-customBeige/30 transition hidden">
                </div>

                <!-- Loại tài khoản -->
                <div>
                    <label class="block text-xs font-bold text-warmBrown uppercase tracking-wider mb-2">Loại tài khoản</label>
                    <div class="w-full px-4 py-3 rounded-full border border-earthOrange/10 text-sm text-warmGray bg-gray-100 flex items-center select-none">
                        <?= (($user['role'] ?? '') === 'admin') ? 'Quản trị viên (Admin)' : 'Khách hàng thành viên' ?>
                    </div>
                </div>
            </div>

            <!-- PHẦN ĐỔI MẬT KHẨU (Mặc định ẩn, chỉ hiện khi bấm "Thay đổi thông tin") -->
            <div id="password-edit-section" class="hidden pt-4 border-t border-earthOrange/10 space-y-4">
                <h4 class="font-serif text-sm font-bold text-warmBrown">Đổi mật khẩu bảo mật (Không bắt buộc)</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-warmBrown mb-1">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" placeholder="••••••••" class="w-full px-4 py-2.5 rounded-full border border-earthOrange/20 text-sm bg-customBeige/20 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-warmBrown mb-1">Mật khẩu mới</label>
                        <input type="password" name="new_password" placeholder="••••••••" class="w-full px-4 py-2.5 rounded-full border border-earthOrange/20 text-sm bg-customBeige/20 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-warmBrown mb-1">Xác nhận mật khẩu mới</label>
                        <input type="password" name="confirm_password" placeholder="••••••••" class="w-full px-4 py-2.5 rounded-full border border-earthOrange/20 text-sm bg-customBeige/20 focus:outline-none">
                    </div>
                </div>
            </div>
        </div>

        <!-- Đường kẻ phân tách -->
        <hr class="border-earthOrange/10">

        <!-- PHẦN 2: SỔ ĐỊA CHỈ NHẬN HÀNG -->
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <h3 class="font-serif text-lg font-bold text-warmBrown">Sổ địa chỉ nhận hàng</h3>
                <button type="button" id="btn-toggle-addr-form" onclick="toggleSubAddressForm()" class="hidden px-4 py-2 bg-earthOrange/10 text-earthOrange hover:bg-earthOrange hover:text-white rounded-full text-xs font-semibold transition">
                    + Thêm địa chỉ mới
                </button>
            </div>

            <!-- Khu vực nhập địa chỉ mới -->
            <div id="sub-address-form-box" class="hidden bg-customBeige/20 p-6 rounded-[20px] border border-earthOrange/15 space-y-4">
                <h4 class="font-bold text-sm text-warmBrown">Thêm địa chỉ giao hàng mới</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-warmBrown mb-1">Phân loại (Tag)</label>
                        <select name="new_tag_name" class="w-full px-3 py-2 rounded-full border border-earthOrange/20 text-sm bg-white focus:outline-none">
                            <option value="Nhà">🏠 Nhà riêng</option>
                            <option value="Công ty">🏢 Công ty / Văn phòng</option>
                            <option value="Khác">📍 Khác</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-warmBrown mb-1">Tên người nhận</label>
                        <input type="text" name="new_receiver_name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" class="w-full px-3 py-2 rounded-full border border-earthOrange/20 text-sm bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-warmBrown mb-1">Số điện thoại nhận</label>
                        <input type="text" name="new_phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" class="w-full px-3 py-2 rounded-full border border-earthOrange/20 text-sm bg-white">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-warmBrown mb-1">Địa chỉ chi tiết</label>
                    <textarea name="new_address_detail" rows="2" placeholder="Số nhà, tên đường, phường/xã, quận/huyện..." class="w-full px-4 py-2 rounded-2xl border border-earthOrange/20 text-sm bg-white"></textarea>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="new_is_default" id="new_is_default" value="1" class="rounded text-earthOrange focus:ring-earthOrange">
                    <label for="new_is_default" class="text-xs text-warmBrown font-medium">Đặt làm địa chỉ mặc định</label>
                </div>
            </div>

            <!-- Danh sách địa chỉ đã lưu (Đã bổ sung nút Sửa và Xóa hiển thị khi bật chế độ chỉnh sửa) -->
            <div class="space-y-4">
                <?php if (!empty($addresses)): ?>
                    <?php foreach ($addresses as $addr): ?>
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 rounded-[16px] border border-earthOrange/15 bg-customBeige/10 gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-earthOrange text-white">
                                        <?= htmlspecialchars($addr['tag_name']) ?>
                                    </span>
                                    <span class="font-bold text-sm text-warmBrown"><?= htmlspecialchars($addr['receiver_name']) ?></span>
                                    <span class="text-xs text-warmGray">(<?= htmlspecialchars($addr['phone']) ?>)</span>
                                    <?php if ($addr['is_default']): ?>
                                        <span class="text-[10px] text-earthOrange font-semibold border border-earthOrange px-2 py-0.5 rounded-full">Mặc định</span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-xs text-textMain pl-1"><?= htmlspecialchars($addr['address_detail']) ?></p>
                            </div>
                            <div class="flex items-center gap-3">
                                <!-- Nút Sửa địa chỉ (Dẫn sang trang chỉnh sửa riêng hoặc popup) -->
                                <a href="/account/editAddress/<?= $addr['id'] ?>" class="btn-action-addr hidden text-xs font-bold text-warmBrown hover:text-earthOrange transition">Sửa</a>
                                <!-- Nút Xóa địa chỉ -->
                                <a href="/account/deleteAddress/<?= $addr['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?');" class="btn-action-addr hidden text-xs text-red-500 hover:underline font-semibold">Xóa</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-xs text-warmGray italic text-center py-4">Bạn chưa lưu địa chỉ nhận hàng nào.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- PHẦN 3: NÚT ĐIỀU KHIỂN NẰM Ở DƯỚI CÙNG -->
        <div class="pt-4 border-t border-earthOrange/10 flex items-center justify-end gap-4">
            <button type="button" id="btn-edit" onclick="toggleEditMode(true)" class="px-8 py-3 bg-earthOrange text-white rounded-full text-sm font-semibold hover:bg-earthHover transition shadow-sm">
                Thay đổi thông tin
            </button>
            <div id="edit-actions" class="hidden items-center gap-3">
                <button type="button" onclick="toggleEditMode(false)" class="px-6 py-3 bg-white border border-warmGray/30 text-warmBrown rounded-full text-sm font-semibold hover:bg-gray-50 transition shadow-sm">
                    Hủy
                </button>
                <button type="submit" class="px-8 py-3 bg-earthOrange text-white rounded-full text-sm font-semibold hover:bg-earthHover transition shadow-sm">
                    Lưu thay đổi
                </button>
            </div>
        </div>
    </form>
</div>

<script>
const originalName = "<?= addslashes($user['name'] ?? '') ?>";
const originalPhone = "<?= addslashes($user['phone'] ?? '') ?>";

function toggleEditMode(isEditing) {
    const viewName = document.getElementById('view-name');
    const editName = document.getElementById('edit-name');
    const viewPhone = document.getElementById('view-phone');
    const editPhone = document.getElementById('edit-phone');
    const btnEdit = document.getElementById('btn-edit');
    const editActions = document.getElementById('edit-actions');
    const btnToggleAddrForm = document.getElementById('btn-toggle-addr-form');
    const passwordEditSection = document.getElementById('password-edit-section');
    const actionAddrs = document.querySelectorAll('.btn-action-addr');

    if (isEditing) {
        viewName.classList.add('hidden');
        editName.classList.remove('hidden');
        viewPhone.classList.add('hidden');
        editPhone.classList.remove('hidden');
        btnEdit.classList.add('hidden');
        editActions.classList.remove('hidden');
        editActions.classList.add('flex');
        
        btnToggleAddrForm.classList.remove('hidden');
        passwordEditSection.classList.remove('hidden');
        actionAddrs.forEach(el => el.classList.remove('hidden'));
    } else {
        editName.value = originalName;
        editPhone.value = originalPhone;
        editName.classList.add('hidden');
        viewName.classList.remove('hidden');
        editPhone.classList.add('hidden');
        viewPhone.classList.remove('hidden');
        editActions.classList.remove('flex');
        editActions.classList.add('hidden');
        btnEdit.classList.remove('hidden');
        
        btnToggleAddrForm.classList.add('hidden');
        passwordEditSection.classList.add('hidden');
        actionAddrs.forEach(el => el.classList.add('hidden'));
        document.getElementById('sub-address-form-box').classList.add('hidden');
    }
}

function toggleSubAddressForm() {
    const box = document.getElementById('sub-address-form-box');
    box.classList.toggle('hidden');
}
</script>