export function WishlistItem(wishlist) {
    return /*html*/`
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>
            ${ (wishlist.images.length !== 0) ? 
            `<img src="api/v1/images/${wishlist.images[0]}" class="img-fluid" alt="lay" style="max-width: 128px">`
            :
            `<img src="assets/img/wishlist-default.jpg" class="img-fluid" alt="lay" style="max-width: 128px">`
            }
            ${wishlist.name}
            </span>
        <input class="custom-control-input form-check-input shadow-none me-1" name="wishlists[]" type="checkbox" value="${wishlist.id}" aria-label="...">
    </li>
    `;
}