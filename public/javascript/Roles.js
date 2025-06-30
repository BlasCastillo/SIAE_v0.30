document.addEventListener('DOMContentLoaded', function() {
    const categoryLinks = document.querySelectorAll('.custom-category-link');

    categoryLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const category = this.dataset.category;

            // Ocultar todos los contenedores
            const permissionContainers = document.querySelectorAll('.permissions-container');
            permissionContainers.forEach(container => {
                container.classList.add('hide');
                container.classList.remove('show');
            });

            // Mostrar el contenedor seleccionado
            document.getElementById(category).classList.add('show');
            document.getElementById(category).classList.remove('hide');

            // Actualizar enlaces activos
            categoryLinks.forEach(link => {
                link.classList.remove('active');
                link.classList.remove('warning-state');
                if (!link.classList.contains('validating-state')) {
                    if (link.classList.contains('active-permission-category')) {
                        link.classList.add('active-permission-category');
                    } else {
                        link.classList.add('inactive-permission-category');
                    }
                }
            });

            this.classList.add('active');
            this.classList.remove('active-permission-category');
            this.classList.remove('inactive-permission-category');
            this.classList.add('warning-state'); // Agregar estado de warning

            // Cambiar icono a warning si es la vista de edición
            if (this.classList.contains('edit-category-link')) {
                const warningIcon = document.getElementById(category).querySelector('.warning-icon');
                if (warningIcon) {
                    warningIcon.style.display = 'block';
                }
            }
        });
    });

    // Al cargar la página, mostrar solo la primera categoría
    const firstCategoryLink = categoryLinks[0];
    if (firstCategoryLink) {
        const firstCategory = firstCategoryLink.dataset.category;
        document.getElementById(firstCategory).classList.add('show');
        firstCategoryLink.classList.add('active');
    }

    // Cambiar a estado de validación cuando se editen permisos
    const permissionContainers = document.querySelectorAll('.permissions-container');
    permissionContainers.forEach(container => {
        container.addEventListener('change', function(event) {
            const categoryLink = document.querySelector(`.custom-category-link[data-category="${container.id}"]`);
            if (categoryLink) {
                const checkboxes = container.querySelectorAll('input[type="checkbox"]');
                let hasChecked = false;
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        hasChecked = true;
                    }
                });

                if (hasChecked) {
                    categoryLink.classList.remove('warning-state');
                    categoryLink.classList.add('validating-state');
                    categoryLink.innerHTML = categoryLink.textContent + ' <i class="bi bi-clock"></i>';
                } else {
                    categoryLink.classList.remove('warning-state');
                    categoryLink.classList.remove('validating-state');
                    categoryLink.classList.add('inactive-permission-category');
                    categoryLink.innerHTML = categoryLink.textContent + ' <i class="bi bi-clock"></i>';
                }
            }
        });
    });
});
