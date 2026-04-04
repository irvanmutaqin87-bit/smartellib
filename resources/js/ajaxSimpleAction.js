export function initAjaxSimpleAction() {
    const forms = document.querySelectorAll(".ajax-action-form");

    forms.forEach((form) => {
        form.addEventListener("submit", async function (e) {
            e.preventDefault();

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn ? submitBtn.innerHTML : "";

            try {
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = "Memproses...";
                }

                const formData = new FormData(form);

                const response = await fetch(form.action, {
                    method: form.method || "POST",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        Accept: "application/json",
                    },
                    body: formData,
                });

                const result = await response.json();

                if (result.success) {
                    showAnggotaToast(result.message || "Berhasil", "success");

                    if (result.reload) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1200);
                    }
                } else {
                    showAnggotaToast(
                        result.message || "Terjadi kesalahan",
                        "error",
                    );
                }
            } catch (error) {
                console.error("AJAX SIMPLE ACTION ERROR:", error);
                showAnggotaToast(
                    "Terjadi kesalahan saat memproses data.",
                    "error",
                );
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            }
        });
    });
}

/**
 * Pakai toast global kalau ada
 */
function showAnggotaToast(message, type = "success") {
    if (window.showAnggotaToast) {
        window.showAnggotaToast(message, type);
        return;
    }

    // fallback sederhana kalau global toast belum ke-bind
    alert(message);
}
