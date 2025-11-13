let dayCount = 0;
const scheduleContainer = document.getElementById('schedule-container');
const addDayBtn = document.getElementById('add-day-btn');

function addDay() {
    dayCount++;
    const dayDiv = document.createElement('div');
    dayDiv.classList.add('border','p-3','mb-2');
    dayDiv.innerHTML = `
        <h5>Ngày ${dayCount} 
            <button type="button" class="btn btn-sm btn-danger remove-day-btn">Xóa</button>
        </h5>
        <div class="mb-2">
            <label>Tiêu đề</label>
            <input type="text" name="schedule[${dayCount}][tieu_de]" class="form-control">
        </div>
        <div class="mb-2">
            <label>Mô tả</label>
            <textarea name="schedule[${dayCount}][mo_ta]" class="form-control" rows="2"></textarea>
        </div>
        <div class="mb-2 activities-container"></div>
        <button type="button" class="btn btn-sm btn-secondary add-activity-btn">+ Thêm hoạt động</button>
    `;
    scheduleContainer.appendChild(dayDiv);

    // Thêm hoạt động
    dayDiv.querySelector('.add-activity-btn').addEventListener('click', () => {
        const container = dayDiv.querySelector('.activities-container');
        const actCount = container.children.length + 1;
        const actDiv = document.createElement('div');
        actDiv.classList.add('border','p-2','mb-2');
        actDiv.innerHTML = `
            <h6>Hoạt động ${actCount} 
                <button type="button" class="btn btn-sm btn-danger remove-activity-btn">Xóa</button>
            </h6>
            <div class="mb-1">
                <label>Thời gian bắt đầu</label>
                <input type="time" name="schedule[${dayCount}][activities][${actCount}][thoi_gian_bat_dau]" class="form-control">
            </div>
            <div class="mb-1">
                <label>Thời gian kết thúc</label>
                <input type="time" name="schedule[${dayCount}][activities][${actCount}][thoi_gian_ket_thuc]" class="form-control">
            </div>
            <div class="mb-1">
                <label>Địa điểm</label>
                <input type="text" name="schedule[${dayCount}][activities][${actCount}][dia_diem]" class="form-control">
            </div>
            <div class="mb-1">
                <label>Hoạt động</label>
                <textarea name="schedule[${dayCount}][activities][${actCount}][hoat_dong]" class="form-control" rows="2"></textarea>
            </div>
            <div class="mb-1">
                <label>Hình ảnh (path)</label>
                <input type="text" name="schedule[${dayCount}][activities][${actCount}][hinh_anh]" class="form-control">
            </div>
        `;
        container.appendChild(actDiv);

        actDiv.querySelector('.remove-activity-btn').addEventListener('click', ()=>actDiv.remove());
    });

    // Xóa ngày
    dayDiv.querySelector('.remove-day-btn').addEventListener('click', ()=>dayDiv.remove());
}

        addDayBtn.addEventListener('click', ()=>addDay());
        let imgCount = 0;
        const imagesContainer = document.getElementById('images-container');
        document.getElementById('add-image-btn').addEventListener('click', ()=>{
            imgCount++;
            const div = document.createElement('div');
            div.classList.add('mb-2');
            div.innerHTML = `
                <input type="text" name="images[]" class="form-control mb-1" placeholder="Đường dẫn hình ảnh">
                <button type="button" class="btn btn-sm btn-danger remove-img-btn">Xóa</button>
            `;
            imagesContainer.appendChild(div);
            div.querySelector('.remove-img-btn').addEventListener('click', ()=> div.remove());
        });
