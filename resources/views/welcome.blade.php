<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>البطاقات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'MyCustomFont';
            src: url('{{asset('fonts/Cairo-VariableFont_slnt,wght.ttf')}}');
        }

        body {
            background-color: #f5f5f5;
            font-family: 'MyCustomFont', sans-serif;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">البطاقات</h1>
    <form action="/upload" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded">
        @csrf
        <div class="mb-3">
            <!-- Display the error message for route field -->
            @if ($errors->has('route'))
                <div class="alert alert-danger">{{ $errors->first('route') }}</div>
            @endif
            <label for="route" class="form-label">النطاق:</label>
            <div class="input-group mb-3" dir="ltr">
                <span class="input-group-text">cards.yt.sa/card/</span>
                <input type="text" name="route" id="route" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">تحميل الصورة:</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*" required max="2M">
        </div>
        <div class="mb-3">
            <label for="font" class="form-label">تحميل الخط: (اختياري)</label>
            <input type="file" name="font" id="font" class="form-control" accept=".ttf,.otf">
        </div>
        <div class="row">
            <p>بالامكان الضغط على اي مكان في الصورة لتحديد مكان الاسم</p>
            <div class="col-md-6 mb-3">
                <label for="textX" class="form-label">موضع النص X:</label>
                <input type="text" name="text_x" id="textX" class="form-control" min="0" value="10" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="textY" class="form-label">موضع النص Y:</label>
                <input type="text" name="text_y" id="textY" class="form-control" min="0" value="10" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="fontSize" class="form-label">حجم الخط:</label>
                <input type="number" name="font_size" id="fontSize" class="form-control" min="10" max="100" value="24" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="fontColor" class="form-label">لون الخط:</label>
                <input type="color" name="font_color" id="fontColor" class="form-control" value="#000000" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">إنشاء البطاقة</button>
    </form>

    <h2 class="text-center mt-5">العرض:</h2>
    <canvas id="preview" width="400" height="200" class="mx-auto d-block mt-2"></canvas>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/opentype.js/1.3.0/opentype.min.js"></script>

<script>
    const canvas = document.getElementById('preview');
    const ctx = canvas.getContext('2d');

    let img = new Image();
    let fontUrl = null;

    const defaultFontUrl = '{{asset('fonts/Cairo-VariableFont_slnt,wght.ttf')}}';

    $('#image').on('change', function () {
        const reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
            img.onload = function () {
                draw();
            };
        };
        reader.readAsDataURL(this.files[0]);
    });

    $('#font').on('change', function () {
        if (this.files.length > 0) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const fontBlob = new Blob([new Uint8Array(e.target.result)], { type: 'font/opentype' });
                fontUrl = URL.createObjectURL(fontBlob);
                draw();
            };
            reader.readAsArrayBuffer(this.files[0]);
        } else {
            fontUrl = defaultFontUrl;
            draw();
        }
    });

    $('input[type=number], input[type=color]').on('input', draw);
    // Draw default preview
    img.src = 'https://via.placeholder.com/400x200';

    // Helper function to calculate new image dimensions
    function fitImageOnCanvas(image, maxWidth, maxHeight) {
        const ratio = Math.min(maxWidth / image.width, maxHeight / image.height);
        return { width: image.width * ratio, height: image.height * ratio };
    }

    function draw() {
        if (!img.src) return;
        if (!fontUrl) fontUrl = defaultFontUrl;

        const newDimensions = fitImageOnCanvas(img, window.innerWidth, window.innerHeight);
        const scaleX = newDimensions.width / img.width;
        const scaleY = newDimensions.height / img.height;
        const scale = Math.min(scaleX, scaleY);

        canvas.width = newDimensions.width;
        canvas.height = newDimensions.height;

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

        const text = 'يزيد فهد الطويل';
        const fontSize = parseInt($('#fontSize').val(), 10) * scale;
        const fontColor = $('#fontColor').val();
        const textX = parseInt($('#textX').val(), 10) * scaleX;
        const textY = parseInt($('#textY').val(), 10) * scaleY;

        const fontFace = new FontFace("customFont", `url(${fontUrl})`);

        fontFace.load().then((loadedFont) => {
            document.fonts.add(loadedFont);
            ctx.font = `${fontSize}px customFont`;
            ctx.fillStyle = fontColor;
            ctx.textAlign = 'center';
            ctx.fillText(text, textX, textY);
        });
    }

    function updateMousePosition(e) {
        const canvasBounds = canvas.getBoundingClientRect();
        const scaleX = img.width / canvasBounds.width;
        const scaleY = img.height / canvasBounds.height;
        const x = (e.clientX - canvasBounds.left) * scaleX;
        const y = (e.clientY - canvasBounds.top) * scaleY;

        $('#textX').val(x.toFixed(2)); // round to 2 decimal places
        $('#textY').val(y.toFixed(2)); // round to 2 decimal places
        draw();
    }

    function updateTouchPosition(e) {
        const canvasBounds = canvas.getBoundingClientRect();
        const scaleX = img.width / canvasBounds.width;
        const scaleY = img.height / canvasBounds.height;
        const x = (e.touches[0].clientX - canvasBounds.left) * scaleX;
        const y = (e.touches[0].clientY - canvasBounds.top) * scaleY;

        $('#textX').val(x.toFixed(2)); // round to 2 decimal places
        $('#textY').val(y.toFixed(2)); // round to 2 decimal places
        draw();
    }




    let isDragging = false;

    canvas.addEventListener('mousedown', function (e) {
        isDragging = true;
        updateMousePosition(e);
    });

    canvas.addEventListener('mousemove', function (e) {
        if (isDragging) {
            updateMousePosition(e);
        }
    });

    canvas.addEventListener('mouseup', function () {
        isDragging = false;
    });

    canvas.addEventListener('mouseout', function () {
        isDragging = false;
    });
    canvas.addEventListener('touchstart', function (e) {
        e.preventDefault();
        isDragging = true;
        updateTouchPosition(e);
    });

    canvas.addEventListener('touchmove', function (e) {
        e.preventDefault();
        if (isDragging) {
            updateTouchPosition(e);
        }
    });

    canvas.addEventListener('touchend', function () {
        isDragging = false;
    });
    draw();
</script>
</body>
</html>
