/**
 * App eCommerce Category List
 */

'use strict';

// Comment editor


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
    var dt_category_list_table = $('.datatables-category-list');

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

    if (dt_category_list_table.length) {
        var dt_category = dt_category_list_table.DataTable({
            ajax: route('getcategoryjson'), // JSON file to add data
            columns: [
                // columns according to JSON
                { data: '' },
                { data: 'id' },
                { data: 'categories' },
                { data: 'total_subcategory' },
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
                        var $name = full['category_name'],
                            $category_detail = full['description'],
                            $image = full['category_image'],
                            $id = full['id'];
                        if ($image) {
                            // For Product image
                            var $output =
                                '<img src="' +
                                assetsPath +
                                'img/ecommerce-category-images/category/' +
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
                    // Total products
                    targets: 3,
                    responsivePriority: 3,
                    render: function (data, type, full, meta) {
                        var $total_products = full['subcategory_count'];
                        return '<div class="text-sm-end">' + $total_products + '</div>';
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
                            '<button class="btn btn-sm btn-icon delete-record me-2"><i class="ti ti-trash"></i></button>' +
                            '<button class="btn btn-sm btn-icon edit-record" data-bs-toggle="modal" data-bs-target="#editCategoryModal" data-category-id="' + full.id + '"><i class="ti ti-edit"></i></button>' +
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
                    text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add Category</span>',
                    className: 'add-new btn btn-primary ms-2 waves-effect waves-light',
                    attr: {
                        'data-bs-toggle': 'offcanvas',
                        'data-bs-target': '#offcanvasEcommerceCategoryList'
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
        $('.datatables-category-list tbody').on('click', '.edit-record', function () {

            // Get the closest row to the clicked edit button
            var $row = $(this).closest('tr');
            // Get the data of the row using DataTables API
            var rowData = dt_category.row($row).data();
            // Get the category name and detail from the row data
            var categoryName = rowData.category_name;
            var categorySlug = rowData.slug;
            var categoryDetail = rowData.description;
            var categoryStatus = rowData.category_status;
            var categoryImage = rowData.category_image;

            // Populate the modal with data from the row
            $('#edit_category_name').val(categoryName);
            $('#edit_ecommerce_category_slug').val(categorySlug);
            $('#edit_ecommerce_category_description_input').val(categoryDetail);
            // Set image preview
            if (categoryImage) {
                $('#edit_image_category_preview').html('<img src="' +
                    assetsPath +
                    'img/ecommerce-category-images/category/' + categoryImage + '" class="img-fluid" alt="Image Preview">');
            } else {
                $('#edit_image_category_preview').empty();
            }
            $('#edit_ecommerce_category_status').val(categoryStatus).trigger('change');
            // Show the modal
            $('#editCategoryModal').modal('show');
        });
        // Image preview functionality (optional, if you also want to update the preview when changing the image)
        $('#edit_ecommerce_category_image').change(function (e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#edit_image_category_preview').html('<img src="' + e.target.result + '" class="img-fluid" alt="Image Preview">');
                }
                reader.readAsDataURL(file);
            } else {
                $('#image_preview').empty();
            }
        });
        // Delete Record
        $('.datatables-category-list tbody').on('click', '.delete-record', function () {
            dt_category.row($(this).parents('tr')).remove().draw();
        });

        $('.dt-action-buttons').addClass('pt-0');
        $('.dataTables_filter').addClass('me-3 ps-0');
    }



    // Filter form control to default size
    // ? setTimeout used for multilingual table initialization
    setTimeout(() => {
        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
});

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('ecommerce_category_image').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            const preview = document.getElementById('image_category_preview');
            preview.innerHTML = ''; // Clear previous preview
            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('img-fluid', 'pt-3');
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});



//For form validation
(function () {
    const eCommerceCategoryListForm = document.getElementById('eCommerceCategoryListForm');

    //Add New customer Form Validation
    const fv = FormValidation.formValidation(eCommerceCategoryListForm, {
        fields: {
            categoryTitle: {
                validators: {
                    notEmpty: {
                        message: 'Please enter category title'
                    }
                }
            },
            slug: {
                validators: {
                    notEmpty: {
                        message: 'Please enter slug'
                    }
                }
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                // Use this for enabling/changing valid/invalid class
                eleValidClass: 'is-valid',
                rowSelector: function (field, ele) {
                    // field is the field name & ele is the field element
                    return '.mb-3';
                }
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            // Submit the form when all fields are valid
            // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        }
    });
})();
