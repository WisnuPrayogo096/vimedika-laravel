document.addEventListener("DOMContentLoaded", function () {
    const searchButton = document.querySelector("#search-button");
    const searchMenuInput = document.querySelector("#search-menu");
    const existingMenuList = document.querySelector("#existing-menu-list");
    const searchModalElement = document.querySelector("#search-menu-modal");
    const searchModal = new Modal(searchModalElement);
    const menus = [];

    if (searchButton && searchModal) {
        searchButton.addEventListener("click", function () {
            searchModal.show();
            if (searchMenuInput) {
                searchMenuInput.focus();
            }
        });
    }

    if (searchMenuInput) {
        searchMenuInput.addEventListener("input", function (e) {
            const searchValue = e.target.value.toLowerCase();
            let filteredMenus = [];

            if (searchValue !== "" && searchValue !== null) {
                filteredMenus = menus.filter((menu) =>
                    menu.label.toLowerCase().includes(searchValue)
                );
            } else {
                filteredMenus = menus.slice(0, 3);
            }

            renderMenus(filteredMenus);
        });
    }

    function initialMenus() {
        const firstRenderMenus = menus.slice(0, 3);
        renderMenus(firstRenderMenus);
    }

    function renderMenus(menusToRender) {
        if (!existingMenuList) return;

        let menuList = "";

        if (menusToRender?.length > 0) {
            menuList = menusToRender
                .map(
                    (menu) => `
                        <li>
                            <a href="${menu.path}" class="w-full flex justify-start gap-4 my-3 items-center px-4 py-2.5 bg-blue-50/40 rounded-md dark:bg-eerie-black dark:border dark:border-gray-700">  
                                <span class="block">${menu.label}</span>
                            </a>
                        </li>
                    `
                )
                .join("");
        }

        existingMenuList.innerHTML = `<ul>${menuList}</ul>`;
    }

    function getExistingLinkMenu() {
        const cachedMenus = sessionStorage.getItem("cachedMenus");
        if (cachedMenus) {
            const jsonMenus = JSON.parse(cachedMenus);
            jsonMenus.forEach((menu) => {
                if (menu?.submenu && menu?.submenu.length === 0) {
                    menus.push(menu);
                } else if (menu?.submenu && menu?.submenu.length > 0) {
                    menu.submenu.forEach((sub) => {
                        menus.push(sub);
                    });
                }
            });
            initialMenus();
        }
    }

    getExistingLinkMenu();

    document.addEventListener("keydown", function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === "m") {
            searchModal.show();
            if (searchMenuInput) {
                searchMenuInput.focus();
            }
        }
    });
});
