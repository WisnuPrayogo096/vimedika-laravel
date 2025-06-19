/**
 * Sidebar Menu Manager
 * Handles dynamic menu rendering based on user roles
 */
class SidebarMenuManager {
    constructor() {
        this.menuList = document.getElementById("menu-list");
        this.currentPath = window.location.pathname;
        this.cacheKey = "cachedMenus";
        this.userRoleKey = "userRole";

        this.init();
    }

    init() {
        if (!this.menuList) {
            console.error("Menu list element not found");
            return;
        }

        this.loadMenus();
    }

    /**
     * Load menus from cache or fetch from API
     */
    async loadMenus() {
        try {
            const cachedData = this.getCachedMenus();

            if (cachedData && this.isCacheValid(cachedData)) {
                // console.log("Loading menus from cache");
                this.renderMenus(cachedData.menus);
            } else {
                // console.log("Fetching fresh menus from API");
                await this.fetchMenusFromAPI();
            }
        } catch (error) {
            console.error("Error loading menus:", error);
            this.showErrorMessage();
        }
    }

    /**
     * Get cached menus with validation
     */
    getCachedMenus() {
        try {
            const cachedMenus = sessionStorage.getItem(this.cacheKey);
            const cachedRole = sessionStorage.getItem(this.userRoleKey);

            if (cachedMenus && cachedRole) {
                return {
                    menus: JSON.parse(cachedMenus),
                    userRole: cachedRole,
                    timestamp: sessionStorage.getItem(
                        this.cacheKey + "_timestamp"
                    ),
                };
            }
        } catch (error) {
            console.warn("Error reading cache:", error);
            this.clearCache();
        }
        return null;
    }

    /**
     * Check if cache is still valid (valid for 30 minutes)
     */
    isCacheValid(cachedData) {
        if (!cachedData.timestamp) return false;

        const cacheAge = Date.now() - parseInt(cachedData.timestamp);
        const maxAge = 30 * 60 * 1000; // 30 minutes

        return cacheAge < maxAge;
    }

    /**
     * Fetch menus from API
     */
    async fetchMenusFromAPI() {
        try {
            const response = await fetch("/api/menus", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.message || "Failed to fetch menus");
            }

            // Cache the results
            this.cacheMenus(result.data, result.user_role);

            // Render menus
            this.renderMenus(result.data);

            console.log(`Menus loaded for role: ${result.user_role}`);
        } catch (error) {
            console.error("API fetch error:", error);
            throw error;
        }
    }

    /**
     * Cache menus data
     */
    cacheMenus(menus, userRole) {
        try {
            sessionStorage.setItem(this.cacheKey, JSON.stringify(menus));
            sessionStorage.setItem(this.userRoleKey, userRole);
            sessionStorage.setItem(
                this.cacheKey + "_timestamp",
                Date.now().toString()
            );
        } catch (error) {
            console.warn("Failed to cache menus:", error);
        }
    }

    /**
     * Clear cache
     */
    clearCache() {
        sessionStorage.removeItem(this.cacheKey);
        sessionStorage.removeItem(this.userRoleKey);
        sessionStorage.removeItem(this.cacheKey + "_timestamp");
    }

    /**
     * Render menus in the sidebar
     */
    renderMenus(menus) {
        if (!Array.isArray(menus) || menus.length === 0) {
            this.showNoMenusMessage();
            return;
        }

        this.menuList.innerHTML = "";

        menus.forEach((menu, index) => {
            const menuItem = this.createMenuItem(menu, index);
            this.menuList.appendChild(menuItem);
        });

        this.attachEventListeners();
    }

    /**
     * Create a single menu item
     */
    createMenuItem(menu, index) {
        const li = document.createElement("li");
        const isActive = this.isMenuActive(menu);

        if (menu.submenu && menu.submenu.length > 0) {
            li.innerHTML = this.createParentMenuItem(menu, index, isActive);
        } else {
            li.innerHTML = this.createSimpleMenuItem(menu, isActive);
        }

        return li;
    }

    /**
     * Check if menu is active based on current path
     */
    isMenuActive(menu) {
        const paths = this.currentPath.split("/");

        if (this.currentPath === "/" && menu.path === "/") {
            return true;
        }

        if (
            menu.path !== "/" &&
            (paths[1] === menu.name || this.currentPath.includes(menu.path))
        ) {
            return true;
        }

        return false;
    }

    /**
     * Create parent menu item with submenu
     */
    createParentMenuItem(menu, index, isActive) {
        const activeClass = isActive ? "active-menu" : "";
        const chevronIcon = isActive
            ? "fa-solid fa-chevron-down"
            : "fa-solid fa-chevron-left";
        const submenuVisible = isActive ? "" : "hidden";

        return `
            <button type="button"
                class="menu flex items-center w-full p-2 text-base text-white transition duration-75 rounded-lg group hover:bg-slate-100 dark:hover:text-gray-100 dark:text-gray-400 dark:hover:hover:bg-eerie-black group hover:text-slate-700 ${activeClass}"
                aria-controls="menu-dropdown-${index + 1}"
                data-collapse-toggle="menu-dropdown-${index + 1}">
                <i class="${
                    menu.icon
                } w-5 text-left text-base" aria-hidden="true"></i>
                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">${
                    menu.label
                }</span>
                <i class="${chevronIcon}" aria-hidden="true"></i>
            </button>
            <ul id="menu-dropdown-${
                index + 1
            }" class="${submenuVisible} py-2 space-y-2 ms-4">
                ${this.createSubmenuItems(menu.submenu)}
            </ul>
        `;
    }

    /**
     * Create submenu items
     */
    createSubmenuItems(submenu) {
        return submenu
            .map((item) => {
                const isSubmenuActive = this.isSubmenuActive(item);
                const activeClass = isSubmenuActive ? "active-menu" : "";

                return `
                <li>
                    <a href="${item.path}"
                        class="menu flex items-center ms-6 p-2 text-white rounded-lg dark:text-gray-400 dark:hover:text-gray-100 hover:bg-slate-100 dark:hover:hover:bg-eerie-black group hover:text-slate-700 text-base ${activeClass}">
                        ${item.label}
                    </a>
                </li>
            `;
            })
            .join("");
    }

    /**
     * Check if submenu is active
     */
    isSubmenuActive(submenu) {
        const submenuPaths = submenu.path.split("/");
        const currentPaths = this.currentPath.split("/").filter(Boolean);
        const lastSegment = currentPaths[currentPaths.length - 1];

        // Handle different path structures
        if (submenuPaths.length > 2) {
            return this.currentPath.startsWith(submenu.path);
        }

        if (submenuPaths.length === 2) {
            // Check if last segment is numeric (like ID)
            if (/^\d+$/.test(lastSegment)) {
                return this.currentPath.startsWith(submenu.path);
            }
            return submenu.path === this.currentPath;
        }

        return false;
    }

    /**
     * Create simple menu item without submenu
     */
    createSimpleMenuItem(menu, isActive) {
        const activeClass = isActive ? "active-menu" : "";

        return `
            <a href="${menu.path}"
                class="menu flex items-center p-2 text-white rounded-lg dark:text-gray-400 dark:hover:text-gray-100 hover:bg-slate-100 dark:hover:hover:bg-eerie-black group hover:text-slate-700 text-base ${activeClass}">
                <i class="${menu.icon} text-base w-5 text-left" aria-hidden="true"></i>
                <span class="flex-1 ms-3 whitespace-nowrap">${menu.label}</span>
            </a>
        `;
    }

    /**
     * Attach event listeners for dropdown toggles
     */
    attachEventListeners() {
        document
            .querySelectorAll("[data-collapse-toggle]")
            .forEach((button) => {
                button.addEventListener("click", (e) => {
                    e.preventDefault();
                    this.toggleDropdown(button);
                });
            });
    }

    /**
     * Toggle dropdown menu
     */
    toggleDropdown(button) {
        const targetId = button.getAttribute("aria-controls");
        const target = document.getElementById(targetId);
        const chevronIcon = button.querySelector("i:last-child");

        if (!target || !chevronIcon) return;

        target.classList.toggle("hidden");

        // Update chevron icon
        if (target.classList.contains("hidden")) {
            chevronIcon.className = "fa-solid fa-chevron-left";
        } else {
            chevronIcon.className = "fa-solid fa-chevron-down";
        }
    }

    /**
     * Show error message when menu loading fails
     */
    showErrorMessage() {
        this.menuList.innerHTML = `
            <li class="p-4 text-center text-red-500">
                <i class="fa-solid fa-exclamation-triangle mb-2"></i>
                <p>Failed to load menu</p>
                <button onclick="location.reload()" class="text-sm text-blue-500 underline mt-2">
                    Retry
                </button>
            </li>
        `;
    }

    /**
     * Show message when no menus are available
     */
    showNoMenusMessage() {
        this.menuList.innerHTML = `
            <li class="p-4 text-center text-gray-500">
                <i class="fa-solid fa-info-circle mb-2"></i>
                <p>No menus available</p>
            </li>
        `;
    }

    /**
     * Refresh menus (useful for role changes)
     */
    async refreshMenus() {
        this.clearCache();
        await this.loadMenus();
    }

    /**
     * Get current user role
     */
    getCurrentUserRole() {
        return sessionStorage.getItem(this.userRoleKey) || "guest";
    }
}

// Utility functions for external use
window.SidebarUtils = {
    refreshMenus: () => {
        if (window.sidebarMenuManager) {
            window.sidebarMenuManager.refreshMenus();
        }
    },

    getCurrentRole: () => {
        if (window.sidebarMenuManager) {
            return window.sidebarMenuManager.getCurrentUserRole();
        }
        return "guest";
    },

    clearMenuCache: () => {
        if (window.sidebarMenuManager) {
            window.sidebarMenuManager.clearCache();
        }
    },
};

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
    window.sidebarMenuManager = new SidebarMenuManager();
});

// Handle page visibility changes to refresh stale data
document.addEventListener("visibilitychange", function () {
    if (!document.hidden && window.sidebarMenuManager) {
        const cachedData = window.sidebarMenuManager.getCachedMenus();
        if (cachedData && !window.sidebarMenuManager.isCacheValid(cachedData)) {
            // console.log("Refreshing stale menu data");
            window.sidebarMenuManager.refreshMenus();
        }
    }
});
