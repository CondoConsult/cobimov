let button = document.querySelector('.side-bar-button');

function toggleMenu() {
    let sideBar = document.querySelector('.side-bar');
    if (sideBar.style.display === 'none' || sideBar.style.display === '') {
        sideBar.style.display = 'block';
    } else {
        sideBar.style.display = 'none';
    }
}

button.addEventListener('click', toggleMenu);