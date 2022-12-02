document.addEventListener( 'alpine:init', () => {
    Alpine.data( 'menuMobile', () => ( {
            menuMobileIsOpen: false,
            searchMobileIsOpen: false,
            sousMenuOpen: 0,
            isLoading: false
        } )
    );
} );