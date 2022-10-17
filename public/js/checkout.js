import { getSession } from './utils/session.js';

const id = getSession();

$.ajax({
    url: `api/v1/users/${id}`,
    method: "GET",
    async: false,
    timeout: 0,
    success: function(response) {
        const url = `api/v1/images/${response.profilePicture}`;
        $('.nav-link img').attr('src', url);
    }
});

// TODO: Checkout inaccesible si no hay productos en el carrito de compras

var fmt = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
});

$.ajax({
    url: `api/v1/shopping-cart`,
    method: 'GET',
    async: false,
    timeout: 0,
    success: function(response) {
        let total = 0;
        response.forEach(function(shoppingCartItem) 
        {
            $('#shipping').append(/*html*/`
            <div class="d-flex justify-content-between">
                <p>${shoppingCartItem.name}</p>
                <p>${fmt.format(shoppingCartItem.price * shoppingCartItem.quantity)} M.N</p>
            </div>
            `);
            total += shoppingCartItem.price * shoppingCartItem.quantity;
        });
        $('#subtotal').text(`${fmt.format(total)} M.N`);
        $('#total').text(`${fmt.format(total)} M.N`);
    }
});

$(document).ready(function() {

    $.validator.addMethod('email5322', function(value, element) {
        return this.optional(element) || /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/.test(value);
    }, 'Please enter a valid email');

    $('#msform').validate({
        rules: {
            'names': {
                required: true
            },
            'last-name': {
                required: true
            },
            'street-address': {
                required: true
            },
            'city': {
                required: true
            },
            'state': {
                required: true
            },
            'postal-code': {
                required: true,
                number: true
            },
            'email': {
                required: true,
                email: false,
                email5322: true
            },
            'phone': {
                required: true,
                number: true,
                phoneUS: true
            },
            'card-number': {
                required: true
            },
            'exp-year': {
                required: true,
                number: true
            },
            'exp-month': {
                required: true,
                number: true
            },
            'cvv': {
                required: true
            }
        },
        messages: {
            'names': {
                required: 'El nombre no puede estar vacío.'
            },
            'last-name': {
                required: 'El apellido no puede estar vacío.'
            },
            'street-address': {
                required: 'La calle y el número no puede estar vacío'
            },
            'city': {
                required: 'La ciudad no puede estar vacío'
            },
            'state': {
                required: 'El estado no puede estar vacío'
            },
            'postal-code': {
                required: 'El código postal no puede estar vacío',
                number: 'El código postal que ingresó no es válido'
            },
            'email': {
                required: 'El correo electrónico no puede estar vacío',
                email5322: 'El correo electrónico que ingresó no es válido.'
            },
            'phone': {
                required: 'El teléfono no puede estar vacío',
                number: 'El teléfono solo puede tener números',
                phoneUS: 'El teléfono no es válido'
            },
            'card-number': {
                required: 'El número de tarjeta no puede estar vacío'
            },
            'exp-year': {
                required: 'La expiración no puede estar vacío',
                number: 'La expiración no es válida'
            },
            'exp-month': {
                required: 'La expiración no puede estar vacío',
                number: 'La expiración no es válida'
            },
            'cvv': {
                required: 'El código de seguridad no puede estar vacío'
            }
        },
        errorElement: 'small',
        errorPlacement: function(error, element) {

            if ($(element)[0].name === 'exp-year' || $(element)[0].name === 'exp-month')
            {
                $('#errors-exp').append(error).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
                return;
            }

            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        },
    });

    $(".next").click(function() {

        let validations = $('#msform').valid();

        if (validations === false) {
            return;
        }
            
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        
        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        
        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
        step: function(now) {
            // for making fielset appear animation
            opacity = 1 - now;
            
            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });

            next_fs.css({'opacity': opacity});
            },
            duration: 600
        });

        window.scrollTo({ top: 0, behavior: 'smooth' })

    });

    $(".previous").click(function() {
        
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        
        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        
        //show the previous fieldset
        previous_fs.show();
        
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
                
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                
                previous_fs.css({'opacity': opacity});
            },
            duration: 600
        });

        window.scrollTo({ top: 0, behavior: 'smooth' })
    });

    $('#msform').submit(function(event) {

        event.preventDefault();

        console.log([...new FormData(this)]);

        console.log('Enviando el msform');

        $.ajax({
            url: '/api/v1/checkout',
            method: 'POST',
            timeout: 0,
            data: $(this).serialize(),
            success: function(response) {
                console.log(response);

                Swal.fire({
                    title: '¡Gracias por su compra!',
                    text: '¡Que tenga un bonito día! ',
                    icon: 'success',
                    html:
                    '<h4>¡Qué tenga un bonito día! <i class="fas fa-smile"></i><h4>',
                    confirmButtonText : 'Ok',
                    //confirmButtonClassName: 'no-border',
                    confirmButtonColor: '#FF5E1F',
                    showCloseButton: true
                });

            }
        });

    });

    $('#radio-card').click(function() {
        $('#card-section').removeClass('d-none');
        $('#paypal-section button').addClass('d-none');
    });

    $('#radio-paypal').click(function() {
        $('#card-section').addClass('d-none');
        $('#paypal-section button').removeClass('d-none');
    });

});