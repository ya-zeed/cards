<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:image" content="{{ asset('storage/'.$images[0]->image_path) }}">
    <title>بطاقتك</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @font-face { font-family: 'Cairo'; src: url('{{ asset('fonts/Cairo-VariableFont_slnt,wght.ttf') }}'); }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Tajawal', 'Cairo', sans-serif;
            background: #faf8f5;
            color: #2c2418;
            min-height: 100vh;
        }

        /* Subtle BG pattern */
        .bg-pattern {
            position: fixed; inset: 0; z-index: 0;
            background: radial-gradient(ellipse at 20% 0%, rgba(212,168,83,0.08) 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 100%, rgba(212,168,83,0.06) 0%, transparent 50%);
        }

        /* Header */
        .top-bar {
            position: relative; z-index: 2;
            text-align: center;
            padding: 2.5rem 1rem 1.5rem;
        }
        .top-bar h1 {
            font-size: 1.7rem;
            font-weight: 900;
            color: #2c2418;
            margin-bottom: 0.3rem;
        }
        .top-bar p { color: #9a8a72; font-size: 0.9rem; }

        /* Main */
        .main-wrap {
            position: relative; z-index: 1;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1.25rem 3rem;
        }

        /* Name Card */
        .name-card {
            background: #fff;
            border: 1px solid rgba(212,168,83,0.15);
            border-radius: 20px;
            padding: 1.25rem;
            margin-bottom: 1.75rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04), 0 0 0 1px rgba(212,168,83,0.06);
        }
        .input-row { display: flex; gap: 0.6rem; align-items: stretch; }
        .name-field {
            flex: 1;
            background: #faf8f5;
            border: 2px solid #e8dfd2;
            border-radius: 14px;
            padding: 0.9rem 1.2rem;
            font-size: 1.15rem;
            font-family: 'Tajawal', sans-serif;
            color: #2c2418;
            outline: none;
            transition: all 0.3s;
        }
        .name-field:focus {
            border-color: #d4a853;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(212,168,83,0.1);
        }
        .name-field::placeholder { color: #c4b89e; }

        .btn-row { display: flex; gap: 0.5rem; }
        .btn-dl {
            background: linear-gradient(135deg, #c9973b, #d4a853);
            color: #fff;
            border: none;
            border-radius: 14px;
            padding: 0.9rem 1.5rem;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Tajawal', sans-serif;
            cursor: pointer;
            display: flex; align-items: center; gap: 0.5rem;
            transition: all 0.3s;
            box-shadow: 0 4px 16px rgba(184,134,11,0.2);
            white-space: nowrap;
        }
        .btn-dl:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(184,134,11,0.3); }

        .btn-wa {
            background: #25D366; color: #fff; border: none;
            border-radius: 14px; padding: 0.9rem; font-size: 1.15rem;
            cursor: pointer; transition: all 0.3s;
            display: flex; align-items: center;
            box-shadow: 0 4px 12px rgba(37,211,102,0.2);
        }
        .btn-wa:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37,211,102,0.3); }

        /* Cards Grid */
        .grid-label {
            display: flex; align-items: center; gap: 0.5rem;
            color: #9a8a72; font-size: 0.82rem; font-weight: 600;
            margin-bottom: 0.75rem;
        }
        .grid-label .dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: #d4a853;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 1rem;
        }
        .card-thumb {
            position: relative; border-radius: 18px;
            overflow: hidden; cursor: pointer;
            border: 2.5px solid transparent;
            transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
            background: #fff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        }
        .card-thumb:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.1);
        }
        .card-thumb.active {
            border-color: #d4a853;
            box-shadow: 0 0 0 3px rgba(212,168,83,0.15), 0 12px 32px rgba(0,0,0,0.1);
        }
        .card-thumb.active .check-badge { opacity: 1; transform: scale(1); }

        .check-badge {
            position: absolute; top: 10px; left: 10px;
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, #c9973b, #d4a853);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem; color: #fff; z-index: 2;
            opacity: 0; transform: scale(0.5);
            transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
            box-shadow: 0 4px 12px rgba(184,134,11,0.3);
        }
        .card-thumb canvas { width: 100%; display: block; }
        .card-thumb img { display: none; }

        /* Footer */
        .pg-footer {
            text-align: center; padding: 2rem 1rem;
            color: #c4b89e; font-size: 0.75rem;
            position: relative; z-index: 1;
        }

        @media (max-width: 600px) {
            .input-row { flex-direction: column; }
            .btn-row { width: 100%; }
            .btn-dl { flex: 1; justify-content: center; }
            .cards-grid { grid-template-columns: 1fr; }
            .top-bar { padding: 1.5rem 1rem 1rem; }
            .top-bar h1 { font-size: 1.4rem; }
        }
    </style>
</head>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-SEJSBXEQTX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','G-SEJSBXEQTX');</script>
<body>

<div class="bg-pattern"></div>

<div class="top-bar">
    <h1>بطاقتك الخاصة</h1>
    <p>اكتب اسمك وحمّل بطاقتك</p>
</div>

<div class="main-wrap">
    <div class="name-card">
        <form id="name-form">
            <div class="input-row">
                <input type="text" class="name-field" id="name" placeholder="اكتب اسمك هنا..." autofocus>
                <div class="btn-row">
                    <button type="submit" class="btn-dl"><i class="fas fa-download"></i> تنزيل</button>
                    <button type="button" class="btn-wa" id="share-btn" title="مشاركة واتساب"><i class="fab fa-whatsapp"></i></button>
                </div>
            </div>
        </form>
    </div>

    @if(count($images) > 1)
    <div class="grid-label"><div class="dot"></div> اختر تصميم البطاقة &mdash; {{ count($images) }} تصاميم</div>
    @endif

    <div class="cards-grid">
        @foreach ($images as $index => $image)
            <div class="card-thumb{{ $index === 0 ? ' active' : '' }}" data-index="{{ $index }}">
                <div class="check-badge"><i class="fas fa-check"></i></div>
                <img src="{{ asset('storage/'.$image->image_path) }}" alt="بطاقة">
                <canvas id="canvas-{{ $index }}"></canvas>
            </div>
        @endforeach
    </div>
</div>

<div class="pg-footer">صُنعت بـ <i class="fas fa-heart" style="color:#d4a853"></i></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function initCanvases(name) {
        const images = {!! json_encode($images) !!};
        images.forEach((image, index) => {
            const canvas = document.getElementById(`canvas-${index}`);
            const ctx = canvas.getContext('2d');
            const img = new Image();
            img.src = '{{ asset("storage/") }}/' + image.image_path;
            let fontUrl = image.font_path ? '{{ asset("storage/") }}/' + image.font_path : '{{ asset("fonts/Cairo-VariableFont_slnt,wght.ttf") }}';
            const fontFace = new FontFace(`customFont-${index}`, `url(${fontUrl})`);
            fontFace.load().then(f => document.fonts.add(f));
            img.onload = function () {
                canvas.width = img.width; canvas.height = img.height;
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                ctx.font = `${image.font_size}px customFont-${index}`;
                ctx.fillStyle = image.font_color; ctx.textAlign = 'center';
                ctx.fillText(name, image.text_x, image.text_y);
            };
        });
    }
    initCanvases('');

    function draw(name, selectedIndex) {
        const canvas = document.getElementById(`canvas-${selectedIndex}`);
        const ctx = canvas.getContext('2d');
        const img = new Image();
        img.src = '{{ asset("storage/") }}/' + {!! json_encode($images) !!}[selectedIndex].image_path;
        img.onload = function () {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            const image = {!! json_encode($images) !!}[selectedIndex];
            ctx.font = `${image.font_size}px customFont`;
            ctx.fillStyle = image.font_color; ctx.textAlign = 'center';
            ctx.fillText(name, image.text_x, image.text_y);
        };
    }

    $('.card-thumb').on('click', function () { $('.card-thumb').removeClass('active'); $(this).addClass('active'); });
    $('#name-form').on('submit', function (e) {
        e.preventDefault();
        const name = $('#name').val(), idx = $('.card-thumb.active').data('index');
        draw(name, idx);
        const link = document.createElement('a');
        link.href = document.getElementById(`canvas-${idx}`).toDataURL();
        link.download = 'card.png'; link.click();
        // Track download
        const cardId = {!! json_encode($images->pluck('id')) !!}[idx];
        fetch('/track-download', {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
            body: JSON.stringify({card_id: cardId})
        });
    });
    $('#name').on('input', function () { initCanvases($(this).val()); });
    $('#share-btn').on('click', function () { window.open(`whatsapp://send?text=${encodeURIComponent(window.location.href)}`, '_blank'); });
</script>
</body>
</html>
