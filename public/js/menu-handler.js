document.addEventListener("DOMContentLoaded", function () {
    const menuList = document.getElementById("menu-list");
    const currentPath = window.location.pathname;
    const cachedMenus = sessionStorage.getItem("cachedMenus");
    const currentRole = sessionStorage.getItem("currentRole");
    const spinnerMenu = document.querySelector("#spinner-menu");
    const btnDropdownRole = document.querySelector("#btn-dropdown-role");

    document.querySelectorAll(".select-role").forEach(function (element) {
        element.addEventListener("click", function () {
            const roleName = this.getAttribute("data-role-name");
            btnDropdownRole.textContent = roleName;
            btnDropdownRole.click();

            sessionStorage.setItem("currentRole", roleName);
            fetchingMenu(roleName);
        });
    });

    if (cachedMenus) {
        const menus = JSON.parse(cachedMenus);
        renderMenus(menus, currentPath, menuList);
    } else {
        const defaultRole = btnDropdownRole.getAttribute("data-default-role");
        fetchingMenu(defaultRole == "Tidak ada role" ? null : defaultRole);
    }

    if (currentRole) {
        btnDropdownRole.textContent = currentRole;
        spinnerMenu.classList.replace("block", "hidden");
    }

    function fetchingMenu(roleName = null) {
        spinnerMenu.classList.replace("hidden", "block");
        let url = "/api/menus";
        if (roleName) {
            url = `/api/menus?role=${roleName}`;
        }
        sessionStorage.setItem("currentRole", roleName);
        btnDropdownRole.textContent = roleName;
        fetch(url)
            .then((response) => response.json())
            .then((menus) => {
                if (cachedMenus) {
                    sessionStorage.removeItem("cachedMenus");
                }
                sessionStorage.setItem("cachedMenus", JSON.stringify(menus));
                renderMenus(menus, currentPath, menuList);
            })
            .catch((error) => console.error("Error fetching menus:", error))
            .finally(() => spinnerMenu.classList.replace("block", "hidden"));
    }

    function renderMenus(menus, currentPath, menuList) {
        menuList.innerHTML = "";
        menus.forEach((menu, index) => {
            let isActive = false;
            const paths = currentPath.split("/");

            if (
                (paths[1] === menu.name || currentPath.includes(menu.path)) &&
                menu.path !== "/"
            ) {
                isActive = true;
            } else if (currentPath === "/" && menu.path === "/") {
                isActive = true;
            }

            const activeClass = isActive ? "active-menu" : "";

            if (menu.submenu && menu.submenu.length > 0) {
                menuList.innerHTML += `
                    <li>
                        <button type="button"
                            class="menu flex items-center w-full p-2 text-base text-slate-500 transition duration-75 rounded-lg group hover:bg-slate-100 dark:hover:text-gray-100 dark:text-gray-400 dark:hover:hover:bg-eerie-black group hover:text-slate-700 ${activeClass}"
                            aria-controls="menu-dropdown-${index + 1}"
                            data-collapse-toggle="menu-dropdown-${index + 1}">
                            <i class="${menu.icon} w-5 text-left text-base"></i>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">${
                                menu.label
                            }</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <ul id="menu-dropdown-${
                            index + 1
                        }" class="hidden py-2 space-y-2 ms-4">
                            ${menu.submenu
                                .map((submenu) => {
                                    const submenuPaths =
                                        submenu.path.split("/");
                                    const segments = currentPath
                                        .split("/")
                                        .filter(Boolean);
                                    const lastSegment =
                                        segments[segments.length - 1];
                                    let submenuActiveClass = false;

                                    if (submenuPaths.length > 2) {
                                        submenuActiveClass =
                                            currentPath.startsWith(
                                                submenu.path
                                            );
                                    } else if (submenuPaths.length == 2) {
                                        if (
                                            paths.length > 3 &&
                                            submenuPaths.length > 2
                                        ) {
                                            submenuActiveClass =
                                                currentPath.startsWith(
                                                    submenu.path
                                                );
                                        } else if (/^\d+$/.test(lastSegment)) {
                                            submenuActiveClass =
                                                currentPath.startsWith(
                                                    submenu.path
                                                );
                                        } else {
                                            submenuActiveClass =
                                                submenu.path == currentPath;
                                        }
                                    }

                                    return `
                                    <li>
                                        <a href="${submenu.path}"
                                            class="menu flex items-center ms-6 p-2 text-slate-500 rounded-lg dark:text-gray-400 dark:hover:text-gray-100 hover:bg-slate-100 dark:hover:hover:bg-eerie-black group hover:text-slate-700 text-base ${
                                                submenuActiveClass
                                                    ? "active-menu"
                                                    : ""
                                            }">
                                            ${submenu.label}
                                        </a>
                                    </li>
                                `;
                                })
                                .join("")}
                        </ul>
                    </li>
                `;
            } else {
                menuList.innerHTML += `
                    <li>
                        <a href="${menu.path}"
                            class="menu flex items-center p-2 text-slate-500 rounded-lg dark:text-gray-400 dark:hover:text-gray-100 hover:bg-slate-100 dark:hover:hover:bg-eerie-black group hover:text-slate-700 text-base ${activeClass}">
                            <i class="${menu.icon} text-base w-5 text-left"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">${menu.label}</span>
                        </a>
                    </li>
                `;
            }

            if (isActive) {
                const target = document.getElementById(
                    `menu-dropdown-${index + 1}`
                );
                if (target) {
                    target.classList.toggle("hidden");
                }
            }
        });

        document
            .querySelectorAll("[data-collapse-toggle]")
            .forEach((button) => {
                button.addEventListener("click", () => {
                    const targetId = button.getAttribute("aria-controls");
                    const target = document.getElementById(targetId);
                    target.classList.toggle("hidden");
                });
            });
    }
});
