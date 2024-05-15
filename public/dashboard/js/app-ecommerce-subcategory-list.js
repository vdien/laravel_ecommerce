/**
 * App eCommerce Category List
 */

'use strict';

// Comment editor

const commentEditor = document.querySelector('.comment-editor');

if (commentEditor) {
    new Quill(commentEditor, {
        modules: {
            toolbar: '.comment-toolbar'
        },
        placeholder: 'Enter category description...',
        theme: 'snow'
    });
}

// Datatable (jquery)

$(function () {
    let borderColor, bodyBg, headingColor;

    if (isDarkStyle) {
        borderColor = config.colors_dark.borderColor;
        bodyBg = config.colors_dark.bodyBg;
        headingColor = config.colors_dark.headingColor;
    } else {
        borderColor = config.colors.borderColor;
        bodyBg = config.colors.bodyBg;
        headingColor = config.colors.headingColor;
    }

    // Variable declaration for category list table
    var dt_subcategory_list_table = $('.datatables-subcategory-list'),
        statusObj = {
            Publish: { title: 'Publish', class: 'bg-label-success' },
            Scheduled: { title: 'Scheduled', class: 'bg-label-warning' },
            Inactive: { title: 'Inactive', class: 'bg-label-danger' },
        };
    //select2 for dropdowns in offcanvas

    var select2 = $('.select2');
    if (select2.length) {
        select2.each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>').select2({
                dropdownParent: $this.parent(),
                placeholder: $this.data('placeholder') //for dynamic placeholder
            });
        });
    }

    // Customers List Datatable

    if (dt_subcategory_list_table.length) {
        var dt_subcategory = dt_subcategory_list_table.DataTable({
            ajax: route('getsubcategoryjson'), // JSON file to add data
            columns: [
                // columns according to JSON
                { data: '' },
                { data: 'id' },
                { data: 'subcategories' },
                { data: 'categories' },
                { data: 'total_products' },
                { data: 'total_earnings' },
                { data: '' }
            ],
            columnDefs: [
                {
                    // For Responsive
                    className: 'control',
                    searchable: false,
                    orderable: false,
                    responsivePriority: 1,
                    targets: 0,
                    render: function (data, type, full, meta) {
                        return '';
                    }
                },
                {
                    // For Checkboxes
                    targets: 1,
                    orderable: false,
                    searchable: false,
                    responsivePriority: 4,
                    checkboxes: true,
                    render: function () {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input">';
                    },
                    checkboxes: {
                        selectAllRender: '<input type="checkbox" class="form-check-input">'
                    }
                },
                {
                    // Categories and Category Detail
                    targets: 2,
                    responsivePriority: 2,
                    render: function (data, type, full, meta) {
                        var $name = full['subcategory_name'],
                            $category_detail = full['description'],
                            $image = full['subcategory_image'],
                            $id = full['id'];
                        if ($image) {
                            // For Product image
                            var $output =
                                '<img src="' +
                                assetsPath +
                                'img/ecommerce-category-images/subcategory/' +
                                $image +
                                '" alt="Product-' +
                                $id +
                                '" class="rounded-2">';
                        } else {
                            // For Product badge
                            var stateNum = Math.floor(Math.random() * 6);
                            var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                            var $state = states[stateNum],
                                $name = full['description'],
                                $initials = $name.match(/\b\w/g) || [];
                            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                            $output = '<span class="avatar-initial rounded-2 bg-label-' + $state + '">' + $initials + '</span>';
                        }
                        // Creates full output for Categories and Category Detail
                        var $row_output =
                            '<div class="d-flex align-items-center">' +
                            '<div class="avatar-wrapper me-2 rounded-2 bg-label-secondary">' +
                            '<div class="avatar">' +
                            $output +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column justify-content-center">' +
                            '<span class="text-body text-wrap fw-medium">' +
                            $name +
                            '</span>' +
                            '<span class="text-muted text-truncate mb-0 d-none d-sm-block"><small>' +
                            $category_detail +
                            '</small></span>' +
                            '</div>' +
                            '</div>';
                        return $row_output;
                    }
                },
                {
                    // Categories parent
                    targets: 3,
                    width: '50px',
                    responsivePriority: 2,
                    render: function (data, type, full, meta) {

                        return full['category']['category_name'];
                    }
                },
                {
                    // Total products
                    targets: 4,
                    width: '50px',
                    responsivePriority: 3,
                    render: function (data, type, full, meta) {
                        var $total_products = full['products_count'];
                        return '<div class="text-sm-center">' + $total_products + '</div>';
                    }
                },
                {
                    // Total Earnings
                    targets: 5,
                    width: '50px',
                    orderable: false,
                    render: function (data, type, full, meta) {
                        var $status = full['subcategory_status'];
                        return (
                            '<span class="badge px-2 ' +
                            statusObj[$status].class +
                            '" text-capitalized>' +
                            statusObj[$status].title +
                            '</span>'
                        );
                    }
                },
                {
                    // Actions
                    targets: -1,
                    title: 'Actions',
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return (
                            '<div class="d-flex align-items-sm-center justify-content-sm-center">' +
                            '<button class="btn btn-sm btn-icon delete-record-subcategory me-2" data-subcategory-id="' + full.id + '"><i class="ti ti-trash"></i></button>' +
                            '<button class="btn btn-sm btn-icon edit-record-subcategory" data-bs-toggle="modal" data-bs-target="#editCategoryModal" data-subcategory-id="' + full.id + '"><i class="ti ti-edit"></i></button>' +
                            '</div>'
                        );
                    }
                }
            ],
            order: [2, 'desc'], //set any columns order asc/desc
            dom:
                '<"card-header d-flex flex-wrap pb-2"' +
                '<f>' +
                '<"d-flex justify-content-center justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex justify-content-center flex-md-row mb-3 mb-md-0 ps-1 ms-1 align-items-baseline"lB>>' +
                '>t' +
                '<"row mx-2"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            lengthMenu: [7, 10, 20, 50, 70, 100], //for length of menu
            language: {
                sLengthMenu: '_MENU_',
                search: '',
                searchPlaceholder: 'Search Category'
            },
            // Button for offcanvas
            buttons: [
                {
                    text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add SubCategory</span>',
                    className: 'add-new btn btn-primary ms-2 waves-effect waves-light',
                    attr: {
                        'data-bs-toggle': 'offcanvas',
                        'data-bs-target': '#offcanvasEcommerceSubCategoryList'
                    }
                }
            ],
            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Details of ' + data['categories'];
                        }
                    }),
                    type: 'column',
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                '<td> ' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td class="ps-0">' +
                                col.data +
                                '</td>' +
                                '</tr>'
                                : '';
                        }).join('');

                        return data ? $('<table class="table"/><tbody />').append(data) : false;
                    }
                }
            }
        });
        $('.dt-action-buttons').addClass('pt-0');
        $('.dataTables_filter').addClass('me-3 ps-0');
    }
    // Add a listener for form submission
    $('#addSubcategoryForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission
        var formData = new FormData(this);
        $.ajax({
            url: route('storesubcategory'),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                // Update DataTable with new data
                $('#offcanvasEcommerceSubCategoryList').offcanvas('hide'); // Hide offcanvas
                //reset form add
                $('#addSubcategoryForm')[0].reset();
                $('#image_subcategory_preview').empty();
                dt_subcategory.clear().rows.add(response).draw();
                toastr.success('Category added successfully.'); // Show success message


            },
            error: function (xhr, status, error) {
                toastr.error(error);
                // Handle error if needed
            }
        });
    });
    $('body').on('click', '.edit-record-subcategory', function () {
        // Get the closest row to the clicked edit button
        var $row = $(this).closest('tr');
        // Get the data of the row using DataTables API
        var rowData = dt_subcategory.row($row).data();
        console.log(rowData)
        // Get the subcategory name and detail from the row data
        var subcategoryId = rowData.id
        var subcategoryName = rowData.subcategory_name;
        var subcategorySlug = rowData.slug;
        var subcategoryDetail = rowData.description;
        var subcategoryStatus = rowData.subcategory_status;
        var parentSubcategory = rowData.category.id;
        console.log(parentSubcategory)
        var subcategoryImage = rowData.subcategory_image;
        // Populate the modal with data from the row
        $('#edit_subcategory_id').val(subcategoryId);
        $('#edit_subcategory_name').val(subcategoryName);
        $('#edit_ecommerce_subcategory_slug').val(subcategorySlug);
        $('#edit_ecommerce_subcategory_description_input').val(subcategoryDetail);
        // Set image preview
        if (subcategoryImage) {
            $('#edit_image_subcategory_preview').html('<img src="' +
                assetsPath +
                'img/ecommerce-category-images/subcategory/' + subcategoryImage + '" class="img-fluid" alt="Image Preview">');
        } else {
            $('#edit_image_subcategory_preview').empty();
        }

        $('#edit_parent_subcategory').val(parentSubcategory).trigger('change');
        $('#edit_ecommerce_subcategory_status').val(subcategoryStatus).trigger('change');

        // Handle click event of "Save Changes" button
    });
    $('#edit_ecommerce_subcategory_image').change(function (e) {
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#edit_image_subcategory_preview').html('<img src="' + e.target.result + '" class="img-fluid" alt="Image Preview">');
            }
            reader.readAsDataURL(file);
        } else {
            $('#edit_image_subcategory_preview').empty();
        }
    });
    $('#editSubcategoryForm').submit(function (e) {
        e.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this);

        $.ajax({
            url: route('updatesubcategory'),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                dt_subcategory.clear().rows.add(response).draw();
                $('#editCategoryModal').modal('hide');
                $('#confirmModal').modal('hide');
                toastr.success('Category updated successfully.');
            },
            error: function (xhr, status, error) {
                toastr.error(error);
            }
        });
    });
    $('#saveChangesBtn').on('click', function (event) {
        event.preventDefault(); // Prevent default form submission
        $('#confirmModal').modal('show'); // Show the confirmation modal
    });
    // Delete Record
    $('body').on('click', '.delete-record-subcategory', function () {
        var $row = $(this).closest('tr');
        var rowData = dt_subcategory.row($row).data();
        var subcategoryId = rowData.id;

        $('.modal').modal('hide');
        // Show the confirmation modal for delete
        $('#confirmDeleteModal').modal('show');

        // Set data-attribute on confirmation button to hold the subcategory ID
        $('#confirmDelete').data('subcategory-id', subcategoryId);
    });
    $('#confirmDelete').on('click', function () {
        var subcategoryId = $(this).data('subcategory-id');
        // Perform the delete action (e.g., send AJAX request to delete the record)
        // Replace this with your actual delete logic
        let deleteCategoryUrl = route('deletesubcategory', { id: subcategoryId });

        $.ajax({
            url: deleteCategoryUrl,
            method: 'GET',
            data: { subcategoryId: subcategoryId },
            success: function (response) {
                var rowIndex = dt_subcategory.rows().eq(0).filter(function(index) {
                    return dt_subcategory.row(index).data().id === subcategoryId;
                });
                // Handle success (e.g., remove the row from the DataTable)
                dt_subcategory.row(rowIndex).remove().draw();
                $('#confirmDeleteModal').modal('hide');
                toastr.success('Category deleted successfully.');
            },
            error: function (xhr, status, error) {
                toastr.error(error);
            }
        });
    });

    // Filter form control to default size
    // ? setTimeout used for multilingual table initialization
    setTimeout(() => {
        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
});
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('ecommerce_subcategory_image').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            const preview = document.getElementById('image_subcategory_preview');
            if (preview) { // Check if the container element exists
                preview.innerHTML = ''; // Clear previous preview
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-fluid', 'pt-3');
                preview.appendChild(img);
            }
        };
        reader.readAsDataURL(file);
    });
});

//For form validation
(function () {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()
