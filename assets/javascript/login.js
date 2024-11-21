const toggleButtons = document.querySelectorAll('.toggle-btn');
const formBoxes = document.querySelectorAll('.form-box');

toggleButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Remove active class from all buttons
        toggleButtons.forEach(btn => btn.classList.remove('active'));
        // Add active class to the clicked button
        button.classList.add('active');

        // Hide all forms
        formBoxes.forEach(form => form.classList.remove('active'));

        // Show the target form
        const target = button.getAttribute('data-target');
        document.querySelector(`.form-box.${target}`).classList.add('active');
    });
});