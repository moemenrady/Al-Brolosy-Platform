@include('home.styles.join-team')
<section id="join-team" class="join-team-section">
    <div class="team-carousel-container">
        <div class="team-slider" id="team-slider">
            @if($teamImages && $teamImages->count() > 0)
                @foreach($teamImages as $index => $image)
                    <div class="team-slide {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Team Image {{ $index }}" class="team-slide-img">
                    </div>
                @endforeach
            @else
                <div class="team-slide active">
                    <img src="{{ asset('home/default-team.jpg') }}" alt="Default Team" class="team-slide-img">
                </div>
            @endif
        </div>

        <div class="team-dark-overlay"></div>

        <div class="team-content-wrapper">
            <div class="team-text-content">
                <h2 class="team-title" data-en="Join Our Team" data-ar="انضم إلى فريقنا">انضم إلى فريقنا</h2>
                <p class="team-description" 
                   data-en="Be part of a motivated community striving to shape the future of real estate in the region. We offer a work environment that encourages innovation and professional development, where opportunities are available for everyone to play an effective role in projects that make a real difference." 
                   data-ar="كن جزءًا من مجتمع متحفز يسعى لتشكيل مستقبل العقارات في المنطقة، نحن نقدم بيئة عمل تشجع على الابتكار والتطوير المهني، حيث تتاح الفرص لكل فرد ليكون له دور فعّال في مشاريع تحدث فرقًا حقيقيًا.">
                   كن جزءًا من مجتمع متحفز يسعى لتشكيل مستقبل العقارات في المنطقة، نحن نقدم بيئة عمل تشجع على الابتكار والتطوير المهني، حيث تتاح الفرص لكل فرد ليكون له دور فعّال في مشاريع تحدث فرقًا حقيقيًا.
                </p>
                
                <div class="team-action">
                    <a href="{{ route('jobs.index') ?? '#' }}" class="btn-browse-jobs">
                        <span data-en="Browse Available Jobs" data-ar="تصفح الوظائف المتاحة">تصفح الوظائف المتاحة</span>
                    </a>
                </div>
            </div>

            @if($teamImages && $teamImages->count() > 1)
                <div class="team-slider-dots">
                    @foreach($teamImages as $index => $image)
                        <button class="team-dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}" aria-label="Go to slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
@include('home.scripts.join-team')
