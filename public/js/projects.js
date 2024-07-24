const localUrl = "http://localhost:80/proyecto_laravel/public";

function openDialog(fill) {
    let dialog, form;
    dialog = document.getElementById(`project_dialog`);
    form = document.getElementById("project_form");

    document
        .getElementById(`project_close_dialog`)
        .addEventListener("click", (e) => {
            dialog.style.display = "none";
            document.getElementById("title").value = "";
            document.getElementById("description").value = "";
            document.getElementById("status").value = "";
            document.getElementById("start_date").value = "";
            document.getElementById("end_date").value = "";
            const membersCheckboxes = document.querySelectorAll(
                'input[name="members[]"]'
            );
            membersCheckboxes.forEach((checkbox) => {
                checkbox.checked = false;
            });
        });

    if (fill) {
        fetch(`${localUrl}/projects/${fill.id}/members`)
            .then((response) => response.json())
            .then((data) => {
                // Marcar los checkboxes correspondientes a los usuarios asignados
                const membersCheckboxes = document.querySelectorAll(
                    'input[name="members[]"]'
                );
                membersCheckboxes.forEach((checkbox) => {
                    checkbox.checked = data.assignedUsers.includes(
                        parseInt(checkbox.value)
                    );
                });
            });

        form.action = `${localUrl}/update_projects/${fill.id}`;
        document.getElementById("title").value = fill.title;
        document.getElementById("description").value = fill.description;
        document.getElementById("status").value = fill.status;
        document.getElementById("start_date").value = fill.start_date;
        document.getElementById("end_date").value = fill.end_date;
    } else {
        form.action = `${localUrl}/projects`;
    }

    dialog.style.display = "block";
}

function filtrarUsers() {
    const searchInput = document.getElementById("searchMembers");
    const membersList = document.getElementById("membersList");
    const checkboxes = membersList.getElementsByClassName("form-check");

    searchInput.addEventListener("keyup", function () {
        const filter = searchInput.value.toLowerCase();

        for (let i = 0; i < checkboxes.length; i++) {
            const checkbox = checkboxes[i];
            const label = checkbox.getElementsByTagName("label")[0];
            const text = label.textContent.toLowerCase();

            if (text.includes(filter)) {
                checkbox.style.display = "";
            } else {
                checkbox.style.display = "none";
            }
        }
    });
}

function createTooltip(button) {
    button.addEventListener("mouseover", function () {
        // Crear el elemento tooltip
        let tooltip = document.createElement("span");
        tooltip.innerText = button.getAttribute("label");
        tooltip.className += "p-2 bg-gray-700 text-white rounded absolute z-10";

        // Posicionar el tooltip
        const rect = button.getBoundingClientRect();
        tooltip.style.top = `${rect.top - 50}px`;
        tooltip.style.left = `${rect.left}px`;

        // Agregar el tooltip al botón
        document.body.appendChild(tooltip);

        // Eliminar el tooltip cuando el cursor ya no esté sobre el botón
        button.addEventListener(
            "mouseout",
            function () {
                tooltip.remove();
            },
            { once: true }
        );
    });
}

document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById(`create_project_button`)
        .addEventListener("click", () => {
            openDialog();
        });

    createTooltip(document.getElementById("refresh_table_button"));

    document.querySelectorAll("[name=edit_button]").forEach((button, index) => {
        button.addEventListener("click", () => {
            openDialog(projects.data[index]);
        });
        createTooltip(button);
    });

    document
        .querySelectorAll("[id=delete_project]")
        .forEach((button) => {
            createTooltip(button);
        });

    document
        .querySelectorAll("[id=status_project]")
        .forEach((button) => {
            createTooltip(button);
        });

    let project_dialog = document.getElementById("project_dialog");
    if (project_dialog && [...project_dialog.classList].includes("block")) {
        openDialog();
    }

    filtrarUsers();
});
