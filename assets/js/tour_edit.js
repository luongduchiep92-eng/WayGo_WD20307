
const addNewBtn = document.getElementById('add-new-image-btn');
const newImagesContainer = document.getElementById('new-images-container');

addNewBtn.addEventListener('click', () => {
    const div = document.createElement('div');
    div.classList.add('mb-2', 'position-relative');
    div.innerHTML = `
        <input type="text" name="images_new[]" class="form-control mb-1" placeholder="Path hình ảnh mới">
        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-img-btn">&times;</button>
    `;
    newImagesContainer.appendChild(div);

    div.querySelector('.remove-img-btn').addEventListener('click', () => div.remove());
});

// Xóa ảnh hiện có
document.querySelectorAll('.remove-img-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const parent = e.target.closest('div.position-relative');
        parent.remove();
    });
});
