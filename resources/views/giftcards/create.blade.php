<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء بطاقة | البطاقات</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @font-face {
            font-family: 'Cairo';
            src: url('{{ asset('fonts/Cairo-VariableFont_slnt,wght.ttf') }}');
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Tajawal', 'Cairo', sans-serif;
            background: #faf8f5;
            color: #2c2418;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .bg-pattern {
            position: fixed; inset: 0; z-index: 0;
            background: radial-gradient(ellipse at 20% 0%, rgba(212,168,83,0.08) 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 100%, rgba(212,168,83,0.06) 0%, transparent 50%);
        }

        /* Nav */
        .glass-nav {
            position: sticky; top: 0; z-index: 50;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(212,168,83,0.12);
            padding: 0.9rem 1.5rem;
        }
        .glass-nav .inner { max-width: 800px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .glass-nav .brand {
            font-size: 1.3rem; font-weight: 800; text-decoration: none;
            color: #2c2418;
        }
        .nav-pills { display: flex; gap: 0.25rem; background: rgba(212,168,83,0.08); border-radius: 12px; padding: 4px; }
        .nav-pills a {
            padding: 0.45rem 1rem; border-radius: 10px; text-decoration: none;
            color: #9a8a72; font-size: 0.85rem; font-weight: 500;
            transition: all 0.3s; display: flex; align-items: center; gap: 0.4rem;
        }
        .nav-pills a:hover { color: #2c2418; }
        .nav-pills a.active {
            background: linear-gradient(135deg, #c9973b, #d4a853);
            color: #fff;
            box-shadow: 0 4px 12px rgba(184,134,11,0.2);
        }

        /* Content */
        .page-wrap {
            position: relative; z-index: 1;
            max-width: 680px; margin: 0 auto;
            padding: 2.5rem 1.25rem 3rem;
        }

        /* Hero */
        .hero { text-align: center; margin-bottom: 2.5rem; }
        .hero-icon {
            width: 64px; height: 64px; border-radius: 20px;
            background: linear-gradient(135deg, #c9973b, #d4a853);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: #fff;
            margin-bottom: 1rem;
            box-shadow: 0 8px 32px rgba(184,134,11,0.2);
        }
        .hero h1 {
            font-size: 2rem; font-weight: 900;
            margin-bottom: 0.5rem; color: #2c2418;
        }
        .hero p { color: #9a8a72; font-size: 0.95rem; }

        /* Glass Card */
        .glass-card {
            background: #fff;
            border: 1px solid rgba(212,168,83,0.15);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 2px 16px rgba(0,0,0,0.04), 0 0 0 1px rgba(212,168,83,0.06);
        }

        /* Section Headers */
        .sec-head { display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1.1rem; }
        .sec-head .dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: linear-gradient(135deg, #c9973b, #d4a853);
        }
        .sec-head span {
            font-size: 0.8rem; font-weight: 700;
            letter-spacing: 1px; text-transform: uppercase;
            color: #9a8a72;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(212,168,83,0.15), transparent);
            margin: 1.75rem 0;
        }

        /* Form */
        label {
            display: block; font-size: 0.85rem; font-weight: 600;
            color: #7a6c5a; margin-bottom: 0.4rem;
        }
        .input-field {
            width: 100%;
            background: #faf8f5;
            border: 2px solid #e8dfd2;
            border-radius: 14px;
            padding: 0.75rem 1rem;
            color: #2c2418;
            font-size: 0.95rem;
            font-family: 'Tajawal', sans-serif;
            transition: all 0.3s;
            outline: none;
        }
        .input-field:focus {
            border-color: #d4a853;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(212,168,83,0.1);
        }
        .input-field::placeholder { color: #c4b89e; }

        /* URL Input */
        .url-group {
            display: flex; direction: ltr;
            border-radius: 14px; overflow: hidden;
            border: 2px solid #e8dfd2;
            transition: all 0.3s;
            background: #fff;
        }
        .url-group:focus-within {
            border-color: #d4a853;
            box-shadow: 0 0 0 4px rgba(212,168,83,0.1);
        }
        .url-prefix {
            background: #f5f0e8;
            padding: 0.75rem 0.9rem;
            font-size: 0.8rem;
            color: #9a8a72;
            white-space: nowrap;
            border-left: 1px solid #e8dfd2;
            display: flex; align-items: center;
        }
        .url-group input {
            flex: 1; background: transparent;
            border: none; padding: 0.75rem 1rem;
            color: #2c2418; font-size: 0.95rem;
            font-family: 'Tajawal', sans-serif;
            outline: none;
        }
        .url-group input::placeholder { color: #c4b89e; }

        /* File Upload */
        .file-drop {
            border: 2px dashed #e0d5c4;
            border-radius: 16px; padding: 1.75rem;
            text-align: center; cursor: pointer;
            position: relative; overflow: hidden;
            transition: all 0.3s;
            background: #faf8f5;
        }
        .file-drop::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(212,168,83,0.04), rgba(245,230,204,0.06));
            opacity: 0; transition: opacity 0.3s;
        }
        .file-drop:hover { border-color: #d4a853; }
        .file-drop:hover::before { opacity: 1; }
        .file-drop.active { border-color: #22c55e; background: rgba(34,197,94,0.04); }
        .file-drop.active .drop-icon { color: #22c55e; }
        .file-drop input[type="file"] {
            position: absolute; inset: 0; opacity: 0;
            cursor: pointer; z-index: 2;
        }
        .drop-icon {
            font-size: 2rem; margin-bottom: 0.5rem;
            color: #d4a853; position: relative;
            transition: color 0.3s; opacity: 0.5;
        }
        .drop-text { font-size: 0.9rem; color: #9a8a72; position: relative; }
        .drop-filename {
            font-size: 0.8rem; color: #22c55e;
            font-weight: 700; margin-top: 0.3rem;
            position: relative;
        }

        /* Row */
        .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

        /* Tip */
        .tip-box {
            display: flex; align-items: center; gap: 0.6rem;
            background: rgba(212,168,83,0.08);
            border: 1px solid rgba(212,168,83,0.15);
            border-radius: 12px;
            padding: 0.7rem 1rem; margin-bottom: 1rem;
        }
        .tip-box i { color: #d4a853; font-size: 0.9rem; }
        .tip-box span { font-size: 0.82rem; color: #7a6c5a; }

        /* Color Input */
        input[type="color"] {
            -webkit-appearance: none; appearance: none;
            width: 100%; height: 48px;
            border: 2px solid #e8dfd2;
            border-radius: 14px; background: #faf8f5;
            cursor: pointer; padding: 4px;
        }
        input[type="color"]::-webkit-color-swatch-wrapper { padding: 2px; }
        input[type="color"]::-webkit-color-swatch { border: none; border-radius: 10px; }

        /* Alert */
        .alert-err {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 14px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 0.6rem;
            font-size: 0.875rem; color: #dc2626;
        }
        .alert-err i { color: #ef4444; }

        /* Button */
        .btn-glow {
            width: 100%; padding: 0.9rem;
            border: none; border-radius: 16px;
            font-size: 1.05rem; font-weight: 700;
            font-family: 'Tajawal', sans-serif;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 0.6rem;
            color: #fff;
            background: linear-gradient(135deg, #c9973b, #d4a853);
            box-shadow: 0 4px 20px rgba(184,134,11,0.2);
            transition: all 0.3s;
        }
        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 36px rgba(184,134,11,0.3);
        }
        .btn-glow:active { transform: translateY(0); }

        /* Preview */
        .preview-wrap { margin-top: 2.5rem; }
        .preview-label {
            text-align: center; margin-bottom: 1rem;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            color: #9a8a72; font-size: 0.85rem; font-weight: 600;
        }
        .preview-label i { color: #d4a853; }
        .preview-glass {
            background: #fff;
            border: 1px solid rgba(212,168,83,0.15);
            border-radius: 20px; padding: 1rem;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        }
        .preview-glass canvas {
            display: block; margin: 0 auto;
            border-radius: 14px; max-width: 100%;
            cursor: crosshair;
        }

        .mb { margin-bottom: 1rem; }

        .pg-footer {
            text-align: center; padding: 2rem 1rem;
            color: #c4b89e; font-size: 0.75rem;
            position: relative; z-index: 1;
        }

        @media (max-width: 600px) {
            .field-row { grid-template-columns: 1fr; }
            .glass-card { padding: 1.5rem; }
            .page-wrap { padding: 1.5rem 1rem 2rem; }
            .hero h1 { font-size: 1.5rem; }
            .nav-pills a span { display: none; }
        }
    </style>
</head>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-SEJSBXEQTX"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-SEJSBXEQTX');
</script>
<body>

<div class="bg-pattern"></div>

<nav class="glass-nav">
    <div class="inner">
        <a href="/" class="brand">البطاقات</a>
        <div class="nav-pills">
            <a href="/" class="active"><i class="fas fa-wand-magic-sparkles"></i> <span>إنشاء</span></a>
            <a href="/routes"><i class="fas fa-folder-open"></i> <span>مجموعاتي</span></a>
            @if(Auth::check() && Auth::user()->email === 'yazoid1421@gmail.com')
            <a href="/admin"><i class="fas fa-chart-line"></i> <span>الإدارة</span></a>
            @endif
        </div>
    </div>
</nav>

<div class="page-wrap">
    <div class="hero">
        <div class="hero-icon"><i class="fas fa-wand-magic-sparkles"></i></div>
        <h1>صمّم بطاقتك</h1>
        <p>أنشئ بطاقة مميزة وشاركها مع أحبابك</p>
    </div>

    <div class="glass-card">
        <form action="/upload" method="POST" enctype="multipart/form-data">
            @csrf

            @if ($errors->has('route'))
                <div class="alert-err">
                    <i class="fas fa-circle-exclamation"></i>
                    {{ $errors->first('route') }}
                </div>
            @endif

            <div class="sec-head"><div class="dot"></div><span>رابط البطاقة</span></div>
            <div class="mb">
                <label>اختر رابط فريد لبطاقتك</label>
                <div class="url-group">
                    <span class="url-prefix">cards.yt.sa/card/</span>
                    <input type="text" name="route" id="route" required pattern="[a-zA-Z0-9]+" placeholder="اسم-المناسبة">
                </div>
            </div>

            <div class="divider"></div>

            <div class="sec-head"><div class="dot"></div><span>رفع الملفات</span></div>

            <div class="mb">
                <label>صورة البطاقة</label>
                <div class="file-drop" id="imageWrap">
                    <div class="drop-icon"><i class="fas fa-cloud-arrow-up"></i></div>
                    <div class="drop-text">اسحب الصورة هنا أو اضغط للاختيار</div>
                    <div class="drop-filename" id="imgName"></div>
                    <input type="file" name="image" id="image" accept="image/*" required>
                </div>
            </div>

            <div class="mb">
                <label>خط مخصص <span style="opacity:0.4">(اختياري)</span></label>
                <div class="file-drop" id="fontWrap">
                    <div class="drop-icon"><i class="fas fa-font"></i></div>
                    <div class="drop-text">TTF أو OTF</div>
                    <div class="drop-filename" id="fntName"></div>
                    <input type="file" name="font" id="font" accept=".ttf,.otf">
                </div>
            </div>

            <div class="divider"></div>

            <div class="sec-head"><div class="dot"></div><span>موضع النص</span></div>
            <div class="tip-box">
                <i class="fas fa-hand-pointer"></i>
                <span>اضغط على المعاينة بالأسفل لتحديد مكان الاسم</span>
            </div>
            <div class="field-row mb">
                <div>
                    <label>الأفقي (X)</label>
                    <input type="text" name="text_x" id="textX" class="input-field" min="0" value="10" required>
                </div>
                <div>
                    <label>العمودي (Y)</label>
                    <input type="text" name="text_y" id="textY" class="input-field" min="0" value="10" required>
                </div>
            </div>

            <div class="divider"></div>

            <div class="sec-head"><div class="dot"></div><span>تنسيق الخط</span></div>
            <div class="field-row mb">
                <div>
                    <label>الحجم</label>
                    <input type="number" name="font_size" id="fontSize" class="input-field" min="10" max="100" value="24" required>
                </div>
                <div>
                    <label>اللون</label>
                    <input type="color" name="font_color" id="fontColor" value="#000000" required>
                </div>
            </div>

            <div class="divider"></div>

            <button type="submit" class="btn-glow">
                <i class="fas fa-sparkles"></i>
                <span>إنشاء البطاقة</span>
            </button>
        </form>
    </div>

    <div class="preview-wrap">
        <div class="preview-label"><i class="fas fa-eye"></i> المعاينة المباشرة</div>
        <div class="preview-glass">
            <canvas id="preview" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<div class="pg-footer">صُنعت بـ <i class="fas fa-heart" style="color:#d4a853"></i></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/opentype.js/1.3.0/opentype.min.js"></script>
<script>
    document.querySelectorAll('.file-drop input[type="file"]').forEach(inp => {
        inp.addEventListener('change', function() {
            const wrap = this.closest('.file-drop');
            const nm = wrap.querySelector('.drop-filename');
            if (this.files.length) { nm.textContent = this.files[0].name; wrap.classList.add('active'); }
            else { nm.textContent = ''; wrap.classList.remove('active'); }
        });
    });

    const canvas = document.getElementById('preview');
    const ctx = canvas.getContext('2d');
    let img = new Image();
    let fontUrl = null;
    const defaultFontUrl = '{{ asset('fonts/Cairo-VariableFont_slnt,wght.ttf') }}';

    $('#image').on('change', function () {
        const reader = new FileReader();
        reader.onload = function (e) { img.src = e.target.result; img.onload = function () { draw(); }; };
        reader.readAsDataURL(this.files[0]);
    });

    $('#font').on('change', function () {
        if (this.files.length > 0) {
            const reader = new FileReader();
            reader.onload = function (e) {
                fontUrl = URL.createObjectURL(new Blob([new Uint8Array(e.target.result)], { type: 'font/opentype' }));
                draw();
            };
            reader.readAsArrayBuffer(this.files[0]);
        } else { fontUrl = defaultFontUrl; draw(); }
    });

    $('input[type=number], input[type=color]').on('input', draw);
    img.src = 'https://via.placeholder.com/400x200';

    function fitImageOnCanvas(image, maxW, maxH) {
        const r = Math.min(maxW / image.width, maxH / image.height);
        return { width: image.width * r, height: image.height * r };
    }

    function draw() {
        if (!img.src) return;
        if (!fontUrl) fontUrl = defaultFontUrl;
        const d = fitImageOnCanvas(img, window.innerWidth, window.innerHeight);
        const sx = d.width / img.width, sy = d.height / img.height, s = Math.min(sx, sy);
        canvas.width = d.width; canvas.height = d.height;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        const text = 'يزيد فهد الطويل';
        const fs = parseInt($('#fontSize').val(), 10) * s;
        const fc = $('#fontColor').val();
        const tx = parseInt($('#textX').val(), 10) * sx;
        const ty = parseInt($('#textY').val(), 10) * sy;
        new FontFace("customFont", `url(${fontUrl})`).load().then(f => {
            document.fonts.add(f);
            ctx.font = `${fs}px customFont`; ctx.fillStyle = fc; ctx.textAlign = 'center';
            ctx.fillText(text, tx, ty);
        });
    }

    function updatePos(x, y) {
        const b = canvas.getBoundingClientRect();
        const sx = img.width / b.width, sy = img.height / b.height;
        $('#textX').val(((x - b.left) * sx).toFixed(2));
        $('#textY').val(((y - b.top) * sy).toFixed(2));
        draw();
    }

    let drag = false;
    canvas.addEventListener('mousedown', e => { drag = true; updatePos(e.clientX, e.clientY); });
    canvas.addEventListener('mousemove', e => { if (drag) updatePos(e.clientX, e.clientY); });
    canvas.addEventListener('mouseup', () => drag = false);
    canvas.addEventListener('mouseout', () => drag = false);
    canvas.addEventListener('touchstart', e => { e.preventDefault(); drag = true; updatePos(e.touches[0].clientX, e.touches[0].clientY); });
    canvas.addEventListener('touchmove', e => { e.preventDefault(); if (drag) updatePos(e.touches[0].clientX, e.touches[0].clientY); });
    canvas.addEventListener('touchend', () => drag = false);
    draw();
</script>
</body>
</html>
