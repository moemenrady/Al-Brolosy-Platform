<!-- قسم أصحاب الرؤية - Visionaries Section -->
@include('home.styles.visionaries-section')

<section class="visionaries-section" id="about-us">
    <div class="visionaries-container">
        <!-- عنوان القسم -->
        <div class="section-header">
            <h2 class="section-title text-center">
                <span data-en="Visionaries at Albrolosy" data-ar="أصحاب الرؤية في البرلسي">أصحاب الرؤية في البرلسي</span>
            </h2>
            <div class="title-line"></div>
        </div>

        <div class="visionaries-grid">

            <!-- الكرت الأول: م. صلاح البرلسي -->
            <a href="{{ route('founders.salah') }}" class="visionary-card vision-card-link">
                <div class="v-image-wrapper">
                    <img src="{{ \App\Models\PlatformSetting::mediaUrl('founder_salah_image', 'home/salah.png') }}" alt="م. صلاح البرلسي" class="v-img">
                    <div class="v-gradient-overlay"></div>
                </div>

                <div class="v-content">
                    <div class="v-intro">
                        <h3 class="v-name" data-en="Eng. Salah Albrolosy" data-ar="م. صلاح البرلسي">م. صلاح البرلسي</h3>
                        <p class="v-title" data-en="CEO of Albrolosy Company" data-ar="الرئيس التنفيذي لشركة البرلسي">
                            الرئيس التنفيذي لشركة البرلسي</p>
                    </div>

                    <div class="v-details">
                        <div class="v-details-inner">
                            <p data-en="As CEO of Albrolosy Real Estate Development, Eng. Salah possesses a strong engineering background. He began his career in Kuwait, co-founding Damac Gulf, a holding company specialized in general contracting. There, he held pivotal executive roles contributing to major projects alongside local and regional partners. From Kuwait, his expansive vision launched to establish an integrated real estate entity in Egypt, aligning with the region's urban ambitions."
                                data-ar="الرئيس التنفيذي لشركة البرلسي للتطوير العقاري، يمتلك م/صلاح خلفية هندسية قوية. بدأ مسيرته في دولة الكويت، حيث كان من المؤسسين لشركة دماك الخليجية، الشركة القابضة المتخصصة في المقاولات العامة، وهناك تولّى أدوارًا تنفيذية محورية ساهمت في بناء وتنفيذ مشاريع كبرى بالتعاون مع شركاء محليين وإقليميين. ومن الكويت، انطلقت رؤيته التوسعية لتأسيس كيان عقاري متكامل في مصر، يواكب الطموحات العمرانية للمنطقة.">
                                الرئيس التنفيذي لشركة البرلسي للتطوير العقاري، يمتلك م/صلاح خلفية هندسية قوية. بدأ
                                مسيرته في دولة الكويت، حيث كان من المؤسسين لشركة دماك الخليجية، الشركة القابضة المتخصصة
                                في المقاولات العامة، وهناك تولّى أدوارًا تنفيذية محورية ساهمت في بناء وتنفيذ مشاريع كبرى
                                بالتعاون مع شركاء محليين وإقليميين. ومن الكويت، انطلقت رؤيته التوسعية لتأسيس كيان عقاري
                                متكامل في مصر، يواكب الطموحات العمرانية للمنطقة.
                            </p>
                            <p data-en="As a board member of the Real Estate Development Division at the Chamber of Commerce, Head of the Investment Secretariat for the Mostaqbal Watan Party in Damietta, and CEO of Albrolosy, Eng. Salah leads a growth strategy based on developing integrated urban communities and forging partnerships rooted in efficiency and quality commitment. He is distinguished by his decisive leadership and practical approach, aiming to enhance the investment value of projects and make a tangible impact on the urban environment."
                                data-ar="بصفته عضو مجلس إدارة شعبة التطوير العقاري بالغرفة التجارية، و رئيس أمانة الاستثمار بحزب مستقبل وطن بدمياط، والرئيس التنفيذي لشركة البرلسي، يقود م.صلاح البرلسي استراتيجية النمو القائمة على تطوير مجتمعات عمرانية متكاملة، وإبرام شراكات قائمة على الكفاءة والالتزام بالجودة. يتميز بقيادته الحازمة ونهجه العملي، إلى جانب حرصه على تعزيز القيمة الاستثمارية للمشاريع وتحقيق أثر ملموس في البيئة العمرانية.">
                                بصفته عضو مجلس إدارة شعبة التطوير العقاري بالغرفة التجارية، و رئيس أمانة الاستثمار بحزب
                                مستقبل وطن بدمياط، والرئيس التنفيذي لشركة البرلسي، يقود م.صلاح البرلسي استراتيجية النمو
                                القائمة على تطوير مجتمعات عمرانية متكاملة، وإبرام شراكات قائمة على الكفاءة والالتزام
                                بالجودة. يتميز بقيادته الحازمة ونهجه العملي، إلى جانب حرصه على تعزيز القيمة الاستثمارية
                                للمشاريع وتحقيق أثر ملموس في البيئة العمرانية.
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- الكرت الثاني: م. غانم البرلسي -->
            <a href="{{ route('founders.ghanem') }}" class="visionary-card vision-card-link">
                <div class="v-image-wrapper">
                    <img src="{{ \App\Models\PlatformSetting::mediaUrl('founder_ghanem_image', 'home/ghanem.png') }}" alt="م. غانم البرلسي" class="v-img">
                    <div class="v-gradient-overlay"></div>
                </div>

                <div class="v-content">
                    <div class="v-intro">
                        <h3 class="v-name" data-en="Eng. Ghanem Albrolosy" data-ar="م. غانم البرلسي">م. غانم البرلسي
                        </h3>
                        <p class="v-title" data-en="Chairman of Albrolosy Company"
                            data-ar="رئيس مجلس إدارة شركة البرلسي">رئيس مجلس إدارة شركة البرلسي</p>
                    </div>

                    <div class="v-details">
                        <div class="v-details-inner">
                            <p data-en="Ghanem Kamal Hamed Albrolosy, Chairman of Albrolosy, brings extensive experience in corporate management, strategic planning, and business development across multiple sectors in various countries. He possesses a proven track record of establishing and managing successful companies, distinguished by his deep expertise in project management, market analysis, and creating sustainable investment solutions."
                                data-ar="غانم كمال حامد البرلسي، رئيس مجلس إدارة شركة البرلسي مع خبرة واسعة في إدارة الشركات، والتخطيط الاستراتيجي، وتطوير الأعمال عبر قطاعات متعددة في دول مختلفة. يمتلك سجلًا حافلًا في تأسيس وإدارة شركات ناجحة، ويتميز بخبراته العميقة في إدارة المشاريع، وتحليل الأسواق، وابتكار حلول استثمارية مستدامة.">
                                غانم كمال حامد البرلسي، رئيس مجلس إدارة شركة البرلسي مع خبرة واسعة في إدارة الشركات،
                                والتخطيط الاستراتيجي، وتطوير الأعمال عبر قطاعات متعددة في دول مختلفة. يمتلك سجلًا حافلًا
                                في تأسيس وإدارة شركات ناجحة، ويتميز بخبراته العميقة في إدارة المشاريع، وتحليل الأسواق،
                                وابتكار حلول استثمارية مستدامة.
                            </p>
                            <p data-en="He holds a Bachelor's degree in Engineering from the Faculty of Engineering - Mansoura University (2006), with an academic specialization in Electrical Machines and Renewable Energy Projects. He is a member of the Chamber of Commerce (Real Estate Division in Damietta), the Egyptian Syndicate of Engineers, and the Kuwait Society of Engineers."
                                data-ar="حاصل على بكالوريوس الهندسة من كلية الهندسة - جامعة المنصورة عام ٢٠٠٦، بتخصص أكاديمي في الآلات الكهربائية ومشاريع الطاقة المتجددة. يشغل عضوية كل من غرفة التجارة، الشعبة العقارية بدمياط، ونقابة المهندسين في مصر، وجمعية المهندسين في الكويت.">
                                حاصل على بكالوريوس الهندسة من كلية الهندسة - جامعة المنصورة عام ٢٠٠٦، بتخصص أكاديمي في
                                الآلات الكهربائية ومشاريع الطاقة المتجددة. يشغل عضوية كل من غرفة التجارة، الشعبة
                                العقارية بدمياط، ونقابة المهندسين في مصر، وجمعية المهندسين في الكويت.
                            </p>
                        </div>
                    </div>
                </div>
            </a>

        </div>
    </div>
</section>
<section class="company-legacy-section" id="albrolosy-company">

    <!-- خلفية الفيديو مع الدارك فيلتر الفخم -->
    <div class="video-bg-wrapper">
        <video autoplay loop muted playsinline class="legacy-video">
            <source src="{{ \App\Models\PlatformSetting::mediaUrl('legacy_video', 'videos/d_hero3.mp4') }}" type="video/mp4">
        </video>
        <div class="video-dark-filter"></div>
    </div>

    <!-- محتوى القسم -->
    <div class="legacy-content-container">

        <!-- الترويسة -->
        <div class="legacy-header">
            <h2 class="legacy-title" data-en="Al-Brolosy Real Estate Development"
                data-ar="شركة البرلسي للتطوير العقاري">
                شركة البرلسي للتطوير العقاري
            </h2>
            <p class="legacy-subtitle"
                data-en="An integrated network of leading companies and profound strategic partnerships spanning over 18 years across the Middle East."
                data-ar="شبكة متكاملة من الشركات الرائدة والشراكات الاستراتيجية العميقة التي تمتد لأكثر من ١٨ عاماً عبر الشرق الأوسط.">
                شبكة متكاملة من الشركات الرائدة والشراكات الاستراتيجية العميقة التي تمتد لأكثر من ١٨ عاماً عبر الشرق
                الأوسط.
            </p>
            <div class="legacy-line"></div>
        </div>

        <!-- كروت التاريخ والفلسفة -->
        <div class="legacy-grid">

            <!-- كارت التاريخ والتأسيس -->
            <div class="legacy-card">
                <h3 class="legacy-card-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                    <span data-en="History & Establishment" data-ar="تاريخ وتأسيس الكيان">تاريخ وتأسيس الكيان</span>
                </h3>
                <p class="legacy-card-text"
                    data-en="Al-Brolosy was established as an integrated real estate entity in Egypt, born from a strategic expansion vision that originated in Kuwait. Through foundational roles in major holding companies like 'Damac Gulf', the company leverages vast regional expertise in contracting, infrastructure, and urban community development to meet modern ambitions."
                    data-ar="تأسست شركة البرلسي ككيان عقاري متكامل في مصر، لتكون امتداداً لرؤية استراتيجية توسعية انطلقت من دولة الكويت. من خلال أدوار محورية في شركات قابضة كبرى مثل 'دماك الخليجية'، تعتمد الشركة على خبرات إقليمية واسعة في المقاولات، البنية التحتية، وتطوير المجتمعات العمرانية لتلبية الطموحات الحديثة.">
                    تأسست شركة البرلسي ككيان عقاري متكامل في مصر، لتكون امتداداً لرؤية استراتيجية توسعية انطلقت من دولة
                    الكويت. من خلال أدوار محورية في شركات قابضة كبرى مثل 'دماك الخليجية'، تعتمد الشركة على خبرات إقليمية
                    واسعة في المقاولات، البنية التحتية، وتطوير المجتمعات العمرانية لتلبية الطموحات الحديثة.
                </p>
            </div>

            <!-- كارت الفلسفة والرؤية -->
            <div class="legacy-card">
                <h3 class="legacy-card-title">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 12h4l3-9 5 18 3-9h5" />
                    </svg>
                    <span data-en="Our Vision & Philosophy" data-ar="رؤيتنا وفلسفتنا">رؤيتنا وفلسفتنا</span>
                </h3>
                <p class="legacy-card-text"
                    data-en="We believe that success is built with science and hard work. Operating under the motto 'One Family.. One Success', we consider human capital our truest investment. Our growth strategy focuses on forging reliable partnerships, committing to operational quality, and cultivating cohesive teams capable of strategic innovation and sustainable development."
                    data-ar="نؤمن بأن النجاح يُبنى بالعلم والعمل. وتحت شعار 'أسرة واحدة .. نجاح واحد'، نعتبر أن الاستثمار الحقيقي يبدأ من الإنسان. ترتكز استراتيجيتنا على إبرام شراكات موثوقة، الالتزام بالجودة التشغيلية، وبناء فرق متماسكة قادرة على الابتكار الاستراتيجي لتحقيق نمو مستدام.">
                    نؤمن بأن النجاح يُبنى بالعلم والعمل. وتحت شعار 'أسرة واحدة .. نجاح واحد'، نعتبر أن الاستثمار الحقيقي
                    يبدأ من الإنسان. ترتكز استراتيجيتنا على إبرام شراكات موثوقة، الالتزام بالجودة التشغيلية، وبناء فرق
                    متماسكة قادرة على الابتكار الاستراتيجي لتحقيق نمو مستدام.
                </p>
            </div>

        </div>

        <!-- قسم الشراكات والشركات المملوكة -->
        <div class="partnerships-wrapper">
            <h3 class="partnerships-title" data-en="Strategic Partnerships & Global Network"
                data-ar="شراكاتنا الاستراتيجية والشبكة الإقليمية">
                شراكاتنا الاستراتيجية والشبكة الإقليمية
            </h3>

            <div class="partners-grid">

                <!-- الشركة 1 -->
                <div class="partner-item">
                    <div class="partner-name" data-en="Damac Gulf" data-ar="دماك الخليجية">دماك الخليجية</div>
                    <div class="partner-desc" data-en="Kuwait | Contracting & Infrastructure"
                        data-ar="الكويت | مقاولات وبنية تحتية">الكويت | مقاولات وبنية تحتية</div>
                </div>

                <!-- الشركة 2 -->
                <div class="partner-item">
                    <div class="partner-name" data-en="Al-Ghanim Integrated" data-ar="الغانم المتكاملة">الغانم
                        المتكاملة</div>
                    <div class="partner-desc" data-en="Oman | Trade & Development"
                        data-ar="سلطنة عُمان | التجارة والتطوير">سلطنة عُمان | التجارة والتطوير</div>
                </div>

                <!-- الشركة 3 -->
                <div class="partner-item">
                    <div class="partner-name" data-en="Makased" data-ar="مقاصد">مقاصد</div>
                    <div class="partner-desc" data-en="UAE (Dubai) | Technological Trade"
                        data-ar="الإمارات (دبي) | التجارة التكنولوجية">الإمارات (دبي) | التجارة التكنولوجية</div>
                </div>

                <!-- الشركة 4 -->
                <div class="partner-item">
                    <div class="partner-name" data-en="Pro Damac" data-ar="برو دماك">برو دماك</div>
                    <div class="partner-desc" data-en="Kuwait / Cyprus | International Trade"
                        data-ar="الكويت / قبرص | التجارة الدولية">الكويت / قبرص | التجارة الدولية</div>
                </div>

                <!-- الشركة 5 -->
                <div class="partner-item">
                    <div class="partner-name" data-en="Al-Ghanim International" data-ar="الغانم الدولية">الغانم
                        الدولية</div>
                    <div class="partner-desc" data-en="China | General Trade & Manufacturing"
                        data-ar="الصين | التجارة العامة والتصنيع">الصين | التجارة العامة والتصنيع</div>
                </div>

                <!-- الشركة 6 -->
                <div class="partner-item">
                    <div class="partner-name" data-en="Tech Entities (AGI, G-Tech, MAK-Tec)"
                        data-ar="الكيانات التقنية (AGI, G-Tech, MAK-Tec)">الكيانات التقنية (AGI, G-Tech, MAK-Tec)</div>
                    <div class="partner-desc" data-en="Kuwait | Advanced Tech Solutions"
                        data-ar="الكويت | الحلول التقنية المتقدمة">الكويت | الحلول التقنية المتقدمة</div>
                </div>

            </div>
        </div>

    </div>
</section>
