<?php
// Nếu hệ thống của ní sử dụng layout tổng (ví dụ file main.php hoặc layout chung), 
// ta truyền hoặc bọc nội dung trực tiếp như sau:
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Chỉnh sửa địa chỉ - hoa&em') ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Be Vietnam Pro"', 'sans-serif'], serif: ['"Playfair Display"', 'serif'] },
                    colors: { earthOrange: '#C96F4E', earthHover: '#b55f3e', warmBrown: '#8B5E3C', customBeige: '#F3E7D9', warmGray: '#686B6B', textMain: '#382A32' }
                }
            }
        }
    </script>
    <style> body { color: #382A32; font-family: 'Be Vietnam Pro', sans-serif; background-color: #FDF7F2; } </style>
</head>
<body class="min-h-screen flex flex-col justify-between antialiased selection:bg-earthOrange selection:text-white">

    <!-- Main Content Form Chỉnh Sửa Địa Chỉ -->
    <main class="flex-grow max-w-2xl mx-auto px-4 py-12 w-full">
        <div class="bg-white rounded-[24px] p-6 sm:p-8 shadow-sm border border-earthOrange/10 space-y-6">
            <div class="flex justify-between items-center border-b border-earthOrange/10 pb-4">
                <h1 class="font-serif text-xl font-bold text-warmBrown">Chỉnh sửa địa chỉ nhận hàng</h1>
                <a href="/account" class="text-xs font-bold text-warmBrown hover:text-earthOrange transition">← Quay lại</a>
            </div>

            <form action="/account/updateAddress" method="POST" class="space-y-4">
                <input type="hidden" name="address_id" value="<?= htmlspecialchars($address['id'] ?? '') ?>">

                <div>
                    <label class="block text-xs font-bold text-warmBrown mb-1">Phân loại (Tag)</label>
                    <select name="tag_name" class="w-full px-4 py-2.5 rounded-full border border-earthOrange/20 text-sm bg-customBeige/20 focus:outline-none focus:ring-1 focus:ring-earthOrange">
                        <option value="Nhà" <?= (isset($address['tag_name']) && $address['tag_name'] === 'Nhà') ? 'selected' : '' ?>>🏠 Nhà riêng</option>
                        <option value="Công ty" <?= (isset($address['tag_name']) && $address['tag_name'] === 'Công ty') ? 'selected' : '' ?>>🏢 Công ty / Văn phòng</option>
                        <option value="Khác" <?= (isset($address['tag_name']) && $address['tag_name'] === 'Khác') ? 'selected' : '' ?>>📍 Khác</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-warmBrown mb-1">Tên người nhận</label>
                    <input type="text" name="receiver_name" value="<?= htmlspecialchars($address['receiver_name'] ?? '') ?>" required class="w-full px-4 py-2.5 rounded-full border border-earthOrange/20 text-sm bg-customBeige/20 focus:outline-none focus:ring-1 focus:ring-earthOrange">
                </div>

                <div>
                    <label class="block text-xs font-bold text-warmBrown mb-1">Số điện thoại nhận</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($address['phone'] ?? '') ?>" required class="w-full px-4 py-2.5 rounded-full border border-earthOrange/20 text-sm bg-customBeige/20 focus:outline-none focus:ring-1 focus:ring-earthOrange">
                </div>

                <div>
                    <label class="block text-xs font-bold text-warmBrown mb-1">Địa chỉ chi tiết</label>
                    <textarea name="address_detail" rows="3" required class="w-full px-4 py-2 rounded-2xl border border-earthOrange/20 text-sm bg-customBeige/20 focus:outline-none focus:ring-1 focus:ring-earthOrange"><?= htmlspecialchars($address['address_detail'] ?? '') ?></textarea>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_default" id="is_default" value="1" <?= !empty($address['is_default']) ? 'checked' : '' ?> class="rounded text-earthOrange focus:ring-earthOrange">
                    <label for="is_default" class="text-xs text-warmBrown font-medium">Đặt làm địa chỉ mặc định</label>
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-earthOrange/10">
                    <a href="/account" class="px-6 py-2.5 bg-white border border-warmGray/30 text-warmBrown rounded-full text-sm font-semibold hover:bg-gray-50 transition">Hủy</a>
                    <button type="submit" class="px-6 py-2.5 bg-earthOrange text-white rounded-full text-sm font-semibold hover:bg-earthHover transition shadow-sm">Lưu cập nhật</button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>