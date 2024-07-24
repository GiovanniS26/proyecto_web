const localUrl = "http://localhost:80/proyecto_web/public";

function openDialog(fill) {
    let dialog, form, checkbox, checkboxContainer;
    dialog = document.getElementById(`user_dialog`);
    document
        .getElementById(`user_close_dialog`)
        .addEventListener("click", (e) => {
            dialog.style.display = "none";
            if (fill) {
                document.getElementById("name").value = "";
                document.getElementById("email").value = "";
                document.getElementById("role_id").value = "";
            }
        });
    form = document.getElementById(`user_form`);
    form.action = fill
        ? `${localUrl}/update_users/${fill.id}`
        : `${localUrl}/users`;
    if (fill) {
        document.getElementById(`name`).value = fill.name;

        document.getElementById("email").value = fill.email;
        document.getElementById("role_id").value = fill.role_id;

        checkboxContainer = document.getElementById("change-password-checkbox");
        checkboxContainer.style.display = "flex";

        checkbox = document.getElementById("change-password");
        checkbox.checked = false;

        document.getElementById("password_container").style.display = "none";
        document.getElementById("confirm_password_container").style.display =
            "none";

        checkbox.addEventListener("change", (e) => {
            if (checkbox.checked) {
                document.getElementById("password_container").style.display =
                    "flex";
                document.getElementById(
                    "confirm_password_container"
                ).style.display = "flex";
            } else {
                document.getElementById("password_container").style.display =
                    "none";
                document.getElementById(
                    "confirm_password_container"
                ).style.display = "none";
                document.getElementById("password").value = "";
                document.getElementById("confirm_password").value = "";
            }
        });
    } else {
        checkboxContainer = document.getElementById("change-password-checkbox");
        checkboxContainer.style.display = "none";
        document.getElementById("password_container").style.display = "flex";
        document.getElementById("confirm_password_container").style.display =
            "flex";
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
        .getElementById(`create_user_button`)
        .addEventListener("click", () => {
            openDialog();
        });

    createTooltip(document.getElementById("refresh_table_button"));

    document.querySelectorAll("[id=edit_user]").forEach((button, index) => {
        button.addEventListener("click", () => {
            openDialog(users.data[index]);
        });
        createTooltip(button);
    });

    document.querySelectorAll("[id=delete_user]").forEach((button, index) => {
        createTooltip(button);
    });

    let user_dialog = document.getElementById("user_dialog");
    if (user_dialog && [...user_dialog.classList].includes("block")) {
        openDialog();
    }
});
