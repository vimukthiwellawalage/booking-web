var popupButtonCategory = document.getElementById('popupButtonCategory');
var popupButtonCuisine = document.getElementById('popupButtonCuisine');
var popupButtonDiet = document.getElementById('popupButtonDiet');

var overlay = document.getElementById('overlay');

var popupContainerCategory = document.getElementById('popupContainerCategory');
var popupContainerCuisine = document.getElementById('popupContainerCuisine');
var popupContainerDiet = document.getElementById('popupContainerDiet');



popupButtonCategory.addEventListener('click', function () {
    overlay.style.display = 'block';
    popupContainerCategory.style.display = 'block';
});

popupButtonCuisine.addEventListener('click', function () {
    overlay.style.display = 'block';
    popupContainerCuisine.style.display = 'block';
});

popupButtonDiet.addEventListener('click', function () {
    overlay.style.display = 'block';
    popupContainerDiet.style.display = 'block';
});




function closePopup() {
    overlay.style.display = 'none';
    popupContainerCategory.style.display = 'none';
    popupContainerCuisine.style.display = 'none';
    popupContainerDiet.style.display = 'none';

}



overlay.addEventListener('click', function () {
    closePopup();
});

