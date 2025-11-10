<footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <a href="/">
                        <img src="{{ asset('assets/front/img/flogo.png') }}" alt="" width="120" />
                    </a>
                    <p class="mt-5">{{ get_setting('footer text', '') }}</p>
                    <div class="social-links">
                        <a href="{{ get_setting('facebook', '') }}" target="_blank" class="mr-3">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="{{ get_setting('instagram', '') }}" target="_blank" class="mr-3">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="{{ get_setting('pinterest', '') }}" target="_blank" class="mr-3">
                            <i class="fab fa-pinterest-p"></i>
                        </a>
                        <a href="{{ get_setting('linkedin', '') }}" target="_blank" class="mr-3">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4 class="fw-bold mb-5">
                        Contact Tongeren
                        <span></span>
                    </h4>
                    <p>
                        Artimar Tongeren Luikersteenweg<br />
                        2183700 Tongeren
                    </p>
                    <p><i class="fa-solid fa-phone me-2"></i> <a href="{{ get_setting('phone', '') }}">{{ get_setting('phone', '') }}</a></p>
                    <p><i class="fa-solid fa-envelope me-2"></i><a href="{{ get_setting('mail', '') }}">{{ get_setting('mail', '') }}</a></p>
                </div>
                <div class="col-md-4">
                    <h4 class="fw-bold mb-5">
                        Opening Hours Showroom
                        <span></span>
                    </h4>
                    <p>Monday: {{ get_setting('opening-hours-monday', '') }}</p>
                    <p>Tuesday: {{ get_setting('opening-hours-tuesday', '') }}</p>
                    <p>Wednesday: {{ get_setting('opening-hours-wednesday', '') }}</p>
                    <p>Thursday: {{ get_setting('opening-hours-thrusday', '') }}</p>
                    <p>Friday: {{ get_setting('opening-hours-friday', '') }}</p>
                    <p>Saturday: {{ get_setting('opening-hours-saturday', '') }}</p>
                    <p>Sunday: {{ get_setting('opening-hours-sunday', '') }}</p>                   
                </div>
            </div>
        </div>
        <div class="footer-btm">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="copyright">
                    © <span id="currentYear"></span> Artimar Nv. All Rights Reserved.
                </div>
                <div class="footer-links">
                    <a href="#" class="small mx-2 text-decoration-none">Allgemeine Bedingungen</a>
                    <a href="#" class="mx-2 text-decoration-none small">Allgemeine Bedingungen Und Konditionen GDPR</a>
                    <a href="#" class="mx-2 text-decoration-none small">BE 0454.405.210</a>
                </div>
            </div>
        </div>
    </footer>