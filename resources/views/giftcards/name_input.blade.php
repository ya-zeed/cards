<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بطاقة معايدة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        @font-face {
            font-family: 'MyCustomFont';
            src: url('{{asset('fonts/Cairo-VariableFont_slnt,wght.ttf')}}');
        }

        body {
            background-color: #f8f9fa;
            /*background-image: url('https://source.unsplash.com/1600x900/?pattern');*/
            background-size: cover;
            background-position: center;
            font-family: 'MyCustomFont', sans-serif;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.85);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .thumbnail.selected {
            border: 2px solid #007bff;
        }
        .thumbnail img, .thumbnail canvas {
            max-width: 100%;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="float-start">
        <button class="btn btn-success" id="share-btn"><i class="fab fa-whatsapp"></i></button>
    </div>
    <h1 class="mb-4">ادخل اسمك</h1>
    <form id="name-form">
        <div class="form-group">
            <input type="text" class="form-control" id="name" placeholder="يزيد الطويل">
        </div>
        <div class="form-group mt-2">
            <label for="images">اختر صورة:</label>
            <div id="images" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 gx-3 gy-3">
                @foreach ($images as $index => $image)
                    <div class="col">
                        <div class="thumbnail mx-2{{ $index === 0 ? ' selected' : '' }}" data-index="{{$index}}">
                            <img src="{{ asset('storage/'.$image->image_path) }}" alt="Thumbnail"
                                 class="img-thumbnail d-none">
                            <canvas id="canvas-{{ $index }}"></canvas>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-2">تنزيل</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function initCanvases(name) {
        const images = {!! json_encode($images) !!};

        images.forEach((image, index) => {
            const canvas = document.getElementById(`canvas-${index}`);
            const ctx = canvas.getContext('2d');
            const img = new Image();

            img.src = '{{ asset("storage/") }}/' + image.image_path;

            const fontSize = image.font_size;
            const fontColor = image.font_color;
            const textX = image.text_x;
            const textY = image.text_y;
            let fontUrl;
            if (image.font_path) {
                fontUrl = '{{ asset("storage/") }}/' + image.font_path;
            } else {
                fontUrl = '{{ asset("fonts/Cairo-VariableFont_slnt,wght.ttf") }}';
            }

            const fontFace = new FontFace(`customFont-${index}`, `url(${fontUrl})`);
            fontFace.load().then((loadedFont) => {
                document.fonts.add(loadedFont);
            });

            img.onload = function () {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                ctx.font = `${fontSize}px customFont-${index}`;
                ctx.fillStyle = fontColor;
                ctx.textAlign = 'center';
                ctx.fillText(name, textX, textY);
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
            ctx.fillStyle = image.font_color;
            ctx.textAlign = 'center';
            ctx.fillText(name, image.text_x, image.text_y);
        };
    }


    $('#images .thumbnail').on('click', function () {
        $('#images .thumbnail').removeClass('selected');
        $(this).addClass('selected');
    });

    $('#name-form').on('submit', function (e) {
        e.preventDefault();

        const name = $('#name').val();
        const selectedIndex = $('.thumbnail.selected').data('index');
        draw(name, selectedIndex);

        const canvas = document.getElementById(`canvas-${selectedIndex}`);
        const link = document.createElement('a');
        console.log(link);
        link.href = canvas.toDataURL();
        link.download = 'card.png';
        link.click();
    });

    $('#name').on('input', function () {
        const name = $(this).val();
        initCanvases(name);
    });

    $('#share-btn').on('click', function () {
        const url = window.location.href;
        const whatsappLink = `whatsapp://send?text=${encodeURIComponent(url)}`;
        window.open(whatsappLink, '_blank');
    });

</script>

</body>
</html>
