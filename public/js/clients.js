const localUrl = "http://localhost:80/proyecto_web/public";

function openDialog(fill) {
    let dialog, form;
    dialog = document.getElementById(`client_dialog`);
    form = document.getElementById("client_form");

    document
        .getElementById(`client_close_dialog`)
        .addEventListener("click", (e) => {
            dialog.style.display = "none";
            if (fill) {
                document.getElementById("name").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phone").value = "";
                document.getElementById("address").value = "";
                document.getElementById("type").value = "";
                document.getElementById("birthdate").value = "";
            }
        });

    if (fill) {
        form.action = `${localUrl}/update_clients/${fill.id}`;
        document.getElementById("name").value = fill.name;
        document.getElementById("email").value = fill.email;
        document.getElementById("phone").value = fill.phone;
        document.getElementById("address").value = fill.address;
        document.getElementById("type").value = fill.type;
        document.getElementById("birthdate").value = fill.birthdate;
    } else {
        form.action = `${localUrl}/clients`;
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
        .getElementById(`create_client_button`)
        .addEventListener("click", () => {
            openDialog();
        });

    createTooltip(document.getElementById("refresh_table_button"));

    document.querySelectorAll("[id=edit_client]").forEach((button, index) => {
        button.addEventListener("click", (button) => {
            openDialog(clients.data[index]);
        });
        createTooltip(button);
    });

    document.querySelectorAll("[id=delete_client]").forEach((button, index) => {
        createTooltip(button);
    });

    let client_dialog = document.getElementById("client_dialog");
    if (client_dialog && [...client_dialog.classList].includes("block")) {
        openDialog();
    }
});
