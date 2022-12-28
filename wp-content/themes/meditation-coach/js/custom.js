
jQuery(document).ready(function ($) {
        /*  for nav-search-1 */
    var focusableElements = 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';

    var modal = document.querySelector(".header-search-wrap"); // select the modal by it's id
    if (modal == null) {
        return;

    } 
    var firstFocusableElement = modal.querySelectorAll(focusableElements)[0]; // get first element to be focused inside modal
    var focusableContent = modal.querySelectorAll(focusableElements);
    var lastFocusableElement = focusableContent[focusableContent.length - 1]; // get last element to be focused inside modal



    document.addEventListener('keydown', function (e) {
        var isTabPressed = e.key === 'Tab' || e.keyCode === 9;

        if (!isTabPressed) {
            return;
        }

        if (e.shiftKey) {
            // if shift key pressed for shift + tab combination
            if (document.activeElement === firstFocusableElement) {
                lastFocusableElement.focus(); // add focus for the last focusable element
                e.preventDefault();
            }
        } else {
            // if tab key is pressed
            if (document.activeElement === lastFocusableElement) {
                // if focused has reached to last focusable element then focus first focusable element after pressing tab
                firstFocusableElement.focus(); // add focus for the first focusable element
                e.preventDefault();
            }
        }
    });

    firstFocusableElement.focus();


    /*  for nav-search-2*/
    var modalsearch = document.querySelector(".mobile-header-wrap .header-search-wrap"); // select the modal by it's id

    var firstFocusableElementss = modalsearch.querySelectorAll(focusableElements)[0]; // get first element to be focused inside modal
    var focusableContentss = modalsearch.querySelectorAll(focusableElements);
    var lastFocusableElementss = focusableContentss[focusableContentss.length - 1]; // get last element to be focused inside modal
    if(!firstFocusableElementss){
        return;
    }

    document.addEventListener('keydown', function (e) {
        var isTabPressed = e.key === 'Tab' || e.keyCode === 9;

        if (!isTabPressed) {
            return;
        }

        if (e.shiftKey) {
            // if shift key pressed for shift + tab combination
            if (document.activeElement === firstFocusableElementss) {
                lastFocusableElementss.focus(); // add focus for the last focusable element
                e.preventDefault();
            }
        } else {
            // if tab key is pressed
            if (document.activeElement === lastFocusableElementss) {
                // if focused has reached to last focusable element then focus first focusable element after pressing tab
                firstFocusableElementss.focus(); // add focus for the first focusable element
                e.preventDefault();
            }
        }
    });

    firstFocusableElementss.focus();

    //header search form toggle 
    $('.header-search .search-toggle').click(function () {
        $(this).siblings('.header-search-wrap').fadeIn();
        $('.header-search-wrap form .search-field').focus();
    });

    $('.header-search .close').click(function () {
        $(this).parents('.header-search-wrap').fadeOut();
    });

    $('.header-search-wrap').keyup(function (e) {
        if (e.key == 'Escape') {
            $('.header-search .header-search-wrap').fadeOut();
        }
    });
    $('.header-search .header-search-inner .search-form').click(function (e) {
        e.stopPropagation();
    });

    $('.header-search .header-search-inner').click(function (e) {
        $(this).parents('.header-search-wrap').fadeOut();
    });


});
