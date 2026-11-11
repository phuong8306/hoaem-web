<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Quản trị - Thêm sản phẩm hoa mới') ?></title>
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
<body class="min-h-screen flex flex-col antialiased selection:bg-earthOrange selection:text-white">

    <header class="w-full bg-white/90 backdrop-blur-md border-b border-customBeige py-4 px-6 md:px-10 flex justify-between items-center sticky top-0 z-30 shadow-sm">
        <a href="/" class="flex items-center gap-3 group cursor-pointer text-decoration-none">
            <span class="text-3xl transition group-hover:scale-110">🌸</span>
            <div>
                <span class="font-serif text-2xl font-bold text-warmBrown tracking-tight group-hover:text-earthOrange transition">hoa&amp;em</span>
                <span class="block text-[10px] font-bold text-earthOrange uppercase tracking-widest">Admin Dashboard</span>
            </div>
        </a>
        <div class="flex items-center gap-4">
            <span class="text-xs font-semibold text-warmGray hidden md:inline">Xin chào, <b class="text-textMain"><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></b></span>
            <a href="/auth/logout" class="px-4 py-2 bg-customBeige/40 hover:bg-red-50 hover:text-red-600 text-warmBrown rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-customBeige"><span>Đăng xuất</span> ➜</a>
        </div>
    </header>

    <main class="flex-grow max-w-5xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="font-serif text-3xl font-bold text-warmBrown">Thêm sản phẩm hoa mới</h1>
                <p class="text-xs text-warmGray mt-1">Cấu hình thông tin cơ bản và tạo danh sách phiên bản tùy biến theo danh mục.</p>
            </div>
            <a href="/admin/products" class="px-4 py-2 bg-customBeige/40 hover:bg-customBeige text-warmBrown rounded-xl text-xs font-bold transition border border-customBeige">← Quay lại danh sách</a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-customBeige p-8">
            <form action="/admin/storeProduct" method="POST" enctype="multipart/form-data" class="space-y-10" onsubmit="return validateAddForm()">
                
                <!-- MỤC 1: THÔNG TIN CƠ BẢN -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 border-b border-customBeige pb-3">
                        <span class="w-7 h-7 rounded-xl bg-earthOrange text-white flex items-center justify-center font-bold text-xs">1</span>
                        <h2 class="font-serif text-lg font-bold text-warmBrown">Thông tin cơ bản</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-warmBrown uppercase tracking-wider mb-2">Tên sản phẩm hoa <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required placeholder="Nhập tên sản phẩm hoa..." class="w-full px-5 py-3.5 bg-customBeige/25 border border-customBeige rounded-2xl text-sm font-medium text-textMain focus:outline-none focus:ring-2 focus:ring-earthOrange/40 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-warmBrown uppercase tracking-wider mb-2">Danh mục sản phẩm <span class="text-red-500">*</span></label>
                            <select name="category_id" id="category-select" onchange="onCategoryChange()" class="w-full px-5 py-3.5 bg-customBeige/25 border border-customBeige rounded-2xl text-sm font-medium text-textMain focus:outline-none focus:ring-2 focus:ring-earthOrange/40 transition" required>
                                <option value="">-- Chọn danh mục hoa --</option>
                                <?php if (!empty($categories)): foreach($categories as$cat): ?>
                                    <option value="<?= $cat['id'] ?>" data-name="<?= htmlspecialchars($cat['name']) ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-warmBrown uppercase tracking-wider mb-2">Mô tả chi tiết sản phẩm</label>
                        <textarea name="description" rows="4" placeholder="Viết mô tả chi tiết..." class="w-full px-5 py-3.5 bg-customBeige/25 border border-customBeige rounded-2xl text-sm font-medium text-textMain focus:outline-none focus:ring-2 focus:ring-earthOrange/40 transition"></textarea>
                    </div>
                </div>

                <!-- MỤC 2: HÌNH ẢNH SẢN PHẢM CHÍNH -->
                <div class="space-y-4 pt-4">
                    <div class="flex items-center gap-2 border-b border-customBeige pb-3">
                        <span class="w-7 h-7 rounded-xl bg-earthOrange text-white flex items-center justify-center font-bold text-xs">2</span>
                        <h2 class="font-serif text-lg font-bold text-warmBrown">Hình ảnh đại diện</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-warmBrown uppercase tracking-wider mb-2">Ảnh đại diện chính <span class="text-red-500">*</span></label>
                            <div class="flex items-center gap-4 p-4 bg-customBeige/15 border border-dashed border-customBeige rounded-2xl">
                                <div id="image-preview-box" class="w-20 h-20 bg-customBeige/30 rounded-xl flex items-center justify-center text-warmGray text-xs font-medium overflow-hidden border border-customBeige shrink-0">
                                    <span id="preview-text">Chưa chọn</span>
                                </div>
                                <div class="flex-grow">
                                    <input type="file" name="image" id="main-image-input" accept="image/*" required onchange="previewMainImage(event)" class="w-full text-xs file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-earthOrange file:text-white hover:file:bg-earthHover file:cursor-pointer transition">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MỤC 3: QUẢN LÝ PHIÊN BẢN & THUỘC TÍNH ĐỘNG TÍCH HỢP TRỰC TIẾP -->
                <div class="space-y-4 pt-4">
                    <div class="flex items-center gap-2 border-b border-customBeige pb-3">
                        <span class="w-7 h-7 rounded-xl bg-earthOrange text-white flex items-center justify-center font-bold text-xs">3</span>
                        <h2 class="font-serif text-lg font-bold text-warmBrown">Quản lý phiên bản sản phẩm <span class="text-red-500">*</span></h2>
                    </div>

                    <div class="p-6 bg-customBeige/10 rounded-2xl border border-customBeige space-y-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-serif text-sm font-bold text-warmBrown">Danh sách các phiên bản</h3>
                                <p class="text-xs text-warmGray">Kích thước là trường cố định. Các thuộc tính bổ sung (màu sắc, kiểu chậu...) được tự động sinh ra theo danh mục.</p>
                            </div>
                            <button type="button" onclick="addVariantCard()" class="px-3.5 py-2 bg-earthOrange text-white rounded-xl text-xs font-bold hover:bg-earthHover transition shadow-xs">+ Thêm phiên bản</button>
                        </div>

                        <div id="variants-container" class="space-y-4">
                            <!-- JS tự render thẻ phiên bản ở đây -->
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-customBeige">
                    <a href="/admin/products" class="px-6 py-3 bg-customBeige/40 hover:bg-customBeige text-warmBrown rounded-2xl text-sm font-bold transition">Hủy bỏ</a>
                    <button type="submit" class="px-8 py-3 bg-earthOrange hover:bg-earthHover text-white rounded-2xl text-sm font-bold transition shadow-md shadow-earthOrange/20">Lưu sản phẩm</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        let currentCategoryAttributes = [];
        let variantCounter = 0;

        function onCategoryChange() {
            const select = document.getElementById('category-select');
            const categoryId = select.value;

            if (!categoryId) {
                currentCategoryAttributes = [];
                renderAllVariants();
                return;
            }

            fetch('/admin/getCategoryAttributes/' + categoryId)
                .then(res => res.json())
                .then(attributes => {
                    currentCategoryAttributes = attributes || [];
                    renderAllVariants();
                })
                .catch(err => console.error('Lỗi nạp thuộc tính:', err));
        }

        function renderAllVariants() {
            const container = document.getElementById('variants-container');
            if (container.children.length === 0) {
                addVariantCard();
            } else {
                const cards = container.querySelectorAll('.variant-card');
                cards.forEach(card => {
                    const idx = card.getAttribute('data-index');
                    const attrBox = card.querySelector('.dynamic-attr-fields');
                    if (attrBox) {
                        attrBox.innerHTML = buildDynamicFieldsHtml(idx);
                    }
                });
            }
        }

        function buildDynamicFieldsHtml(variantIdx) {
            if (!currentCategoryAttributes || currentCategoryAttributes.length === 0) {
                return '';
            }

            let html = '';
            currentCategoryAttributes.forEach(attr => {
                const isReq = attr.is_required == 1;
                const reqMark = isReq ? '<span class="text-red-500">*</span>' : '';
                const reqAttr = isReq ? 'required' : '';
                const fieldName = `variants[${variantIdx}][attrs][${attr.attribute_name}]`;

                html += `<div>`;
                html += `<label class="block text-[10px] font-bold text-warmGray uppercase mb-1">${attr.attribute_name} ${reqMark}</label>`;

                if (attr.data_type === 'select' && attr.options && attr.options.length > 0) {
                    html += `<select name="${fieldName}" ${reqAttr} class="w-full px-3.5 py-2.5 bg-customBeige/15 border border-customBeige rounded-xl text-xs font-medium text-textMain focus:ring-2 focus:ring-earthOrange/40">`;
                    html += `<option value="">-- Chọn ${attr.attribute_name} --</option>`;
                    attr.options.forEach(opt => {
                        html += `<option value="${opt}">${opt}</option>`;
                    });
                    html += `</select>`;
                } else if (attr.data_type === 'integer') {
                    html += `<input type="number" step="1" name="${fieldName}" ${reqAttr} placeholder="Nhập số..." class="w-full px-3.5 py-2.5 bg-customBeige/15 border border-customBeige rounded-xl text-xs font-medium text-textMain">`;
                } else if (attr.data_type === 'decimal') {
                    html += `<input type="number" step="0.01" name="${fieldName}" ${reqAttr} placeholder="Nhập số..." class="w-full px-3.5 py-2.5 bg-customBeige/15 border border-customBeige rounded-xl text-xs font-medium text-textMain">`;
                } else {
                    html += `<input type="text" name="${fieldName}" ${reqAttr} placeholder="Nhập ${attr.attribute_name}..." class="w-full px-3.5 py-2.5 bg-customBeige/15 border border-customBeige rounded-xl text-xs font-medium text-textMain">`;
                }

                html += `</div>`;
            });

            return html;
        }

        function addVariantCard() {
            const container = document.getElementById('variants-container');
            const idx = variantCounter++;
            const card = document.createElement('div');
            card.className = "variant-card p-5 bg-white border border-customBeige rounded-2xl shadow-xs space-y-4 relative";
            card.setAttribute('data-index', idx);

            card.innerHTML = `
                <div class="flex justify-between items-center border-b border-customBeige/60 pb-2">
                    <span class="font-serif text-sm font-bold text-warmBrown variant-title">Phiên bản</span>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="duplicateVariantCard(this)" class="px-2.5 py-1 bg-customBeige text-warmBrown rounded-lg text-xs font-bold hover:bg-warmBrown hover:text-white transition">Sao chép</button>
                        <button type="button" onclick="removeVariantCard(this)" class="btn-remove-variant px-2.5 py-1 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-100 transition">Xóa</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-warmGray uppercase mb-1">Kích thước / Size <span class="text-red-500">*</span></label>
                        <select name="variants[${idx}][size]" required class="w-full px-3.5 py-2.5 bg-customBeige/15 border border-customBeige rounded-xl text-xs font-medium text-textMain">
                            <option value="Tiêu chuẩn">Tiêu chuẩn</option>
                            <option value="Nhỏ (S)">Nhỏ (S)</option>
                            <option value="Vừa (M)">Vừa (M)</option>
                            <option value="Lớn (L)">Lớn (L)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-warmGray uppercase mb-1">Giá bán (VNĐ) <span class="text-red-500">*</span></label>
                        <input type="number" name="variants[${idx}][price]" min="1" required placeholder="VD: 250000" class="w-full px-3.5 py-2.5 bg-customBeige/15 border border-customBeige rounded-xl text-xs font-medium text-textMain">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-warmGray uppercase mb-1">Số lượng tồn kho <span class="text-red-500">*</span></label>
                        <input type="number" name="variants[${idx}][stock]" min="0" value="10" required class="w-full px-3.5 py-2.5 bg-customBeige/15 border border-customBeige rounded-xl text-xs font-medium text-textMain">
                    </div>
                </div>

                <div class="dynamic-attr-fields grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 border-t border-customBeige/40">
                    ${buildDynamicFieldsHtml(idx)}
                </div>

                <div class="pt-2 border-t border-customBeige/40">
                    <label class="block text-[10px] font-bold text-warmGray uppercase mb-1">Ảnh riêng phiên bản (nếu có)</label>
                    <input type="file" name="variant_images[${idx}]" accept="image/*" class="w-full text-[10px] text-warmGray">
                </div>
            `;
            container.appendChild(card);
            updateVariantStates();
        }

        function duplicateVariantCard(btn) {
            const card = btn.closest('.variant-card');
            const clone = card.cloneNode(true);
            const newIdx = variantCounter++;
            
            clone.setAttribute('data-index', newIdx);
            clone.querySelectorAll('input, select').forEach(el => {
                if (el.name) {
                    el.name = el.name.replace(/variants\[\d+\]/, `variants[${newIdx}]`);
                }
            });
            document.getElementById('variants-container').appendChild(clone);
            updateVariantStates();
        }

        function removeVariantCard(btn) {
            const container = document.getElementById('variants-container');
            if (container.children.length <= 1) {
                alert('Sản phẩm bắt buộc phải có ít nhất 1 phiên bản!');
                return;
            }
            btn.closest('.variant-card').remove();
            updateVariantStates();
        }

        function updateVariantStates() {
            const cards = document.querySelectorAll('.variant-card');
            cards.forEach((card, idx) => {
                card.querySelector('.variant-title').innerText = `Phiên bản #${idx + 1}`;
                const removeBtn = card.querySelector('.btn-remove-variant');
                if (removeBtn) {
                    if (cards.length === 1) {
                        removeBtn.disabled = true;
                        removeBtn.className = "btn-remove-variant px-2.5 py-1 bg-gray-100 text-gray-400 rounded-lg text-xs font-bold cursor-not-allowed transition";
                    } else {
                        removeBtn.disabled = false;
                        removeBtn.className = "btn-remove-variant px-2.5 py-1 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-100 transition";
                    }
                }
            });
        }

        function previewMainImage(event) {
            const box = document.getElementById('image-preview-box');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    box.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                }
                reader.readAsDataURL(file);
            }
        }

        function validateAddForm() {
            const cards = document.querySelectorAll('.variant-card');
            if (cards.length === 0) {
                alert('Sản phẩm bắt buộc phải có ít nhất 1 phiên bản!');
                return false;
            }
            return true;
        }

        document.addEventListener('DOMContentLoaded', () => {
            addVariantCard();
        });
    </script>
</body>
</html>