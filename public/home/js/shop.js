<script>
$(document).ready(function() {
    function fetchProducts() {
        $.ajax({
            url: "{{ url('shop') }}",
            type: "GET",
            data: {
                sort_by: $('#sortByselect').val(),
                size: $('#sizeFilter').val(),
                category_id: $('.filter-category.active').data('category-id'),
                subcategory_id: $('.filter-subcategory.active').data('subcategory-id')
            },
            success: function(response) {
                $('#productList').html(response);
            }
        });
    }

    // Event handler for category filter
    $('a.filter-category').on('click', function(e) {
        e.preventDefault();
        // Toggle active class
        $(this).toggleClass('active');
        $('.filter-subcategory').not(this).removeClass('active');
        // Remove active class from other category links
        $('.filter-category').not(this).removeClass('active');
        // Fetch products
        fetchProducts();
    });

    // Event handler for subcategory filter
    $('a.filter-subcategory').on('click', function(e) {
        $('.filter-category').not(this).removeClass('active');
        e.preventDefault();
        // Toggle active class
        $(this).toggleClass('active');
        // Remove active class from other subcategory links
        $('.filter-subcategory').not(this).removeClass('active');
        // Fetch products
        fetchProducts();
    });

    // Event handler for sorting
    $('#sortByselect').on('change', function() {
        fetchProducts();
    });

    // Event handler for size filter
    $('#sizeFilter').on('change', function() {
        fetchProducts();
    });
});
</script>
