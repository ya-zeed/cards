<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم | البطاقات</title>
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
        .glass-nav .inner { max-width: 1000px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
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
            max-width: 1000px; margin: 0 auto;
            padding: 2rem 1.25rem 3rem;
        }

        .page-head {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 2rem;
        }
        .page-head h1 {
            font-size: 1.6rem; font-weight: 900;
            color: #2c2418;
            display: flex; align-items: center; gap: 0.6rem;
        }
        .page-head h1 i { color: #d4a853; font-size: 1.3rem; }

        .btn-back {
            background: #fff; border: 1px solid #e8dfd2;
            border-radius: 14px; padding: 0.6rem 1.2rem;
            font-size: 0.85rem; font-weight: 600;
            font-family: 'Tajawal', sans-serif;
            color: #9a8a72; cursor: pointer; text-decoration: none;
            display: flex; align-items: center; gap: 0.5rem;
            transition: all 0.3s;
        }
        .btn-back:hover { border-color: #d4a853; color: #2c2418; }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: #fff;
            border: 1px solid rgba(212,168,83,0.12);
            border-radius: 18px;
            padding: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            transition: all 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        }
        .stat-icon {
            width: 42px; height: 42px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; margin-bottom: 0.85rem;
        }
        .stat-icon.gold { background: rgba(212,168,83,0.12); color: #d4a853; }
        .stat-icon.green { background: rgba(34,197,94,0.1); color: #22c55e; }
        .stat-icon.blue { background: rgba(59,130,246,0.1); color: #3b82f6; }
        .stat-icon.purple { background: rgba(139,92,246,0.1); color: #8b5cf6; }

        .stat-value {
            font-size: 1.8rem; font-weight: 900;
            color: #2c2418; line-height: 1;
            margin-bottom: 0.2rem;
        }
        .stat-label { font-size: 0.82rem; color: #9a8a72; font-weight: 600; }

        /* Section */
        .section-head {
            display: flex; align-items: center; gap: 0.5rem;
            margin-bottom: 1rem; margin-top: 0.5rem;
        }
        .section-head .dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: #d4a853;
        }
        .section-head span {
            font-size: 0.85rem; font-weight: 700; color: #9a8a72;
        }

        /* Top Card Highlight */
        .top-card-box {
            background: linear-gradient(135deg, rgba(212,168,83,0.06), rgba(212,168,83,0.02));
            border: 1px solid rgba(212,168,83,0.2);
            border-radius: 20px;
            padding: 1.25rem;
            display: flex; align-items: center; gap: 1.25rem;
            margin-bottom: 2rem;
        }
        .top-card-box img {
            width: 140px; height: 90px;
            object-fit: cover; border-radius: 14px;
            border: 2px solid rgba(212,168,83,0.2);
        }
        .top-card-info { flex: 1; }
        .top-card-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: linear-gradient(135deg, #c9973b, #d4a853);
            color: #fff; font-size: 0.72rem; font-weight: 700;
            padding: 0.25rem 0.75rem; border-radius: 50px;
            margin-bottom: 0.5rem;
        }
        .top-card-route { font-weight: 800; font-size: 1.1rem; margin-bottom: 0.15rem; }
        .top-card-stats {
            display: flex; gap: 1rem;
            font-size: 0.82rem; color: #9a8a72;
        }
        .top-card-stats strong { color: #2c2418; }

        /* Routes Table */
        .routes-table {
            background: #fff;
            border: 1px solid rgba(212,168,83,0.12);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            margin-bottom: 2rem;
        }
        .routes-table table {
            width: 100%; border-collapse: collapse;
        }
        .routes-table th {
            background: #faf8f5;
            padding: 0.85rem 1.1rem;
            text-align: right;
            font-size: 0.78rem;
            font-weight: 700;
            color: #9a8a72;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #f0e9de;
        }
        .routes-table td {
            padding: 0.9rem 1.1rem;
            font-size: 0.9rem;
            border-bottom: 1px solid #f5f0e8;
            vertical-align: middle;
        }
        .routes-table tr:last-child td { border-bottom: none; }
        .routes-table tr:hover td { background: rgba(212,168,83,0.03); }

        .route-cell { display: flex; align-items: center; gap: 0.7rem; }
        .route-cell-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: rgba(212,168,83,0.1);
            display: flex; align-items: center; justify-content: center;
            color: #d4a853; font-size: 0.85rem;
        }
        .route-cell-name { font-weight: 700; }
        .route-cell-url { font-size: 0.72rem; color: #b8a990; direction: ltr; text-align: right; }

        .num-cell { font-weight: 800; font-size: 1rem; }
        .num-gold { color: #a67c2e; }
        .num-green { color: #16a34a; }
        .num-blue { color: #2563eb; }

        .user-pill {
            display: inline-flex; align-items: center; gap: 0.3rem;
            background: rgba(212,168,83,0.08);
            padding: 0.2rem 0.6rem; border-radius: 8px;
            font-size: 0.78rem; font-weight: 600; color: #7a6c5a;
        }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1rem;
        }
        .card-item {
            background: #fff;
            border: 1px solid rgba(212,168,83,0.12);
            border-radius: 18px;
            overflow: hidden;
            transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        .card-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        }
        .card-item img {
            width: 100%; aspect-ratio: 16/10;
            object-fit: cover; display: block;
        }
        .card-item-info {
            padding: 0.75rem 0.9rem;
            display: flex; justify-content: space-between; align-items: center;
        }
        .card-item-route {
            font-size: 0.82rem; font-weight: 700;
            color: #2c2418;
        }
        .card-item-stats {
            display: flex; gap: 0.6rem;
            font-size: 0.75rem; color: #9a8a72;
        }
        .card-item-stats span { display: flex; align-items: center; gap: 0.25rem; }
        .card-item-stats i { font-size: 0.65rem; }

        .rank-badge {
            position: absolute; top: 8px; right: 8px;
            background: linear-gradient(135deg, #c9973b, #d4a853);
            color: #fff; font-size: 0.7rem; font-weight: 800;
            width: 26px; height: 26px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 8px rgba(184,134,11,0.3);
        }
        .card-item-img-wrap { position: relative; }

        .pg-footer {
            text-align: center; padding: 2rem 1rem;
            color: #c4b89e; font-size: 0.75rem;
            position: relative; z-index: 1;
        }

        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .top-card-box { flex-direction: column; text-align: center; }
            .top-card-box img { width: 100%; height: auto; }
            .top-card-stats { justify-content: center; }
            .routes-table { overflow-x: auto; }
            .routes-table table { min-width: 600px; }
        }

        @media (max-width: 600px) {
            .page-head { flex-direction: column; gap: 1rem; align-items: stretch; }
            .cards-grid { grid-template-columns: 1fr; }
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
            <a href="/admin" class="active"><i class="fas fa-chart-line"></i> <span>الإدارة</span></a>
        </div>
    </div>
</nav>

<div class="page-wrap">
    <div class="page-head">
        <h1><i class="fas fa-chart-line"></i> لوحة التحكم</h1>
        <a href="/" class="btn-back"><i class="fas fa-arrow-right"></i> الرئيسية</a>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon gold"><i class="fas fa-folder-open"></i></div>
            <div class="stat-value">{{ $totalRoutes }}</div>
            <div class="stat-label">مجموعة</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-images"></i></div>
            <div class="stat-value">{{ $totalCards }}</div>
            <div class="stat-label">بطاقة</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-download"></i></div>
            <div class="stat-value">{{ number_format($totalDownloads) }}</div>
            <div class="stat-label">تحميل</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-eye"></i></div>
            <div class="stat-value">{{ number_format($totalViews) }}</div>
            <div class="stat-label">مشاهدة</div>
        </div>
    </div>

    <!-- Top Card -->
    @if($topCard && $topCard->download_count > 0)
    <div class="section-head"><div class="dot"></div><span>الأكثر تحميلاً</span></div>
    <div class="top-card-box">
        <img src="{{ asset('storage/' . $topCard->image_path) }}" alt="top">
        <div class="top-card-info">
            <div class="top-card-badge"><i class="fas fa-crown"></i> الأعلى تحميلاً</div>
            <div class="top-card-route">{{ $topCard->route }}</div>
            <div class="top-card-stats">
                <span><strong>{{ number_format($topCard->download_count) }}</strong> تحميل</span>
                <span><strong>{{ number_format($topCard->view_count) }}</strong> مشاهدة</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Routes Table -->
    <div class="section-head"><div class="dot"></div><span>إحصائيات المجموعات</span></div>
    @if($routeStats->count() > 0)
    <div class="routes-table">
        <table>
            <thead>
                <tr>
                    <th>المجموعة</th>
                    <th>البطاقات</th>
                    <th>التحميلات</th>
                    <th>المشاهدات</th>
                    <th>المالك</th>
                </tr>
            </thead>
            <tbody>
                @foreach($routeStats as $stat)
                <tr>
                    <td>
                        <div class="route-cell">
                            <div class="route-cell-icon"><i class="fas fa-folder"></i></div>
                            <div>
                                <div class="route-cell-name">{{ $stat['route'] }}</div>
                                <div class="route-cell-url">cards.yt.sa/card/{{ $stat['route'] }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="num-cell num-blue">{{ $stat['cards_count'] }}</td>
                    <td class="num-cell num-green">{{ number_format($stat['downloads']) }}</td>
                    <td class="num-cell num-gold">{{ number_format($stat['views']) }}</td>
                    <td>
                        @if($stat['user'])
                        <span class="user-pill"><i class="fas fa-user"></i> {{ $stat['user']->name }}</span>
                        @else
                        <span class="user-pill" style="opacity:0.5">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="text-align:center; padding: 2rem; color: #9a8a72; font-size: 0.9rem;">
        لا توجد مجموعات بعد
    </div>
    @endif

    <!-- All Cards -->
    <div class="section-head"><div class="dot"></div><span>جميع البطاقات حسب التحميلات</span></div>
    @if($cardsByDownloads->count() > 0)
    <div class="cards-grid">
        @foreach($cardsByDownloads as $index => $card)
        <div class="card-item">
            <div class="card-item-img-wrap">
                <img src="{{ asset('storage/' . $card->image_path) }}" alt="{{ $card->route }}">
                @if($index < 3 && $card->download_count > 0)
                <div class="rank-badge">{{ $index + 1 }}</div>
                @endif
            </div>
            <div class="card-item-info">
                <div class="card-item-route">{{ $card->route }}</div>
                <div class="card-item-stats">
                    <span><i class="fas fa-download"></i> {{ $card->download_count }}</span>
                    <span><i class="fas fa-eye"></i> {{ $card->view_count }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<div class="pg-footer">صُنعت بـ <i class="fas fa-heart" style="color:#d4a853"></i></div>
</body>
</html>
