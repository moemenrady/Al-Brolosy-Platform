@extends('layouts.app')

@section('title', 'Find Closest Scarves')
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        /* ===== 🎨 مركز عجلة الألوان وظهورها بشكل جميل ===== */
        #color-picker-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            width: 260px;
            height: 260px;
        }

        @media (max-width: 500px) {
            #color-picker-container {
                width: 200px;
                height: 200px;
            }
        }

        /* ===== كروت المنتجات بالظبط زي كروت صفحة الـ Collection ===== */
        #results {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 40px 20px;
            width: 100%;
        }

        @media (min-width: 600px) {
            #results {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 992px) {
            #results {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .product-card {
            display: flex;
            flex-direction: column;
            position: relative;
            text-align: right;
        }

        .product-image-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            height: 400px;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.3s ease;
        }

        /* اسم */
        .product-name {
            color: var(--text-color);
            font-size: 1.1rem;
            margin: 8px 0 5px;
        }

        /* السعر */
        .product-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--text-color);
            margin-top: 5px;
        }

        /* تأثير الأنيميشن للكروت */
        .fade-slide {
            opacity: 0;
            transform: translateY(20px);
            animation: fade-in-slide 0.5s ease-out forwards;
        }

        @keyframes fade-in-slide {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #color-name {
            flex: 1;
            margin-left: 12px;
            font-weight: 500;
            color: #333;
        }

        #color-selector {
            width: 100%;
            max-width: 600px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 12px;
            cursor: pointer;
            background-color: #7297c1;
            color: #fff;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid #ccc;
        }

        #color-selector:hover {
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.15);
        }

        #color-wheel-container {
            display: none;
            margin-top: 12px;
            justify-content: center;
        }

        .predefined-colors {
            display: flex;
            gap: 10px;
            margin-top: 12px;
            justify-content: center;
        }

        .predefined-colors div {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            cursor: pointer;
            border: 1px solid #aaa;
            transition: transform 0.15s;
        }

        .predefined-colors div:hover {
            transform: scale(1.2);
        }


        #results {
            display: grid;
            gap: 40px 20px;
            width: 100%;
        }

        /* موبايل */
        @media (max-width: 600px) {
            #results {
                grid-template-columns: 1fr;
            }
        }

        /* تابلت */
        @media (min-width: 601px) and (max-width: 992px) {
            #results {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* ديسكتوب */
        @media (min-width: 993px) {
            #results {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        #color-selector {
            width: 100%;
            max-width: 600px;
        }

        .btn-action {
            max-width: 600px;
        }
    </style>
@endsection



@section('content')
    <div class="container d-flex flex-column align-items-center py-5">

        <h2 class="mb-4 fw-bold text-primary">Find Closest Scarves by Color</h2>

        <!-- Color Selector Button -->
        <div id="color-selector">Choose a color</div>

        <!-- Predefined Colors -->
        <div class="predefined-colors">
            <div style="background-color:#ff0000" data-color="#ff0000"></div>
            <div style="background-color:#00ff00" data-color="#00ff00"></div>
            <div style="background-color:#0000ff" data-color="#0000ff"></div>
            <div style="background-color:#ffff00" data-color="#ffff00"></div>
            <div style="background-color:#800080" data-color="#800080"></div>
            <div style="background-color:#000000" data-color="#000000"></div>
        </div>

        <!-- Color Picker Wheel -->
        <div id="color-wheel-container" style="display:none; justify-content:center;">
            <div id="color-picker-container"></div>
        </div>

        <!-- Show Results Button -->
        <button id="showScarves" class="btn-action btn-add mt-4">
            Show Results
        </button>

        <!-- Results -->
        <div id="results" class="mt-4 w-100"></div>

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        let selectedColor = '#ffffff';
        const resultsContainer = document.getElementById('results');

        // Create Pickr
        const pickr = Pickr.create({
            el: '#color-picker-container',
            theme: 'classic',
            components: {
                preview: true,
                opacity: false,
                hue: true,
                interaction: {
                    hex: true,
                    input: true
                }
            }
        });

        // When color changes
        pickr.on('change', (color) => {
            selectedColor = color.toHEXA().toString().substring(0, 7);

            const selector = document.getElementById('color-selector');
            selector.style.backgroundColor = selectedColor;

            const rgb = color.toRGBA();
            const brightness = (rgb[0] * 299 + rgb[1] * 587 + rgb[2] * 114) / 1000;
            selector.style.color = brightness < 128 ? '#fff' : '#000';
        });

        // Toggle Color Wheel
        document.getElementById('color-selector').addEventListener('click', () => {
            const wheel = document.getElementById('color-wheel-container');
            wheel.style.display = wheel.style.display === 'flex' ? 'none' : 'flex';
            pickr.show();
        });

        // Quick Color Selection
        document.querySelectorAll('.predefined-colors div').forEach(colorEl => {
            colorEl.addEventListener('click', () => {
                selectedColor = colorEl.dataset.color;
                document.getElementById('color-selector').style.backgroundColor = selectedColor;
                pickr.setColor(selectedColor);
            });
        });

        // Show Results Button
        document.getElementById('showScarves').addEventListener('click', () => {

            resultsContainer.innerHTML = `<p class="fw-bold text-primary">Loading...</p>`;

            axios.post("{{ route('color.nearest') }}", {
                    hex: selectedColor,
                    _token: "{{ csrf_token() }}"
                })
                .then(response => {
                    const data = response.data;
                    resultsContainer.innerHTML = '';

                    if (!data || data.length === 0) {
                        resultsContainer.innerHTML = `<p class="text-danger fw-bold">No results found.</p>`;
                        return;
                    }

                    data.forEach(scarf => {
                        const card = document.createElement('div');
                        card.className = 'fade-slide';

                        card.innerHTML = `
                <div class="product-card">
                    <a href="/product/${scarf.id}" class="product-link">
                        <div class="product-image-wrapper">
                            <img src="${scarf.image_url}" class="product-image">
                        </div>

                        <div class="product-details">
                            <h2 class="product-name">${scarf.name}</h2>
                            <div class="product-price">
                                Color: ${scarf.color_name}
                            </div>
                        </div>
                    </a>

                    <button class="choose-options-btn">
                        Choose options
                    </button>
                </div>
                `;

                        resultsContainer.appendChild(card);
                    });
                })
                .catch(error => {
                    console.error(error);
                    resultsContainer.innerHTML = `<p class="text-danger fw-bold">Something went wrong.</p>`;
                });
        });
    </script>
@endsection
