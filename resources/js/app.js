import "./bootstrap";
import "flowbite";
import { Modal, Dropdown, Accordion } from "flowbite";
import Alpine from "alpinejs";
import Swal from "sweetalert2";
import Quill from "quill";
import "quill/dist/quill.snow.css";

document.addEventListener("DOMContentLoaded", function () {
    window.Alpine = Alpine;
    window.Swal = Swal;
    window.Modal = Modal;
    window.Accordion = Accordion;
    window.Dropdown = Dropdown;
    window.Quill = Quill;
    Alpine.start();
    const darkModeButton = document.getElementById("darkModeButton");

    const observer = new MutationObserver(() => {
        document
            .querySelectorAll(
                'div[class*="bg-gray-900"][class*="fixed"][class*="inset-0"]'
            )
            .forEach((el) => {
                el.style.backgroundColor = "rgba(13, 17, 23, 0.3)";
            });
        document.querySelectorAll("[drawer-backdrop]").forEach((el) => {
            el.style.backgroundColor = "rgba(0, 0, 0, 0)";
        });
    });
    observer.observe(document.body, { childList: true, subtree: true });

    let theme = localStorage.getItem("theme") || "dark";
    if (darkModeButton) {
        darkModeButton.addEventListener("click", function () {
            if (
                localStorage.getItem("theme") === "light" ||
                (!("theme" in localStorage) &&
                    window.matchMedia("(prefers-color-scheme: light)").matches)
            ) {
                localStorage.setItem("theme", "dark");
                document.documentElement.classList.add("dark");
            } else {
                localStorage.setItem("theme", "light");
                document.documentElement.classList.remove("dark");
            }
        });
    }

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        background: theme === "dark" ? "#212830" : "#fff",
        color: theme === "dark" ? "#fff" : "#212830",
        timer: 4500,
        animation: false,
        timerProgressBar: false,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
    });

    window.Toast = Toast;

    document.querySelectorAll('input[type="file"]').forEach((input) => {
        input.addEventListener("change", function () {
            if (!input.id) return;

            const fileNameDisplay = document.getElementById(
                input.id + "-filename"
            );
            if (!fileNameDisplay) return;

            if (input.files.length > 0) {
                fileNameDisplay.textContent = input.files[0].name;
            } else {
                fileNameDisplay.textContent = "";
            }
        });
    });
});
