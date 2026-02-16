<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>البطاقات | إدارة</title>
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

        .page-wrap {
            position: relative; z-index: 1;
            max-width: 900px; margin: 0 auto;
            padding: 2.5rem 1.25rem 3rem;
        }

        .page-head {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 2rem;
        }
        .page-head h1 {
            font-size: 1.5rem; font-weight: 900;
            color: #2c2418;
            display: flex; align-items: center; gap: 0.6rem;
        }
        .page-head h1 i { color: #d4a853; font-size: 1.2rem; }

        .btn-back {
            background: #fff;
            border: 1px solid #e8dfd2;
            border-radius: 14px;
            padding: 0.6rem 1.2rem;
            font-size: 0.85rem; font-weight: 600;
            font-family: 'Tajawal', sans-serif;
            color: #9a8a72; cursor: pointer;
            text-decoration: none;
            display: flex; align-items: center; gap: 0.5rem;
            transition: all 0.3s;
        }
        .btn-back:hover { border-color: #d4a853; color: #2c2418; }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.25rem;
        }

        .card-box {
            background: #fff;
            border: 1px solid rgba(212,168,83,0.12);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        .card-box:hover {
            transform: translateY(-3px);
            border-color: rgba(212,168,83,0.3);
            box-shadow: 0 12px 32px rgba(0,0,0,0.07);
        }

        .card-box img {
            width: 100%; aspect-ratio: 16/10;
            object-fit: cover; display: block;
        }

        .card-actions {
            padding: 0.8rem 1rem;
            display: flex; justify-content: flex-end;
        }

        .btn-del {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 0.45rem 1rem;
            font-size: 0.82rem; font-weight: 600;
            font-family: 'Tajawal', sans-serif;
            cursor: pointer;
            display: flex; align-items: center; gap: 0.4rem;
            transition: all 0.3s;
        }
        .btn-del:hover {
            background: #ef4444; color: #fff;
            border-color: #ef4444;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(239,68,68,0.25);
        }

        .empty-box { text-align: center; padding: 4rem 1rem; }
        .empty-icon {
            width: 80px; height: 80px; border-radius: 24px;
            background: rgba(212,168,83,0.06);
            border: 1px solid rgba(212,168,83,0.1);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 2rem; color: #d4a853; opacity: 0.4;
            margin-bottom: 1.25rem;
        }
        .empty-box h3 { font-size: 1.1rem; font-weight: 700; color: #7a6c5a; margin-bottom: 0.4rem; }
        .empty-box p { color: #b8a990; font-size: 0.9rem; }

        .pg-footer {
            text-align: center; padding: 2rem 1rem;
            color: #c4b89e; font-size: 0.75rem;
            position: relative; z-index: 1;
        }

        @media (max-width: 600px) {
            .cards-grid { grid-template-columns: 1fr; }
            .page-head { flex-direction: column; gap: 1rem; align-items: stretch; }
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
            <a href="/"><i class="fas fa-wand-magic-sparkles"></i> <span>إنشاء</span></a>
            <a href="/routes"><i class="fas fa-folder-open"></i> <span>مجموعاتي</span></a>
            @if(Auth::check() && Auth::user()->email === 'yazoid1421@gmail.com')
            <a href="/admin"><i class="fas fa-chart-line"></i> <span>الإدارة</span></a>
            @endif
        </div>
    </div>
</nav>

<div class="page-wrap">
    <div class="page-head">
        <h1><i class="fas fa-images"></i> البطاقات</h1>
        <a href="/routes" class="btn-back"><i class="fas fa-arrow-right"></i> رجوع للمجموعات</a>
    </div>

    @if(count($cards) > 0)
    <div class="cards-grid">
        @foreach ($cards as $card)
        <div class="card-box">
            <img src="{{ asset('storage/' . $card->image_path) }}" alt="{{ $card->route }}">
            <div class="card-actions">
                <form action="{{ route('giftcards.destroy', $card->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه البطاقة؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-del"><i class="fas fa-trash-alt"></i> حذف</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-box">
        <div class="empty-icon"><i class="fas fa-images"></i></div>
        <h3>لا توجد بطاقات</h3>
        <p>لم يتم إنشاء بطاقات في هذه المجموعة</p>
    </div>
    @endif
</div>

<div class="pg-footer">صُنعت بـ <i class="fas fa-heart" style="color:#d4a853"></i></div>
</body>
</html>
