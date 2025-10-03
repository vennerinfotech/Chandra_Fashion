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




// product variant - remove and Image perview in add-update product from
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('variants-wrapper');

    // Track removed old images
    const removedInput = document.getElementById('removed_images');
    removedInput.value = removedInput.value || '[]';

    // Add new variant
    document.getElementById('add-variant').addEventListener('click', function () {
        const index = wrapper.querySelectorAll('.variant-item').length;
        const html = `
        <div class="variant-item border rounded p-3 mb-3 position-relative">
            <a href="javascript:void(0);" title="Cancel" class="btn-action btn-sm remove-variant position-absolute top-0 end-0 m-2">
                <i class="fa-solid fa-circle-xmark text-danger"></i>
            </a>
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="form-label">Product Code</label>
                    <input type="text" name="variants[${index}][product_code]" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Color</label>
                    <input type="text" name="variants[${index}][color]" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Size</label>
                    <input type="text" name="variants[${index}][size]" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">MOQ</label>
                    <input type="number" name="variants[${index}][moq]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Images</label>
                    <input type="file" name="variants[${index}][images][]" class="form-control variant-images" multiple>
                    <div class="mt-2 preview-wrapper"></div>
                </div>
            </div>
        </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
    });

    // Remove variant
    wrapper.addEventListener('click', function (e) {
        if (e.target.closest('.remove-variant')) {
            const item = e.target.closest('.variant-item');
            if (item) item.remove();
        }
    });

    // Preview new images
    wrapper.addEventListener('change', function (e) {
        if (e.target.classList.contains('variant-images')) {
            const previewWrapper = e.target.closest('.col-md-3').querySelector('.preview-wrapper');
            if (!previewWrapper) return;

            previewWrapper.innerHTML = '';
            Array.from(e.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function (event) {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('position-relative', 'd-inline-block',
                        'me-2', 'mb-2');

                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.width = 100;
                    img.height = 100;
                    img.classList.add('rounded', 'border');

                    const removeBtn = document.createElement('span');
                    removeBtn.innerHTML =
                        `<i class="fa-solid fa-circle-xmark text-danger"></i>`;
                    removeBtn.classList.add('position-absolute', 'top-0', 'end-0',
                        'p-1', 'cursor-pointer');

                    removeBtn.addEventListener('click', () => {
                        imgContainer.remove();
                        // Optional: remove file from input by creating DataTransfer (advanced)
                    });

                    imgContainer.appendChild(img);
                    imgContainer.appendChild(removeBtn);
                    previewWrapper.appendChild(imgContainer);
                }
                reader.readAsDataURL(file);
            });
        }
    });

    // Remove old images (static Blade images)
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-old-image')) {
            const container = e.target.closest('div.position-relative');
            if (container) {
                const input = container.querySelector('input[type=hidden]');
                if (input) {
                    // store removed image paths in hidden input
                    let removed = JSON.parse(removedInput.value);
                    removed.push(input.value);
                    removedInput.value = JSON.stringify(removed);

                    input.remove();
                }
                container.remove();
            }
        }
    });
});
