/**
 * App eCommerce Add Product Script
 */
'use strict';

//Javascript to handle the e-commerce product add page

(function () {

    // Initialize Quill editors
    const shortDescription = document.querySelector('.short-description-editor');
    let shortQuill;
    if (shortDescription) {
        shortQuill = new Quill(shortDescription, {
            modules: {
                toolbar: '.comment-short'
            },
            placeholder: 'Product Short Description',
            theme: 'snow'
        });
    }

    const longDescription = document.querySelector('.long-description-editor');
    let longQuill;
    if (longDescription) {
        longQuill = new Quill(longDescription, {
            modules: {
                toolbar: '.comment-long'
            },
            placeholder: 'Product Long Description',
            theme: 'snow'
        });
    }

    // previewTemplate: Updated Dropzone default previewTemplate

    // ! Don't change it unless you really know what you are doing

    const previewTemplate = `<div class="dz-preview dz-file-preview">
<div class="dz-details">
  <div class="dz-thumbnail">
    <img data-dz-thumbnail>
    <span class="dz-nopreview">No preview</span>
    <div class="dz-success-mark"></div>
    <div class="dz-error-mark"></div>
    <div class="dz-error-message"><span data-dz-errormessage></span></div>
    <div class="progress">
      <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
    </div>
  </div>
  <div class="dz-filename" data-dz-name></div>
  <div class="dz-size" data-dz-size></div>
</div>
</div>`;

    // ? Start your code from here


    // Basic Tags

    const tagifyBasicEl = document.querySelector('#ecommerce_product_tags');
    const TagifyBasic = new Tagify(tagifyBasicEl);

    // Flatpickr

    // Datepicker
    const date = new Date();

    const productDate = document.querySelector('.product-date');

    if (productDate) {
        productDate.flatpickr({
            monthSelectorType: 'static',
            defaultDate: date
        });
    }
})();

//Jquery to handle the e-commerce product add page


function addSizeQuantityField() {
    const container = document.getElementById('size-quantity-container');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-3';

    newRow.innerHTML = `
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="size[]" placeholder="Size">
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" name="quantity[]" placeholder="Quantity">
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-danger" onclick="removeSizeQuantityField(this)">Remove</button>
                </div>
            `;

    container.appendChild(newRow);
}
document.getElementById('inStockSwitch').addEventListener('change', function () {
    document.getElementById('productStock').value = this.checked ? 1 : 0;
});

function removeSizeQuantityField(button) {
    const row = button.parentElement.parentElement;
    row.remove();
}

document.addEventListener('DOMContentLoaded', function () {
    function previewImages(input, previewContainer) {
        // Clear the existing previews
        previewContainer.innerHTML = '';

        // Ensure files are selected
        if (input.files) {
            Array.from(input.files).forEach(file => {
                if (!file.type.startsWith('image/')) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    const col = document.createElement('div');
                    col.classList.add('col-4'); // Adjust column size as needed
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail'); // Add any additional classes
                    img.style.width = '100%'; // Ensure image fits the container
                    col.appendChild(img);
                    previewContainer.appendChild(col);
                }
                reader.readAsDataURL(file);
            });
        }
    }

    // Select file inputs and preview containers
    const productImagesInput = document.getElementById('product_images');
    const productImagesPreview = document.getElementById('imagePreviewRow');
    const productImagesChildInput = document.getElementById('product_images_child');
    const productImagesChildPreview = document.getElementById('imagePreviewRowChild');

    // Add event listeners to file inputs
    productImagesInput.addEventListener('change', function () {
        previewImages(productImagesInput, productImagesPreview);
    });

    productImagesChildInput.addEventListener('change', function () {
        previewImages(productImagesChildInput, productImagesChildPreview);
    });
});
