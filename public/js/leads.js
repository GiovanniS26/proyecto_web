const localUrl = "http://localhost:80/proyecto_web/public";

function openDialog(fill) {
    let dialog, form;
    dialog = document.getElementById(`lead_dialog`);
    form = document.getElementById("lead_form");

    document
        .getElementById(`lead_close_dialog`)
        .addEventListener("click", (e) => {
            dialog.style.display = "none";

            document.getElementById("status_id").value = "";
        });

    if (fill) {
        form.action = `${localUrl}/update_leads/${fill.id}`;

        document.getElementById("status_id").value = fill.status_id;
    } else {
        form.action = `${localUrl}/leads`;
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
    createTooltip(document.getElementById("refresh_table_button"));

    document.querySelectorAll("[id=edit_lead]").forEach((button, index) => {
        button.addEventListener("click", () => {
            openDialog(leads.data[index]);
        });
        createTooltip(button);
    });

    document.querySelectorAll("[id=delete_lead]").forEach((button) => {
        createTooltip(button);
    });

    let lead_dialog = document.getElementById("lead_dialog");
    if (lead_dialog && [...lead_dialog.classList].includes("block")) {
        openDialog();
    }
});
