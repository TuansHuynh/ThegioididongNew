
const toggleButtons = document.querySelectorAll('.toggle-btn');
const formBoxes = document.querySelectorAll('.form-box');

// Lặp qua từng nút chuyển đổi
toggleButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Xóa class 'active' khỏi tất cả nút
        toggleButtons.forEach(btn => btn.classList.remove('active'));
        // Thêm class 'active' vào nút được click
        button.classList.add('active');

        // Ẩn tất cả các form
        formBoxes.forEach(form => form.classList.remove('active'));

        // Hiển thị form mục tiêu
        const target = button.getAttribute('data-target');
        const targetForm = document.querySelector(`.form-box.${target}`);

        if (targetForm) {
            targetForm.classList.add('active');
        } else {
            console.error(`Không tìm thấy form nào với class .form-box.${target}`);
        }
    });
});