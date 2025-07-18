let currentMenu = null;

// Function to toggle a dropdown menu
function toggleDropdownMenu(menu) {
    if (currentMenu) {
        if (currentMenu === menu) {
            menu.style.display = 'none';
            currentMenu = null;
        } else {
            currentMenu.style.display = 'none';
            menu.style.display = 'block';
            currentMenu = menu;
        }
    } else {
        menu.style.display = 'block';
        currentMenu = menu;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Add click event to each overview row
    document.querySelectorAll('.added__post__content__overview').forEach(row => {
        row.addEventListener('click', function () {
            closeAllMenus();

            const header = this.querySelector('.post__header')?.innerText || '';
            const description = this.querySelector('.post__description')?.innerText || '';
            const imgSrc = this.querySelector('.post__img__container img')?.src || '';

            document.querySelector('.popup__head__page__name').innerText = header;
            document.querySelector('.popup__head__description').innerText = description;
            document.querySelector('.popup__post__image__area img').src = imgSrc;

            document.getElementById('popup').style.display = 'block';
            document.body.classList.add('no-scroll');
        });
    });

    // Add click event to all menu togglers
    document.querySelectorAll('.menu__list__post__toggler').forEach(button => {
        button.addEventListener('click', function (event) {
            event.stopPropagation();
            const menu = button.nextElementSibling;
            toggleDropdownMenu(menu);
        });
    });
});

// Close all menus function
function closeAllMenus() {
    document.querySelectorAll('.menu__list__post').forEach(menu => {
        menu.style.display = 'none';
    });
    currentMenu = null; // Reset current menu
}
// Add click event to each row to open the popup
document.querySelectorAll('.added__post__content__overview').forEach(row => {
    row.addEventListener('click', function () {
        closeAllMenus();

        const header = this.querySelector('.post__header').innerText;
        const description = this.querySelector('.post__description').innerText;
        const imgSrc = this.querySelector('.post__img__container img').src;

        document.querySelector('.popup__head__page__name').innerText = header;
        document.querySelector('.popup__head__description').innerText = description;
        document.querySelector('.popup__post__image__area img').src = imgSrc;

        document.getElementById('popup').style.display = 'block';
        document.body.classList.add('no-scroll'); // Add no-scroll class
    });
});

// Close the popup when any close button is clicked
document.querySelectorAll('.close-button').forEach(button => {
    button.addEventListener('click', function () {
        document.getElementById('popup').style.display = 'none';
        document.body.classList.remove('no-scroll'); // Remove no-scroll class
    });
});

// Close the popup when clicking outside of the content area
window.addEventListener('click', function (event) {
    const popup = document.getElementById('popup');
    if (event.target === popup) {
        popup.style.display = 'none';
        document.body.classList.remove('no-scroll'); // Remove no-scroll class
    }
});

// Upward menu toggler functionality
document.querySelector('.upward-menu-toggler').addEventListener('click', function (event) {
    const menu = document.querySelector('.upward-menu');
    event.stopPropagation();
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
});

// Close the upward menu when clicking outside of it
window.addEventListener('click', function (event) {
    const menu = document.querySelector('.upward-menu');
    if (event.target !== menu && event.target !== document.querySelector('.upward-menu-toggler')) {
        menu.style.display = 'none';
    }
});

// Close the selection menu when clicking outside of it
// window.addEventListener('click', function(event) {
//     if (event.target !== selectionButton && !selectionMenu.contains(event.target)) {
//         selectionMenu.style.display = 'none';
//     }
// });



function setupToggleButtons() {
    const buttons = document.querySelectorAll('.selection__button, .selection__button__export');
    const menus = document.querySelectorAll('.selection__menu, .selection__menu__export');

    buttons.forEach((button, index) => {
        button.addEventListener('click', function (event) {
            event.stopPropagation(); // Prevent event bubbling

            // Get the corresponding menu
            const menuToToggle = menus[index];

            // Close all menus first
            menus.forEach(menu => {
                if (menu !== menuToToggle) {
                    menu.style.display = 'none'; // Close other menus
                }
            });
            // Toggle the visibility of the clicked menu
            menuToToggle.style.display = menuToToggle.style.display === 'block' ? 'none' : 'block';
        });
    });
}

// Close all menus when clicking outside
document.addEventListener('click', function () {
    document.querySelectorAll('.selection__menu, .selection__menu__export').forEach(menu => {
        menu.style.display = 'none'; // Close all menus
    });
});

// Call the setup function
setupToggleButtons();




















const dropdownButton = document.querySelector('.custom-dropdown-toggle');
const dropdownMenu = document.querySelector('.custom-dropdown-menu.small-screen');

function toggleDropdown() {
    // Check if the menu is currently visible
    const isVisible = dropdownMenu.style.display === 'block';

    // Toggle the display property
    dropdownMenu.style.display = isVisible ? 'none' : 'block';
}

// Event listener for the button click
dropdownButton.addEventListener('click', toggleDropdown);









document.querySelectorAll('.toggle').forEach(link => {
    link.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default anchor behavior

        // Get the target container class from the data attribute
        const targetClass = this.getAttribute('data-target');

        // Hide all containers by removing the active class
        document.querySelectorAll('.overview__container__contains, .postinsights__container__contains, .hashtag__container__contains, .competitor__container__contains').forEach(container => {
            container.classList.remove('active');
        });

        // Show the target container by adding the active class
        const targetContainer = document.querySelector(`.${targetClass}`);
        if (targetContainer) {
            targetContainer.classList.add('active');
        }
    });
});
document.addEventListener('DOMContentLoaded', () => {
    // Add active class to the first button on page load
    const buttons = document.querySelectorAll('.toggle__selection__lg__btn');
    if (buttons.length > 0) {
        buttons[0].classList.add('active');
    }

    // Set up click event listener for each button
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            // Remove active class from all buttons
            buttons.forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to the clicked button
            this.classList.add('active');
        });
    });
});