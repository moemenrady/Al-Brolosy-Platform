<!-- section: Media Center -->
@include('home.styles.media-section')

<section class="media-section" id="media-center">
    <div class="media-container">
        <!-- Header -->
        <div class="section-header">
            <h2 class="section-title" data-en="Media Center" data-ar="المركز الإعلامي">Media Center</h2>
            <p class="section-subtitle" data-en="Latest news, events, and press releases."
                data-ar="أحدث الأخبار، الفعاليات، والبيانات الصحفية.">
                Latest news, events, and press releases.
            </p>
        </div>

        <!-- Filters (Multi-Select) -->
        <div class="media-filters">
            <button class="filter-btn active" data-filter="all" data-en="All" data-ar="الكل">All</button>

            @foreach ($categories as $category)
                <button class="filter-btn" data-filter="{{ $category->id }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        <!-- Media Grid Area -->
        <div class="media-grid-wrapper">

            <!-- Mini Loader -->
            <div id="media-filter-loader" class="media-loader-overlay" style="display: none;">
                <div class="brand-logo-box spin-90" id="filter-logo">
                    <img src="{{ asset('albrolosy_logo.png') }}" alt="Albrolosy Logo" class="logo-img">
                </div>
            </div>

            <!-- Posts Grid -->
            <div class="media-grid" id="media-grid">
                @foreach ($posts as $post)
                    @php
                        $category = $post->category;
                    @endphp

                    <a href="{{ url('/media/show/' . $post->id) }}" class="media-card"
                        data-category="{{ $post->media_category_id }}">

                        <!-- Image -->
                        <div class="card-image-box">

                            <img src="/images/media/{{ $post->cover_image }}" alt="{{ $post->title }}"
                                class="post-img">

                            <div class="camera-flash"></div>
                            <div class="viewfinder top-left"></div>
                            <div class="viewfinder top-right"></div>
                            <div class="viewfinder bottom-left"></div>
                            <div class="viewfinder bottom-right"></div>

                            <div class="category-badge">
                                {{ $category?->name ?? __('Uncategorized') }}
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="card-content">
                            <div class="post-meta">
                                <span class="post-date">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($post->published_at)->format('d M, Y') }}
                                </span>
                            </div>

                            <h3 class="post-title">
                                {{ $post->title }}
                            </h3>

                            <p class="post-desc">
                                {{ \Illuminate\Support\Str::limit($post->short_description, 100) }}
                            </p>

                            <!-- Read More -->
                            <span class="read-more">
                                <span data-en="Read More" data-ar="اقرأ المزيد">Read More</span>
                                <i class="fa-solid fa-arrow-right-long rtl-flip"></i>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

@include('home.scripts.media-section')
