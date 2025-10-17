// sidebar active class js

$(document).ready(function () {
    var currentUrl = window.location.href;

    // Remove active class from all menu items first
    $('.sidebar-wrapper ul li').removeClass('active');

    $('.sidebar-wrapper ul li a').each(function () {
        var link = $(this).attr('href'); // Get the link of the current anchor tag

        // Check if current URL matches the link
        if (currentUrl === link) {
            $(this).parent().addClass('active');
        }

        // Check for Family Group active state
        else if (link.includes("familygroup") && (currentUrl.includes("familygroup/create") ||
            currentUrl.includes("familygroup"))) {
            $(this).parent().addClass('active');
        }

        // Check for Family Member active state
        else if (link.includes("familymember") && (currentUrl.includes("familymember/create") ||
            currentUrl.includes("familymember"))) {
            $(this).parent().addClass('active');
        }
    });
});


$(document).ready(function () {
    // When the toggle button is clicked
    $('.sidebar-toggle').on('click', function (e) {
        e.preventDefault(); // Prevent the default action (e.g., following the link)

        $('.sidebar-wrapper').toggleClass('open'); // Toggle the 'open' class

        $('.menu-bar').toggleClass('collapsed');
        $('.main-wrapper').toggleClass('collapsed');
    });
});



// resources\views\admin\layouts\app.blade.php - setting cilck open  General-About Settings
$(document).ready(function () {
    // Toggle dropdown menu
    $('.sidebar-wrapper .dropdown-toggle').on('click', function (e) {
        console.log('Click')
        e.preventDefault();
        $(this).next('.sidebar-wrapper .dropdown-menu').slideToggle();
    });

    // Close dropdown when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.sidebar-wrapper .dropdown-toggle, .sidebar-wrapper .dropdown-menu').length) {
            $('.sidebar-wrapper .dropdown-menu').slideUp();
        }
    });
});



