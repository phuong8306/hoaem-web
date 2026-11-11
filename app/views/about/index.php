<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giới Thiệu - HoaEm Boutique</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Be Vietnam Pro"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        earthOrange: '#C86D53', 
                        earthHover: '#A85A43',
                        warmBrown: '#5C4033',   
                        customBeige: '#FAF4EF', 
                        warmGray: '#8A7A71',    
                        textMain: '#3E2F28',    
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            color: #3E2F28; 
            font-family: 'Be Vietnam Pro', sans-serif;
            background: url('/assets/img/bg-floral.png') no-repeat top center fixed;
            background-size: cover;
            background-color: #FAF4EF;
        }
        .reveal-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-up.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col selection:bg-earthOrange selection:text-white">


    <!-- BẮT ĐẦU PHẦN BODY TRANG GIỚI THIỆU (Chỉ sửa phần này, giữ nguyên Header/Footer) -->
    <main class="flex-grow w-full relative z-10 about-body-wrapper pb-16">
        
        <!-- CSS Scoped nội bộ bảo vệ Header/Footer không bị vỡ layout -->
        <style>
            .about-body-wrapper .reveal-up {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity 0.8s ease-out, transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .about-body-wrapper .reveal-up.active {
                opacity: 1;
                transform: translateY(0);
            }
            .about-body-wrapper .vertical-text {
                writing-mode: vertical-rl;
                text-orientation: mixed;
            }
        </style>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 space-y-20">

            <!-- KHU VỰC A & B: HERO BANNER & CÂU CHUYỆN THƯƠNG HIỆU -->
            <section class="flex flex-col md:flex-row items-center gap-12 lg:gap-16 reveal-up">
                <!-- Cột Nội Dung (Câu chuyện) -->
                <div class="w-full md:w-1/2 space-y-6 md:pr-4">
                    <span class="inline-flex items-center gap-2 bg-red-50 text-earthOrange text-[10px] sm:text-xs font-bold px-4 py-1.5 rounded-full border border-earthOrange/20 uppercase tracking-widest">
                        ⭐ CÂU CHUYỆN CỦA CHÚNG MÌNH
                    </span>
                    
                    <h1 class="font-serif text-3xl md:text-4xl lg:text-5xl font-bold text-warmBrown leading-[1.25]">
                        Gửi yêu thương<br>
                        qua từng <span class="italic text-earthOrange font-serif">cánh hoa</span>
                    </h1>
                    
                    <div class="space-y-4 text-warmGray text-sm md:text-base leading-relaxed">
                        <p>
                            Chúng mình tin rằng, một bó hoa được trao đi không chỉ là món quà đơn thuần, mà là sứ giả của những cảm xúc khó gọi tên. Từ lời cảm ơn chân thành, lời yêu thương ngọt ngào, cho đến sự an ủi lặng lẽ — mọi thứ đều có thể gửi gắm qua từng sắc hoa.
                        </p>
                        <p>
                            Được truyền cảm hứng từ những hoài niệm thanh xuân tươi đẹp, HoaEm Boutique ra đời với khao khát lưu giữ những khoảnh khắc rực rỡ nhất. Từng nhành hoa, từng lớp giấy gói tại đây đều được chọn lọc và sắp xếp tỉ mỉ, trọn vẹn tâm huyết như cách chúng ta trân trọng người thương yêu.
                        </p>
                    </div>
                    
                    <div class="pt-2">
                        <a href="/products" class="inline-flex items-center gap-2 bg-earthOrange hover:bg-earthHover text-white px-8 py-3.5 rounded-full font-semibold text-sm transition shadow-lg shadow-earthOrange/30">
                            Khám phá bộ sưu tập &rarr;
                        </a>
                    </div>
                </div>

                <!-- Cột Hình Ảnh (Đã FIX lỗi chữ đè ngang ảnh) -->
                <div class="w-full md:w-1/2 relative flex justify-center md:justify-end mt-8 md:mt-0">
                    <div class="relative w-full max-w-md">
                        <!-- Khung ảnh chính -->
                        <div class="rounded-[2.5rem] overflow-hidden shadow-2xl relative border-[6px] border-white z-10 bg-customBeige">
                            <img src="https://images.unsplash.com/photo-1563241527-3004b7be0ffd?q=80&w=1000&auto=format&fit=crop" alt="Florist HoaEm Boutique" class="w-full h-[400px] lg:h-[480px] object-cover hover:scale-105 transition duration-700">
                        </div>
                        
                        <!-- Lời tựa chạy dọc (Đã Fix: đẩy ra ngoài bằng trục origin-center và -right-10, không còn lẹm vào ảnh) -->
                        <div class="absolute -right-8 lg:-right-12 top-1/2 transform -translate-y-1/2 hidden md:block z-0">
                            <p class="font-serif italic text-warmBrown/60 text-xs tracking-[0.2em] rotate-90 origin-center whitespace-nowrap">
                                "HOA TƯƠI LÀ HẠNH PHÚC ĐONG ĐẦY NHỮNG ĐIỀU NHỎ BÉ"
                            </p>
                        </div>
                        
                        <!-- Họa tiết trang trí phụ -->
                        <div class="absolute -bottom-6 -left-6 bg-white p-3 rounded-2xl shadow-xl border border-earthOrange/10 hidden sm:block z-20">
                            <span class="text-3xl">🌿</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- KHU VỰC C: GIÁ TRỊ THƯƠNG HIỆU -->
            <section class="reveal-up" style="transition-delay: 150ms;">
                <div class="text-center mb-10">
                    <span class="text-earthOrange font-semibold text-xs tracking-widest uppercase flex items-center justify-center gap-2">
                        <span class="w-8 h-[1px] bg-earthOrange/50"></span> ĐIỀU LÀM NÊN SỰ KHÁC BIỆT <span class="w-8 h-[1px] bg-earthOrange/50"></span>
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                    <!-- Value Card 1 -->
                    <div class="bg-white/90 backdrop-blur-sm p-8 rounded-[24px] border border-earthOrange/15 shadow-sm hover:shadow-md hover:-translate-y-1 transition duration-300 flex flex-col items-start gap-4">
                        <div class="w-12 h-12 bg-earthOrange/10 text-earthOrange rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-warmBrown text-base mb-2">Tươi thắm mỗi ngày</h4>
                            <p class="text-xs text-warmGray leading-relaxed">Luôn cẩn trọng chọn lọc những đóa hoa tươi rực rỡ nhất để thắp sáng những ngày bình thường của bạn.</p>
                        </div>
                    </div>
                    <!-- Value Card 2 -->
                    <div class="bg-white/90 backdrop-blur-sm p-8 rounded-[24px] border border-earthOrange/15 shadow-sm hover:shadow-md hover:-translate-y-1 transition duration-300 flex flex-col items-start gap-4">
                        <div class="w-12 h-12 bg-earthOrange/10 text-earthOrange rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-warmBrown text-base mb-2">Tỉ mỉ từng chi tiết</h4>
                            <p class="text-xs text-warmGray leading-relaxed">Gửi gắm toàn bộ tâm huyết và sự chân thành qua từng nếp giấy gói, từng dòng code và nét vẽ giao diện.</p>
                        </div>
                    </div>
                    <!-- Value Card 3 -->
                    <div class="bg-white/90 backdrop-blur-sm p-8 rounded-[24px] border border-earthOrange/15 shadow-sm hover:shadow-md hover:-translate-y-1 transition duration-300 flex flex-col items-start gap-4">
                        <div class="w-12 h-12 bg-earthOrange/10 text-earthOrange rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-warmBrown text-base mb-2">Trọn vẹn hoài niệm</h4>
                            <p class="text-xs text-warmGray leading-relaxed">Mỗi sản phẩm là một câu chuyện riêng, thay bạn trao đi những cảm xúc chân thành và tinh tế nhất.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- KHU VỰC D: NGƯỜI THỰC HIỆN WEBSITE (DEVELOPER PROFILE) -->
            <section class="reveal-up" style="transition-delay: 300ms;">
                <div class="bg-[#FAF4EF] rounded-[32px] border border-earthOrange/20 p-8 md:p-12 lg:p-14 shadow-sm">
                    <div class="flex flex-col lg:flex-row items-center justify-between gap-10">
                        
                        <!-- Lời tựa (Cột trái) -->
                        <div class="w-full lg:w-5/12 space-y-4 text-center lg:text-left">
                            <span class="text-earthOrange font-bold text-[10px] uppercase tracking-widest flex items-center justify-center lg:justify-start gap-1">
                                ✦ THÔNG TIN ĐỒ ÁN / NGƯỜI THỰC HIỆN
                            </span>
                            <h3 class="font-serif text-3xl lg:text-4xl font-bold text-warmBrown leading-snug">Một chút đam mê,<br>cho hoa thêm ý nghĩa</h3>
                            <p class="text-sm text-warmGray leading-relaxed max-w-md mx-auto lg:mx-0">
                                Mình là người đã thiết kế và lập trình website này với mong muốn xây dựng một không gian trải nghiệm mua hoa trực tuyến đơn giản, tiện lợi nhưng vẫn đong đầy cảm xúc nghệ thuật.
                            </p>
                        </div>
                        
                        <!-- Profile Card (Cột giữa) -->
                        <div class="w-full sm:w-8/12 lg:w-4/12 flex flex-col items-center bg-white p-6 rounded-3xl shadow-sm border border-earthOrange/10">
                            <div class="w-24 h-24 rounded-full bg-earthOrange text-white flex items-center justify-center font-serif text-4xl font-bold shadow-md mb-4 border-4 border-[#FAF4EF]">
                                PH
                            </div>
                            <h4 class="font-serif text-xl font-bold text-warmBrown">Phương Huỳnh</h4>
                            <p class="text-xs text-earthOrange uppercase tracking-wider font-semibold mt-1">Web Designer & Developer</p>
                            <div class="w-12 h-[1px] bg-earthOrange/30 my-4"></div>
                            <p class="text-xs text-warmGray italic text-center px-2">
                                "Vì mình tin rằng, một giao diện web đẹp cũng giống như một bó hoa tươi, có thể làm dịu đi những ngày bình thường."
                            </p>
                        </div>

                        <!-- Kỹ năng & Đóng góp (Cột phải) -->
                        <div class="w-full lg:w-3/12 flex flex-col items-center lg:items-start gap-4 text-sm text-warmBrown font-medium">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-orange-50 text-earthOrange flex items-center justify-center shrink-0">🎯</span> 
                                <span>Thiết kế UI/UX Giao diện</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-orange-50 text-earthOrange flex items-center justify-center shrink-0">💻</span> 
                                <span>Lập trình PHP & Tailwind CSS</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-orange-50 text-earthOrange flex items-center justify-center shrink-0">❤️</span> 
                                <span>Tối ưu trải nghiệm mua sắm</span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>

            <!-- KHU VỰC E: CTA CUỐI TRANG -->
            <section class="reveal-up" style="transition-delay: 400ms;">
                <div class="bg-[#C86D53] rounded-full py-5 px-6 sm:px-10 flex flex-col sm:flex-row items-center justify-center sm:justify-between gap-5 shadow-lg">
                    <div class="font-serif text-xl md:text-2xl font-bold flex items-center gap-3 text-white">
                        <span>🌸</span> Một bó hoa, ngàn lời muốn nói
                    </div>
                    <a href="/products" class="bg-white text-earthOrange px-8 py-3.5 rounded-full text-sm font-bold hover:bg-customBeige focus:ring-4 focus:ring-white/30 transition shadow-sm whitespace-nowrap">
                        Khám phá sản phẩm &rarr;
                    </a>
                </div>
            </section>

        </div>

        <!-- Script Animation (Chỉ áp dụng nội bộ trang giới thiệu) -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('active');
                            observer.unobserve(entry.target); // Tối ưu tài nguyên
                        }
                    });
                }, { threshold: 0.15, rootMargin: "0px 0px -50px 0px" });
                
                document.querySelectorAll('.about-body-wrapper .reveal-up').forEach(el => observer.observe(el));
            });
        </script>
    </main>
    <!-- KẾT THÚC PHẦN BODY TRANG GIỚI THIỆU -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.reveal-up').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>