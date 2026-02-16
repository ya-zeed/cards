<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مجموعاتي | البطاقات</title>
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

        /* Page */
        .page-wrap {
            position: relative; z-index: 1;
            max-width: 700px; margin: 0 auto;
            padding: 2.5rem 1.25rem 3rem;
        }

        /* Header */
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

        .btn-new {
            background: linear-gradient(135deg, #c9973b, #d4a853);
            color: #fff; border: none; border-radius: 14px;
            padding: 0.7rem 1.3rem; font-size: 0.9rem;
            font-weight: 700; font-family: 'Tajawal', sans-serif;
            cursor: pointer; text-decoration: none;
            display: flex; align-items: center; gap: 0.5rem;
            transition: all 0.3s;
            box-shadow: 0 4px 16px rgba(184,134,11,0.2);
        }
        .btn-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(184,134,11,0.3);
            color: #fff;
        }

        /* Alert */
        .alert-msg {
            border-radius: 14px; padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 0.6rem;
            font-size: 0.875rem; font-weight: 600;
        }
        .alert-msg.success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
        .alert-msg.error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        /* Route List */
        .route-list { display: flex; flex-direction: column; gap: 0.75rem; }

        .route-card {
            background: #fff;
            border: 1px solid rgba(212,168,83,0.12);
            border-radius: 18px;
            padding: 1.1rem 1.25rem;
            display: flex; justify-content: space-between; align-items: center;
            transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        .route-card:hover {
            border-color: rgba(212,168,83,0.3);
            box-shadow: 0 8px 28px rgba(0,0,0,0.06);
        }

        .route-right { display: flex; align-items: center; gap: 0.85rem; flex: 1; min-width: 0; }
        .route-icon {
            width: 44px; height: 44px; border-radius: 14px;
            background: rgba(212,168,83,0.1);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: #d4a853; flex-shrink: 0;
        }
        .route-text { min-width: 0; flex: 1; }
        .route-name {
            font-weight: 700; font-size: 1rem;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .route-name a {
            text-decoration: none; color: #2c2418;
            transition: color 0.2s;
        }
        .route-name a:hover { color: #d4a853; }
        .route-url {
            font-size: 0.78rem; color: #b8a990;
            direction: ltr; text-align: right;
        }

        .route-actions { display: flex; align-items: center; gap: 0.5rem; flex-shrink: 0; }
        .count-pill {
            background: rgba(212,168,83,0.12);
            color: #a67c2e; font-weight: 700;
            font-size: 0.82rem;
            padding: 0.25rem 0.8rem;
            border-radius: 50px;
        }
        .btn-edit {
            background: rgba(212,168,83,0.08);
            color: #a67c2e; border: 1px solid rgba(212,168,83,0.15);
            border-radius: 10px; padding: 0.35rem 0.65rem;
            font-size: 0.78rem; cursor: pointer;
            display: flex; align-items: center; gap: 0.3rem;
            transition: all 0.3s;
            font-family: 'Tajawal', sans-serif; font-weight: 600;
        }
        .btn-edit:hover {
            background: rgba(212,168,83,0.18);
            border-color: #d4a853; color: #8b6914;
        }
        .arrow-link {
            color: #c4b89e; font-size: 0.8rem; transition: all 0.3s;
            text-decoration: none; display: flex; align-items: center;
            padding: 0.35rem;
        }
        .route-card:hover .arrow-link { transform: translateX(-5px); color: #d4a853; }

        /* Modal */
        .modal-overlay {
            display: none; position: fixed; inset: 0; z-index: 100;
            background: rgba(44,36,24,0.4);
            backdrop-filter: blur(4px);
            align-items: center; justify-content: center;
            padding: 1rem;
        }
        .modal-overlay.show { display: flex; }
        .modal-box {
            background: #fff; border-radius: 22px;
            padding: 2rem; width: 100%; max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.12);
            animation: modalIn 0.25s ease-out;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: translateY(20px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .modal-head {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.25rem;
        }
        .modal-head h3 {
            font-size: 1.1rem; font-weight: 800; color: #2c2418;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .modal-head h3 i { color: #d4a853; }
        .modal-close {
            background: none; border: none; font-size: 1.2rem;
            color: #c4b89e; cursor: pointer; padding: 0.3rem;
            transition: color 0.2s;
        }
        .modal-close:hover { color: #2c2418; }

        .modal-label {
            font-size: 0.82rem; font-weight: 600; color: #7a6c5a;
            margin-bottom: 0.35rem; display: block;
        }
        .modal-input {
            width: 100%; background: #faf8f5;
            border: 2px solid #e8dfd2; border-radius: 14px;
            padding: 0.75rem 1rem; color: #2c2418;
            font-size: 0.95rem; font-family: 'Tajawal', sans-serif;
            outline: none; transition: all 0.3s;
            direction: ltr; text-align: left;
            margin-bottom: 1.25rem;
        }
        .modal-input:focus {
            border-color: #d4a853; background: #fff;
            box-shadow: 0 0 0 4px rgba(212,168,83,0.1);
        }
        .modal-url-hint {
            font-size: 0.75rem; color: #b8a990; direction: ltr;
            text-align: left; margin-top: -1rem; margin-bottom: 1.25rem;
        }
        .modal-btns { display: flex; gap: 0.6rem; }
        .modal-btns .btn-save {
            flex: 1; background: linear-gradient(135deg, #c9973b, #d4a853);
            color: #fff; border: none; border-radius: 14px;
            padding: 0.75rem; font-size: 0.95rem; font-weight: 700;
            font-family: 'Tajawal', sans-serif; cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 16px rgba(184,134,11,0.2);
        }
        .modal-btns .btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(184,134,11,0.3);
        }
        .modal-btns .btn-cancel {
            background: #fff; border: 1px solid #e8dfd2;
            border-radius: 14px; padding: 0.75rem 1.2rem;
            font-size: 0.9rem; font-weight: 600; color: #9a8a72;
            font-family: 'Tajawal', sans-serif; cursor: pointer;
            transition: all 0.3s;
        }
        .modal-btns .btn-cancel:hover { border-color: #d4a853; color: #2c2418; }

        /* Empty */
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
            .page-head { flex-direction: column; gap: 1rem; align-items: stretch; }
            .page-head h1 { justify-content: center; }
            .btn-new { justify-content: center; }
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
            <a href="/routes" class="active"><i class="fas fa-folder-open"></i> <span>مجموعاتي</span></a>
            @if(Auth::check() && Auth::user()->email === 'yazoid1421@gmail.com')
            <a href="/admin"><i class="fas fa-chart-line"></i> <span>الإدارة</span></a>
            @endif
        </div>
    </div>
</nav>

<div class="page-wrap">
    <div class="page-head">
        <h1><i class="fas fa-folder-open"></i> مجموعاتي</h1>
        <a href="/" class="btn-new"><i class="fas fa-plus"></i> بطاقة جديدة</a>
    </div>

    @if(session('success'))
    <div class="alert-msg success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert-msg error"><i class="fas fa-circle-exclamation"></i> {{ session('error') }}</div>
    @endif

    @if(count($routes) > 0)
    <div class="route-list">
        @foreach ($routes as $route)
            <div class="route-card">
                <div class="route-right">
                    <div class="route-icon"><i class="fas fa-folder"></i></div>
                    <div class="route-text">
                        <div class="route-name">
                            <a href="{{ route('giftcards.cards', ['route' => $route->first()->route]) }}">{{ $route->first()->route }}</a>
                        </div>
                        <div class="route-url">cards.yt.sa/card/{{ $route->first()->route }}</div>
                    </div>
                </div>
                <div class="route-actions">
                    <span class="count-pill">{{ $route->count() }} بطاقة</span>
                    <button class="btn-edit" onclick="openEdit('{{ $route->first()->route }}')"><i class="fas fa-pen"></i> تعديل</button>
                    <a href="{{ route('giftcards.cards', ['route' => $route->first()->route]) }}" class="arrow-link"><i class="fas fa-chevron-left"></i></a>
                </div>
            </div>
        @endforeach
    </div>
    @else
    <div class="empty-box">
        <div class="empty-icon"><i class="fas fa-folder-open"></i></div>
        <h3>لا توجد مجموعات بعد</h3>
        <p>أنشئ أول بطاقة وستظهر هنا</p>
    </div>
    @endif
</div>

<!-- Edit Modal -->
<div class="modal-overlay" id="editModal">
    <div class="modal-box">
        <div class="modal-head">
            <h3><i class="fas fa-pen"></i> تعديل الرابط</h3>
            <button class="modal-close" onclick="closeEdit()"><i class="fas fa-xmark"></i></button>
        </div>
        <form action="{{ route('routes.update') }}" method="POST">
            @csrf
            <input type="hidden" name="old_route" id="editOldRoute">
            <label class="modal-label">الرابط الجديد</label>
            <input type="text" name="new_route" id="editNewRoute" class="modal-input" required pattern="[a-zA-Z0-9]+" placeholder="اسم-المجموعة">
            <div class="modal-url-hint">cards.yt.sa/card/<span id="editPreview">...</span></div>
            <div class="modal-btns">
                <button type="submit" class="btn-save"><i class="fas fa-check"></i> حفظ</button>
                <button type="button" class="btn-cancel" onclick="closeEdit()">إلغاء</button>
            </div>
        </form>
    </div>
</div>

<div class="pg-footer">صُنعت بـ <i class="fas fa-heart" style="color:#d4a853"></i></div>

<script>
    function openEdit(route) {
        document.getElementById('editOldRoute').value = route;
        document.getElementById('editNewRoute').value = route;
        document.getElementById('editPreview').textContent = route;
        document.getElementById('editModal').classList.add('show');
    }
    function closeEdit() {
        document.getElementById('editModal').classList.remove('show');
    }
    document.getElementById('editNewRoute').addEventListener('input', function() {
        document.getElementById('editPreview').textContent = this.value || '...';
    });
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) closeEdit();
    });
</script>
</body>
</html>
