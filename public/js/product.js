$(document).ready(function() {

    $('.sellers').owlCarousel({
        loop: true,
        margin: 10,
        dots: true,
        autoplay: true,
        autoplayTimeout: 10000,
        autoplayHoverPause: true, // Es molesto ver un producto y que el carousel se mueva
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            },
            1200: {
                items: 3
            },
            1400: {
                items: 3
            },
            2000: {
                items: 6
            },
            3000: {
                items: 7
            },
            4000: {
                items: 8
            }
        }
    });

    $(".rating-star").click(function() {

        const stars = $(this).parent().children();
    
        //let position = $(this).position();
        let starIndex = parseInt($(this).attr('value'));

        for (let i = 0; i < 5; i++) {
            stars[i].className = 'rating-star far fa-star';
        }
        
        for (let i = starIndex; i > 0; i--) {
            stars[i - 1].className = 'rating-star fas fa-star';
        }
        
    });
    
    
    $(".zoom").ezPlus({
        zoomType: 'inner',
        cursor: 'crosshair',
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 500,
        lensFadeIn: 500,
        lensFadeOut: 500
    }/*{
        zoomType: "inner",
        zoomLevel: 2,
        cursor: "crosshair",
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 500,
        lensFadeIn: 500,
            lensFadeOut: 500
    }*/);

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        showCloseButton: true,
        timer: 1500,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    $('.add-cart').click(function() {
        Toast.fire({
            icon: 'success',
            title: 'Tu producto ha sido añadido al carrito'
        });
    });

    $('#add-cart').click(function() {
        Toast.fire({
            icon: 'success',
            title: 'Tu producto ha sido añadido al carrito'
        });
    });

    $('#add-wishlists').submit(function(event) {
        event.preventDefault();

        modal = document.getElementById('select-wishlist');
        modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

        Toast.fire({
            icon: 'success',
            title: 'Tu producto ha sido añadido a las listas de deseos'
        })
    });

    $('#send-message').click(function() {

        const text = $('#message-box').val();
        $('#message-box').val('');

        if (text === '')
        {
            return;
        }

        const html = /*html*/`
        <div class="d-flex">
            <img src="assets/img/fragile.webp" alt="John Doe" class="me-3 rounded-circle" style="width: 48px; height: 48px;">
            <div class="col-9">
                <a href="/sandbox" class="mt-0 me-1">Eliam Rodríguez Pérez</a>
                <span class="rating">
                    <i class="rating-star far fa-star" value="1"></i>
                    <i class="rating-star far fa-star" value="2"></i>
                    <i class="rating-star far fa-star" value="3"></i>
                    <i class="rating-star far fa-star" value="4"></i>
                    <i class="rating-star far fa-star" value="5"></i>
                </span>
                <p class="mb-0">${text}</p>
                <small>${new Date().toUTCString()}</small><br>
                <span class="badge bg-primary" role="button">Editar</span>
                <span class="badge bg-danger" role="button">Eliminar</span>
            </div>
        </div>
        <hr>`;

        $('#comment-section').prepend(html);


    });

})