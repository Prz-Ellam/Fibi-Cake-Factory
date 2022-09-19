const chatComponent = /*html*/`
<div class="d-flex chat rounded-1 p-1" role="button">
    <img style="width: 64px; height: 64px" class="img-fluid rounded-circle" src="assets/img/elp.jpg">
    <div class="row ms-2 align-self-center" style="white-space: nowrap; width: 75%; text-overflow: ellipsis; overflow: hidden;">
        <span class="fw-bold">Bryan Duarte</span>
        <small>Hola</small>
    </div>
</div>
<hr>
`;

for (let i = 0; i < 8; i++)
{
    $('#chats-container').append(chatComponent);
}

$(document).ready(function() {

    $('#send-message').click(function() {

        let message = $('#message').val();
        
        if ($('#chat-file')[0].files.length !== 0)
        {
            const reader = new FileReader();
            reader.readAsDataURL($('#chat-file')[0].files[0]);

            reader.onloadend = function(e) {
                $('#comment-box').append(`
                <div class="d-flex justify-content-end my-3">
                    <img class="img-fluid rounded-2 overflow-auto w-50" src="${e.target.result}">
                </div>
                `);
                $('#message').val('');
                $('#chat-file').val('');
                $('#comment-box').stop().animate({
                    scrollTop: $('#comment-box')[0].scrollHeight
                }, 800);
            }
        }

        if (message === '') return;
        postMessage(message);

    });

    $('#message').on('keydown', function(e) {
        if(e.keyCode == 13)
        {
            let message = $('#message').val();
            if (message === '') return;
            postMessage(message);
        }
    });

    function postMessage(message)
    {
        $('#comment-box').append(`
            <div class="d-flex justify-content-end my-3">
                <small class="bg-orange text-light p-2 rounded-2 overflow-auto">${message}</small>
            </div>
        `);
        $('#message').val('');
        $('#comment-box').stop().animate({
            scrollTop: $('#comment-box')[0].scrollHeight
        }, 800);
    }

    $('#chat-messages').click(function() {
        const status = $(this).is(':checked');
        if (status)
        {
            $('#chats-container').addClass('d-md-block d-none');
            $('#messages-container').removeClass('d-md-block d-none');
        }
        else
        {
            $('#chats-container').removeClass('d-md-block d-none');
            $('#messages-container').addClass('d-md-block d-none');
        }
    });

    $('.chat').click(function(e) {
        $('#chat-messages').prop('checked', true);
        $('#chats-container').addClass('d-md-block d-none');
        $('#messages-container').removeClass('d-md-block d-none');
    })

});