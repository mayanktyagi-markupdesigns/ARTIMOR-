<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/front/js/custom.js')}}"></script>
    <script>
    function changeImage(el) {
        document.getElementById("mainImage").src = el.src;
        document.querySelectorAll(".thumb-img").forEach((img) => img.classList.remove("active"));
        el.classList.add("active");
    }

    window.onload = function() {
        const thumbData = [
            "{{ asset('assets/front/img/11.jpg')}}",
            "{{ asset('assets/front/img/12.jpg')}}",
            "{{ asset('assets/front/img/13.jpg')}}",
            "{{ asset('assets/front/img/11.jpg')}}",
        ];

        const thumbsContainer = document.getElementById("thumbCarouselInner");
        const thumbHeight = 88;
        let currentIndex = 0;

        thumbData.forEach((src, index) => {
            const img = document.createElement("img");
            img.src = src;
            img.classList.add("thumb-img");
            img.onclick = () => changeImage(img);
            thumbsContainer.appendChild(img);

            if (index === 0) {
                img.classList.add("active");
                document.getElementById("mainImage").src = src;
            }
        });

        const thumbCarousel = document.getElementById("thumbnailCarousel");
        if (thumbData.length > 0) {
            thumbCarousel.style.display = "flex";
        }

        const upBtn = document.getElementById("thumbUp");
        const downBtn = document.getElementById("thumbDown");

        upBtn.addEventListener("click", function() {
            if (currentIndex > 0) {
                currentIndex--;
                updateScroll();
            }
        });

        downBtn.addEventListener("click", function() {
            const maxIndex = thumbData.length - 4;
            if (currentIndex < maxIndex) {
                currentIndex++;
                updateScroll();
            }
        });

        function updateScroll() {
            thumbsContainer.style.transform = `translateY(-${currentIndex * thumbHeight}px)`;
            upBtn.disabled = currentIndex === 0;
            downBtn.disabled = currentIndex >= thumbData.length - 4;
        }
        updateScroll();
    };
    </script>
</body>

</html>