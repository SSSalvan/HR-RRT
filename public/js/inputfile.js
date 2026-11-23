// Custom file input styling and functionality
document.addEventListener('DOMContentLoaded', function() {
    // Handle file input labels
    const fileInputs = document.querySelectorAll('input[type="file"]');

    fileInputs.forEach(function(input) {
        input.addEventListener('change', function(e) {
            const fileName = e.target.value.split('\\').pop();
            const label = input.nextElementSibling;
            if (label && label.classList.contains('custom-file-label')) {
                label.textContent = fileName || 'Choose file';
            }
        });
    });
});
