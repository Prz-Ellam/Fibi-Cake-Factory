export const wishlistCard = /*html*/`
{{#each this}}
<div class="col-12 col-md-6 col-lg-4 mb-5 d-flex align-items-stretch wishlist-card" id="{{id}}">
    <div class="card mx-auto" style="width: 18rem;">
        <div class="carousel slide" data-bs-ride="carousel" role="button">
            <div class="carousel-inner">
            {{#if images.length}}
                {{#each images}}
                <div class="carousel-item {{#if @first}}active{{/if}}" data-bs-interval="5000">
                    <div class="ratio ratio-4x3">
                        <img src="/api/v1/images/{{this}}" class="card-img-top w-100 h-100">
                    </div>
                </div>
                {{/each}}
            {{else}}
                <div class="carousel-item active" data-bs-interval="5000">
                    <div class="ratio ratio-4x3">
                        <img src="assets/img/wishlist-default.jpg" class="card-img-top w-100 h-100">
                    </div>
                </div>
            {{/if}}
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title text-brown wishlist-name">{{name}}</h5>
            <p class="card-text text-brown wishlist-description mb-2 text-truncate">{{description}}</p>
            {{#if visible}}
                <p class="text-brown wishlist-visibility" value="1"><i class="fas fa-users"></i> Pública</p> 
            {{else}}
                <p class="text-brown wishlist-visibility" value="0"><i class="fas fa-lock"></i> Privada</p>
            {{/if}}
            <div class="d-flex justify-content-start">
                <button class="btn btn-blue shadow-none rounded-1 me-1 update-wishlist">Editar</button>
                <button class="btn btn-red shadow-none rounded-1 delete-wishlist">Eliminar</button>
            </div>
        </div>
    </div>
</div>
{{/each}}
`;