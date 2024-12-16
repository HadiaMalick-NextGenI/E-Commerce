export function showToast(message) {
    const toastElement = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');

    toastMessage.textContent = message;

    const toast = new bootstrap.Toast(toastElement, {
        delay: 2000
    });

    toast.show();
}