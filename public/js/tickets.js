const localUrl = "http://localhost:80/proyecto_web/public";

function openDialog(fill) {
    let dialog, form;
    dialog = document.getElementById(`ticket_dialog`);
    form = document.getElementById("ticket_form");

    document
        .getElementById(`ticket_close_dialog`)
        .addEventListener("click", (e) => {
            dialog.style.display = "none";
            document.getElementById("subject").value = "";
            document.getElementById("description").value = "";
            document.getElementById("status").value = "";
            const membersCheckboxes = document.querySelectorAll(
                'input[name="user_id"]'
            );
            membersCheckboxes.forEach((checkbox) => {
                checkbox.checked = false;
            });
        });

    if (fill) {
        // Marcar los checkboxes correspondientes a los usuarios asignados
        const membersCheckboxes = document.querySelectorAll(
            'input[name="user_id"]'
        );
        membersCheckboxes.forEach((checkbox) => {
            checkbox.checked = fill.user_id === parseInt(checkbox.value);
        });

        form.action = `${localUrl}/update_tickets/${fill.id}`;
        document.getElementById("subject").value = fill.subject;
        document.getElementById("description").value = fill.description;
        document.getElementById("status").value = fill.status;
    } else {
        form.action = `${localUrl}/tickets`;
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
        .getElementById(`create_ticket_button`)
        .addEventListener("click", () => {
            openDialog();
        });

    createTooltip(document.getElementById("refresh_table_button"));

    document.querySelectorAll("[id=edit_ticket]").forEach((button, index) => {
        button.addEventListener("click", (button) => {
            openDialog(tickets.data[index]);
        });
        createTooltip(button);
    });

    document.querySelectorAll("[id=delete_ticket]").forEach((button, index) => {
        createTooltip(button);
    });

    document
        .querySelectorAll("[id=resolve_ticket]")
        .forEach((button, index) => {
            createTooltip(button);
        });

    document.querySelectorAll("[id=close_ticket]").forEach((button, index) => {
        createTooltip(button);
    });

    let ticket_dialog = document.getElementById("ticket_dialog");
    if (ticket_dialog && [...ticket_dialog.classList].includes("block")) {
        openDialog();
    }

    filtrarUsers();
});
