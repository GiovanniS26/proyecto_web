function checkWhiteSpaces(value) {
    if (value.includes(" ")) {
        return true;
    }
    return false;
}

/**
 * Función para verificar que la contraseña sea valiada e igual a su confirmación
 * esta función se usa para crear un usuario o para actualizarlo
 */
function registerFormAction() {
    let registerForm = document.getElementById("register_form") ? document.getElementById("register_form") : document.getElementById("users_form");
    if (registerForm) {
        registerForm.addEventListener("submit", function (event) {
            event.preventDefault();
    
            const passwordError = document.getElementById("password_minlength_error");
            passwordError.style.display = "none";
            passwordError.textContent = "";
    
            const passwordMatchError = document.getElementById("password_match_error");
            passwordMatchError.style.display = "none";
            passwordMatchError.textContent = "";
    
            const password = document.getElementById("password").value;
            const confirmPassword =
                document.getElementById("confirm_password").value;
    
            hasWhiteSpaces = checkWhiteSpaces(password);
    
            if (
                password.length < 8 ||
                password !== confirmPassword ||
                hasWhiteSpaces
            ) {
                if (password.length < 8) {
                    passwordError.textContent = "La contraseña debe tener al menos 8 caracteres.";
                    passwordError.style.display = "block";
                }
    
                if (password !== confirmPassword) {
                    passwordMatchError.textContent = "Las contraseñas deben coincidir.";
                    passwordMatchError.style.display = "block";
                }
    
                if (hasWhiteSpaces) {
                    passwordMatchError.textContent = "La contraseña no puede tener espacios.";
                    passwordMatchError.style.display = "block";
                }
            } else {
                this.submit();
            }
        });
    }    
}

registerFormAction();

