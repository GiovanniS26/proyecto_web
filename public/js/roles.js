const localUrl = "http://localhost:80/proyecto_laravel/public";

function openDialog(fill) {
    let dialog, form;
    dialog = document.getElementById(`role_dialog`);
    document
        .getElementById(`role_close_dialog`)
        .addEventListener("click", (e) => {
            dialog.style.display = "none";
            if (fill) {
                document.getElementById("name").value = "";
            }
        });
    form = document.getElementById(`role_form`);
    form.action = fill
        ? `${localUrl}/update_roles/${fill.id}`
        : `${localUrl}/roles`;
    if (fill) {
        document.getElementById(`name`).value = fill.name;
    }

    dialog.style.display = "block";
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
        .getElementById(`create_role_button`)
        .addEventListener("click", () => {
            openDialog();
        });

    createTooltip(document.getElementById("refresh_table_button"));

    document.querySelectorAll("[id=edit_role]").forEach((button, index) => {
        button.addEventListener("click", () => {
            openDialog(roles.data[index]);
        });
        createTooltip(button);
    });

    document.querySelectorAll("[id=delete_role]").forEach((button, index) => {
        createTooltip(button);
    });

    let role_dialog = document.getElementById("role_dialog");
    if (role_dialog && [...role_dialog.classList].includes("block")) {
        openDialog();
    }
});
