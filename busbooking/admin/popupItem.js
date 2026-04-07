var popupButtonItem = document.getElementById('popupButtonItem');
var overlay2 = document.getElementById('overlay-2');
var popupContainerItem = document.getElementById('popupContainerItem');

popupButtonItem.addEventListener('click', function () {
    overlay2.style.display = 'block';
    popupContainerItem.style.display = 'block';
});


function closePopupItem() {
    overlay2.style.display = 'none';
    popupContainerItem.style.display = 'none';


}

overlay2.addEventListener('click', function () {
    closePopupItem();
});
