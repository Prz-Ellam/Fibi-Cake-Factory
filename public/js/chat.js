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
    //$('#chats-container').append(chatComponent);
}

var id;
$.ajax({
    url: 'api/v1/session',
    method: 'GET',
    async: false,
    timeout: 0,
    success: function(response) {
        id = response.id;
        $.ajax({
            url: `api/v1/users/${response.id}`,
            method: "GET",
            async: false,
            timeout: 0,
            success: function(response) {
                const url = `api/v1/images/${response.profilePicture}`;
                $('.nav-link img').attr('src', url);
            }
        });
    }
});

$.ajax({
    url: `/api/v1/users?exclude=${id}`,
    method: 'GET',
    timeout: 0,
    success: function(response) {
        console.log(response);
    }
});

var chatParticipantId = null;
var chatId = null;

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
        if (chatParticipantId !== null && chatId !== null)
        {
            $.ajax({
                url: `/api/v1/chats/${chatId}/messages`,
                method: 'POST',
                data: `chatParticipantId=${chatParticipantId}&messageContent=${message}`,
                timeout: 0,
                success: function(response)
                {
                    console.log(response);
                    $('#comment-box').append(`
                        <div class="d-flex justify-content-end my-3">
                            <small class="bg-orange text-light p-2 rounded-2 overflow-auto">${message}</small>
                        </div>
                    `);
                }
            })
        }
        
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
    });

    var data = ["Boston Celtics", "Chicago Bulls", "Miami Heat", "Orlando Magic", "Atlanta Hawks", "Philadelphia Sixers", "New York Knicks", "Indiana Pacers", "Charlotte Bobcats", "Milwaukee Bucks", "Detroit Pistons", "New Jersey Nets", "Toronto Raptors", "Washington Wizards", "Cleveland Cavaliers"];

    //$("#search").autocomplete({source:data});
    $("#search").autocomplete({
        delay: 0,
        source: data,
        minLength: 1,
        open: function(){
            setTimeout(function () {
                $('.ui-autocomplete').css('z-index', 99999999999999);
            }, 0);
        },
        select: function(event, ui) {
            alert("Selecciono: " + ui.item.label);
        }
    });
    
    $("#search-users").autocomplete({
        delay: 0,
        source: function(request, response) {
            $.ajax({
                data: {term : request.term},
                method: 'GET',
                url: `/api/v1/users?exclude=${id}`,
                success: function(data) {
                    // TODO: ?
                    const list = [];
                    data.forEach((element) => {
                        list.push(element.username);
                    });

                    response($.map(data, function(objet){
                        return {
                            label: objet.username,
                            value: objet.id
                        };
                    }));
                }
            });
        },
        minLength: 1,
        open: function(){
            setTimeout(function () {
                $('.ui-autocomplete').css('z-index', 99999999999999);
            }, 0);
        },
        focus: function(event, ui)
        {
            // prevent autocomplete from updating the textbox
			event.preventDefault();
			// manually update the textbox
			$(this).val(ui.item.label);
        },
        select: function(event, ui) {


            // prevent autocomplete from updating the textbox
			event.preventDefault();
		    // manually update the textbox and hidden field
			// $(this).attr('user-id', ui.item.value);
			$("#search-users").val(ui.item.label);


            console.log(ui.item.value);

            $.ajax({
                url: '/api/v1/chats/findOrCreate',
                method: 'POST',
                data: `userId1=${id}&userId2=${ui.item.value}`,
                async: false,
                timeout: 0,
                success: function(response)
                {
                    console.log(response);
                    chatId = response.id;
                }
            });

            $.ajax({
                url: '/api/v1/chatParticipants/userId',
                method: 'POST',
                data: `userId=${id}&chatId=${chatId}`,
                timeout: 0,
                success: function(response)
                {
                    console.log(response);
                    chatParticipantId = response.id;
                }
            });

            $.ajax({
                url: `/api/v1/chats/${chatId}/messages`,
                method: 'GET',
                timeout: 0,
                success: function(response)
                {
                    $('#comment-box').empty();

                    response.forEach(function(message)
                    {
                        $('#comment-box').append((message.user === chatParticipantId) ?
                        `
                            <div class="d-flex justify-content-end my-3">
                                <small class="bg-orange text-light p-2 rounded-2 overflow-auto">${message.content}</small>
                            </div>
                        `
                        :
                        `
                            <div class="d-flex justify-content-start my-3">
                                <small class="bg-secondary text-light p-2 rounded-2 overflow-auto">${message.content}</small>
                            </div>
                        `
                        );
                    });
                }
            });


            
        }
    });
    

});