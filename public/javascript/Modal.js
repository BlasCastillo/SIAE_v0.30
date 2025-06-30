document.addEventListener('DOMContentLoaded', () => {
    const openModalButtons = document.querySelectorAll('.open-modal');
    const closeModalButtons = document.querySelectorAll('.close-modal');

    openModalButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const target = button.getAttribute('data-modal-target');
            const modal = document.getElementById(target);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('show');
            }
        });
    });

    closeModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                const modal = button.closest('.fixed');
                if (modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    });
