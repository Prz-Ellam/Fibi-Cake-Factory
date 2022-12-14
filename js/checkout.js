import { getSession } from './utils/session.js';
const id = getSession();

var fmt = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
});

let checkoutTotal = 0;
$.ajax({
    url: `api/v1/shopping-cart`,
    method: 'GET',
    async: false,
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
        checkoutTotal = total;
    }
});

$(document).ready(function() {

    paypal.Button.render({
        env: 'sandbox',
        client: {
            sandbox: 'AYRWL7VDLGBBSSSutwgu3nPO8ZDZKNGCiON9pO_X-dGx3lgkWMLL2xlQjDycSG5qA3bh4IRsjMMgHunl'
        },
        payment: function (data, actions) {
            return actions.payment.create({
                transactions: [{
                    amount: {
                        total: checkoutTotal,
                        currency: 'MXN'
                    }
                }]
            });
        },
        onAuthorize: function (data, actions) {
            return actions.payment.execute()
                    .then(function() {
                        $('#msform').submit();
                        //window.location = "<?php echo PayPalBaseUrl ?>orderDetails.php?paymentID="+data.paymentID+"&payerID="+data.payerID+"&token="+data.paymentToken+"&pid=<?php echo $productId; ?>";
                    });
        }
    }, '#paypal-section');

    $.validator.addMethod('email5322', function(value, element) {
        return this.optional(element) || /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/.test(value);
    }, 'Please enter a valid email');

    $.validator.addMethod('regex', function (value, element, parameter) {
        var regexp = new RegExp(parameter);
        return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $('#msform').validate({
        rules: {
            'names': {
                required: true,
                maxlength: 50
            },
            'last-name': {
                required: true,
                maxlength: 50
            },
            'street-address': {
                required: true,
                maxlength: 100
            },
            'city': {
                required: true,
                maxlength: 30
            },
            'state': {
                required: true,
                maxlength: 30
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
            'flexRadioDefault': {
                required: true
            },
            'card-number': {
                required: true,
                number: true
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
                required: true,
                regex: /^[0-9]{3,4}$/
            }
        },
        messages: {
            'names': {
                required: 'El nombre no puede estar vac??o.'
            },
            'last-name': {
                required: 'El apellido no puede estar vac??o.'
            },
            'street-address': {
                required: 'La calle y el n??mero no puede estar vac??o',
                maxlength: 'La calle y el n??mero es demasiado largo'
            },
            'city': {
                required: 'La ciudad no puede estar vac??o'
            },
            'state': {
                required: 'El estado no puede estar vac??o'
            },
            'postal-code': {
                required: 'El c??digo postal no puede estar vac??o',
                number: 'El c??digo postal que ingres?? no es v??lido'
            },
            'email': {
                required: 'El correo electr??nico no puede estar vac??o',
                email5322: 'El correo electr??nico que ingres?? no es v??lido.'
            },
            'phone': {
                required: 'El tel??fono no puede estar vac??o',
                number: 'El tel??fono solo puede tener n??meros',
                phoneUS: 'El tel??fono no es v??lido'
            },
            'card-number': {
                required: 'El n??mero de tarjeta no puede estar vac??o'
            },
            'exp-year': {
                required: 'La expiraci??n no puede estar vac??o',
                number: 'La expiraci??n no es v??lida'
            },
            'exp-month': {
                required: 'La expiraci??n no puede estar vac??o',
                number: 'La expiraci??n no es v??lida'
            },
            'cvv': {
                required: 'El c??digo de seguridad no puede estar vac??o'
            }
        },
        errorElement: 'small',
        errorPlacement: function(error, element) {

            if ($(element)[0].name === 'exp-year' )
            {
                $('#errors-exp').append(error).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
                return;
            }

            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        },
    });

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;

    $(".next").click(function() {

        let validations = $('#msform').valid();

        if (!validations) {
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

        let validations = $('#msform').valid();
        if (!validations) {
            return;
        }

        $.ajax({
            url: '/api/v1/checkout',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    title: '??Gracias por su compra!',
                    text: '??Que tenga un bonito d??a! ???',
                    icon: 'success',
                    html:
                    '<h4>??Qu?? tenga un bonito d??a! <i class="fas fa-smile"></i><h4>',
                    confirmButtonText : 'Ok',
                    //confirmButtonClassName: 'no-border',
                    confirmButtonColor: '#FF5E1F',
                    showCloseButton: true
                }).then(function() {
                    window.location.href = '/home';
                });
            }
        });

    });

    $('#radio-card').click(function() {
        $('#card-section').removeClass('d-none');
        $('#paypal-section').addClass('d-none');
    });

    $('#radio-paypal').click(function() {
        $('#card-section').addClass('d-none');
        $('#paypal-section').removeClass('d-none');
    });

});