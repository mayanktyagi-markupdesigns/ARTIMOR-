
(function($) {
  "use strict";
 
  //product value set
   $('input[type="number"]').on('input', function() {
        var value = parseInt($(this).val(), 10);
        if (value < 0) {
            $(this).val(0);
        }
        if (value > 10) {
            $(this).val(10);
        }
    });

    // for search
    const openSearch = document.getElementById("openSearch");
    const closeSearch = document.getElementById("closeSearch");
    const searchOverlay = document.getElementById("searchOverlay");
    openSearch.onclick = () => {
        searchOverlay.style.display = "flex";
        document.body.classList.add("overflow-hidden");
    };
    closeSearch.onclick = () => {
        searchOverlay.style.display = "none";
        document.body.classList.remove("overflow-hidden");
    };
    window.onclick = (e) => {
        if (e.target === searchOverlay) {
            searchOverlay.style.display = "none";
            document.body.classList.remove("overflow-hidden");
        }
    };


    //year
    var currentYear = new Date().getFullYear();  
    document.getElementById('currentYear').textContent = currentYear;

})(window.jQuery);

