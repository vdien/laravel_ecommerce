/**
 * app-ecommerce-product-list
 */

'use strict';
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
    // Select2
    var select2 = $('.select2');
    if (select2.length) {
        select2.each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>').select2({
                dropdownParent: $this.parent(),
                placeholder: $this.data('placeholder') // for dynamic placeholder
            });
        });
    }

    var formRepeater = $('.form-repeater');

    // Form Repeater
    // ! Using jQuery each loop to add dynamic id and class for inputs. You may need to improve it based on form fields.
    // -----------------------------------------------------------------------------------------------------------------

    if (formRepeater.length) {
        var row = 2;
        var col = 1;
        formRepeater.on('submit', function (e) {
            e.preventDefault();
        });
        formRepeater.repeater({
            show: function () {
                var fromControl = $(this).find('.form-control, .form-select');
                var formLabel = $(this).find('.form-label');

                fromControl.each(function (i) {
                    var id = 'form-repeater-' + row + '-' + col;
                    $(fromControl[i]).attr('id', id);
                    $(formLabel[i]).attr('for', id);
                    col++;
                });

                row++;
                $(this).slideDown();
                $('.select2-container').remove();
                $('.select2.form-select').select2({
                    placeholder: 'Placeholder text'
                });
                $('.select2-container').css('width', '100%');
                $('.form-repeater:first .form-select').select2({
                    dropdownParent: $(this).parent(),
                    placeholder: 'Placeholder text'
                });
                $('.position-relative .select2').each(function () {
                    $(this).select2({
                        dropdownParent: $(this).closest('.position-relative')
                    });
                });
            }
        });
    }


    // Variable declaration for table
    var dt_product_table = $('.datatables-products'),
        productAdd = 'app-ecommerce-product-add.html',
        statusObj = {
            Scheduled: { title: 'Scheduled', class: 'bg-label-warning' },
            Published: { title: 'Published', class: 'bg-label-success' },
            Inactive: { title: 'Inactive', class: 'bg-label-danger' }
        },

        stockObj = {
            0: { title: 'Out_of_Stock' },
            1: { title: 'In_Stock' }
        },
        stockFilterValObj = {
            0: { title: 'Out of Stock' },
            1: { title: 'In Stock' }
        };

    // E-commerce Products datatable

    if (dt_product_table.length) {
        var dt_products = dt_product_table.DataTable({
            ajax: route('allproductsjson'), // JSON file to add data
            columns: [
                // columns according to JSON
                { data: 'id' },
                { data: 'id' },
                { data: 'product_name' },
                { data: 'category' },
                { data: 'stock' },
                { data: 'sku' },
                { data: 'price' },
                { data: 'quantity' },
                { data: 'status' },
                { data: '' }
            ],
            columnDefs: [
                {
                    // For Responsive
                    className: 'control',
                    searchable: false,
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0,
                    render: function (data, type, full, meta) {
                        return '';
                    }
                },
                {
                    // For Checkboxes
                    targets: 1,
                    orderable: false,
                    checkboxes: {
                        selectAllRender: '<input type="checkbox" class="form-check-input">'
                    },
                    render: function () {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input" >';
                    },
                    searchable: false
                },
                {
                    // Product name and product_brand
                    targets: 2,
                    responsivePriority: 1,
                    render: function (data, type, full, meta) {
                        var $name = full['product_name'],
                            $id = full['id'],
                            $product_brand = full['subcategory']['subcategory_name'],
                            $image = full['product_img'];
                        if ($image) {
                            // For Product image

                            var $output =
                                '<img src="' +
                                assetsPath +
                                'img/ecommerce-product-images/product/' +
                                $image +
                                '" alt="Product-' +
                                $id +
                                '" class="rounded-2">';
                        } else {
                            // For Product badge
                            var stateNum = Math.floor(Math.random() * 6);
                            var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                            var $state = states[stateNum],
                                $name = full['subcategory']['subcategory_name'],
                                $initials = $name.match(/\b\w/g) || [];
                            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                            $output = '<span class="avatar-initial rounded-2 bg-label-' + $state + '">' + $initials + '</span>';
                        }
                        // Creates full output for Product name and product_brand
                        var $row_output =
                            '<div class="d-flex justify-content-start align-items-center product-name">' +
                            '<div class="avatar-wrapper">' +
                            '<div class="avatar avatar me-2 rounded-2 bg-label-secondary">' +
                            $output +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<h6 class="text-body text-nowrap mb-0">' +
                            $name +
                            '</h6>' +
                            '<small class="text-muted text-truncate d-none d-sm-block">' +
                            $product_brand +
                            '</small>' +
                            '</div>' +
                            '</div>';
                        return $row_output;
                    }
                },
                {
                    // Product Category

                    targets: 3,
                    responsivePriority: 5,
                    render: function (data, type, full, meta) {
                        var $category = full['subcategory']['subcategory_name'];

                        return (
                            "<span class='text-truncate d-flex align-items-center'>" +
                            $category +
                            '</span>'
                        );
                    }
                },
                {
                    // Stock
                    targets: 4,
                    orderable: false,
                    responsivePriority: 3,
                    render: function (data, type, full, meta) {
                        var $stock = full['stock'];
                        var stockSwitchObj = {
                            Out_of_Stock:
                            '<span class="badge bg-label-danger'  +
                            '" text-capitalized>' +
                            'Out of stock' +
                            '</span>',
                            In_Stock:
                            '<span class="badge bg-label-primary'  +
                            '" text-capitalized>' +
                            'Instock' +
                            '</span>',
                        };
                        return (
                            "<span class='text-truncate'>" +
                            stockSwitchObj[stockObj[$stock].title] +
                            '<span class="d-none">' +
                            stockObj[$stock].title +
                            '</span>' +
                            '</span>'
                        );
                    }
                },
                {
                    // Sku
                    targets: 5,
                    render: function (data, type, full, meta) {
                        var $sku = full['sku'];

                        return '<span>' + $sku + '</span>';
                    }
                },
                {
                    // price
                    targets: 6,
                    render: function (data, type, full, meta) {
                        var $price = full['price'];

                        return '<span>' + $price + '</span>';
                    }
                },
                {
                    // qty
                    targets: 7,
                    responsivePriority: 4,
                    render: function (data, type, full, meta) {
                        var $qty = full['total_quantity'];

                        return '<span>' + $qty + '</span>';
                    }
                },
                {
                    // Status
                    targets: -2,
                    render: function (data, type, full, meta) {
                        var $status = full['status'];

                        return (
                            '<span class="badge ' +
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
                            '<button class="btn btn-sm btn-icon delete-record-product me-2" data-product-id="' + full.id + '"><i class="ti ti-trash"></i></button>' +
                            '<button class="btn btn-sm btn-icon edit-record-product" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-id="' + full.id + '"><i class="ti ti-edit"></i></button>'
                        );
                    }
                }
            ],
            order: [2, 'asc'], //set any columns order asc/desc
            dom:
                '<"card-header d-flex border-top rounded-0 flex-wrap py-2"' +
                '<"me-5 ms-n2 pe-5"f>' +
                '<"d-flex justify-content-start justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row"lB>>' +
                '>t' +
                '<"row mx-2"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            lengthMenu: [7, 10, 20, 50, 70, 100], //for length of menu
            language: {
                sLengthMenu: '_MENU_',
                search: '',
                searchPlaceholder: 'Search Product',
                info: 'Displaying _START_ to _END_ of _TOTAL_ entries'
            },
            // Buttons with Dropdown
            buttons: [
                {
                    extend: 'collection',
                    className: 'btn btn-label-secondary dropdown-toggle me-3 waves-effect waves-light',
                    text: '<i class="ti ti-download me-1 ti-xs"></i>Export',
                    buttons: [
                        {
                            extend: 'print',
                            text: '<i class="ti ti-printer me-2" ></i>Print',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7],
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('product-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            },
                            customize: function (win) {
                                // Customize print view for dark
                                $(win.document.body)
                                    .css('color', headingColor)
                                    .css('border-color', borderColor)
                                    .css('background-color', bodyBg);
                                $(win.document.body)
                                    .find('table')
                                    .addClass('compact')
                                    .css('color', 'inherit')
                                    .css('border-color', 'inherit')
                                    .css('background-color', 'inherit');
                            }
                        },
                        {
                            extend: 'csv',
                            text: '<i class="ti ti-file me-2" ></i>Csv',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7],
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('product-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'excel',
                            text: '<i class="ti ti-file-export me-2"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7],
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('product-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="ti ti-file-text me-2"></i>Pdf',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7],
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('product-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'copy',
                            text: '<i class="ti ti-copy me-2"></i>Copy',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7],
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('product-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        }
                    ]
                },
                {
                    text: '+ Add product',
                    className: 'btn btn-primary ms-2 ms-sm-0 waves-effect waves-light add-new',
                    action: function () {
                        $('#addProductModal').modal('show');
                    }
                }
            ],
            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Details of ' + data['product_name'];
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
                                '<td>' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td>' +
                                col.data +
                                '</td>' +
                                '</tr>'
                                : '';
                        }).join('');

                        return data ? $('<table class="table"/><tbody />').append(data) : false;
                    }
                }
            },
            initComplete: function () {
                // Adding status filter once table initialized
                this.api()
                    .columns(-2)
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select id="ProductStatus" class="form-select text-capitalize"><option value="">Status</option></select>'
                        )
                            .appendTo('.product_status')
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="' + statusObj[d].title + '">' + statusObj[d].title + '</option>');
                            });
                    });

                // Adding stock filter once table initialized
                this.api()
                    .columns(4)
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select id="ProductStock" class="form-select text-capitalize"><option value=""> Stock </option></select>'
                        )
                            .appendTo('.product_stock')
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="' + stockObj[d].title + '">' + stockFilterValObj[d].title + '</option>');
                            });
                    });
            }
        });


        $('.dataTables_length').addClass('mt-2 mt-sm-0 mt-md-3 me-2');
        $('.dt-buttons').addClass('d-flex flex-wrap');
    }
    $('#addProductBtn').on('click', function (event) {
        $('#formAddProduct').submit() // Show the confirmation modal
    });
    $('#formAddProduct').submit(function (event) {
        event.preventDefault(); // Prevent default form submission
        // Set the value of the short description hidden input field
        $('#short-description-input').val($('#short-description').html());
        // Set the value of the long description hidden input field
        $('#long-description-input').val($('#long-description').html());
        var formData = new FormData(this);

        $.ajax({
            url: route('storeproduct'),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {

                // Update DataTable with new data
                dt_products.clear().rows.add(response).draw();
                $('#addProductModal').modal('hide'); // Hide offcanvas
                toastr.success('Product added successfully.'); // Show success message
                //reset form add
                $('#imagePreviewRow').empty();
                $('#imagePreviewRowChild').empty();
                $('#formAddProduct')[0].reset();


            },
            error: function (xhr, status, error) {
                console.error(error);
                // Handle error if needed
            }
        });
    });
    $('body').on('click', '.edit-record-product', function () {
        // Get the product ID from the data attribute
        var $row = $(this).closest('tr');
        var rowData = dt_products.row($row).data();

        let productId = rowData.id
        let productName = rowData.product_name
        let productSku = rowData.sku
        let productShortDesc = rowData.product_short_des
        let productLongDesc = rowData.product_long_des
        let productImage = rowData.product_img
        let productChildImage = rowData.product_img_child
        let sizes = rowData.sizes
        let productPrice = rowData.price
        let discountPrice = rowData.discount_price
        let stock = rowData.stock
        let subCategory = rowData.subcategory.id
        let status = rowData.status
        let tags = rowData.tags
        $('#edit_product_id').val(productId)
        $('#edit_product_name').val(productName)
        $('#edit-product-sku').val(productSku)
        $('#edit-short-description').html(productShortDesc)
        $('#edit-long-description').html(productLongDesc)
        $('#edit_product_price').val(productPrice)
        $('#edit_product_discount_price').val(discountPrice)
        $('#edit-short-description-input').val($('#edit-short-description').html());
        // Set the value of the long description hidden input field
        $('#edit-long-description-input').val($('#edit-long-description').html());
        $('')
        if (productImage) {
            $('#editImagePreview').html('<img src="' +
                assetsPath +
                'img/ecommerce-product-images/product/' + productImage + '" class="img-fluid" alt="Image Preview">');
        } else {
            $('#editImagePreview').empty();
        }
        if (productChildImage) {
            // Parse the JSON string to convert it into an array
            var imageArray = JSON.parse(productChildImage);
            // Check if it's an array
            if ($.isArray(imageArray)) {
                // Iterate over the array
                $.each(imageArray, function (index, image) {
                    $('#editImagePreviewRowChild').append('<img src="' + assetsPath + 'img/ecommerce-product-images/child-product/' + image + '" class="img-fluid pt-5" alt="Image Preview">');
                });
            } else {
                // Handle the case when productChildImage is not an array
                console.error("productChildImage is not an array.");
            }
        } else {
            // Handle the case when productChildImage is empty or null
            $('#editImagePreviewRowChild').empty();
        }
        const container = document.getElementById('edit-size-quantity');
        sizes.forEach(size => {
            const newRow = document.createElement('div');
            newRow.className = 'row mb-3';

            newRow.innerHTML = `
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="size[]" value="${size.size}" placeholder="Size">
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" name="quantity[]" value="${size.quantity}" placeholder="Quantity">
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-danger" onclick="removeSizeQuantityField(this)">Remove</button>
                </div>
            `;
            container.appendChild(newRow);
        });
        // Set the checked attribute of the checkbox based on the value of stock
        stock == 1 ? $("#editInStockSwitch").prop("checked", true) : $("#editInStockSwitch").prop("checked", false)

        $('#edit_subcategory_product').val(subCategory).trigger('change');
        $('#edit_product_status').val(status).trigger('change');
        let tagsArray = $.parseJSON(tags);

        // Initialize an empty array to store tag values
        let tagValues = [];

        // Loop through the array to extract tag values
        $.each(tagsArray, function (index, tag) {
            // Push the tag value into the tagValues array
            tagValues.push(tag.value);
        });

        // Join the tag values with a comma and space
        let concatenatedTags = tagValues.join(', ');

        // Set the concatenated tag values to the input field
        $("#edit_product_tags").val(concatenatedTags);
    })
    $('#editProductSubmit').on('click', function (event) {
        event.preventDefault(); // Prevent default form submission
        $('#confirmEditProduct').modal('show'); // Show the confirmation modal
    });

    $('#confirmEditProductBtn').on('click',function(){
        $('#formEditProduct').submit();
    })
    $('#formEditProduct').on('submit',function(event){
        event.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this);
        $.ajax({
            url: route('updateproduct'),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                dt_products.clear().rows.add(response).draw();
                $('#editProductModal').modal('hide');
                $('#confirmEditProduct').modal('hide');
                toastr.success('Subcategory updated successfully.');
            },
            error: function (xhr, status, error) {
                toastr.error(error);
            }
        });
    })


    // Delete Record
    $('body').on('click', '.delete-record-product', function () {
        dt_products.row($(this).parents('tr')).remove().draw();
    })


    // Filter form control to default size
    // ? setTimeout used for multilingual table initialization
    setTimeout(() => {
        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
});
