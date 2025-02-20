document.addEventListener("DOMContentLoaded", function () {
    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-role-btn")) {
            const userId = event.target.getAttribute("data-user-id");
            const roleId = event.target.getAttribute("data-role-id");
            removeRole(userId, roleId);
        }
    });
    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("add-role-btn")) {
            const userId = event.target.getAttribute("data-user-id");
            addRole(userId);
        }
    });
    document.getElementById("exampleModal").addEventListener("show.bs.modal", function(event) {
        
        const roleId = event.relatedTarget.getAttribute("data-role-id");        
        const roleName = event.relatedTarget.getAttribute("data-role-name");
        const roleDescription = event.relatedTarget.getAttribute("data-role-description");

        document.getElementById("modifyRoleForm").action = "/administracion/roles/" + roleId;
        document.getElementById("roleName").value = roleName;
        document.getElementById("roleDescription").value = roleDescription;
    });

    document.getElementById("deleteModal").addEventListener("show.bs.modal", function(event) {
        document.getElementById("deleteForm").action = "/administracion/roles/" + event.relatedTarget.getAttribute("data-role-id");
    });
});

function removeRole(userId, roleId) {
    fetch(`/usuarios/${userId}/roles/${roleId}/eliminar`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                document.getElementById(`role-${userId}-${roleId}`).remove();
            }
        })
        .catch((error) => console.error("Error:", error));
}

function addRole(userId) {
    const roleId = document.getElementById(`new-role-${userId}`).value;

    fetch(`/usuarios/${userId}/roles/agregar`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ role_id: roleId }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                const rolesList = document.getElementById(`roles-list-${userId}`);
                const newRoleItem = document.createElement("li");
                newRoleItem.id = `role-${userId}-${data.role.id}`;
                newRoleItem.innerHTML = `
                    ${data.role.name}
                    <button class="remove-role-btn" data-user-id="${userId}" data-role-id="${data.role.id}">❌</button>
                `;
                rolesList.appendChild(newRoleItem);
            }
        })
        .catch((error) => console.error("Error:", error));



}
