class NavbarProfileManager {
    constructor() {
        this.profileCacheKey = "userProfile";
        this.cacheDuration = 15 * 60 * 1000;

        this.profileNameElement = document.querySelector(".profile_name");
        this.emailElement = document.querySelector(".email");
        this.roleElement = document.querySelector(".otoritas");
        this.avatarElement = document.querySelector(
            '[data-dropdown-toggle="dropdown-user"] span.block'
        );

        this.init();
    }

    init() {
        this.loadProfileData();
    }

    async loadProfileData() {
        try {
            const cachedProfile = this.getCachedProfile();

            if (cachedProfile && this.isCacheValid(cachedProfile)) {
                console.log("Loading profile from cache");
                this.updateProfileDisplay(cachedProfile.data);
            } else {
                console.log("Fetching fresh profile data from API");
                await this.fetchProfileFromAPI();
            }
        } catch (error) {
            console.error("Error loading profile:", error);
            this.showDefaultProfile();
        }
    }

    /**
     * Get cached profile data
     */
    getCachedProfile() {
        try {
            const cached = sessionStorage.getItem(this.profileCacheKey);
            return cached ? JSON.parse(cached) : null;
        } catch (error) {
            console.warn("Error reading profile cache:", error);
            this.clearProfileCache();
            return null;
        }
    }

    /**
     * Check if cache is still valid
     */
    isCacheValid(cachedProfile) {
        if (!cachedProfile.timestamp) return false;

        const cacheAge = Date.now() - cachedProfile.timestamp;
        return cacheAge < this.cacheDuration;
    }

    /**
     * Fetch profile data from API
     */
    async fetchProfileFromAPI() {
        try {
            const response = await fetch("/api/profile", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            if (!response.ok) {
                if (response.status === 401) {
                    // Redirect to login if unauthorized
                    window.location.href = "/auth/login";
                    return;
                }
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            console.log(result);

            this.cacheProfile(result); // Cache profil secara langsung

            // Perbarui tampilan
            this.updateProfileDisplay(result);

            console.log("Profile loaded successfully");
        } catch (error) {
            console.error("API fetch error:", error);
            throw error;
        }
    }

    /**
     * Cache profile data
     */
    cacheProfile(profileData) {
        try {
            const cacheData = {
                data: profileData,
                timestamp: Date.now(),
            };
            sessionStorage.setItem(
                this.profileCacheKey,
                JSON.stringify(cacheData)
            );
        } catch (error) {
            console.warn("Failed to cache profile:", error);
        }
    }

    /**
     * Update profile display in navbar
     */
    updateProfileDisplay(profile) {
        try {
            if (this.profileNameElement) {
                this.profileNameElement.textContent = `Halo ${this.getFirstName(
                    profile.profile_name
                )}`;
            }

            if (this.emailElement) {
                this.emailElement.textContent = profile.email;
                this.emailElement.title = profile.email;
            }

            // Update role display
            if (this.roleElement) {
                this.roleElement.textContent =
                    profile.role_display || this.formatRole(profile.user_role);
            }

            // Update avatar initial
            if (this.avatarElement) {
                const initial = this.getInitial(profile.profile_name);
                this.avatarElement.textContent = initial;
            }

            // Update avatar background color based on role
            this.updateAvatarColor(profile.user_role);

            // Store profile globally for other components
            window.currentUserProfile = profile;

            // Dispatch custom event for other components
            this.dispatchProfileLoadedEvent(profile);
        } catch (error) {
            console.error("Error updating profile display:", error);
        }
    }

    /**
     * Get first name from full name
     */
    getFirstName(fullName) {
        if (!fullName) return "User";
        return fullName.split(" ")[0];
    }

    /**
     * Get initial from name
     */
    getInitial(name) {
        // if (!name) return "U";

        const names = name.trim().split(" ");
        if (names.length === 1) {
            return names[0][0].toUpperCase();
        }
        return (names[0][0] + names[names.length - 1][0]).toUpperCase();
    }

    /**
     * Format role name for display
     */
    formatRole(role) {
        const roleMap = {
            superadmin: "Super Administrator",
            operator: "Operator",
            finance: "Finance",
            guest: "Guest",
        };

        return roleMap[role] || role.charAt(0).toUpperCase() + role.slice(1);
    }

    /**
     * Update avatar background color based on role
     */
    updateAvatarColor(role) {
        const avatarContainer = document.querySelector(
            '[data-dropdown-toggle="dropdown-user"] div'
        );
        if (!avatarContainer) return;

        // Remove existing role classes
        avatarContainer.classList.remove(
            "bg-blue-600",
            "bg-green-600",
            "bg-purple-600",
            "bg-orange-600",
            "bg-gray-600"
        );

        // Add role-specific color
        const roleColors = {
            superadmin: "bg-purple-600",
            operator: "bg-blue-600",
            finance: "bg-green-600",
            guest: "bg-gray-600",
        };

        const colorClass = roleColors[role] || "bg-blue-600";
        avatarContainer.classList.add(colorClass);
    }

    /**
     * Show default profile when data loading fails
     */
    showDefaultProfile() {
        const defaultProfile = {
            name: "User",
            email: "user@example.com",
            user_role: "guest",
            role_display: "Guest",
        };

        this.updateProfileDisplay(defaultProfile);
    }

    /**
     * Clear profile cache
     */
    clearProfileCache() {
        sessionStorage.removeItem(this.profileCacheKey);
    }

    /**
     * Refresh profile data
     */
    async refreshProfile() {
        this.clearProfileCache();
        await this.loadProfileData();
    }

    /**
     * Dispatch profile loaded event
     */
    dispatchProfileLoadedEvent(profile) {
        const event = new CustomEvent("profileLoaded", {
            detail: { profile },
        });
        document.dispatchEvent(event);
    }

    /**
     * Get current profile data
     */
    getCurrentProfile() {
        return window.currentUserProfile || null;
    }
}

/**
 * Search functionality for navbar
 */
class NavbarSearchManager {
    constructor() {
        this.searchButton = document.getElementById("search-button");
        this.isSearchModalOpen = false;

        this.init();
    }

    init() {
        this.attachEventListeners();
    }

    attachEventListeners() {
        // Search button click
        if (this.searchButton) {
            this.searchButton.addEventListener("click", () => {
                this.openSearchModal();
            });
        }

        // Keyboard shortcut Ctrl+M
        document.addEventListener("keydown", (e) => {
            if (e.ctrlKey && e.key === "m") {
                e.preventDefault();
                this.openSearchModal();
            }

            // Close search modal with Escape
            if (e.key === "Escape" && this.isSearchModalOpen) {
                this.closeSearchModal();
            }
        });
    }

    openSearchModal() {
        // Create search modal if it doesn't exist
        if (!document.getElementById("search-modal")) {
            this.createSearchModal();
        }

        const modal = document.getElementById("search-modal");
        modal.classList.remove("hidden");

        // Focus on search input
        const searchInput = document.getElementById("search-input");
        if (searchInput) {
            searchInput.focus();
        }

        this.isSearchModalOpen = true;
    }

    closeSearchModal() {
        const modal = document.getElementById("search-modal");
        if (modal) {
            modal.classList.add("hidden");
        }
        this.isSearchModalOpen = false;
    }

    createSearchModal() {
        const modalHTML = `
            <div id="search-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-start justify-center pt-20">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4">
                    <div class="p-4">
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="search-input" 
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                placeholder="Cari menu atau fitur...">
                        </div>
                        <div id="search-results" class="mt-4 max-h-96 overflow-y-auto">
                            <p class="text-gray-500 text-center py-8">Ketik untuk mencari...</p>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML("beforeend", modalHTML);

        // Add event listeners for the modal
        const modal = document.getElementById("search-modal");
        const searchInput = document.getElementById("search-input");

        // Close modal when clicking outside
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                this.closeSearchModal();
            }
        });

        // Search functionality
        searchInput.addEventListener("input", (e) => {
            this.performSearch(e.target.value);
        });
    }

    async performSearch(query) {
        const resultsContainer = document.getElementById("search-results");

        if (!query.trim()) {
            resultsContainer.innerHTML =
                '<p class="text-gray-500 text-center py-8">Ketik untuk mencari...</p>';
            return;
        }

        try {
            // Search in menus
            const response = await fetch(
                `/api/menus?search=${encodeURIComponent(query)}`
            );
            const result = await response.json();

            if (result.success && result.data.length > 0) {
                this.displaySearchResults(result.data);
            } else {
                resultsContainer.innerHTML =
                    '<p class="text-gray-500 text-center py-8">Tidak ada hasil ditemukan</p>';
            }
        } catch (error) {
            console.error("Search error:", error);
            resultsContainer.innerHTML =
                '<p class="text-red-500 text-center py-8">Error saat mencari</p>';
        }
    }

    displaySearchResults(menus) {
        const resultsContainer = document.getElementById("search-results");
        let html = "";

        menus.forEach((menu) => {
            // Add main menu
            html += `
                <div class="p-3 hover:bg-gray-50 rounded-lg cursor-pointer border-b border-gray-100" onclick="window.location.href='${menu.path}'">
                    <div class="flex items-center">
                        <i class="${menu.icon} text-gray-400 mr-3"></i>
                        <span class="font-medium">${menu.label}</span>
                    </div>
                </div>
            `;

            // Add submenus
            if (menu.submenu && menu.submenu.length > 0) {
                menu.submenu.forEach((submenu) => {
                    html += `
                        <div class="p-3 pl-8 hover:bg-gray-50 rounded-lg cursor-pointer border-b border-gray-100" onclick="window.location.href='${submenu.path}'">
                            <div class="flex items-center">
                                <i class="fa-solid fa-arrow-right text-gray-300 mr-3 text-xs"></i>
                                <span>${submenu.label}</span>
                            </div>
                        </div>
                    `;
                });
            }
        });

        resultsContainer.innerHTML = html;
    }
}

// Utility functions for external use
window.NavbarUtils = {
    refreshProfile: () => {
        if (window.navbarProfileManager) {
            window.navbarProfileManager.refreshProfile();
        }
    },

    getCurrentProfile: () => {
        if (window.navbarProfileManager) {
            return window.navbarProfileManager.getCurrentProfile();
        }
        return null;
    },

    clearProfileCache: () => {
        if (window.navbarProfileManager) {
            window.navbarProfileManager.clearProfileCache();
        }
    },
};

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
    window.navbarProfileManager = new NavbarProfileManager();
    window.navbarSearchManager = new NavbarSearchManager();
});

// Listen for profile changes from other components
document.addEventListener("profileUpdated", function (event) {
    if (window.navbarProfileManager) {
        window.navbarProfileManager.updateProfileDisplay(event.detail.profile);
    }
});
