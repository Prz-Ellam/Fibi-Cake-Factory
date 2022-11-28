var chatParticipantId = null;
var chatId = null;

function loadChat(_chatId, _username) {
    chatId = _chatId;
    $.ajax({
        url: '/api/v1/chatParticipants/userId',
        method: 'POST',
        data: `userId=${id}&chatId=${chatId}`,
        async: false,
        success: function(response)
        {
            console.log(response);
            chatParticipantId = response.id;
        }
    });

    $.ajax({
        url: `/api/v1/chats/${chatId}/messages`,
        method: 'GET',
        success: function(response)
        {
            $('#comment-box').empty();
            $('#chat-name').text(_username);
            //$('#user-label').attr('href', `/profile?id=${ui.item.value}`)

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

const chatComponent = /*html*/`
{{#each this}}
<div class="d-flex chat rounded-1 p-1" role="button" onclick="loadChat('{{chat-id}}', '{{username}}');">
    <img style="width: 64px; height: 64px" class="img-fluid rounded-circle" src="api/v1/images/{{profile-picture}}">
    <div class="row ms-2 align-self-center" style="white-space: nowrap; width: 75%; text-overflow: ellipsis; overflow: hidden;">
        <span class="fw-bold">{{username}}</span>
        <small>{{email}}</small>
    </div>
</div>
<hr>
{{/each}}
`;

var id;
$.ajax({
    url: 'api/v1/session',
    method: 'GET',
    async: false,
    success: function(response) {
        id = response.id;
    }
});

$.ajax({
    url: `/api/v1/users/${id}/chats`,
    method: 'GET',
    async: false,
    success: function(response) {
        const template = Handlebars.compile(chatComponent);
        $('#chats-container').append(template(response));
    }
})


$(document).ready(function() {

    $('#send-message').click(function() {
        let message = $('#message').val();
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

    function postMessage(message) {
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
    
    $("#search-users").autocomplete({
        delay: 0,
        source: function(request, response) {
            $.ajax({
                data: {term : request.term},
                method: 'GET',
                url: `/api/v1/users?exclude=${id}&search=${$('#search-users').val()}`,
                success: function(data) {
                    // TODO: ?
                    const list = [];
                    data.forEach(element => {
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
            setTimeout(() => {
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
                async: false,
                success: function(response) {
                    chatParticipantId = response.id;
                }
            });

            $.ajax({
                url: `/api/v1/chats/${chatId}/messages`,
                method: 'GET',
                success: function(response) {
                    $('#chat-name').text(ui.item.label);
                    //$('#user-label').attr('href', `/profile?id=${ui.item.value}`);

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