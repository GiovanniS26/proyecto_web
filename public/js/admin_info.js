const localUrl="http://localhost:80/proyecto_web/public"

// Función para convertir cadenas de texto en formato snake_case a formato Title Case.
function snakeToTitleCase(snakeStr) {
    return snakeStr
        .split('_') // Divide la cadena en palabras utilizando el guion bajo como separador.
        .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()) // Convierte la primera letra de cada palabra en mayúscula y el resto en minúsculas.
        .join(' '); // Une las palabras con un espacio entre ellas.
}

// Función para realizar solicitudes HTTP.
function makeRequest(method, url, callback, action) {
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Obtiene el token CSRF del contenido de la metaetiqueta.
    
    var xhr = new XMLHttpRequest(); // Crea un nuevo objeto XMLHttpRequest.
    xhr.open(method, url); // Inicializa la solicitud con el método y URL dados.
    xhr.setRequestHeader('Content-Type', 'application/json'); // Establece la cabecera de tipo de contenido a JSON.
    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken); // Añade el token CSRF a la solicitud para protección contra CSRF.
    
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            callback(JSON.parse(xhr.response), action); // Llama al callback con la respuesta parseada como JSON si la solicitud es exitosa.
        } else {
            callback(null, action); // Llama al callback con null en caso de error.
        }
    };
    xhr.send(JSON.stringify({key: 'value'})); // Envía la solicitud con datos en formato JSON.
}

// Define la función load_info que acepta dos parámetros: response y action.
function load_info(response, action) {
    // Verifica si la respuesta contiene datos y tiene longitud.
    if (response && response.length) {
        let table, tr, td, button;

        // Obtiene la tabla basada en el tipo de acción, asumiendo que cada acción tiene su propia tabla con un id único.
        table = document.getElementById(`${action}_table`);

        // Crea un elemento <tr> (fila de tabla).
        tr = document.createElement('tr');

        // Itera sobre las claves del primer objeto en el array de respuesta para crear los encabezados de la tabla.
        // Excluye la columna 'email_verified_at' de ser creada.
        Object.keys(response[0]).forEach(key => {
            if (key !== 'email_verified_at') {
                td = document.createElement('td');
                td.className += 'first:rounded-l px-4 py-2 bg-red-500 text-white';
                td.innerText = snakeToTitleCase(key); // Convierte el nombre de la clave de formato snake_case a Title Case.
                tr.appendChild(td);
            }
        });
        td = document.createElement('td');
        td.className += 'bg-red-500 text-white rounded-r px-4 py-2';
        tr.appendChild(td);

        // Añade la fila de encabezado a la tabla.
        table.appendChild(tr);

        // Itera sobre cada objeto en el array de respuesta para llenar la tabla con datos.
        response.forEach(element => {
            tr = document.createElement('tr');
            tr.className += 'border-b border-gray-300 p-4 bg-gray-100 relative';

            // Itera sobre cada clave de los objetos para crear las celdas de la tabla.
            Object.keys(element).forEach(key => {
                if (action === 'users' && key !== 'email_verified_at') {
                    if (key === 'created_at' || key === 'updated_at') {
                        element[key] = new Date(element[key]).toLocaleDateString();
                    } else if (key === 'role_id') {
                        element[key] = element[key];
                    }
                    td = document.createElement('td');
                    td.className += 'p-4 bg-white';
                    td.innerText = element[key];
                    tr.appendChild(td);
                } else if (action === 'roles') {
                    td = document.createElement('td');
                    td.className += 'p-4 bg-white';
                    td.innerText = element[key];
                    tr.appendChild(td);
                }
            });

            td = document.createElement('td');
            td.className += 'flex items-center gap-4 p-4 bg-white rounded-r';

            // Crea un botón con un ícono SVG para abrir modo edición.
            button = createButtonWithSVG(action, element, 'yellow', 'M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z');
            button.addEventListener('click', () => {
                openDialog(action, element);
            });
            td.appendChild(button);
            tr.appendChild(td);

            // Crea otro botón para realizar una solicitud POST para eliminar un elemento.
            button = createButtonWithSVG(action, element, 'red', 'M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z');
            button.addEventListener('click', () => {
                makeRequest('POST', `${localUrl}/destroy_${action}/${element.id}`, deleteInfo, action);
            });
            td.appendChild(button);
            tr.appendChild(td);

            // Agrega la fila completa a la tabla.
            table.appendChild(tr);
        });

        // Si la acción es 'roles', actualiza un elemento select con opciones basadas en la respuesta.
        if (action === 'roles') {
            let role_select = document.getElementById("role_id");
            if (role_select) {
                response.forEach(element => {
                    let option = document.createElement('option');
                    option.innerText = element.name;
                    option.value = element.id;
                    role_select.appendChild(option);
                });
            }
        }
    }
};

// Función auxiliar para crear un botón con un ícono SVG.
function createButtonWithSVG(action, element, bgColor, svgPath) {
    let button = document.createElement('button');
    button.id = `${action}_action_${element.id}`;
    button.className += `inline-flex w-full justify-center rounded-md bg-${bgColor}-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-${bgColor}-600 sm:w-auto disabled:bg-gray-500`;

    let svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    let path = document.createElementNS("http://www.w3.org/2000/svg", 'path');
    svg.setAttributeNS(null, 'viewBox', '0 -960 960 960');
    svg.setAttributeNS(null, 'width', '24px');
    svg.setAttributeNS(null, 'height', '24px');
    path.setAttribute('d', svgPath);
    path.setAttribute('fill', 'white');
    svg.appendChild(path);
    button.appendChild(svg);

    return button;
}


function openDialog(action, fill) {
    let dialog, form, checkbox, checkboxContainer;
    dialog = document.getElementById(`edit_${action}_dialog`);
    document.getElementById(`${action}_close_dialog`).addEventListener('click', (e) => {
        dialog.style.display = 'none';
        if (fill) {
            document.getElementById(`name_${action}`).value = '';
            if (action === 'users') {
                document.getElementById("email").value = '';
                document.getElementById("role_id").value = '';
            }
        }
    });
    form = document.getElementById(`${action}_form`);
    form.action = fill ? `${localUrl}/update_${action}/${fill.id}` : `${localUrl}/${action}`;
    if (fill) {
        document.getElementById(`name_${action}`).value = fill.name;
        if (action === 'users') {
            document.getElementById("email").value = fill.email;
            document.getElementById("role_id").value = fill.role_id;

            checkboxContainer = document.getElementById("change-password-checkbox");
            checkboxContainer.style.display = 'flex';

            checkbox = document.getElementById("change-password");
            checkbox.checked = false;

            document.getElementById('password_container').style.display = 'none';
            document.getElementById('confirm_password_container').style.display = 'none';

            checkbox.addEventListener('change', (e) => {
                if (checkbox.checked) {
                    document.getElementById('password_container').style.display = 'flex';
                    document.getElementById('confirm_password_container').style.display = 'flex';
                } else {
                    document.getElementById('password_container').style.display = 'none';
                    document.getElementById('confirm_password_container').style.display = 'none';
                    document.getElementById('password').value = '';
                    document.getElementById('confirm_password').value = '';
                }
            });
        }
    } else if (action === 'users') {
        checkboxContainer = document.getElementById("change-password-checkbox");
        checkboxContainer.style.display = 'none';
        document.getElementById('password_container').style.display = 'flex';
        document.getElementById('confirm_password_container').style.display = 'flex';
    }
    
    dialog.style.display = 'block';
}

function deleteInfo(response, action) {
    let responseContainer = document.getElementById('response-message');
    let responseMessage = document.createElement('span');

    responseMessage.className += 'text-red-500 text-4xl text-center';
    responseMessage.innerText = response.message;

    responseContainer.appendChild(responseMessage);
    setTimeout(() => {
        responseContainer.removeChild(responseMessage);
    }, 5000);
    if (response.success) {
        refreshTable(action);
    } else {

    }
}

function refreshTable(action) {
    let table = document.getElementById(`${action}_table`);
    table.innerHTML = '';
    makeRequest('GET', `${localUrl}/${action}`, load_info, action);
}

function setRefreshButton(action) {
    document.getElementById(`refresh_${action}_button`).addEventListener('click', function () {
        let button = this;
        button.disabled = true;
        
        refreshTable(action);

        setTimeout(function() {
            button.disabled = false;
        }, 1000);
    });
    
    document.getElementById(`create_${action}_button`).addEventListener('click', () => {
        openDialog(action);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    makeRequest('GET', `${localUrl}/users`, load_info, 'users');
    makeRequest('GET', `${localUrl}/roles`, load_info, 'roles');

    setRefreshButton('users');
    setRefreshButton('roles');

    let users_dialog = document.getElementById('edit_users_dialog');
    let roles_dialog = document.getElementById('edit_roles_dialog');
    if (users_dialog && [...users_dialog.classList].includes('block')) {
        openDialog('users');
    } else if (roles_dialog && [...roles_dialog.classList].includes('block')) {
        openDialog('roles');
    }
});