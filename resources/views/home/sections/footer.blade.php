@include('home.styles.footer')

<footer id="moemen-footer" class="moemen-footer">
    <div class="footer-bottom-bar">
        <canvas id="footer-bubbles-canvas"></canvas>

        <div class="footer-glow-effect"></div>

        <p class="copyright-text">
            &copy; <span id="footer-year"></span>
            <span data-ar="جميع الحقوق محفوظة لمنصة البرلسي" data-en="All rights reserved for Al-Burullusy Platform">جميع
                الحقوق محفوظة لمنصة البرلسي</span>
            |
            <span data-ar="صنع بشغف بوساطة" data-en="Crafted by">صنع بوساطة</span>
            <a href="https://moemen-team.tech/" target="_blank" class="team-inline-link">Moemen Team</a>
        </p>
    </div>
</footer>

@include('home.scripts.footer')
