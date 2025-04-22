// toast.js
import Toastify from 'toastify-js'
import "toastify-js/src/toastify.css"

function successToast(msg) {
    const toastContent = document.createElement("div");
    toastContent.innerHTML = `<strong>✅ Success!</strong> ${msg}`;
    toastContent.style.userSelect = "none";

    Toastify({
        gravity: "top",
        position: "center",
        node: toastContent,
        className: "mb-5",
        style: {
            background: "linear-gradient(to right, #33ccff 0%, #00cc00 100%)",
        }
    }).showToast();
}

function errorToast(msg) {
    const toastContent = document.createElement("div");
    toastContent.innerHTML = `<strong>☠️ Error!</strong> ${msg}`;
    toastContent.style.userSelect = "none";

    Toastify({
        gravity: "top",
        position: "center",
        node: toastContent,
        className: "mb-5",
        style: {
            background: "linear-gradient(to bottom, #ff3300 0%, #cc0066 100%)",
        }
    }).showToast();
}

export { successToast, errorToast }
